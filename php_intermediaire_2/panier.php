<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Votre panier</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="stylesheet.css">
    <?php
    require('fichier-aux/inc_connexion.php');
    require('fichier-aux/ajouter_au_panier.php');
    ?>
</head>

<header>
    <nav class="nav-menu">
        <ul>
            <?php
            require("fichier-aux/inc_menu.php");
            ?>
            <a href="index.php">Page d'accueil</a>
        </ul>
    </nav>
</header>

<body>
    <div class="bloc-1">
    <?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $result = $mysqli->query("SELECT product_id, quantity FROM carts WHERE user_id = $user_id");

    if ($result) {
        $panier = [];
        while ($row = $result->fetch_assoc()) {
            $panier[$row['product_id']] = $row['quantity'];
        }
    } else {
        echo "Erreur de requête SQL : " . $mysqli->error;
        $panier = [];
    }
} elseif (isset($_COOKIE['panier'])) {
    $panier = json_decode($_COOKIE['panier'], true);
} else {
    $panier = [];
}
if (!empty($panier)) {
    foreach ($panier as $product_id => $quantity) {
        $query = "SELECT produit_nom, produit_prix FROM produit WHERE produit_id = $product_id";
        $result = $mysqli->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $produit_nom = $row['produit_nom'];
            $produit_prix = $row['produit_prix'];
            echo "<p>$produit_nom - Quantité: $quantity - Prix: $produit_prix €</p>";
        } else {
            echo "Erreur de récupération des détails du produit.";
        }
    }
    
} else {
    echo "Votre panier est vide.";
}
?>
    </div>
</body>

</html>