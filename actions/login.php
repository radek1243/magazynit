<?php
session_start();
if(filter_input(INPUT_POST, 'login')!==null){
    require_once '../database/DBManager.php';
    $username = filter_input(INPUT_POST, "user");
    $password = filter_input(INPUT_POST, "pass");
    $link = DBManager::connect2();   
    $id = DBManager::login($link, htmlspecialchars($username), hash('sha256', $password));
    $link=null;
    if($id==-1){
        $_SESSION['komunikat'] = "Błędny login lub hasło.";
    }
    else{
        $_SESSION['login'] = $id;
    }
    header("Location: ../index.php");
}
