<?php
class App{

    // Pour cree un connectoin tout au long de notre aplication on fait :
    static $db = null;
    // et l'orqu'on fera appelle a la base de donnee on modifira la variable statique 



    // Avantage de la classe ces que si je change mes identifiants 
    // je les modifies a un seul endroit
    // et pour appeller ma base de fait seulement App::getDatabase  
    static function getDatabase(){
        // echo 'la fonction----------';
        // Maitentemant il faut mettre une condition pour qu'au demarage self::$db soit initialiser car il es encore null a ce moment là
        if(!self::$db){
        // et maintemant ce que code sera executer une seul foit 
            // echo 'initialisation --------';
            self::$db = new Database('root','root','Espace',"localhost");
        }
         
         return self::$db;
    }

    static function redirect($page){
        header("Location:$page");
        exit();
    }

    static function getAuth(){
       return new Auth (Session::getInstance(),['restriction_msg' => 'Tu es bloquer']);
    }
}