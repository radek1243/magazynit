<?php
session_start();
if(isset($_SESSION['cur_loc'])) {unset($_SESSION["cur_loc"]);}
if(isset($_SESSION['cur_type'])) {unset($_SESSION["cur_type"]);}
if(isset($_SESSION['dev_type'])) {unset($_SESSION["dev_type"]);}
if(isset($_SESSION['dev_model'])) {unset($_SESSION["dev_model"]);}
if(isset($_SESSION['find_sn'])) {unset($_SESSION['find_sn']);}
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    require_once '../data/Typ.php';
    require_once '../data/Location.php';
    ?>
    <html>
        <head>
            <title>Dodawanie protokołu</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">

            <script src="../scripts/devicesbylok.js" type="text/javascript"></script>
            <script type="text/javascript" src="../js/mdb.min.js"></script>
            <script src="../scripts/devicesbylok.js"></script>
            <script src="../scripts/reservedevice.js"></script>
            <script src="../scripts/setcheckbox.js"></script> 

            <!-- Your custom styles (optional) -->
            <link href="../css/menu.css" rel="stylesheet">
            <!-- Font Awesome -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <!-- Bootstrap core CSS -->
            <link href="../css/bootstrap.min.css" rel="stylesheet">
            <!-- Material Design Bootstrap -->
            <link href="../css/mdb.min.css" rel="stylesheet">  

            <script>
                $("#alert").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert").slideUp(500);
                });
            </script>
        </head>
        <body onload="getDevByLok('../actions/getDevByLok.php','addlist');">
            <?php include 'menu.php'; ?>
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
            ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Wybór urządzeń do wysłania</h2>
                </div>
                <div id="menu2">
                <select id="typ" class='custom-select custom-select-sm w-25 m-2' onchange="getDevByLok('../actions/getDevByLok.php','addlist');">
                    <?php   
                        $link = DBManager::connect2();
                        $result = DBManager::select($link, Query::$GET_TYPES, null, "Typ"); 
                        if(is_array($result)){
                            for($i=0;$i<sizeof($result);$i++){
                                echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()."</option>";
                            }
                        }
                    ?>
                </select>
                <?php
                    $result = DBManager::select($link, Query::$GET_LOC_BY_SHORT_NAME, array("MIT"), "Location");
                    if(is_array($result)){
                        for($i=0;$i<sizeof($result);$i++){
                            echo "<input type='hidden' id='lok' value='".$result[$i]->getId()."'>";
                        }
                    }
                ?>
                <button value="Dodaj" class='btn btn-sm btn-dark' onclick="reserveDevice();">Dodaj</button>
                </div>
                <div id="devices" class="border-bottom mb-4 mt-3">     
                </div>
                <form method="post" action="../actions/addprotocol.php">
                    <label>Lokalizacja: </label><select name="send_lok" class='custom-select custom-select-sm w-25 m-2'>
                        <?php
                            $result = DBManager::select($link, Query::$GET_VIS_LOC, null, "Location");
                            if(is_array($result)){
                                for($i=0;$i<sizeof($result);$i++){
                                    echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()." - ".$result[$i]->getShortName()."</option>";
                                }
                            }
                        ?>
                    </select><br>
                    <?php 
                        $link=null;
                    ?>
					<label>Zlecający: </label><input type="text" class='form-control form-control-sm m-2 w-25 d-inline' name="zlec" required><br>
                    <label>Osoba (opcjonalnie): </label><input type="text" class='form-control form-control-sm m-2 w-25 d-inline' name="oso"><br>
                    <label>Data: </label><input type="date" class='form-control form-control-sm m-2 w-25 d-inline' name="date" max="<?=date("Y-m-d", time());?>" value="<?=date("Y-m-d", time());?>" required><br>
                    Urządzenia w rezerwacji:  <button class='btn btn-sm btn-dark' onclick="removeReservation(); return false;">Usuń rezerwację</button><br>
                    <table id="res_tab" class='table table-striped table-sm'>

                    </table>
                    <br>
                    Dodatkowe urządzenia: <br>
                    <textarea class='form-control form-control-sm w-25 d-inline' name="poz_urz"></textarea><br><br>
                    <input type="submit" class='btn btn-sm btn-dark' name="submit" value="Dodaj protokół" onclick="check();">
                </form>
            </main>
            </div>
            </div>
        </body>
    </html>
<?php } ?>


