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
   
    // Connect to local SQL server
    $con=mysqli_connect("localhost","root","","manuel-blechschmidt");
    
    if(isset($_REQUEST["molekuel"])) {
        $sql = "INSERT Molekuele (name) VALUES ('".
            mysqli_real_escape_string($con, $_REQUEST["molekuel"])."')";
            echo $sql;
            if(!mysqli_query($con, $sql)) {
                echo mysqli_error($con);
            }
    }
            
    // Gehe durch alle Zeilen des Ergebnisses
    $rs = mysqli_query($con, "SELECT id, name FROM Molekuele");
    
    
    while($row = mysqli_fetch_assoc($rs)) {
        // Gebe Zeile aus
        print_r($row);
    }
    
    mysqli_close($con);
    ?>
    <form method="POST">
        <fieldset>
            <legend>Neues Molekül anlegen</legend>
            <label>Neuer Molekülname</label><br>
            <input type="text" name="molekuel"><br>
            <input type="submit" name="Anlegen">
        </fieldset>
    </form>
</body>
</html>