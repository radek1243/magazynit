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
    require_once '../data/Device.php';
    ?>
    <html>
        <head>
            <title>Historia od dnia</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">

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
                    <h2>Historia urządzeń wg daty</h2>
                </div>
		<form method="post">
                    <select id="typ" name="typ" class='custom-select custom-select-sm w-25 m-2'>
                        <?php
                            $link = DBManager::connect2();
                            $result = DBManager::select($link, Query::$GET_TYPES, null, "Typ");
                            $link=null;
                            if(is_array($result)){
                                for($i=0;$i<sizeof($result);$i++){
                                    echo "<option value='".$result[$i]->getId()."'>".$result[$i]->getName()."</option>";
                                }
                            }
                        ?>
                    </select>   
		    <input type="date" name="date" value="<?php echo date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))); ?>" max="<?php echo date("Y-m-d"); ?>">       
		    <input type="submit" name="dhsub" value="Pokaż historię"> 
		</form>
                <br>
                <div id="devices" class="mb-4 mt-3">   
		<?php
			if(filter_input(INPUT_POST,"dhsub")!=null){
			    $link = DBManager::connect2();
    			    $result = null;
			    if(filter_input(INPUT_POST,"typ")==="9"){
				$result = DBManager::select($link, Query::$GET_DEVS_HIST_BY_DATE_SPEC_SORT, array(filter_input(INPUT_POST,"date"),filter_input(INPUT_POST,"typ"),filter_input(INPUT_POST,"date"),filter_input(INPUT_POST,"typ")), "Device");
			    }
                            else{
				$result = DBManager::select($link, Query::$GET_DEVS_HIST_BY_DATE, array(filter_input(INPUT_POST,"date"),filter_input(INPUT_POST,"typ"),filter_input(INPUT_POST,"date"),filter_input(INPUT_POST,"typ")), "Device");
			    }
                            $link=null;
			    if(is_array($result)){
				echo "<table class='table table-striped table-sm'>";
                        	echo "<tr><td>Typ</td><td>Model</td><td>Numer seryjny</td><td>Numer seryjny 2</td><td>Opis</td><td>Lokalizacja</td>";
                        	echo "<td>W serwisie</td><td>Stan</td><td>Zafakturowane</td><td>Utylizacja</td><td>Czas operacji</td></tr><tbody>";
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
				            echo "<td>"; if($result[$i]->getFV()==0) echo "Nie"; else echo "Tak"; echo "</td>";
				            echo "<td>"; if($result[$i]->getUtyl()==0) echo "Nie"; else echo "Tak"; echo "</td>";
				            echo "<td>".$result[$i]->getOperationTime()."</td>";
				            echo "</tr>";
                        		}
                    	    }
                    	    else{
                        	echo "Nie udało sie pobrać historii urządzeń.";
                            }	
			}
		?>  
                </div>    
            </main>
        </body>
    </html>
<?php } ?>

