<?php
class Validator {

    private $data; // les donnee de poste  
    private $errors = [];// le tableau de eurre


    public function __construct($data){
        $this -> data = $data;
    }
    // |- verif si est dans la base ou pas || s'il est null
    private function getField($field){
        //$value = $this -> data[$field];
        if(!isset($this -> data[$field])){
        //     // $nll = 'null';
            return  null ;
        }
        return  $this -> data[$field];
    }

    public function isAlpha($field, $errorMesg){
        // Pour le if avant de tester la validation on va verifier s'il exsiste dans la base de donnee |-
        //var_dump($this-> getField([$field]));
        if(!preg_match('/^[a-zA-Z0-9_]+$/',$this-> getField($field))){
            //echo "je suis la 1";
            $this -> errors[$field] = $errorMesg;
        }
    
    }

    public function isUnique($field,$db,$table,$errorMesg){
        $record = $db -> query("SELECT id FROM $table WHERE $field = ?",[$this -> getField($field)])-> fetch(); 
            if($record){
               // echo "je suis la 2";
                $this -> errors[$field] = $errorMesg;
            }
    }

    public function isEmail($field,$errorMesg){
        if (!filter_var($this-> getField($field),FILTER_VALIDATE_EMAIL)){
            // $errors['email']= "Votre Email m'est pas valide";
            $this -> errors[$field] = $errorMesg;
            //echo "je suis la 3";
         }
        //  else{
        //     // require_once 'inc/db.php';
        //     // $req = $pdo -> prepare('SELECT id FROM users WHERE email = ?'); 
        //     $user = $db -> query('SELECT id FROM users WHERE email = ?',[$_POST['email']])-> fetch(); 
        //     // $req -> execute([$_POST['email']]);
        //     // $user = $req-> fetch();
        //     if($user){
        //         $errors['email'] = 'Cet Email est deja utiliser poas une autre personne';
           // }
        //}
    }

    public function isConfirmed($field,$errorMesg=''){
        $value = $this -> getField($field);
        if (empty($value) || ($value != $this -> getField($field.'_confirm'))){
            $this -> errors[$field] = $errorMesg;
            //echo "je suis la 4";
        }
    }

    public function isValid(){
        return empty ($this -> errors);
        // si tableau d'erreur vide true
        // si non false 
    }

    public function getErrors(){
        return $this -> errors;
    }
}