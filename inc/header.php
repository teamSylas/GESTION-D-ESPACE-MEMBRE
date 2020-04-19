<?php
// on va testes si la session est deja ouverte 
  // if(session_status() == PHP_SESSION_NONE){
  //   session_start();
  // }
  require_once 'inc/bootstrapp.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Espace menbre</title>

    <link rel="canonical" href="css/bootstrap.min.css">

    <!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Favicons -->


    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">Espace Connexion</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <?php if(isset($_SESSION['auth'])): ?>
        <li class="nav-item active">
          <a class="nav-link" href="logout.php">Se deconnecter<span class="sr-only">(current)</span></a>
        </li>
      <?php else:?>
        <li class="nav-item active">
          <a class="nav-link" href="../Espace_menbre_pro/register.php">S'inscrire<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Se connecter</a>
        </li>
      <?php endif; ?>
      
    </ul>
    
  </div>
</nav>

<main role="main" class="container">
  <!-- si on n'a quelque chose dans la section en va la pacourrie  -->
<!-- <?php //if(isset($_SESSION['flash'])): ?> -->
<!-- on charge l'instance et on verifie s'il y un message en memoire  -->
<?php if(Session::getInstance()-> hasFlashes()): ?>
  <?php foreach(Session::getInstance()-> getFlashes() as $type => $message): ?>
      <div class="alert alert-<?=$type;?>">
      <?= $message; ?>
      </div> 
    
  <?php endforeach; ?>
  <!-- <?php// unset($_SESSION['flash']);?> -->
  <!-- plus besion de unset car la methode se charge automatiquement  -->
<?php endif; ?>