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

$subdata = array('usermail','boulet@email.fr', PDO::PARAM_STR_CHAR);
$subdata2 = array('id_role','3', PDO::PARAM_INT);

$data = array($subdata, $subdata2);

$req = new Sql();
$req->insertion("T_USERS", $data);
