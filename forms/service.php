<?php
session_start();
if(isset($_SESSION['cur_loc'])) {unset($_SESSION["cur_loc"]);}
if(isset($_SESSION['cur_type'])) {unset($_SESSION["cur_type"]);}
if(isset($_SESSION['dev_type'])) {unset($_SESSION["dev_type"]);}
if(isset($_SESSION['dev_model'])) {unset($_SESSION["dev_model"]);}
if(isset($_SESSION['find_sn'])) {unset($_SESSION['find_sn']);}
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../data/Device.php';
    require_once '../database/Query.php';
    ?>
    <html>
        <head>
            <title>Urządzenia w serwisie</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">

            <script src="../scripts/devicesbylok.js" type="text/javascript"></script>
            <script type="text/javascript" src="../js/mdb.min.js"></script>

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
        <body>
            <?php include 'menu.php'; ?>
            <?php if(isset($_SESSION['komunikat'])) {
                ?> 
                    <div class="alert alert-danger position-absolute" role="alert" id="alert">
                <?php
                    echo $_SESSION['komunikat'];
                    unset($_SESSION['komunikat']);  //dodawanie lokalizacji zapytanie + skrypt
                ?>
                    </div>
                <?php
            } 
            ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Urządzenia w serwisie</h2>
                </div>
                <div>
                <form method="post" action="../actions/return.php">                       
                    <?php
                        $link = DBManager::connect2();
                        $result = DBManager::select($link, Query::$GET_DEV_IN_SERVICE, null, "Device"); //DBManager::getDevicesInService();
                        $link=null;
                        if(is_array($result)){
                            echo "<table class='table table-striped table-sm'><thread><tr><th>Typ</th><th>Model</th><th>Numer seryjny</th><th>Numer seryjny 2</th><th>Opis</th><th>Powrót</th></tr></thread><tbody>";
                            for($i=0;$i<sizeof($result);$i++){
                                echo "<tr>";
                                echo "<td>".$result[$i]->getTypeName()."</td>";
                                echo "<td>".$result[$i]->getModelName()."</td>";
                                echo "<td>".$result[$i]->getSN()."</td>";
                                echo "<td>".$result[$i]->getSN2()."</td>";
                                echo "<td>".$result[$i]->getDesc()."</td>";
                                echo "<td><input type='checkbox' name='chbx[".$result[$i]->getId()."]' value='".$result[$i]->getId()."'></td>";
                                echo "</tr>";
                            }
                        }
                        else{
                            echo "Nie udało sie pobrać urządzeń w serwisie";
                        }
                    ?>
                    </tbody>
                    </table>
                    <input class='btn btn-sm btn-dark' type="submit" name='ret' value="Powrót z serwisu">   
                </form>  
            </div>
        </body>
    </html>
<?php } ?>

