<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', 'pass');
     
} catch (PDOException $e) {
    print "Connetion Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
