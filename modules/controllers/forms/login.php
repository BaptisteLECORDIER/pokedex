<?php
    session_start();
    session_destroy();
    session_start();

    include_once('../../models/classes/database.php');

    $db = new DataBase('Localhost','root','','pokedex');



    if (isset($_POST['username']) && isset($_POST['password'])) {
        if ($db -> has_datas ('users', $db -> construct_cond_equal(['username' => $_POST['username'], 'password' => $_POST['password']]))) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
        }
    }
    header('Location: http://pokedex_.test/login.php');



?>