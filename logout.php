<?php 
    // session_destroy();
    // session_start();
    // setcookie('remember', NULL,-1);
    // unset($_SESSION['auth']);
    require_once 'inc/bootstrapp.php';
    App::getAuth()-> logout();
    Session::getInstance() -> setFlash('success','vous etes maitant deconnecter');
    App::redirect('login.php');
    // $_SESSION['flash']['success'] = 'vous etes maitant deconnecter';
    // header ('Location:login.php')

?>