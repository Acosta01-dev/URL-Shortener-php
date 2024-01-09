<?php
try {
    $host = "localhost"; 
    $dbname = "shortener"; 
    $usuario = "root";
    $contraseña = ""; 

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $contraseña);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
}
?>
