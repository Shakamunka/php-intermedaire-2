<!DOCTYPE html>
<html lang="fr">

<head>
    <?php
    require("fichier-aux/inc_connexion.php");
    session_start();
    if (isset($_GET['ajouter'])) {
        $produit_id = $_GET['ajouter'];


        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }
        $_SESSION['panier'][] = $produit_id;
    }
    ?>
    <title>Accueil</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
    <header>
        <nav class="nav-menu">
            <ul>
                <a href="sup_cookies.php">Suppression du cookie</a>

                <?php
                require("fichier-aux/inc_menu.php");

                ?>
            </ul>
        </nav>
    </header>
    <main>
        <div class="bloc-1">

            <?php
            $result = $mysqli->query('SELECT produit_id, produit_nom, produit_prix FROM produit');
            while ($row = $result->fetch_array()) {
                $id = $row['produit_id'];
                $nom = $row['produit_nom'];
                $prix = $row['produit_prix'];
                $produits[$id] = $nom;
            }
            ?>
            <h2>Nos produits</h2>
            <div class="produit">
                <ul>
                    <?php foreach ($produits as $id => $nom): ?>
                        <li>
                            <?php echo $nom ?> -
                            <?php
                            $result = $mysqli->query("SELECT produit_prix FROM produit WHERE produit_id = $id");
                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_array();
                                $prix = $row['produit_prix'];
                                echo $prix;
                            } else {
                                echo 'Prix non disponible';
                            }
                            ?> euros.
                        </li>
                        <li><a href="fichier-aux/ajouter_au_panier.php?id=<?php echo $id; ?>">Ajouter au panier</a></li>

                    <?php endforeach ?>
                </ul>
            </div>
            <div id="formulaire">
                <form method="GET" action="panier.php">
                    <input type="submit" name="voir_panier" value="Voir le panier">
                </form>
            </div>

        </div>
    </main>
</body>

</html>