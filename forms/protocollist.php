<?php
session_start();
if(isset($_SESSION['cur_loc'])) {unset($_SESSION["cur_loc"]);}
if(isset($_SESSION['cur_type'])) {unset($_SESSION["cur_type"]);}
if(isset($_SESSION['dev_type'])) {unset($_SESSION["dev_type"]);}
if(isset($_SESSION['dev_model'])) {unset($_SESSION["dev_model"]);}
if(isset($_SESSION['find_sn'])) {unset($_SESSION['find_sn']);}
if(isset($_SESSION['login'])){   
    require_once '../database/DBManager.php';
    require_once '../data/Protocol.php';
    require_once '../database/Query.php';
    ?>
    <html>
        <head>
            <title>Lista protokołów</title>
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
                    <h2>Lista protokołów</h2>
                </div>
                <form method="post" action="../actions/showprotocol.php">
                    <div><input type="submit" class='btn btn-sm btn-dark' name="zat" value="Zatwierdź"> <input type="submit" class='btn btn-sm btn-dark' name="pod" value="Podgląd"></div>
                <table class='table table-striped table-sm'>
                <?php
                $link = DBManager::connect2();
                $result = DBManager::select($link, Query::$GET_ALL_PROT, null, "Protocol"); //DBManager::getAllProtocols();
                $link=null;
                if(is_array($result)){
                    echo "<thread><tr><th>Numer</th><th>Data wystawienia</th><th>Odbiorca</th><th>Osoba wystawiająca</th><th>Czy wrócił</th><th>Zatwierdź</th><th>Podgląd</th></tr></thread><tbody>";
                    for($i=0;$i<sizeof($result);$i++){
                        echo "<tr>";
                        echo "<td>".$result[$i]->getId()."</td>";
                        echo "<td>".$result[$i]->getDate()."</td>";                
                        echo "<td>".$result[$i]->getLokName()." ".$result[$i]->getShortName()." ".$result[$i]->getOso()."</td>";
                        echo "<td>".$result[$i]->getLogin()."</td>";
                        if($result[$i]->getReturned()==1){
                            echo "<td><img src='../images/ok.png'></td><td></td><td><input type='radio' name='podglad' value='".$result[$i]->getId()."'></td>";
                        }
                        else{
                            echo "<td><img src='../images/x.png'></td><td><input type='checkbox' name=chbx[] value='".$result[$i]->getId()."'></td><td><input type='radio' name='podglad' value='".$result[$i]->getId()."'></td>";
                        }
                        echo "</tr>";
                    }
                }
                else{
                    echo "Nie udało sie pobrać modeli";
                }
                ?>
                </tbody></table>
                </form>
            </main>
            </div>
            </div>
        </body>
    </html>
<?php } ?>


