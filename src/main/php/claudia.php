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
    
    
    
    //Connecte zum lokalen Mysql Server
    $connection=mysqli_connect("localhost","root","","manuel-blechschmidt");
    // wenn der Parameter molekuel gesetzt ist
    if(isset($_REQUEST["molekuel"])) {
    	$nqi="INSERT molekuel (name) VALUES ('".
    		mysqli_real_escape_string($connection,$_REQUEST["molekuel"])."')";
    	echo $sql;
    	// Füge eine neue Zeile in der Tabelle molekuel an
    	if(!mysqli_query($connection,$nqi)) {
    		echo mysqli_error($connection);
    	}
    }
    
    //Sende Anfrage an den MySQL Server
    $resultSet=mysqli_query($connection, "SELECT name FROM Molekuele");
    
    
    echo "<table>";
    echo "<tr><th>Name</th><th>Löschen</th><
    
    
    
    //Gehe durch alle Zeilen des Ergebnisses
    while($row=mysqli_fetch_assoc($resultSet)) {
    //Gebe die aktuelle zeile aus
    print_r($row);
    }
    
    mysqli_close($connection);
    ?>
    <form method="POST">
    	<fieldset>
    		<legend>Neues Molekül anlegen</legend>
    		<label for="molekuel">Neuer Molekülname</label><br>
    		<input type="text" name="molekuel"><br>
    		<input type="submit" name="Anlegen">
    	</fieldset>
    </form>
</body>
</html>