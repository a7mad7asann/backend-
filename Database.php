<?php
define("HOST", "localhost");
define("DBNAME", "manager");
define("USER", "root");
define("PASS", "");

try {

    $conn = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
  


} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
}
