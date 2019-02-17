<?php
    include("Templates/header.php");
?>

    <!--
    Formulär för att skapa konto. Information jämförs med de tidigare skapade kontona och säger ifrån om ett konto försöker skapas med samma namn som ett existerande konto. Är det unikt däremot matas informationen in i databasen och en ny användare är skapad.

    -->

    <main>      
                

        <form class="accForm" method="post" action="CreateAccount.php">
            
            <h3>Skapa konto</h3>

            <h5>Användarnamn:</h5>
            <input class="input" type="text" placeholder="Användarnamn" name="username"><br>
            <h5>Lösenord:</h5>
            <input class="input" type="password" placeholder="Lösenord" name="password"><br>
            <h5>Adress:</h5>
            <input class="input" type="text" placeholder="Adress" name="adress"><br>
            
            <input type="submit" class="publish" value="Skapa konto" name="createAcc">

        </form>

    </main>

    <?php
        
        if(isset($_POST['username'])){

            
            $username = $_POST['username'];
            $password = $_POST['password'];
            $adress = $_POST['adress'];
            
            $identicalUsername = false;
            
            $sql = "SELECT * FROM accounts";
            $stmt = $database->prepare($sql);
            $stmt->execute();
            $content = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            
            foreach($content as $value){
                if($value['Username'] == $username){
                    $identicalUsername = true;
                }
            }
            
            if($identicalUsername){
                echo "<script> alert('Det användarnamnet är redan upptaget!'); </script>";
            }
            
            else{
                $params = [$username, $password, $adress];
                $sql = "INSERT INTO accounts (Username, Password, Adress) VALUES (?,?,?)";
                $stmt = $database->prepare($sql);   

                try{
                    $stmt->execute($params);
                }
                catch(PDOException $e){
                    echo "<p>Det gick inte att spara</p>";
                }
                
                echo "<script> alert('Ditt konto är nu skapat!'); </script>";
                header("Location:Start.php");
            }
        }


    ?>

    </body>
</html>