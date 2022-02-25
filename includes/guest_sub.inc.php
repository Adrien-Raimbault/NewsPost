<h2>S'abonner aux newsletter</h2>

<?php
if (isset($_POST['frm'])) {
    $email = trim(mb_strtolower($_POST['email'])) ?? '';

    $erreur = array();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($erreur, "Veuillez saisir un e-mail valide");

    if (count($erreur) === 0) {
        $subdata = array('usermail',"$email", PDO::PARAM_STR_CHAR);
        $subdata2 = array('id_role','3', PDO::PARAM_INT);
        $data = array($subdata, $subdata2);

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
        include 'frmGuest_Sub.php';
    }
} else {
    echo "Merci de renseigner le formulaire";
    $name = $firstname = $email = '';
    include 'frmGuest_Sub.php';
}
