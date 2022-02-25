<h2>Création de votre compte</h2>

<?php
if (isset($_POST['frm'])) {
    $name = htmlentities(mb_strtoupper(trim($_POST['name']))) ?? '';
    $firstname = htmlentities(ucfirst(mb_strtolower(trim($_POST['firstname'])))) ?? '';
    $email = trim(mb_strtolower($_POST['email'])) ?? '';
    $password = htmlentities(trim($_POST['password'])) ?? '';
    $passwordverif = htmlentities(trim($_POST['passwordverif'])) ?? '';

    $erreur = array();

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($name)) !== 1)
        array_push($erreur, "Veuillez saisir votre nom");
    else
        $name = html_entity_decode($name);

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($firstname)) !== 1)
        array_push($erreur, "Veuillez saisir votre prénom");
    else
        $firstname = html_entity_decode($firstname);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($erreur, "Veuillez saisir un e-mail valide");

    if (strlen($password) === 0)
        array_push($erreur, "Veuillez saisir un mot de passe");

    if (strlen($passwordverif) === 0)
        array_push($erreur, "Veuillez saisir la vérification de votre mot de passe");

    if ($password !== $passwordverif)
        array_push($erreur, "Vos mots de passe ne correspondent pas");

    if (count($erreur) === 0) {
        $subdata = array('USERMAIL',"$email", PDO::PARAM_STR_CHAR);
        $subdata2 = array('ID_ROLE','3', PDO::PARAM_INT);
        $subdata3 = array('USENAME', "$name", PDO::PARAM_STR_CHAR);
        $subdata4 = array('USEFIRSTNAME', "$firstname", PDO::PARAM_STR_CHAR);
        $subdata5 = array('USEPASSWORD', "$password" , PDO::PARAM_STR_CHAR);

        $data = array($subdata, $subdata2, $subdata3, $subdata4, $subdata5);

        $req = new Sql;
        if($req->select("T_USERS", $data, "Ce compte existe déjà")){
            $req->insertion("T_USERS", $data);
        }

    } else {
        $messageErreur = "<ul>";
        $i = 0;
        do {
            $messageErreur .= "<li>" . $erreur[$i] . "</li>";
            $i++;
        } while ($i < count($erreur));

        $messageErreur .= "</ul>";

        echo $messageErreur;
        include 'frmUser_Sub.php';
    }
} else {
    echo "Merci de renseigner le formulaire";
    $name = $firstname = $email = '';
    include 'frmUser_Sub.php';
}
