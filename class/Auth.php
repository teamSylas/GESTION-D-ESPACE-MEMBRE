<?php
class Auth{

    private $db;
    private $options = [
        'restriction_msg' => "Vous n'avez pas le droit d'accer a cette espace"
    ];
    
    private $session;

    public function __construct($session, $options = []){
        $this -> options = array_merge($this -> options, $options);
        $this -> session = $session;

    }

     // Pour la methode de hachage du mode de passe 
     public function hashPassword($password){
        return password_hash($password,PASSWORD_BCRYPT);
    }

    public  function register($db,$username,$password,$email){
        // le password est passer en parametre donc plus de $_POST['password']
            // on doit acher le mots de passe 
                $password = $this -> hashPassword($password);
                $token = Str::random(60);
                $db -> query("INSERT INTO users SET username = ?, password = ?, email=?,confirmation_token=?",[
                    // on passe en suite les parametre 
                    $username, //$_POST['username'],
                    $password,
                    $email, //$_POST['email'],
                    $token
                    ]);
                
                $user_id = $db -> lastInsertId(); //revoie le dernier id genere pas PDO
                // envoie du token pas mail
                /**
                 * maim(
                 * @arg1 ==> l'email envoyer
                 * @arg1 ==> l'Objet
                 * @arg2 ==> le comptenue du mail)
                 */
                mail($email,'Confirmation de la creation de votre compe',"afin de valider votre compte meci de cliquer sur ce lien\n\nhttp://localhost:8888/Espace_menbre/confirm.php?id=$user_id&$token=$token");
                
    }
// Dans le car de la confirmation on na besoins de lui envoie la section 
    public function confirm($db,$user_id,$token){
        $user = $db -> query('SELECT * FROM users WHERE id=?',[$user_id]) -> fetch();
        // echo "confirmation_token ==-----";
        // var_dump($user -> confirmation_token);
        // echo "je suis la";
        
        if($user && $user-> confirmation_token == $token){
            echo "je suis la B";
            $db -> query('UPDATE users SET confirmation_token = NULL,confirmed_at = NOW() WHERE id=?', [$user_id]);
            // $_SESSION['auth']=$user;
            $this-> session  -> write('auth',$user);
            return true ;
        }else{

            return false;
            echo "je suis la R";
        }
    }


    public function restrict(){
        if(!$this ->session -> read('auth')){
            // comment il a ete passer en option on peut lui passer des argument 
            $this -> session -> setFlash('danger',$this -> options['restriction_msg']);
            header('Location:login.php');
            // App::redirect(login.php);
            exit();
          }

    }

    public function user(){
        if(!$this -> session -> read('auth')){
            return false;
        }
        return $this -> session -> read('auth');
    }

    public function connect($user){
        $this -> session -> write('auth', $user);
    }

    public function connectFromCookie($db){
        
        if(isset($_COOKIE['remember']) && !$this-> user()) {
            // require_once 'db.php';
            //var_dump($pdo);
           // var_dump($_COOKIE['remember']);
            // if(!isset($pdo)){
            //      global $pdo;
            // }
        
            // separation pas des double egale 

            $remember_token = $_COOKIE['remember'];
            $parts = explode('//',$remember_token);
            //var_dump($user_id);
            $user_id = $parts[0];
             //var_dump($pdo);
            // on fair une regete preparer pours vour quel utilisateur a ce remember_token
            $user = $db -> query('SELECT * FROM users WHERE id = ?',[$user_id])-> fetch();
            // $req -> execute();
            // $user = $req -> fetch();
            if($user){
                //var_dump($user_id);
                // si on n'a une information on veririffie bien que le token corresponde 
                $expected = $user_id .'//'. $user->remember_token.sha1($user_id .'ratonlaveurs');
                //var_dump($expected);
                //var_dump($remember_token);
                if($expected == $remember_token){
                    // die('reco Automatique ');
                    // session_start();
                    // $_SESSION['flash']['success'] = 'Vous etre maintemant connecter';
                    $this -> connect($user);
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

    public function login ($db, $username,$password,$remember = false){
       
    //  if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
        $user = $db -> query('SELECT * FROM users WHERE (username = :username OR email= :username) AND confirmed_at IS NOT NULL',['username'=> $username])-> fetch();
        // $req -> execute(['username'=> $_POST['username']]);
        // $user = $req -> fetch();
        //debug(password_hash($_POST['password'],PASSWORD_BCRYPT));
        // pour verifier le password_verify () ==>
        //@arg1 le password
        //@arg2 la version acher
        // var_dump($user);
        // die();
        if(password_verify($password,$user -> password)){
            // session_start();
            // $_SESSION['flash']['success'] = 'Vous etre maintemant connecter';
            $this -> connect($user);
            // $_SESSION['auth'] = $user;
            if($remember){
                $this -> remember($db, $user->id);
            }
            // header('Location:account.php');
            // exit();
            return $user;
        //     var_dump ($_SESSION);
        //    die(); //pour eviter la redirection 
            
        }else{
            // $_SESSION['flash']['danger'] = 'Identifiant ou Mos de passe incorrecte';
            return false;
        }
    // }
}

    public function logout(){
        setcookie('remember', NULL,-1);
        $this ->session -> delete('auth');
        // unset($_SESSION['auth']);
    }

    public function remember($db,$user_id){
        $remember_token = Str::random(250);
        $db -> query('UPDATE users SET remember_token = ? WHERE id =?',[$remember_token,$user_id]);
        setcookie('remember',$user_id .'//'. $remember_token.sha1($user_id .'ratonlaveurs'),time()+60*60*24*7);
    }

     public function resetPassword($db,$email){
        $user = $db -> query('SELECT * FROM users WHERE email= ? AND confirmed_at IS NOT NULL',[$email])-> fetch();
    // $req -> execute(['email'=> $_POST['email']]);
    // $user = $req -> fetch();
    //debug(password_hash($_POST['password'],PASSWORD_BCRYPT));
    // pour verifier le password_verify () ==>
    //@arg1 le password
    //@arg2 la version acher
    if($user){
        $reset_token = Str::random(60);
        $db -> query('UPDATE users SET reset_token = ?,reset_at = NOW() WHERE id = ?',[$reset_token ,$user-> id]);
        // $_SESSION['flash']['success'] = 'Les insctruction de rapelle du message vou on ete envoyer';
        mail($_POST['email'],'reinitialisation de votre mots de passe ',"afin de reinitialiser votre compte meci de cliquer sur ce lien\n\nhttp://localhost:8888/Espace_menbre/reset.php?id={$user->id}&token=$reset_token");
        return $user;
        // debug($reset_token);
        //die($reset_token);
        // header('Location: login.php');
    }
    // else{
    //     $_SESSION['flash']['danger'] = 'Aucun compte ne correspon a cette adresse mail';
    // }
    return false;
    }


    public function checkResetToken($db,$user_id,$token){
        $user = $db -> query('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB( NOW(), INTERVAL 30 MINUTE)',[$user_id,$token])-> fetch();
        // $req -> execute([$_GET['id'],$_GET['token']]);
        // on recuper les resultat
        // $user = $req -> fetch();
        return $user;
    }


}