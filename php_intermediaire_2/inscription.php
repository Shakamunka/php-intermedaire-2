<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="stylesheet.css">
    <?php require("fichier-aux/inc_connexion.php"); ?>
    <title>Inscription</title>
</head>
<body>
    <main>
        <div class="bloc-inscription">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_input_login = $mysqli->real_escape_string($_POST['user_input_login']);
                $user_input_password = $mysqli->real_escape_string($_POST['user_input_password']);

                if (!empty($user_input_login) && !empty($user_input_password)) {
                    $check_query = "SELECT user_login FROM user WHERE user_login = '$user_input_login'";
                    $resultat_check = $mysqli->query($check_query);

                    if ($resultat_check->num_rows > 0) {
                        echo '<div class="message"><p>Ce login existe déjà, veuillez en choisir un autre.</p></div>';
                    } else {
                        $hashed_password = password_hash($user_input_password, PASSWORD_DEFAULT);
                        $query = "INSERT INTO user (user_login, user_password) VALUES ('$user_input_login', '$hashed_password')";
                        if ($result = $mysqli->query($query)) {
                            echo '<div class="message"><p>Inscription réalisée avec succès.</p></div>';
                            header('Location: login.php');
                        } else {
                            echo '<div class="message"><p>Erreur lors de l\'inscription : ' . $mysqli->error . '</p></div>';
                        }
                    }
                } else {
                    echo '<div class="message"><p>Les champs n\'ont pas été correctement remplis.</p></div>';
                }
            }
            ?>

            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="form-signin" method="post">
                <input type="text" id="user_login" name="user_input_login" placeholder="Login" required>
                <input type="password" id="user_password" name="user_input_password" placeholder="Password" required>
                <input type="submit" id="submit" value="Valider">
            </form>
            <div class="lien">
                <a href="login.php">Connexion</a>
                <a href="index.php">Page d'accueil</a>
            </div>
        </div>
    </main>
</body>
</html>