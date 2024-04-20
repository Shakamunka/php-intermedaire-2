<!DOCTYPE html>
<html lang="fr">
<meta charset="utf-8">
<link rel="stylesheet" href="stylesheet.css">

<head>
    <?php
    require("fichier-aux/inc_connexion.php");
    $user_input_login = isset($_POST['user_input_login']) ? $_POST['user_input_login'] : "";
    $user_input_password = isset($_POST['user_input_password']) ? $_POST['user_input_password'] : "";
    ?>
    <title>Connexion</title>

</head>

<body>
    <main>
        <div class="bloc-login">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_input_login = isset($_POST['user_input_login']) ? $mysqli->real_escape_string($_POST['user_input_login']) : "";
                $user_input_password = isset($_POST['user_input_password']) ? $mysqli->real_escape_string($_POST['user_input_password']) : "";
                $message = "";

                if (empty($user_input_login) || empty($user_input_password)) {
                    $message = "Les champs n'ont pas été correctement remplis";
                } else {
                    $query = "SELECT user_id, user_login, user_password FROM user WHERE user_login = '$user_input_login'";
                    $result = $mysqli->query($query);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $stored_password = $row['user_password'];

                        if (password_verify($user_input_password, $stored_password)) {
                            session_start();
                            $_SESSION['user_id'] = $row['user_id'];
                            $_SESSION['user_login'] = $user_input_login;
                            header('Location: index.php');
                            exit();
                        } else {
                            $message = "Mot de passe incorrect";
                        }
                    } else {
                        $message = "Ce login n'existe pas";
                    }
                }
            }
            ?>

            <form action=<?php echo $_SERVER["PHP_SELF"]; ?> method="POST" id="form-login">
                <input type="text" id="user_input_login" name="user_input_login" placeholder="Login" required>
                <input type="password" id="user_input_password" name="user_input_password" placeholder="Password"
                    required>
                <input type="submit" id="submit" value="valider">
            </form>
            <div class="lien-accueil">
                <a href="inscription.php">Incription</a>
                <a href="../index.php">Allez a la page d'accueil</a>
            </div>
        </div>
    </main>
</body>

</html>