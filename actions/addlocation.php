<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    if(filter_input(INPUT_POST, "submit")!==null){
        $link = DBManager::connect2();       
        if(filter_input(INPUT_POST, "widoczna")!==null){
            $result = DBManager::insert($link, Query::$INSERT_LOCATION,array(filter_input(INPUT_POST, "nazwa"), strtoupper(filter_input(INPUT_POST, "skrot")), 1));
        }
        else{
            $result = DBManager::insert($link, Query::$INSERT_LOCATION,array(filter_input(INPUT_POST, "nazwa"), strtoupper(filter_input(INPUT_POST, "skrot")), 0));
        }
        $link=null;
        if($result===TRUE){
            $_SESSION['komunikat'] = "Dodano lokalizację do bazy.";
            header("Location: ../forms/locations.php");
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się dodać lokalizacji do bazy.";
            header("Location: ../forms/locations.php");
        }
    }
    else{
        $_SESSION['komunikat'] = "Błąd ogólny.";
        header("Location: ../forms/locations.php");
    }
}
