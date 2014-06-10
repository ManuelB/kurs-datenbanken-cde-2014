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
    

    // Connecte zum lokalen Mysql Server
    $connection=mysqli_connect("localhost","root","","manuel-blechschmidt");
    // wenn der Parameter molekuel gesetzt ist
    if(isset($_REQUEST["molekuel"])) {
        $sql = "INSERT Molekuele (name) VALUES ('".
        	mysqli_real_escape_string($connection, $_REQUEST["molekuel"])."')";
        // echo $sql;
        // Füge eine neue Zeile in der Tabelle molekuel an
        if(!mysqli_query($connection, $sql)) {
            echo mysqli_error($connection);
        }
    }
    
    if(isset($_REQUEST["basissatz"])) {
        $sql = "INSERT Ionisierungsenergien (molekuel_id, basissatz_id, energie) VALUES ('"
        	.mysqli_real_escape_string($connection, $_REQUEST["molekuel_id"]).","
        	.mysqli_real_escape_string($connection, $_REQUEST["basissatz_id"]).","
        	.mysqli_real_escape_string($connection, $_REQUEST["energie"]).","
        	."')";
        // echo $sql;
        // Füge eine neue Zeile in der Tabelle molekuel an
        if(!mysqli_query($connection, $sql)) {
            echo mysqli_error($connection);
        }
    }
    
    if(isset($_REQUEST["delete"])) {
        $sql = "DELETE FROM Molekuele WHERE id = ".
        	mysqli_real_escape_string($connection, $_REQUEST["delete"])."";
        // echo $sql;
        // Füge eine neue Zeile in der Tabelle molekuel an
        if(!mysqli_query($connection, $sql)) {
            echo mysqli_error($connection);
        }
    }
    
    // Sende Anfrage an den MySQL Server
    $resultSet = mysqli_query($connection, "SELECT id, name FROM Molekuele ORDER BY id");
    echo "<h2>Moleküle</h2><table>";
    echo "<tr><th>Name</th><th>Löschen</th></tr>";
    // Gehe durch alle Zeilen des Ergebnisses
    while($row = mysqli_fetch_assoc($resultSet)) {
        // Gebe die aktuelle Zeile aus

    	echo "<tr><td>$row[name]</td><td><a href=\"?delete=$row[id]\">Löschen</a></td></tr>";
    	
    	// print_r($row);
    }
    echo "</table>";
    

    ?>
    </pre>
    <form method="POST">
        <fieldset>
            <legend>Neues Molekül anlegen</legend>
            <label for="molekuel">Neuer Molekülname</label><br>
            <input type="text" name="molekuel" id="molekuel"><br>
            <input type="submit" name="Anlegen">
        </fieldset>
    </form>
    <?php
    
        $resultSet = mysqli_query($connection, "SELECT id, energie FROM Ionisierungsenergien ORDER BY id");
    
    echo "<h2>Ionisierungsenergien</h2><table>";
    echo "<tr><th>energie</th><th>Löschen</th></tr>";
    // Gehe durch alle Zeilen des Ergebnisses
    while($row = mysqli_fetch_assoc($resultSet)) {
        // Gebe die aktuelle Zeile aus

    	echo "<tr><td>$row[energie]</td><td><a href=\"?delete=$row[id]\">Löschen</a></td></tr>";
    	
    	// print_r($row);
    }
    echo "</table>";

    
    ?>
    <form method="POST">
    <fieldset>
        <legend>Energie neu anlegen</legend>
        <label>Molekül</label><br>
        <select name="molekuel_id">
            <?php
            $resultSet = mysqli_query($connection, "SELECT id, name FROM Molekuele");
            while($row = mysqli_fetch_assoc($resultSet)) {
                echo "<option value=\"$row[id]\">$row[name]</option>";
            }
            ?>
        </select><br>
        <label>Basissatz:</label>
        <select name="basissatz_id">
            <?php
            $resultSet = mysqli_query($connection, "SELECT id, name FROM Basissaetze");
            while($row = mysqli_fetch_assoc($resultSet)) {
                echo "<option value=\"$row[id]\">$row[name]</option>";
            }
            ?>
        </select><br />
        <label>Energie</label>
        <input type="number" name="energie" value=""><br />
        <input type="submit" name="basissatz" value="anlegen">
    </fieldset>
    </form>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>