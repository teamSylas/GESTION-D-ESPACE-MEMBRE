<?php 
    $pdo = new PDO("mysql:dbname=Espace;host=localhost",'root','root');
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // on modifie la maniere de recupewr l'information dans les tables 
    $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>