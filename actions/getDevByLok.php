<?php
session_start();
require_once '../database/DBManager.php';
require_once '../database/Query.php';
require_once '../data/Device.php';
if(filter_input(INPUT_POST, "lok")!==null && filter_input(INPUT_POST, "typ")!==null && filter_input(INPUT_POST, "listtype")!==null){
    $link = DBManager::connect2();
    $query=null;
    switch (filter_input(INPUT_POST, "listtype")) {
        case 'mainlist':
            $query = Query::$GET_DEV_FROM_LOK;
            break;
        case 'addlist':
            $query = Query::$GET_WORKING_DEV_FROM_LOK;
            break;
        default:
            break;
    }
    $result =DBManager::select($link, $query, array(filter_input(INPUT_POST, "lok"),filter_input(INPUT_POST, "typ")), "Device");
    $link=null;
    if(is_array($result)){
        echo "<table class='table table-striped table-sm'>";
        echo "<thread><tr><th>Model</th><th>Stan</th><th>Numer seryjny</th><th>Numer seryjny 2</th><th>Opis</th>";
        if(isset($_SESSION['login'])) {echo "<th>Wysłać</th>";}
        echo"</tr></thread><tbody>";
        for($i=0;$i<sizeof($result);$i++){
            echo "<tr>";
            echo "<td>".$result[$i]->getModelName()."</td>";
            echo "<td ";
            if($result[$i]->getStan()=='N') {echo "class='text-white bg-danger'";} else {echo "class='text-white green'";}
            echo ">".$result[$i]->getStan()."</td>";
            echo "<td>".$result[$i]->getSN()."</td>";
            echo "<td>".$result[$i]->getSN2()."</td>";
            echo "<td>".$result[$i]->getDesc()."</td>";
            if(isset($_SESSION['login'])) {echo "<td><input type='checkbox' name='chbx[".$result[$i]->getId()."]' value='".$result[$i]->getId()."'></td>";}
            echo "</tr>";
        }
        echo "</tbody></table>";
    }
    else{
        echo "Błąd pobierania danych z bazy.";
    }
}
else{
    echo "Nie podano lokalizacji lub typu urządzenia.";
}

