<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    if(filter_input(INPUT_POST, "submit")!==null){
        $link = DBManager::connect2();
        $result = DBManager::insert($link, Query::$INSERT_MODEL,array(filter_input(INPUT_POST, 'nazwa')));
        $link=null;
        if($result===TRUE){
            $_SESSION['komunikat'] = "Dodano model do bazy.";
            header("Location: ../forms/models.php");
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się dodać modelu do bazy.";
            header("Location: ../forms/models.php");
        }
    }
    else{
        $_SESSION['komunikat'] = "Błąd ogólny.";
        header("Location: ../forms/models.php");
    }
}
