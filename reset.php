
<?php  
    require_once "inc/bootstrapp.php";
?>

<?php  
    if(isset($_GET['id']) && isset($_GET['token'])){
        $auth = App::getAuth();
        $db = App::getDatabase();
        $user = $auth-> checkResetToken($db,$_GET['id'],$_GET['token']);
        // require "inc/db.php";
        // $req = $pdo -> prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB( NOW(), INTERVAL 30 MINUTE)');
        // $req -> execute([$_GET['id'],$_GET['token']]);
        // // on recuper les resultat
        // $user = $req -> fetch();
        if ($user){
            if(!empty($_POST)){
                $validator = new Validator($_POST);
                $validator -> isConfirmed('password');
                // echo"verif";
                // var_dump($validator -> isValid());
                // die();
                if($validator -> isValid()){

            //     }
            // // debug($user);
            //     if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
                    $password = $auth -> hashPassword($_POST['password']) ;
                    $db -> query('UPDATE users SET password =?,reset_at = NULL,reset_token = NULL WHERE id = ?',[$password,$_GET['id']]);
                    $auth -> connect($user);
                    // session_start();
                    // $_SESSION['flash']['success']= "Votre mot de passe a bie nete modifier";
                    // $_SESSION['auth'] = $user;
                    Session::getInstance()->setFlash('success',"Votre mot de passe a bie nete modifier");
                    App::redirect('account.php');
                    // header('Location: account.php');
                    // exit();
                }
            }
        }else{
            Session::getInstance()->setFlash('danger',"Ce token n'est pas valide");
        //    echo"je suis la ";
        //     die();
            // session_start();
            // $_SESSION['flash']['danger'] = "Ce token n'est pas valide";
            App::redirect('login.php');
            // header('Location: login.php');
            exit();
        }
    }else{
        // header('Location: login.php');
        App::redirect('login.php'); 
    }
?>
<?php require "inc/header.php";?>


<h1> Reinitialisation du mot de passe  </h1>

<form action ="" method="POST">
    
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Confirmation du mot de passe</label>
        <input type="password" name="password_confirm" id="password_confirm" class="form-control" />
    </div>


    <button type="submit" class="btn btn-primary">Reinitialisation le mots de passe</button>
</form>



  <!-- <?php debug($_SESSION); ?> -->

<?php require "inc/footer.php";?>