<?php
class Database{

    private $pdo;

    // on peut dire la valeur pas defaut de l'cocale hoste
    public function __construct($login,$password,$database_name,$host = "localhost"){
        // $database_name == > Espace
        // localhost
        $this -> pdo = new PDO("mysql:dbname=$database_name;host=$host",$login,$password);
        $this -> pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // on modifie la maniere de recupewr l'information dans les tables 
        $this -> pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    }

    // @arg1 la requete
    // @arg2 les parametre
    public function query($query,$params = false){

        if ($params){
            $req = $this -> pdo -> prepare($query); 
            $req -> execute($params);
        }else{
           $req = $this -> pdo -> query($query);
        }
        
            return $req;
    }

    public function lastInsertId (){
       return $this -> pdo -> lastInsertId();
    }
}