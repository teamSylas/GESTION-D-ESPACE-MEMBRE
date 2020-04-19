<?php 
    require 'inc/bootstrapp.php';
    $db = App::getDatabase();
    //var_dump($db);
    $auth = new Auth($session);
    // $auth -> confirm($_GET['id'],$_GET['token']);
    // Auth::confirm($user_id,$token);
    // session_start();
    // on recuper d'abord tous les prametre 
    // $user_id = $_GET['id'];
    // $token = $_GET['token'];
    // require 'inc/db.php';
    // require_once 'inc/functions.php';
    // pour recuper tous les information dans la section c'est SELECT*
    // $req = $pdo -> prepare('SELECT confirmation_token FROM users WHERE id=?');
    
    // $user = $db -> query('SELECT * FROM users WHERE id=?',[$user_id]) -> fetch();
    // $req -> execute([$user_id]);
    // $user = $req -> fetch();
    
    //session_destroy();
    // on test si le token du user correspon a celui qui est passer en parametre
   // if($user && $user-> confirmation_token == $token){
    echo"<br>";
    var_dump($_GET['token']);
    echo"<br>";
    // var_dump($db);
    // var_dump(App::getAuth() -> confirm($db,$_GET['id'],$_GET['token'],Session::getInstance()));
    
    // var_dump($user -> confirmation_token);
    if(App::getAuth() -> confirm($db,$_GET['id'],$_GET['token'],Session::getInstance())){
        //App::redirect('account.php');
        // pour eviter que l'utilisateur ai acces apres la confirmation on modifir sont champs dans la base de donnee
        // $req = $pdo -> prepare('UPDATE users SET confirmation_token = NULL,confirmed_at = NOW() WHERE id=?')-> execute([$user_id]);
        // $_SESSION['auth']=$user;
        //$_SESSION['flash']['success'] = "Votre compte a bien ete valider";
        Session::getInstance()-> setFlash('success',"Votre compte a bien ete valider");
        App::redirect('account.php');
        // debug($_SESSION);
        header('Location:account.php');
    //    print_r($_SESSION);
        
    }else{
        // die('Ok');
        //App::redirect('account.php');
        //die('il y a un probeme de votre coter veririer bien vos information');
        // on informer l'utilisateur de se wquu c'est passer en faisant un message flache 
        /***
         * dans session :
         * @arg1 est le type de message
         * @arg2 est le contenue du message
         */
        // $_SESSION['flash']['danger']="Ce token n'est plus validable";
        Session::getInstance()-> setFlash('danger',"Ce token n'est plus validable");
        // print_r($_SESSION);
        // die();
        App::redirect('login.php');
        
        // header('Location:login.php');
        // 
       // App::redirect('login.php');
        //header('Location: login.php');
    }
?>