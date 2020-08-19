<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    $isOk = true;
    $link = DBManager::connect2();
    foreach ($_POST as $key => $value){
        $result = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array($value), Query::$UPDATE_DEV_RES, array(0,$value));
        if($result!==true){
            $isOk=false;
            break;
        }
    }
    $link=null;
    if($isOk===true){
        echo "1";
    }
    else{
        echo "0";
    }
}
