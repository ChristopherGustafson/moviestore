<?php
    include("Templates/header.php");

    if(isset($_SESSION['user']) && isset($_GET['movie'])){
        
        $user = $_SESSION['user'];
        $movie = $_GET['movie'];
        
        $params = [$user, $movie];
        $sql = "INSERT INTO carts (Username, MovieID) VALUES (?,?)";
        $stmt = $database->prepare($sql);   
            
        try{
            $stmt->execute($params);
        }
        catch(PDOException $e){
            echo "<p>Det gick inte att spara</p>";
        }      
    }

    if(isset($_GET['movieremove'])){
        
        $movie = $_GET['movieremove'];
        
        $sql = "DELETE FROM carts WHERE MovieID ='$movie'";
        $stmt = $database->prepare($sql);
        
        try{
            $stmt->execute($params);    
        }
        catch(PDOException $e){
            echo "<p>Det gick inte att spara</p>";
        }
        
    }
    
?>
    <main>  
              
        <h3 class="pageHeader"><?php echo $_SESSION['user']; ?>'s Kundvagn</h3>

        <?php
        
        $username = $_SESSION['user'];
        
        $sql = "SELECT movies.MovieID, movies.Title, movies.Releaseyear, movies.Price FROM carts JOIN movies ON carts.MovieID = movies.MovieID WHERE carts.Username = '$username'";
        $stmt = $database->prepare($sql);
        $stmt->execute();

        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($content as $value){
                    echo " <a href='Product.php?id=".$value['MovieID']."'>
                                <article>
                                    <h2 class='Title'>".$value['Title']." (".$value['Releaseyear'].")</h2>
                                    
                                    <a href='Cart.php?movieremove=".$value['MovieID']."'><span class='AdToCart'>Ta bort från kundvagn</span></a>
                                    
                                    <h2 class='Price'>".$value['Price'].":-</h2>
                                </article>
                            </a>";
                }
        
            if($content != null){
        
        ?>
        
        <form  id="placeOrder" method="post" action="AccountOverview.php">
            <input id="placeOrderButton" type="submit" name="placeorder" value="Placera Order">
        </form>
        
        <?php   }else{  ?>
        
        <h4>Kundvagnen är tom</h4>
        
        <?php   }  ?>
    </main>


    </body>
</html>