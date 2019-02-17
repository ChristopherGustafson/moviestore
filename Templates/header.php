<!DOCTYPE html>
<html>
    <head>
        <title>Annonssida</title>
        <meta charset="utf-8">
        <link href="Stylesheet.css" rel="stylesheet" type="text/css">
        
        <script>
            
	   </script>
        
    </head>
    
    <?php
    
        //initierar databasen
        
        $dsn = 'mysql:host=localhost;dbname=filmbutiken';
        $user = 'root';
        $dbpassword = '';
        try{
            $database = new PDO($dsn, $user, $dbpassword);
        }
        catch(PDOException $e){
            echo "Det gick inte att ansluta till datbasen";
            throw $e;
        }
    
        //Initierar SESSION-variablarna som ska hålla koll på om användaren är inloggad eller inte
    
        Session_Start();
    
       if(!isset($_SESSION['loggedin'])){
            $_SESSION['loggedin'] = false;
            $_SESSION['user'] = '';
            $_SESSION['admin']; 
       }
       
        
        /*Om användaren loggar in jämförs inmatningarna med värden i databasen och om
        det stämmer loggas man in och användarnamnet och inloggningen sparas i en session
        variabel som gör att inloggningen inte försvinner om du t.ex. laddar om sidan*/

        if(isset($_POST['login'])){
            if(isset($_POST['username']) && isset($_POST['password'])){

                $username = $_POST['username'];
                $password = $_POST['password'];

                $sql = "SELECT * FROM accounts WHERE username = '$username'"; 
                $stmt = $database->prepare($sql);
                $stmt->execute();  

                $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($content as $value){
                    if($username == $value['Username'] && $password == $value['Password']){
                        $_SESSION['loggedin'] = true;
                        $_SESSION['user'] = $username;
                        $_SESSION['admin'] = false; 
                        if($value['Admin'] == 1){
                            $_SESSION['admin'] = true; 
                        }
                    }
                    
                }
            }
        }
        
    ?>
    
    <body>
    
        <nav>
            
            <!-- Navigationsfältet består av ett inloggningsformulär samt länken till  att skapa nya konton. 
            Beroende på om användaren är inloggad eller inte (d.v.s. om sessionvariabeln är sann) kommer 
            antingen inloggningsformuläret visas då ingen är inloggad eller länkar till funktioner som enbart 
            går att använda när man inloggad. Är kontot som loggas in ett adminkonto kommer det att visas andra
            till funktioner som enbart en admin kan använda.
            . -->
            
            <div id="logo">
                <a href="Start.php">
                    <h2>Filmbutiken</h2>
                </a>
            </div>
            
            <?php if($_SESSION['loggedin'] == false){  ?>
            
            <div id="loginBar">
                <form method="post">
                    <div id="loginFormContent">
                        <input class='login' type='text' name='username' placeholder='Användarnamn'>
                        <input class='login' type='password' name='password' placeholder='Lösenord'>
                        <input class='login' type='submit' name='login' value='Logga in'> 
                        <a href="CreateAccount.php"><button type="button"  class="login">Skapa nytt konto</button></a>
                    </div> 
                </form>
            </div>
            
            <?php } else{
                    if($_SESSION['admin'] == 0){
            ?>
            
            
            
            <ul id="loggedinBar">  
                
                <li>Inloggad som <?php echo $_SESSION['user']; ?></li>
                
                <li><a href="AccountOverview.php">Kontoöversikt</a></li>
                <li><a href="Cart.php">Kundvagn</a></li>
                   
            </ul>
            
            <form id="logout" method="post">
                <input id="logoutButton" type="submit" name="logout" value="Logga ut">
            </form>
            
            <?php } else{ ?>
            
            <ul id="loggedinBar">  
                
                <li>Inloggad som <?php echo $_SESSION['user']; ?></li>
                
                <li><a href="AddProduct.php">Lägg till i sortiment</a></li>
                <li><a href="AdminOverview.php">Hantera orders</a></li>
            
            </ul>
            
            <form id="logout" method="post">
                <input id="logoutButton" type="submit" name="logout" value="Logga ut">
            </form>

                    
            <?php 
                        }
                    }
            
            
            if(isset($_POST['logout'])){
                $_SESSION['loggedin'] = false;
                $_SESSION['admin'] = false;
                $_SESSION['user'] = '';
                header("Location: Start.php");
            }
            
            ?>
            
        </nav>