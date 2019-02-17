<?php
    include("Templates/header.php");

    if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
?>

<!--
Sidan går endast att användas om man är inloggad med ett adminkonto. Sidan presenterar alla ordrar som är lagda och ger möjligheten att ändra status på dessa vilket sedan en användaren kan se genom deras konto.

-->

    <main>
        
        <h3 class="pageHeader">Alla ordrar</h3>

    <?php
        
        if(isset($_POST['status'])){
            
            $status = $_POST['status'];
            $orderid = $_POST['order'];
            
            $sql = "UPDATE orders SET Status = '$status' WHERE OrderID = '$orderid'";
            $stmt = $database->prepare($sql);   

            try{
                $stmt->execute();
            }
            catch(PDOException $e){
                echo "<p>Det gick inte att spara</p>";
            }

        }
        
        //Presenterar alla orders för det för tillfället inloggade kontot
        $username = $_SESSION['user'];

        $sql = "SELECT * FROM orders";
        $stmt = $database->prepare($sql);
        $stmt->execute();

        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($content as $value){

            echo "
                    <article>

                        <h2 class='orderOverview'>".$value['Username']."'s order, Orderstatus: ".$value['Status']."</h2>
                ";

            $order = $value['OrderID'];

            $sql = "SELECT MovieID FROM ordercontents WHERE OrderID = '$order'";
            $stmt = $database->prepare($sql);
            $stmt->execute();

            $content2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<ul>";

            foreach($content2 as $value2){
                $movieid = $value2['MovieID'];
                $sql = "SELECT Title FROM movies WHERE MovieID = '$movieid'";
                $stmt = $database->prepare($sql);
                $stmt->execute();
                $title = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo "<li>".$title[0]['Title']."</li>";
            }

            echo "   </ul class='orderOverview'>

                        <form class='changeStatus' action='AdminOverview.php' method='post'>

                            <input type='radio' name='status' value ='Order mottagen'>Order mottagen
                            <input type='radio' name='status' value ='Order skickad'>Order skickad
                            <input type='radio' name='status' value ='Order har anlänt'>Order har anlänt
                            
                            <input type='hidden' name='order' value ='".$value['OrderID']."'>
                            <input type='submit' name='changeStatus' value='Ändra status'>

                        </form>

                    </article>";
        }     
        
        } else{
    ?>

    <h3 class="pageHeader">Du har inte adminrättigheter och kan därför inte använda denna funktion</h3>

    <?php } ?>
        
    
        
</main>
</body>
</html>