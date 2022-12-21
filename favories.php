<?php
    session_start();

    include_once('./modules/models/classes/database.php');

    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        $db = new DataBase('Localhost','root','','pokedex');
        $datas = $db -> read_condition ('users', $db -> construct_cond_equal (['username' => $username, 'password' => $password]));

        $preferences = (json_decode($datas[0]['preferences'],true));

        if (isset($_GET['pokemon'])) {
            if (!(in_array( $_GET['pokemon'], $preferences))) {
                array_push($preferences, $_GET['pokemon']);
                $db -> modify (['preferences' => json_encode($preferences)], 'users', $db -> construct_cond_equal (['username' => $username, 'password' => $password]));
            } else {
                function eraseValueArray ($value, $array) {
                    $key = array_search($value, $array);
                    $test = [];
                    foreach ($array as $key2 => $value)
                        if ($key != $key2) {
                            array_push($test, $value);
                        }
                    return $test;
                }
            
                $preferences = eraseValueArray ($_GET['pokemon'], $preferences);
                $db -> modify (['preferences' => json_encode($preferences)], 'users', $db -> construct_cond_equal (['username' => $username, 'password' => $password]));

            }


        };



    }




    

    

?>