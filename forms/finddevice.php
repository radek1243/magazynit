<?php
session_start();
if(isset($_SESSION['cur_loc'])) {unset($_SESSION["cur_loc"]);}
if(isset($_SESSION['cur_type'])) {unset($_SESSION["cur_type"]);}
if(isset($_SESSION['dev_type'])) {unset($_SESSION["dev_type"]);}
if(isset($_SESSION['dev_model'])) {unset($_SESSION["dev_model"]);}
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    require_once '../data/Device.php';
    require_once '../data/Typ.php';
    require_once '../data/Model.php';
    require_once '../data/Location.php';
    ?>
    <html>
        <head>
            <title>Wyszukiwanie urządzenia</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">

            <script src="../scripts/devicesbylok.js" type="text/javascript"></script>
			<script src="../scripts/newdescwindow.js" type="text/javascript"></script>
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
            <?php include 'menu.php'; 
				if(filter_input(INPUT_POST, "sn")!==null){
					$_SESSION['find_sn'] = filter_input(INPUT_POST, "sn");
				}
				if(isset($_SESSION['komunikat'])) {
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
                    <h2>Urządzenie do wyszukania</h2>
                </div>
                <form method="post" class="pb-2 mb-3 border-bottom">
                    <Label>Podaj numer seryjny urządzenia: </Label><input type="text" class="form-control-sm form-control w-25 m-2 d-inline" name="sn" maxlength="30" value="<?php if(isset($_SESSION['find_sn'])){echo $_SESSION['find_sn'];} ?>"><br>
                    <input type="submit" class='btn btn-sm btn-dark' name='submit' value="Wyszukaj">
                </form>
				<form method="post" action="../actions/senddevice.php">
                <?php					
                    $link = DBManager::connect2();
					if(isset($_SESSION['find_sn'])){
						$result = DBManager::select($link, Query::$GET_DEV_BY_SN, array("%".$_SESSION['find_sn'], "%".$_SESSION['find_sn']), "Device");
					}
					else{
						$result = DBManager::select($link, Query::$GET_DEV_BY_SN, array("%".filter_input(INPUT_POST, "sn"), "%".filter_input(INPUT_POST, "sn")), "Device");
					}
                    
                    if(is_array($result)){
                        echo "<table class='table table-striped table-sm'>";
                        echo "<tr><td>Typ</td><td>Model</td><td>Numer seryjny</td><td>Numer seryjny 2</td><td>Opis</td><td>Lokalizacja</td><td>W serwisie</td><td>Stan</td><td>Utylizacja</td><td>Zaznacz</td></tr><tbody>";
                        for($i=0;$i<sizeof($result);$i++){
                            echo "<tr>";
                            echo "<td>".$result[$i]->getTypeName()."</td>";
                            echo "<td>".$result[$i]->getModelName()."</td>";
                            echo "<td>".$result[$i]->getSN()."</td>";
                            echo "<td>".$result[$i]->getSN2()."</td>";
                            echo "<td>".$result[$i]->getDesc()."</td>";
                            echo "<td>".$result[$i]->getLocName()."</td>";
                            echo "<td>"; if($result[$i]->getService()==0) echo "Nie"; else echo "Tak"; echo "</td>";
                            echo "<td>".$result[$i]->getStan()."</td>";
                            echo "<td>"; if($result[$i]->getUtyl()==0) echo "Nie"; else echo "Tak"; echo "</td>";
							echo "<td><input type='checkbox' name='chbx[".$result[$i]->getId()."]' value='".$result[$i]->getId()."'></td>";
                            echo "</tr>";
                        }
                    }
                    else{
                        echo "Nie udało sie pobrać urządzenia lub nie podano numeru seryjnego.";
                    }
                ?>
                </tbody></table>				
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <?php
                        echo "<Label><b>Wybierz lokalizację docelową:</b></Label> ";
						echo "<select class='custom-select custom-select-sm w-25' name='sendlok'>";
						$result = DBManager::select($link, Query::$GET_VIS_LOC, null, "Location"); //DBManager::getVisibleLocations();
						$link=null;
                        if(is_array($result)){
                            for($i=0;$i<sizeof($result);$i++){
                                echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()." - ".$result[$i]->getShortName()."</option>";
                            }
                        }
                        echo "</select> ";                
						echo "<input type='submit' class='btn btn-sm btn-dark' name='wyslij' value='Wyslij'> <input type='submit' class='btn btn-sm btn-dark' name='serwis' value='Na serwis'> <input type='submit' class='btn btn-sm btn-dark' name='zm_stan' value='Zmiana stanu urządzenia' onclick='changeDesc()'><input type='submit' class='btn btn-sm btn-dark' name='zm_opis' value='Zmień opis urządzenia' onclick='changeDesc()'><input type='submit' class='btn btn-sm btn-dark' name='utylizacja' value='Utylizacja'>";               
                        $result = null;
                    ?>
					<input type="hidden" id="find" name="find" value="true">
					<input type="hidden" id="newdesc" name="newdesc">					
                    </div>
				</form>
            </main>
            </div>
            </div>
        </body>
    </html>
<?php } ?>
