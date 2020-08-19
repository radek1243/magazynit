<?php
session_start();
if(isset($_SESSION['cur_loc'])) {unset($_SESSION["cur_loc"]);}
if(isset($_SESSION['cur_type'])) {unset($_SESSION["cur_type"]);}
if(isset($_SESSION['find_sn'])) {unset($_SESSION['find_sn']);}
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../database/Query.php';
    require_once '../data/Typ.php';
    require_once '../data/Model.php';
    ?>
    <html>
        <head>
            <title>Dodawanie urządzenia</title>
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
            <?php include 'menu.php'; ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Dodaj urządzenie</h2>
                </div>
                <form method="post" action="../actions/adddevice.php">
                    <?php
                        $link = DBManager::connect2();
                        $result = DBManager::select($link, Query::$GET_TYPES, null, "Typ");
                        if(is_array($result)){
                            echo "<Label>Typ urządzenia: </Label><select name='typ' class='custom-select custom-select-sm w-25 m-2'>";
                            for($i=0;$i<sizeof($result);$i++){
				if(isset($_SESSION['dev_type'])){
					if($result[$i]->getId()==$_SESSION['dev_type']){
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
                            echo "</select><br>";
                        }
                        $result = DBManager::select($link, Query::$GET_MODELS, null, "Model");
                        if(is_array($result)){
                            echo "<Label>Model urządzenia: </Label><select name='model' class=' custom-select-sm custom-select w-25 m-2'>";
                            for($i=0;$i<sizeof($result);$i++){
                                if(isset($_SESSION['dev_model'])){
					if($result[$i]->getId()==$_SESSION['dev_model']){
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
                            echo "</select><br>";
                            echo "<input type='hidden' name='lok' value='1'/>";
                            echo "<Label>Numer seryjny: </Label><input type='text' class='form-control w-25 m-2 d-inline' maxlength=30 name='sn'><br>";
                            echo "<Label>Numer seryjny 2 (opcjonalnie): </Label><input type='text' class='form-control w-25 m-2 d-inline' maxlength=30 name='sn2'><br>";
                            echo "<Label>Stan: </Label><select name='stan' class='custom-select custom-select-sm w-25 m-2'><option value='S'>Sprawny</option><option value='N'>Niesprawny</option></select><br>";
                            echo "<Label>Opis: </Label><textarea name='opis' class='form-control form-control-sm m-2 w-25' maxlength='255' col='25' rows='3'></textarea><br>";
                            echo "<input type='submit' class='btn btn-sm btn-dark' name='submit' value='Dodaj urządzenie'>";    
                        }
                        $link=null;
                    ?>
                </form>
            </main>
            </div>
            </div>
            </div>
        </body>
    </html>
<?php }?>
