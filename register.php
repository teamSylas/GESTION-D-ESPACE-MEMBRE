<!-- traitement du questionnaire  -->
<?php
    // les fonction 
    // require_once 'inc/bootstrapp.php';
    // session_start();

    // $db = App::getDatabase();
    // // $user = $db -> query('SELECT * FROM users WHERE id = ?',['2']) -> fetch();
    // $user = $db -> query('SELECT * FROM users') -> fetchAll();
    // var_dump($user);
    // die();
    require_once 'inc/bootstrapp.php';
    $errors = array();

    $db = App::getDatabase();
    //var_dump($db);
    $validator = new Validator($_POST);
    
    if(!empty($_POST)){

    
   //var_dump($validator);
       
    $validator -> isAlpha("username","Votre Pseudo n'est pas valide (alpha numerique)");
        
        // on ne verifie l'inisiter que quant la vaiable envoier est valide
        if($validator -> isValid()){
                    $validator -> isUnique('username',$db,'users','Ce Pseudo est deja utiliser poas une autre personne');
                   // echo "je suis la";
        }
        $validator -> isEmail('email',"Votre Email m\'est pas valide");
        if($validator -> isValid()){
           $validator -> isUnique('email',$db,'users','Cet Email est deja utiliser poas une autre personne');
           //echo "je suis la";
        }
        $validator -> isConfirmed('password',"Vous devez entre un mots de passe valide ");
        
        // var_dump($validator);
        // var_dump($validator -> isValid());
        // echo '</pre>';
        // die();

                  /*-----------------------------------*
                   Pour confirmer le username          *
                   ------------------------------------*
                  */

        // if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/',$_POST['username'])){
        //     $errors['username'] = "Votre Pseudo n'est pas valide (alpha numerique)";
        // }else{
        //     // pour eviter que les gens s'inscrive plusieur fois on fait un controle sur lke user name
        //     // require_once 'inc/db.php';
        //     $user = $db -> query('SELECT id FROM users WHERE username = ?',[$_POST['username']])-> fetch(); 
        //     // $req -> execute();
        //     // pour verifier les resultats obtenue on utlise la methode fecht pour recupere le premier enregistremewnt 
        //     // $user = $req-> fetch();
        //     if($user){
        //         $errors['username'] = 'Ce Pseudo est deja utiliser poas une autre personne';
        //     }
        //     // debug($user);
        //     // die();

        // }

        /*-----------------------------------*
          Pour confirmer le mail         *
         ------------------------------------*
        */
    

        // if (empty($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
        //     $errors['email']= "Votre Email m'est pas valide";
        // }else{
        //     // require_once 'inc/db.php';
        //     // $req = $pdo -> prepare('SELECT id FROM users WHERE email = ?'); 
        //     $user = $db -> query('SELECT id FROM users WHERE email = ?',[$_POST['email']])-> fetch(); 
        //     // $req -> execute([$_POST['email']]);
        //     // $user = $req-> fetch();
        //     if($user){
        //         $errors['email'] = 'Cet Email est deja utiliser poas une autre personne';
        //     }
        // }

        /*-----------------------------------*
         Pour confirmer le mot de passe      *
         ------------------------------------*
         */

        // if (empty($_POST['password'] || ($_POST['password'] != $_POST['password_confirm']))){
        //     $errors['password']= "Vous devez entre un mots de passe valide ";
        // }
        // inscription dans la base de donne 
        /*---------------------------------------------------*
         Verification des erreur avnant l'envoie dans la base *
         ----------------------------------------------------*
         */
        // if(empty($errors))

        //  var_dump($validator -> isValid());
        //  var_dump($validator);
        // die();
        if($validator -> isValid()){
            // $auth = new Auth();
            // $auth -> register($db ,$_POST['username'],$_POST['password'],$_POST['email']);
            App::getAuth() -> register($db ,$_POST['username'],$_POST['password'],$_POST['email']);
            
            // mail($_POST['email'],'Confirmation de la creation de votre compe',"afin de valider votre compte meci de cliquer sur ce lien\n\nhttp://localhost:8888/Espace_menbre/confirm.php?id=$user_id&$token=$token");
            // // message de connection 
            //$session  = new Session();
            Session::getInstance()-> setFlash('success',"Un email de confirmation vous été envoyer pour valider votre compt");
            // $_SESSION['flash']['success'] = "Un email de confirmation vous été envoyer pour valider votre compt";
            //debug($_SESSION);
            // redirection vert la page de connextion
            //header('Location:account.php');
            App::redirect('login.php');
            exit(); // indique lq fin du scripe 
            // die("Notre compte a bien été creer");
            //echo 'je suis la';

        }else {
        /*---------------------------------------------------*
         Stockage des erreurs pour les affichers*
         ----------------------------------------------------*
         */
        //echo 'je suis la';
        $errors = $validator ->getErrors();
    }
}
?>

<?php require "inc/header.php";?>

<h1>S'inscrire </h1>

<?php if(!empty($errors)): ?>
    <div class="alert alert-danger">
        <p>
            Vous n'avez pas bien remplire le formulaire 
        </p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif?>
<form action ="" method="POST">
    
    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" id="username" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Email</label>
        <input type="text" name="email" id="email" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" />
    </div>

    <div class="form-group">
        <label for="">Confirmer votre mot de passe</label>
        <input type="password" name="password_confirm" id="password_confirm" class="form-control" />
    </div>

    <button type="submit" class="btn btn-primary">M'inscrire</button>
</form>

<?php require "inc/footer.php";?>
