<?php
    require 'inc/bootstrapp.php';
    $auth = App::getAuth();
    // var_dump($auth);
    session_start();
    $auth -> connectFromCookie();
    var_dump($auth);
   // require_once 'inc/db.php';
    
    //     // separation pas des double egale 
    //     $remember_token = $_COOKIE['remember'];
    //     $parts = explode('==',$remember_token);
    //     $user_id = $parts[0];
    //     // on fair une regete preparer pours vour quel utilisateur a ce remember_token
    //     $req = $pdo -> prepare('SELECT * FROM users WHERE id = ?');
    //     $req -> execute([$user_id]);
    //     $user = $req -> fetch();
    //     if($user){
    //         //var_dump($user);
    //         // si on n'a une information on veririffie bien que le token corresponde 
    //         $expected = $user_id .'=='. $user->remember_token.sha1($user_id .'ratonlaveurs');
    //         var_dump($expected);
    //         var_dump($remember_token);
    //         if($expected == $remember_token){
    //             die('reco Automatique '); 

    //         }
    //     }

    // }
    // require_once "inc/functions.php";
    
    
    // reconnecte_from_cookie();

    if(isset($_SESSION['auth'])){
        header('Location:account.php');
        exit();
    }
    var_dump($_SESSION)
?>
<?php if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    $req = $pdo -> prepare('SELECT * FROM users WHERE (username = :username OR email= :username) AND confirmed_at IS NOT NULL');
    $req -> execute(['username'=> $_POST['username']]);
    $user = $req -> fetch();
    //debug(password_hash($_POST['password'],PASSWORD_BCRYPT));
    // pour verifier le password_verify () ==>
    //@arg1 le password
    //@arg2 la version acher
    if(password_verify($_POST['password'],$user -> password)){
        session_start();
        $_SESSION['flash']['success'] = 'Vous etre maintemant connecter';
        $_SESSION['auth'] = $user;
        if($_POST['remember']){
            $remember_token = str_random(250);
            $pdo -> prepare('UPDATE users SET remember_token = ? WHERE id =?') -> execute([$remember_token,$user -> id]);
            setcookie('remember',$user->id .'//'. $remember_token.sha1($user -> id .'ratonlaveurs'),time()+60*60*24*7);
        }
        //die(); //pour eviter la redirection 
        header('Location:account.php');
    }else{
        $_SESSION['flash']['danger'] = 'Identifiant ou Mos de passe incorrecte';
    }
    //debug($user -> password );
}
?>



<?php require_once "inc/header.php"; ?>


<h1> se connecter </h1>

<form action ="" method="POST">
    
    <div class="form-group">
        <label for="">Pseudo ou E-mail</label>
        <input type="text" name="username" id="username" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Mot de passe <a href="forget.php">(J'ai oublier mon mots de pass)</a> </label>
        <input type="password" name="password" id="password" class="form-control" />
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="remember" .value="1"/> Se souvenire de moi
        </label>
    </div>

    <button type="submit" class="btn btn-primary">Se Connecter</button>
</form>



  <!-- <?php debug($_SESSION); ?> -->

<?php require "inc/footer.php";?>