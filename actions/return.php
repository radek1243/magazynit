<?php
session_start();
if(isset($_SESSION['login'])){  
    require_once '../database/DBManager.php';
    require_once '../data/Device.php';
    require_once '../database/Query.php';
    if(filter_input(INPUT_POST, "ret")!==null){
        $devices = filter_input(INPUT_POST, "chbx", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $isOk = true;
        $link = DBManager::connect2();
        $result=null;
        foreach ($devices as $key => $value){
            $result = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array($value), Query::$RETURN_DEV_FROM_SERV, array($value));
            if($result!==true){
               $isOk=false;
               break;
            }
        }
        $link=null;
        if($isOk===true){
            $_SESSION['komunikat'] = "Urządzenia wróciły z serwisu";
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się przywrócić urządzeń z serwisu";
        }
        header('Location: ../index.php');
    }
}

