<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    require_once '../data/Device.php';
    if(filter_input(INPUT_POST, "cur_type")!==null && filter_input(INPUT_POST, "cur_loc")!==null){
        $_SESSION['cur_loc'] = filter_input(INPUT_POST, "cur_loc");
        $_SESSION['cur_type'] = filter_input(INPUT_POST, "cur_type");
    }
    if(filter_input(INPUT_POST, "wyslij")!==null){
        $devices = filter_input(INPUT_POST,"chbx", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $isOk = true;
        $link = DBManager::connect2();
        $result=null;
        foreach ($devices as $key => $value){
            $result = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array($value), 
               Query::$UPDATE_DEV_LOC, array(filter_input(INPUT_POST, "sendlok"),$value));
            if($result!==true){				
               $isOk=false;
               break;
            }
        }
        $link=null;
        if($isOk===true){
            $_SESSION['komunikat'] = "Wysłano urządzenia";
        }
        else{
            $_SESSION['komunikat'] = "Nie udało się wysłać wszystkich urządzeń";
        }
		if(filter_input(INPUT_POST,"find")!==null) {
			header('Location: ../forms/finddevice.php');
		}			
        else {header('Location: ../index.php');}
    }
    else if(filter_input(INPUT_POST, "serwis")!==null){ 
        //print_r($_POST);
        $devices = filter_input(INPUT_POST,"chbx", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $bd_count=0;
        if(filter_input(INPUT_POST, "cur_loc")==1){
            $link = DBManager::connect2();
            foreach($devices as $key => $value){
                if(sizeof(DBManager::select($link, Query::$GET_BROKEN_DEV, array($value), "Device"))>0) $bd_count++;
            }
            if(sizeof($devices)==$bd_count){
                $isOk = true;
                $result = null;
                foreach ($devices as $key => $value){
                    $result = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array($value), Query::$UPDATE_DEV_SERV, array(1, $value));
                    if($result!==true){
                       $isOk=false;
                       break;
                    }
                }
                if($isOk===true){
                    $_SESSION['komunikat'] = "Wysłano urządzenia na serwis";
                }
                else{
                    $_SESSION['komunikat'] = "Nie udało się wysłać wszystkich urządzeń na serwis";
                }           
            }
            else{
                $_SESSION['komunikat'] = "Próbujesz wysłać też sprawne urządzenia na serwis!";
            }
            $link=null;
        }
        else{
            $_SESSION['komunikat'] = "Próbujesz wysłać na serwis urządzenia z innej lokalizacji niż Magazyn IT!";
        }
		if(filter_input(INPUT_POST,"find")!==NULL) header('Location: ../forms/finddevice.php');
        else {header('Location: ../index.php');}
    }
    else if(filter_input(INPUT_POST, "zm_stan")!==null){
        $devices = filter_input(INPUT_POST,"chbx", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if(sizeof($devices)==1){
            $link = DBManager::connect2();
            $result = DBManager::call($link, Query::$CALL_PROC_TWO_PARAMS, "changeStan", array(reset($devices), filter_input(INPUT_POST, "newdesc")));
            if($result===true){
                $_SESSION['komunikat'] = "Zmieniono stan urządzenia.";
            }
            else{
                $_SESSION['komunikat'] = "Nie udało się zmienić stanu urządzenia.";
            }
            $link=null;
        }
        else{
            $_SESSION['komunikat'] = "Zaznaczono więcej niż jedno urządzenie do zmiany. Operacja niedozwolona.";
        }
		if(filter_input(INPUT_POST,"find")!==NULL) header('Location: ../forms/finddevice.php');		
        else {header('Location: ../index.php');}
    }
else if(filter_input(INPUT_POST, "zm_opis")!==null){
        $devices = filter_input(INPUT_POST,"chbx", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if(sizeof($devices)==1){
            $link = DBManager::connect2();
	    $result = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array(reset($devices)), Query::$UPDATE_DEV_DESC, array(filter_input(INPUT_POST, "newdesc"), reset($devices)));
            //$result = DBManager::call($link, Query::$CALL_PROC_TWO_PARAMS, "changeStan", array(reset($devices), filter_input(INPUT_POST, "newdesc")));
            if($result===true){
                $_SESSION['komunikat'] = "Zmieniono opis urządzenia.";
            }
            else{
                $_SESSION['komunikat'] = "Nie udało się zmienić opisu urządzenia.";
            }
            $link=null;
        }
        else{
            $_SESSION['komunikat'] = "Zaznaczono więcej niż jedno urządzenie do zmiany. Operacja niedozwolona.";
        }  
		if(filter_input(INPUT_POST,"find")!==NULL) header('Location: ../forms/finddevice.php');
        else {header('Location: ../index.php');}
    }
    else if(filter_input(INPUT_POST, "utylizacja")!==null){ 
        //print_r($_POST);
        $devices = filter_input(INPUT_POST,"chbx", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $bd_count=0;
        if(filter_input(INPUT_POST, "cur_loc")==1){
            $link = DBManager::connect2();
            $isOk = true;
            $result = null;
            foreach ($devices as $key => $value){
                $result = DBManager::executeUpdate($link, Query::$GET_DEV_FOR_UPD, array($value), Query::$UPDATE_DEV_UTYL, array($value));
                if($result!==true){
                   $isOk=false;
                   break;
                }
            }
            if($isOk===true){
                $_SESSION['komunikat'] = "Zutylizowano urządzenie";
            }
            else{
                $_SESSION['komunikat'] = "Nie udało się zutylizować urządzenia";
            }           
            $link=null;
        }
        else{
            $_SESSION['komunikat'] = "Próbujesz zutylizować urządzenia z innej lokalizacji niż Magazyn IT!";
        }
		if(filter_input(INPUT_POST,"find")!==NULL) header('Location: ../forms/finddevice.php');
        else {header('Location: ../index.php');}
    }
}
