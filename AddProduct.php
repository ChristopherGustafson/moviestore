<?php
    include("Templates/header.php");


    if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
?>

<!--
Ett formulär för att lägga till produkter till sortimentet som sedan presenteras på webplatsen. Är det inloggade kontot inte admin fungerar inte sidan. 

-->

    <main>      
                

        <form class="accForm" method="post" action="AddProduct.php">
            
            <h3>Lägg till produkt</h3>

            <h5>Titel:</h5>
            <input class="input" type="text" placeholder="Titel" name="title">
            <h5>Utgivningsår:</h5>
            <input class="input" type="text" placeholder="Utgivningsår" name="releaseyear">
            <h5>Beskrivning:</h5>
            <input class="input" type="text" placeholder="Beskrivning" name="description">
            <h5>Pris:</h5>
            <input class="input" type="text" placeholder="Pris" name="price"><br>
            
            <input type="submit" class="publish" value="Lägg till" name="adProduct">

        </form>

    </main>

    <?php
        
        if(isset($_POST['title'])){

            
            $title = $_POST['title'];
            $releaseyear = $_POST['releaseyear'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            
            
            $params = [$title, $releaseyear, $description, $price];
            $sql = "INSERT INTO movies (Title, Releaseyear, Description, Price) VALUES (?,?,?,?)";
            $stmt = $database->prepare($sql);   

            try{
                $stmt->execute($params);
            }
            catch(PDOException $e){
                echo "<p>Det gick inte att spara</p>";
            }

            header("Location:Start.php");
            
        }
        
    } else{
    ?>

    <h3 class="pageHeader">Du har inte adminrättigheter och kan därför inte använda denna funktion</h3>

    <?php } ?>

    </body>
</html>