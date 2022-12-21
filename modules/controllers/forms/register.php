<?php
    session_start();


    include_once('../../models/classes/database.php');

    $db = new DataBase('Localhost','root','','pokedex');



    if (isset($_POST['username']) && isset($_POST['password'])) {

        $db -> add_genID (['username' => $_POST['username'], 'password' => $_POST['password'], 'preferences' => '[]'], 'users', 'id');

    }

    header('Location: http://pokedex_.test/login.php');

?>