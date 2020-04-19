
<?php
    function debug($variable){
         echo '<pre>'.print_r($variable,true).'</pre>';
    }

    // function str_random($length){
    //     $alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    //     // on repeter str_shuffle()
    //     // on melange str_shuffle()
    //     return substr(str_shuffle(str_repeat($alphabet,$length)),0,$length);
    // }

    function logged_only(){
        // if(session_status() == PHP_SESSION_NONE){
        //     session_start();
        //   }

        // if(!isset($_SESSION['auth'])){
        //     $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accer a cette espace";
        //     header('Location: login.php');
        //     exit();
        // }
    };

    function reconnecte_from_cookie(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
          }
        if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])) {
            require_once 'db.php';
            //var_dump($pdo);
           // var_dump($_COOKIE['remember']);
            if(!isset($pdo)){
                 global $pdo;
            }
        
            // separation pas des double egale 

            $remember_token = $_COOKIE['remember'];
            $parts = explode('//',$remember_token);
            //var_dump($user_id);
            $user_id = $parts[0];
             //var_dump($pdo);
            // on fair une regete preparer pours vour quel utilisateur a ce remember_token
            $req = $pdo -> prepare('SELECT * FROM users WHERE id = ?');
            $req -> execute([$user_id]);
           
            $user = $req -> fetch();
            if($user){
                //var_dump($user_id);
                // si on n'a une information on veririffie bien que le token corresponde 
                $expected = $user_id .'//'. $user->remember_token.sha1($user_id .'ratonlaveurs');
                //var_dump($expected);
                //var_dump($remember_token);
                if($expected == $remember_token){
                    // die('reco Automatique ');
                    session_start();
                    // $_SESSION['flash']['success'] = 'Vous etre maintemant connecter';
                    $_SESSION['auth'] = $user;
                    setcookie('remember', $remember_token, time()+ 60*60*24*7);
                    header('Location:account.php');
                }else{
                    // si les deux cle ne correcponde pas alors 
                    setcookie('remember',NULL,-1);
                }
                

            }else{
                setcookie('remember',NULL,-1);
            }
    
        }
    }