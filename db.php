<?php
$servername = "localhost";
$username = "root"; 
$password = "alaa2004"; 
$dbname = "gaming_website";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
