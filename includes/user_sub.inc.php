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
        $serverName = "localhost";
        $userName = "root";
        $database = "sendnews";
        $userPassword = "root";

        try {
            $conn = new PDO("mysql:host=$serverName; dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $requete = $conn->prepare("SELECT * FROM T_users WHERE usermail='$email'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
           
            if(count($resultat) !== 0) {
                echo "<p>Votre adresse est déjà enregistrée dans la base de données</p>";
            }

            else {
                $query = $conn->prepare("
                INSERT INTO T_users(usename, usefirstname, usermail, usepassword)
                VALUES (:name, :firstname, :email, :password)
                ");

                $query->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
                $query->bindParam(':firstname', $firstname, PDO::PARAM_STR_CHAR);
                $query->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
                $query->bindParam(':password', $password);
                $query->execute();

                echo "<p>Insertions effectuées</p>";
            }
        } catch (PDOException $e) {
            die("Erreur :  " . $e->getMessage());
        }

        $conn = null;
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
