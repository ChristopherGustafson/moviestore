<?php
    include("Templates/header.php");

   /*
   Då en användare trycker på placera order i kundvagnen kommer följande if-sats bli sann. Då det händer sparas den nuvarande användaren och läggs in som en order i databasen med den ursprungliga statusen "Order mottagen". Efter detta hämtas det största orderID eftersom detta är det som skapats sist. Sedan hämtas alla de filmer som är kopplad till den ordern och som tidigare legat i kundvagnen för att sedan sparas ner i tabellen för orderinnehåll (Order Contents). När detta är gjort kan sedan kundvagnen för det nuvarande kontot att tömmas genom att radera inforamtionen kopplad till det konto i kundvagntabellen. 
   */

    if(isset($_POST['placeorder'])){
        
        $username = $_SESSION['user'];
        $status = "Order mottagen";
        
        $params = [$status, $username];
        $sql = "INSERT INTO orders (Status, Username) VALUES (?,?)";
        $stmt = $database->prepare($sql);
        
        try{
            $stmt->execute($params);
        }
        catch(PDOException $e){
            echo "<p>Det gick inte att spara</p>";
        }
        
        $sql = "SELECT Max(OrderID) AS OrderID FROM orders WHERE Username = '$username'";
        $stmt = $database->prepare($sql);
        $stmt->execute();
        
        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $orderid = $content[0]['OrderID'];
        
        $sql = "SELECT MovieID FROM carts WHERE Username ='$username'";
        $stmt = $database->prepare($sql);
        $stmt->execute();
        
        $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        for($i = 0; $i < count($content); $i++){
            
            $movie = $content[$i]['MovieID'];
            

            $params = [$orderid, $movie];
            $sql = "INSERT INTO ordercontents (OrderID, MovieID) VALUES (?,?)";
            $stmt = $database->prepare($sql);

            try{
                $stmt->execute($params);
            }
            catch(PDOException $e){
                echo "<p>Det gick inte att spara</p>";
            }
            
            
        }

        $sql = "DELETE FROM carts WHERE Username ='$username'";
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
    
    <h3 class="pageHeader"><?php echo $_SESSION['user']; ?>'s Orders</h3>

   <?php

    //Presenterar alla orders och vad dem innehåller för det för tillfället inloggade kontot
    $username = $_SESSION['user'];
    
    $sql = "SELECT * FROM orders WHERE Username = '$username'";
    $stmt = $database->prepare($sql);
    $stmt->execute();

    $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($content as $value){
        
        echo "
                <article>
                    
                    <h2 class='orderOverview'>Orderstatus: ".$value['Status']."</h2>
            ";
        
        $order = $value['OrderID'];
        
        $sql = "SELECT MovieID FROM ordercontents WHERE OrderID = '$order'";
        $stmt = $database->prepare($sql);
        $stmt->execute();

        $content2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<ul class='orderOverview'>";
            
        foreach($content2 as $value2){
            $movieid = $value2['MovieID'];
            $sql = "SELECT Title FROM movies WHERE MovieID = '$movieid'";
            $stmt = $database->prepare($sql);
            $stmt->execute();
            $title = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<li>".$title[0]['Title']."</li>";
        }
        
        echo "      </ul>
        
                </article>";
        }     
    ?>
    
        </main>
    </body>
</html>
