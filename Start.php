<?php
    include("Templates/header.php");

    if(isset($_GET['removemovie'])){
                    
        $sql = "DELETE FROM movies WHERE MovieID = ?";
        $params = [$_GET['removemovie']];
        $stmt = $database->prepare($sql);

        try{
            $stmt->execute($params);
        }
        catch(PDOException $e){
            echo "<p>Det gick inte att spara</p>";
        }

    }
?>
        
        <!-- Sökfältet består av ett formulär där ena fältet matas in med text för att hitta annonser efter önskad
        titel eller med en scrollbar där man kan se alternativen för kategorier som finns för annonserna. Vilka
        kategorier man kan välja på väljs genom att alla kategorier i databasen hämtas in och visas som alternativ.-->
        
        <div id="searchbar">
            <form method="post">
                <input id="searchText" type="text" name="search" placeholder="Sök efter film...">
                <input id="search" type="submit" value="Sök">
            </form>
           
        </div> 
        
        <main>
            
            <?php
            
                if(isset($_POST['changeProduct'])){

                    $title = $_POST['title'];
                    $releaseyear = $_POST['releaseyear'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];

                    $movie = $_POST['movie'];


                    if($title != ''){

                        $sql = "UPDATE movies SET Title = '$title' WHERE MovieID = '$movie'";
                        $stmt = $database->prepare($sql);   

                        try{
                            $stmt->execute();
                        }
                        catch(PDOException $e){
                            echo "<p>Det gick inte att spara</p>";
                        }
                    }

                    if($releaseyear != ''){

                        $sql = "UPDATE movies SET Releaseyear = '$releaseyear' WHERE MovieID = '$movie'";
                        $stmt = $database->prepare($sql);   

                        try{
                            $stmt->execute();
                        }
                        catch(PDOException $e){
                            echo "<p>Det gick inte att spara</p>";
                        }

                    }

                    if($description != ''){

                        $sql = "UPDATE movies SET Description = '$description' WHERE MovieID = '$movie'";
                        $stmt = $database->prepare($sql);   

                        try{
                            $stmt->execute();
                        }
                        catch(PDOException $e){
                            echo "<p>Det gick inte att spara</p>";
                        }

                    }

                    if($price != ''){

                        $sql = "UPDATE movies SET Price = '$price' WHERE MovieID = '$movie'";
                        $stmt = $database->prepare($sql);   

                        try{
                            $stmt->execute();
                        }
                        catch(PDOException $e){
                            echo "<p>Det gick inte att spara</p>";
                        }

                    }

                }
                
            
                //Om användaren söker efter en annons händer följande:

                if(isset($_POST["search"])){

                    $value = $_POST['search'];

                    $sql = "SELECT * FROM movies WHERE Title LIKE '%$value%'"; 
                    $stmt = $database->prepare($sql);
                    $params = [$value];
                    $stmt->execute($params);

                    $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
                     
                    //Är inte heller en text inmatad i sökformuläret hämtas alla filmer i databasen.
                }

                else{
                    $sql = "SELECT * FROM movies";
                    $stmt = $database->prepare($sql);
                    $stmt->execute();

                    $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                /* När annonser är hämtade från databasen presenteras dem på rad efter varandra där annonsens rubrik, information
                och pris visas. Beroende på om man är inloggad eller inte eller admin eller inte kommer olika alternativ för vad som kan göras med filmerna visas, bland annat lägga till i kundvagnen om man är inloggad på ett konto utan adminrättigheter.*/
                
                foreach($content as $value){
                    
                    if($_SESSION['loggedin'] && $_SESSION['admin'] == 0){
                        
                    echo " <a href='Product.php?id=".$value['MovieID']."'>
                                <article>
                                    <h2 class='Title'>".$value['Title']." (".$value['Releaseyear'].")</h2>
                                    
                                    <a href='Cart.php?movie=".$value['MovieID']."'><span class='AdToCart'>Lägg till i kundvagn</span></a>
                                    
                                    <h2 class='Price'>".$value['Price'].":-</h2>
                                </article>
                            </a>";
                    }
                    else if($_SESSION['loggedin'] && $_SESSION['admin'] == 1){
                        
                        echo " <a href='Product.php?id=".$value['MovieID']."'>
                                <article>
                                    <h2 class='Title'>".$value['Title']." (".$value['Releaseyear'].")</h2>
                                    
                                    <a href='Start.php?removemovie=".$value['MovieID']."'><span class='AdToCart'>Ta bort</span></a>
                                    <a href='changeProduct.php?movie=".$value['MovieID']."'><span class='AdToCart'>Ändra information</span></a>
                                    
                                    <h2 class='Price'>".$value['Price'].":-</h2>
                                </article>
                            </a>";
                    }
                    
                    else{
                        echo " <a href='Product.php?id=".$value['MovieID']."'>
                                <article>
                                    <h2 class='Title'>".$value['Title']." (".$value['Releaseyear'].")</h2>
                                 
                                    <h2 class='Price'>".$value['Price'].":-</h2>
                                </article>
                            </a>";
                        
                        
                    }
                }
            
            
                /* Om användaren klickar på knappen "Skapa nytt konto" hamnar användaren på en ny sida med ett formulär om användarnamn
                och lösenord, detta formulär skickas då tillbaka till denna sida, där värdena sparas i databasen och tabellen "users". */

                if(isset($_POST['createAcc'])){

                    $username = $_POST['username'];
                    $password = $_POST['password'];

                    $params = [$username, $password];
                    $sql = "INSERT INTO accounts (Username, Password) VALUES (?,?)";
                    $stmt = $database->prepare($sql);

                    try{
                        $stmt->execute($params);
                    }
                    catch(PDOException $e){
                        echo "<p>Det gick inte att spara</p>";
                    }
                }
            
            ?>
            
        </main>
    
    
    </body>
    
</html>