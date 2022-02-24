<?php

class Sql
{
    private string $serverName = "localhost";
    private string $userName = "root";
    private string $database = "sendnews";
    private string $userPassword = "root";
    private object $connexion;

    public function __construct()
    {
        try{
            $this->connexion = new PDO("mysql:host=$this->serverName;dbname=$this->database", $this->userName, $this->userPassword);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
            die("Erreur :  " . $e->getMessage());
        }
    }

    public function insertion($sql, $data)
    {
        try{
            $requete = $this->connexion->prepare($sql);
            
            for($i = 0 ; $i < count($data) ; $i++){
                $value = $data[$i][0];
                dump($requete->bindParam(":$value", $data[$i][1], $data[$i][2]));
            }
            $requete->execute();
            echo "<p>Insertion effectuée</p>";
            }
            catch(PDOException $e){
                die("Erreur :  " . $e->getMessage());
            }
    }

    public function __destruct()
    {
        unset($this->connexion);        
    }
}
