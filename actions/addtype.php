<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    if(filter_input(INPUT_POST, "submit")!==null){
        $link = DBManager::connect2();
        $result = DBManager::insert($link, Query::$INSERT_TYPE, array(filter_input(INPUT_POST, 'typ')));
        $link=null;
        if($result===TRUE){
            $_SESSION['komunikat'] = "Dodano typ do bazy.";
            header("Location: ../forms/types.php");
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się dodać typu do bazy.";
            header("Location: ../forms/types.php");
        }
    }
    else{
        $_SESSION['komunikat'] = "Błąd ogólny.";
        header("Location: ../forms/types.php");
    }
}

