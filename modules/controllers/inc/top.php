<?php
session_start();
include_once('./modules/models/classes/database.php');

$db = new DataBase('Localhost','root','','pokedex');
//$db -> remove_genID ('users', 'id = 1', 'id');
//$db -> add_genID (['username' => 'admin', 'password' => 'admin@', 'preferences' => '[]'], 'users', 'id');
?>