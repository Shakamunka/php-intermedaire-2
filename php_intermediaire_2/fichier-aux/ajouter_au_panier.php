<?php
require('inc_connexion.php');
session_start();

if (isset($_GET['id'])) {
    $produit_id = $_GET['id'];
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $mysqli->query("INSERT INTO carts (user_id, product_id, quantity) VALUES ('$user_id', '$produit_id', 1) ON DUPLICATE KEY UPDATE quantity = quantity + 1");
    } else $panier = [];  
    if (isset($_COOKIE['panier'])) {
        $panier = json_decode($_COOKIE['panier'], true); 
    }
    if (array_key_exists($produit_id, $panier)) {
        $panier[$produit_id] += 1;
    } else {
        $panier[$produit_id] = 1;
    }   
    setcookie('panier', json_encode($panier), time() + 1296000, '/');  
    header('Location: ../panier.php');
} else {
    echo 'ID de produit non spécifié.';
}
?>