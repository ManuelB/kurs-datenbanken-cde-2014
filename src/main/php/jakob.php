<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h1>Meine MySQL Anwendung</h1>
    <pre>
    <?php
    
    print_r($_REQUEST);
    
    $con=mysqli_connect("localhost","root","","Jakob_Olbrich");
    if(isset($_REQUEST["Spielername"])) {
    $sql = "INSERT Spieler (Name) VALUES ('".
    	mysqli_real_escape_string($con, $_REQUEST["Spielername"])."')";
    	echo $sql;
    	if(!mysqli_query($con, $sql)) {
            echo mysqli_error($con);
        }
    }
    if(isset($_REQUEST["delete"])) {
        $sql = "DELETE FROM Spieler WHERE id = ".
        	mysqli_real_escape_string($con, $_REQUEST["delete"])."";
        // echo $sql;
        if(!mysqli_query($con, $sql)) {
            echo mysqli_error($con);
        }
    }
    
    
    $resultSet = mysqli_query($con, "SELECT id, Name FROM Spieler ORDER BY id");
    echo "<table>";
    echo "<tr><th>Name</th><th>Löschen</th></tr>";
    // Gehe durch alle Zeilen des Ergebnisses
    while($row = mysqli_fetch_assoc($resultSet)) {
        // Gebe die aktuelle Zeile aus

    	echo "<tr><td>$row[Name]</td><td><a href=\"?delete=$row[id]\">Löschen</a></td></tr>";
    	
    	// print_r($row);
    }
    echo "</table>";
    
    mysqli_close($con);
    ?>
    <form method="POST">
        <fieldset>
            <legend>Neuen Spieler anlegen</legend>
            <label>Neuer Spieler</label><br>
            <input type="text" name="Spielername"><br>
            <input type="submit" name="Anlegen">
        </fieldset>
    </form>
    </pre>
</body>
</html>