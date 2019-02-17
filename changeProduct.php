<?php
    include("Templates/header.php");

    $movie = $_GET['movie'];
        
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
?>

<!--
Sidan består av ett formulär som används för att ändra på produkter i databasen. Formuläret skickas till startsidan där information i databasen ändras. Lämnas ett fält tomt kommer hemsidan ignorera att ändra detta attribut och lämna det som det var tidigare.



-->

    <main>      
                

        <form class="accForm" method="post" action="Start.php">
            
            <h3>Ändra information om produkt</h3>

            <h5>Titel:</h5>
            <input class="input" type="text" placeholder="Titel" name="title">
            <h5>Utgivningsår:</h5>
            <input class="input" type="text" placeholder="Utgivningsår" name="releaseyear">
            <h5>Beskrivning:</h5>
            <input class="input" type="text" placeholder="Beskrivning" name="description">
            <h5>Pris:</h5>
            <input class="input" type="text" placeholder="Pris" name="price"><br> 
            <input type="hidden" name="movie" value="<?php echo $movie; ?>">
            
            <input type="submit" class="publish" value="Ändra" name="changeProduct">

        </form>

    </main>

<?php
        
        if(isset($_POST['changeProduct'])){

            $title = $_POST['title'];
            $releaseyear = $_POST['releaseyear'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            
            $movie = $_SESSION['movie'];
            
            
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

    } else{
    ?>

    <h3 class="pageHeader">Du har inte adminrättigheter och kan därför inte använda denna funktion</h3>

    <?php } ?>


    

    </body>
</html>