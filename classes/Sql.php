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

    public function insertion($sqlTable, $data)
    {
        $tables = array();
        $values = array();
        for($i = 0 ; $i < count($data); $i++){
            array_push($tables, $data[$i][0]);
            $val = ":" . $data[$i][0];
            array_push($values, $val);
        }
        $tables = implode(",", $tables);
        $values = implode(",", $values);

        $sql = "INSERT INTO $sqlTable($tables) VALUES ($values)";

        try{
            $requete = $this->connexion->prepare($sql);
            
            for($i = 0 ; $i < count($data) ; $i++){
                $value = $data[$i][0];
                $requete->bindParam(":$value", $data[$i][1], $data[$i][2]);
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
