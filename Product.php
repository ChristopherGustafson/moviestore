<?php
    include("Templates/header.php");

    //Då en film klickas på på startsidan kommer denna sida upp som visar lite mer information om filmen.

    $movie = $_GET['id'];

    $sql = "SELECT * FROM movies WHERE MovieID = '$movie'";
    $stmt = $database->prepare($sql);
    $stmt->execute();

    $content = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<main>";
    
    echo "<h3 class='pageHeader'>Filmbeskrivning</h3>";

    echo "<article>
            <h2 class='Title'>".$content[0]['Title']." (".$content[0]['Releaseyear'].")</h2>

            <h2 class='Price'>".$content[0]['Price'].":-</h2>
            
            <p class='movieDescription'>".$content[0]['Description']."</p>
        </article>";

    echo "</main>";
?>

