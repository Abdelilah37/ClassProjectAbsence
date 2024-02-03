<?php
// Paths updated
$servername = "localhost";
$username = "root";
$password ="";
$db ="absenceprojetbase";

try{
      $pdo_conn = new PDO("mysql:host=$servername;dbname=$db",$username,$password);
      $pdo_conn->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
}
catch(PDOException $e){
      echo "Connection Failed : ".$e->getMessage();
}

?>
