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
    ?>
    <html>
        <head>
            <title>Strona główna</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">

            <script src="../scripts/fv.js" type="text/javascript"></script>
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
        <body onload="getDevToFV();">
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
                    <h2>Fakturowanie</h2>
                </div>
                    <select id="typ" class='custom-select custom-select-sm w-25 m-2' onchange="getDevToFV();">
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
                <br>
                <form method="post" action="../actions/setfv.php" class="border-bottom mb-4 mt-3">
                <div id="devices" class="mb-4 mt-3">     
                </div>    
                <input type="submit" class='btn btn-sm btn-dark' name="fv" value="Zafakturuj"><br>    
                </form>
            </main>
        </body>
    </html>
<?php } ?>

