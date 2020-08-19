<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../data/Device.php';
    require_once '../data/Protocol.php';
    require_once '../database/Query.php';
    //print_r($_POST);
    if(filter_input(INPUT_POST, "zat")!==null){
        $prots = filter_input(INPUT_POST,"chbx",FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
        $isOk = true;
        $link = DBManager::connect2();
        $result = null;
        foreach ($prots as $key => $value){
            $result = DBManager::executeUpdate($link, Query::$GET_PROT_FOR_UPD, array($value), Query::$UPDATE_PROT_WRO, array($value));
            if($result!==true){
               $isOk=false;
               break;
            }
        }
        $link=null;
        if($isOk===true){
            $_SESSION['komunikat'] = "Zatwierdzono protokoły.";
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się zatwierdzć protokołów.";
        }
        header('Location: ../forms/protocollist.php');
    }
    else if(filter_input(INPUT_POST, "pod")!==null){
        //print_r($_POST);
        $link = DBManager::connect2();
        $result = DBManager::select($link, Query::$GET_PROT_BY_ID, array(filter_input(INPUT_POST,"podglad")), "Protocol"); //DBManager::getProtocolById(filter_input(INPUT_POST, "podglad"));
        $result2 = DBManager::select($link, Query::$GET_DEV_FROM_PROT, array(filter_input(INPUT_POST,"podglad")), "Device"); //DBManager::getDevicesFromProtocol(filter_input(INPUT_POST, "podglad"));
        /*print_r($result);
        print_r($result2);*/
        $link=null;
        if(is_array($result) && is_array($result2)){
            include_once '../template/szablon.php';
        }
    }
    else if(isset($_SESSION['prot'])){
        $link = DBManager::connect2();
        $result = DBManager::select($link, Query::$GET_PROT_BY_ID, array($_SESSION['prot']), "Protocol"); //DBManager::getProtocolById($_SESSION['prot']);
        $result2 = DBManager::select($link, Query::$GET_DEV_FROM_PROT, array($_SESSION['prot']), "Device"); //DBManager::getDevicesFromProtocol($_SESSION['prot']);
        $link=null;
        if(is_array($result) && is_array($result2)){
            include_once '../template/szablon.php';
        }
        unset($_SESSION['prot']);
    }
}