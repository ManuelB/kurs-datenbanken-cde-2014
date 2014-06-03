<?php
$con=mysqli_connect("localhost","root","","kurs04");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$res = mysqli_query($con,"SELECT * FROM adressbuch");

while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}

mysqli_close($con);
?>