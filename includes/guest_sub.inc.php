<?php

// Instancié via Objet PDO connection
//
if (isset($_POST['frm'])) {
    $email = trim(mb_strtolower($_POST['email'])) ?? '';

    $erreur = array();

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($erreur, "Veuillez saisir un e-mail valide");

    if (count($erreur) === 0) {
        // Instancier l'objet SQL
        $serverName = "localhost";
        $userName = "root";
        $database = "sendnews";
        $userPassword = "root";

        // Appeler la methode insertion de l'objet SQL
        try {
            $conn = new PDO("mysql:host=$serverName; dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $requete = $conn->prepare("SELECT * FROM T_users WHERE usermail='$email'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
           
            if(count($resultat) !== 0) {
                echo "<p>Votre adresse est déjà enregistrée dans la base de données</p>";
            }

            else {
                $query = $conn->prepare("
                INSERT INTO T_users(USERMAIL, ID_ROLE)
                VALUES (:email, :id_role)
                ");

                $role = 3;
                
                $query->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
                $query->bindParam(':id_role', $role, PDO::PARAM_INT);
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
        include 'frmGuest_Sub.php';
    }
} else {
    echo "Merci de renseigner le formulaire";
    $name = $firstname = $email = '';
    include 'frmGuest_Sub.php';
}
