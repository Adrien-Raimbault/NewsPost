<h1>Bienvenue sur NewsPost</h1>
<?php
if(isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $bienvenue = "<p>";
    $bienvenue .= "Bonjour ";
    if ($_SESSION['pseudo'] !== "") {
        $bienvenue .= $_SESSION['pseudo'];
    }
    else {
        $bienvenue .= $_SESSION['prenom'];
        $bienvenue .= " ";
        $bienvenue .= $_SESSION['nom'];
    }
    $bienvenue .= "</p>";
    echo $bienvenue;
}