<?php  
   require_once 'inc/bootstrapp.php';
?>
<?php if (!empty($_POST) && !empty($_POST['email'])){
    $db = App::getDatabase();
    $auth = App::getAuth();
    $session = Session::getInstance();
    if ($auth -> resetPassword($db, $_POST['email'])){
        $session -> setFlash('success','Les insctruction de rapelle du mot de passe  vous ont ete envoyer');
        App::redirect('login.php');
    }else{
        $session -> setFlash('danger','Aucun compte ne correspon a cette adresse mail');
    }
     
    
    //debug($user -> password );
}
?>




<?php require "inc/header.php";?>

<h1> Mot de passe oublier </h1>

<form action ="" method="POST">
    
    <div class="form-group">
        <label for="">E-mail</label>
        <input type="email" name="email" id="email" class="form-control" />
    </div>


    <button type="submit" class="btn btn-primary">Se Connecter</button>
</form>



  <!-- <?php debug($_SESSION); ?> -->

<?php require "inc/footer.php";?>