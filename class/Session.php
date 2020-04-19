<?php
    class Session {

        // ---------------------
        // le designe patterne Singleton 
        // --------------------
        static $instance;

        public function __construct(){
            session_start(); 
        }

        static function getInstance(){
            // return new Session();
            if(!self::$instance){
                self::$instance = new Session();
            }
            return self::$instance;
        }

        

        public function setFlash($key,$message){
            $_SESSION['flash'][$key] = $message;
        }

        // pour verifier si on ma des messages flashe en memoire de la sessions    
        public function hasFlashes(){
            return isset($_SESSION['flash']);
            //renvoir true si present  ou sfalse si noms 
        }

        // une fonction qu renvera tous les message fashe 

        public function getFlashes(){
            $flash = $_SESSION ['flash'];
            unset($_SESSION ['flash']);
            return $flash ;
        }


        public function write($key,$value){
            $_SESSION[$key] = $value;
        }

        public function read($key){
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }


        public function delete($key){
            unset($_SESSION[$key]);
        }

    }