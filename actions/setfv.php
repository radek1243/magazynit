<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    $isOk = true;
    $link = DBManager::connect2();
    $devices = filter_input(INPUT_POST, "chbx",FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $result = null;
    foreach ($devices as $key => $value){
        $result = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array($value), Query::$UPDATE_DEV_FV, array($value));
        if($result!==true){
            $isOk=false;
            break;
        }
    }
    $link=null;
    if($isOk===true){
        $_SESSION['komunikat'] = "Zafakturowano urządzenia.";
    }
    else{
        $_SESSION['komunikat'] = "Nie udało się zafakturować urządzeń.";
    }
    header('Location: ../forms/fv.php');
    /*if(filter_input(INPUT_POST, "fv")!==null){
        $forupdate ="select * from urzadzenie where id in (";
        $updatequery=array();
        foreach($_POST as $key => $value){
            if($key!=='fv'){
                $forupdate = $forupdate.$key.",";
                $updatequery[$key] = "update urzadzenie set fv=1 where id=".$key.";";
            }
        }
        $forupdate = substr_replace($forupdate, ") for update;", strlen($forupdate)-1);
        if(DBManager::changeLocation($forupdate, $updatequery)===true){
            $_SESSION['komunikat'] = "Zafakturowano urządzenia.";
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się zafakturować urządzeń.";
        }
        header('Location: ../forms/fv.php');
    }*/
}
