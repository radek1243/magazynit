<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(isset($_SESSION['dev_type'])) {unset($_SESSION["dev_type"]);}
if(isset($_SESSION['dev_model'])) {unset($_SESSION["dev_model"]);}
if(isset($_SESSION['find_sn'])) {unset($_SESSION['find_sn']);}
require_once 'database/DBManager.php';
require_once 'data/Typ.php';
require_once 'data/Location.php';
require_once 'database/Query.php';
//$_SESSION['login'] = '1';
//wszedzie pododawać czy user zalogowany!!!!
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Strona główna</title>

        <script src="scripts/devicesbylok.js" type="text/javascript"></script>
        <script src="scripts/addhiddenloc.js" type="text/javascript"></script>
	    <script src="scripts/newdescwindow.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/mdb.min.js"></script>

        <!-- Your custom styles (optional) -->
        <link href="css/menu.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="css/mdb.min.css" rel="stylesheet">  

        <script>
            $("#alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert").slideUp(500);
            });
        </script>

    </head>
    <body onload="getDevByLok('actions/getDevByLok.php','mainlist'); addHiddenLoc(); addHiddenType();">

        <?php if(isset($_SESSION['komunikat'])) {
            ?> 
                <div class="alert alert-danger position-absolute" role="alert" id="alert">
            <?php
                echo $_SESSION['komunikat'];
                unset($_SESSION['komunikat']); 
            ?>
                </div>
            <?php   
        } 
        if(isset($_SESSION['current_loc']) && isset($_SESSION['current_type'])) echo $_SESSION['current_loc']."<br>".$_SESSION['current_type'];
        ?>

        <div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-white sidebar">
                <?php if(isset($_SESSION['login'])){ ?>
                    <div id="menu1" class="sidebar-sticky">
                        <ul id="menulist" class="nav flex-column">
                            <li class="nav-item"><a class="nav-link" href="index.php">Strona główna</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/devices.php">Dodaj urządzenie</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/models.php">Modele</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/locations.php">Lokalizacje</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/types.php">Typy urządzeń</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/protocollist.php">Lista protkołów</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/protocol.php">Dodaj protokół</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/fv.php">Fakturowanie</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/service.php">W serwisie</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/finddevice.php">Wyszukaj urządzenie</a></li>
                            <li class="nav-item"><a class="nav-link" href="forms/checkhist.php">Historia urządzenia</a></li>
			    <li class="nav-item"><a class="nav-link" href="forms/dayhist.php">Historia urządzeń wg daty</a></li>
                        </ul>
                    </div>
                    <nav class="navbar navbar-dark fixed-top elegant-color flex-md-nowrap p-0 shadow">
                        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php">Kanciapa ERP v3</a>
                        <ul class="navbar-nav px-3 text-white">
                            <li class="nav-item text-nowrap">
                                <a class="nav-link font-weight-light" href="forms/logout.php">Wyloguj</a>
                            </li>
                        </ul>
                    </nav>
                    <?php }
                        else{ ?>
                        <div id="menu1" class="sidebar-sticky">
                            <ul id="menulist" class="nav flex-column">
                                <li class="nav-item">Zaloguj się, aby zobaczyć</a></li>
                            </ul>
                        </div>
                        <nav class="navbar navbar-dark fixed-top elegant-color flex-md-nowrap p-0 shadow">
                            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="index.php">Kanciapa ERP v3</a>
                            <ul class="navbar-nav px-3">
                                <li class="nav-item text-nowrap text-right">
                                    <form method="post" action="actions/login.php" class="text-white">
                                        <input type="text" maxlength="20" name="user" class="form-control form-control-sm m-2 w-25 d-inline" placeholder="Login">
                                        <input type="password" name="pass" class="form-control form-control-sm m-2 w-25 d-inline" placeholder="Hasło">
                                        <input type="submit" name="login" class="btn btn-sm btn-light d-inline" value="Zaloguj">
                                    </form>
                                </li>
                            </ul>
                        </nav>
                        <?php } 
                    ?>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Urządzenia na stanie</h2>
                        <div id="menu2" class="w-50">
                            <select class='custom-select custom-select-sm float-right w-25 ml-2 mr-2' id="typ" onchange="getDevByLok('actions/getDevByLok.php','mainlist'); addHiddenType();">
                                <?php
                                    $link = DBManager::connect2();
                                    $result = DBManager::select($link, Query::$GET_TYPES, null, "Typ"); //DBManager::getTypes();
                                    if(is_array($result)){
                                        for($i=0;$i<sizeof($result);$i++){
                                                if(isset($_SESSION['cur_type'])){
                                                    if($result[$i]->getId()==$_SESSION['cur_type']){
                                                        echo "<option value='".$result[$i]->getId()."' selected>".$result[$i]->getName()."</option>";
                                                    }
                                                    else{
                                                        echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()."</option>";
                                                    }
                                                }
                                                else{
                                                    echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()."</option>";
                                                }
                                        }
                                    }
                                ?>
                            </select>
                            <?php
                                if(isset($_SESSION['login'])){
                                    echo "<select id='lok' class='custom-select custom-select-sm float-right w-25 ml-2 mr-2' onchange=\"getDevByLok('actions/getDevByLok.php','mainlist'); addHiddenLoc();\">";
                                }
                                else{
                                    echo "<select id='lok' class='custom-select custom-select-sm float-right w-25 ml-2 mr-2' onchange=\"getDevByLok('actions/getDevByLok.php','mainlist'); addHiddenLoc();\" disabled>";
                                }
                                $result = DBManager::select($link, Query::$GET_VIS_LOC, null, "Location"); //DBManager::getVisibleLocations();
                                $link=null;
                                echo "<option value='1'>Magazyn IT - MIT</option>";
                                if(is_array($result)){
                                    for($i=0;$i<sizeof($result);$i++){
                                        if($result[$i]->getID()!=1)
                                        {
                                            if(isset($_SESSION['cur_loc'])){
                                                if($result[$i]->getId()==$_SESSION['cur_loc']){
                                                    echo "<option value='".$result[$i]->getId()."' selected>".$result[$i]->getName()." - ".$result[$i]->getShortName()."</option>";
                                                }
                                                else{
                                                    echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()." - ".$result[$i]->getShortName()."</option>";
                                                }
                                            }
                                            else{
                                                echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()." - ".$result[$i]->getShortName()."</option>";
                                            }
                                        }
                                    }
                                }
                                echo "</select>";
                            ?>
                        </div>
                    </div>
                    <form method="post" action="actions/senddevice.php">
                    <input type="hidden" id="cur_loc" name="cur_loc">
                    <input type="hidden" id="cur_type" name="cur_type">
                    <div class="table-responsive border-bottom" id="devices">     
                    </div>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <?php
                        echo "<Label><b>Wybierz lokalizację docelową:</b></Label> ";
                        if(isset($_SESSION['login'])){
                            echo "<select class='custom-select custom-select-sm w-25' name='sendlok'>";
                        }
                        else{
                            echo "<select class='custom-select custom-select-sm W-25' name='sendlok' disabled>";
                        }
                        if(is_array($result)){
                            for($i=0;$i<sizeof($result);$i++){
                                echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()." - ".$result[$i]->getShortName()."</option>";
                            }
                        }
                        echo "</select> ";                
                        if(isset($_SESSION['login'])){
                            echo "<input type='submit' class='btn btn-sm btn-dark' name='wyslij' value='Wyslij'> <input type='submit' class='btn btn-sm btn-dark' name='serwis' value='Na serwis'> <input type='submit' class='btn btn-sm btn-dark' name='zm_stan' value='Zmiana stanu urządzenia' onclick='changeDesc()'><input type='submit' class='btn btn-sm btn-dark' name='zm_opis' value='Zmień opis urządzenia' onclick='changeDesc()'><input type='submit' class='btn btn-sm btn-dark' name='utylizacja' value='Utylizacja'>";               
                        }
                        $result = null;
                    ?>
					<input type="hidden" id="newdesc" name="newdesc">
                    </div>
                    </form>
                </main>
            </div>
        </div>

<script>
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#alert").slideUp(500);
    });
</script>
    </body>
</html>
