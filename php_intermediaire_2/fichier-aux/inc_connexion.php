<?php 
$mysqli = new mysqli('localhost', 'root','root', 'php_intermediaire_2'); 
if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $mysqli->query("SELECT * FROM users WHERE id = $user_id");
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        unset($_SESSION['user_id']);
        $user = null;
    }
} else {
    $user = null;
}
?>