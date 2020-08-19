<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';       
    //print_r($_POST);
    if(filter_input(INPUT_POST, "submit")!==null){  //wyniki zapytań do result przechwytywać i przerobione tak żeby zapytanie zwracało wyjątek, wszedzie popoprawiac
        $devices = filter_input(INPUT_POST, "chbx", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if($devices!==null){
            $link = DBManager::connect2();
            $result = DBManager::insertWithLIID($link, Query::$INSERT_PROTOCOL, array(filter_input(INPUT_POST, "send_lok"), $_SESSION['login'], filter_input(INPUT_POST, "oso"), filter_input(INPUT_POST, "poz_urz"), filter_input(INPUT_POST, "date"), filter_input(INPUT_POST, "zlec")));
            if($result["ok"]===true){
                $prot_id = $result["id"];
                $isOk=true;
                foreach($devices as $key => $value){    
                    $result2 = DBManager::insert($link, Query::$INSERT_PROT_URZ, array($prot_id, $value));
                    $result3 = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array($value), Query::$UPDATE_DEV_LOC_AND_RES, array(filter_input(INPUT_POST, "send_lok"), $value));
                    if($result2!==true || $result3!==true){
                        $isOk=false;
                        break;
                    }
                }
                $link=null;
                if($isOk===true){
                    $_SESSION['prot'] = $prot_id;
                    header("Location: showprotocol.php");
                }
                else{
                    $_SESSION['komunikat'] = "Błąd podczas dodawania pozycji do protokołu. Protokół może być niepełny.";
                    header("Location: ../forms/protocol.php");
                }
            }
            else{
                $_SESSION['komunikat'] = "Błąd podczas dodawania nagłówka protokołu.";
                header("Location: ../forms/protocol.php");
            }
            $link=null;
        }
        else{
            $_SESSION['komunikat'] = "Nie wybrano urządzeń do wysłania!";
            header("Location: ../forms/protocol.php");    
        }
    }
    else{
        $_SESSION['komunikat'] = "Błąd ogólny.";
        header("Location: ../forms/protocol.php");
    }
}

