<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<pre>
<?php
$var = "";
$error = "";
exec("Rscript ./".$_REQUEST["file"], $var, $error);
print(join("\n", $var));   
?>
</pre>
</body>
</html>

