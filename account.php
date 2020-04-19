<?php 
    require('inc/bootstrapp.php');
    // session_start();
    // POUR MODIFIER LE COMPORTEMENT DU MESSAGE FLACH JE PEUT LA METRE EN PARAMETRE DE L'OANTIFICATION
    require "inc/functions.php";
    // $auth = new Auth(['restriction_msg'=> 'LOL tu est bloqué !']);
    $auth = App::getAuth() -> restrict();
    // logged_only();
    if(!empty($_POST)){
        if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
            $_SESSION['flash']['danger'] = "les mot de passe en corresponde pas";
        }else{
            $user_id = $_SESSION['auth']-> id;
            $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
            require_once "inc/db.php";
            $req = $pdo -> prepare('UPDATE users SET password = ?')-> execute([$password]);
            $_SESSION['flash']['success'] = "Votre mot de passe a bien ete mise a jours";
        }
    }
?>

<?php require "inc/header.php";?>

<h1>Bienvenu dans votre espace </h1>
<h2> Bonjour <?=$_SESSION['auth'] -> username;?> </h2>

<form action="" method="post">
    <div class="form-group">
    <!-- placeholder() permet de pre remplire les chant  -->
        <input class="form-control" type="password" name="password" placeholder= "changer votre mot de passe"/>
    </div>
    
    <div class="form-group">
        <input class="form-control" type="password" name="password_confirm" placeholder= "confirmation du mot de passe"/>
    </div>

    <button class="btn btn-primary">
        Changement de mot de passe
    </button>
</form>

<?php debug($_SESSION); ?>

<?php require "inc/footer.php";?>