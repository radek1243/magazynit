<?php
session_start();
if(isset($_SESSION['login'])){    
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    if(filter_input(INPUT_POST, "submit")!==null){
        $link = DBManager::connect2();
        $result = DBManager::insert($link, Query::$INSERT_DEVICE, array(filter_input(INPUT_POST, "typ"), filter_input(INPUT_POST, "model"), filter_input(INPUT_POST, "lok"), 
                strtoupper(filter_input(INPUT_POST, "sn")), strtoupper(filter_input(INPUT_POST, "sn2")), filter_input(INPUT_POST, "stan"), filter_input(INPUT_POST, "opis")));
        $link=null;
	if(isset($_SESSION['dev_type'])===false) $_SESSION['dev_type'] = filter_input(INPUT_POST, "typ");
	if(isset($_SESSION['dev_model'])===false) $_SESSION['dev_model'] = filter_input(INPUT_POST, "model");
        if($result===TRUE){
            $_SESSION['komunikat'] = "Dodano urządzenie do bazy.";
            header("Location: ../forms/devices.php");
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się dodać urządzenia do bazy.";
            header("Location: ../forms/devices.php");
        }
    }
    else{
        $_SESSION['komunikat'] = "Błąd ogólny.";
        header("Location: ../forms/devices.php");
    }
}
