<?php
session_start();
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    require_once '../data/Device.php';
    if(filter_input(INPUT_POST, "typ")!==null){
        $link = DBManager::connect2();
        $result = DBManager::select($link, Query::$GET_DEV_TO_FV, array(filter_input(INPUT_POST, "typ")), "Device");
        $link=null;
        if(is_array($result)){
            echo "<table>";
            echo "<tr><td>Model</td><td>Stan</td><td>Numer seryjny</td><td>Nazwa lokalizacji</td><td>Opis</td><td>Zafakturować</td>";
            echo"</tr>";
            for($i=0;$i<sizeof($result);$i++){
                echo "<tr>";
                echo "<td>".$result[$i]->getModelName()."</td>";
                echo "<td>".$result[$i]->getStan()."</td>";
                echo "<td>".$result[$i]->getSN()."</td>";
                echo "<td>".$result[$i]->getSN2()."</td>";
                echo "<td>".$result[$i]->getLocName()." ".$result[$i]->getShortName()."</td>";
                echo "<td>".$result[$i]->getDesc()."</td>";
                echo "<td><input type='checkbox' name=chbx[".$result[$i]->getId()."] value='".$result[$i]->getId()."'></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "Błąd pobierania danych z bazy.";
        }
    }
    else{
        echo "Nie podano lokalizacji lub typu urządzenia.";
    }
}
