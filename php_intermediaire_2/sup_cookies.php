<?php 
if (isset($_COOKIE['panier'])) { 
    setcookie('panier', '', time() - 3600, '/'); 
}
echo $_COOKIE['panier'];
header('Location: index.php');
exit();

?>