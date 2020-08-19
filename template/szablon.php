<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Strona główna</title>

    <script src="../scripts/devicesbylok.js" type="text/javascript"></script>
    <script type="../text/javascript" src="js/mdb.min.js"></script>

    <!-- Your custom styles (optional) -->
    <link href="../css/menu.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../css/mdb.min.css" rel="stylesheet"> 
	<link href="../template/prot.css" rel="stylesheet">
	<link href="../template/print.css" rel="stylesheet" media="print"> 

    <script>
        $("#alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#alert").slideUp(500);
        });
    </script>
</head>
<body class="">

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

    <div class="container-fluid">
        <div class="row">
            <?php if(isset($_SESSION['login'])){ ?>
                <nav class="navbar navbar-dark fixed-top elegant-color flex-md-nowrap p-0 shadow">
                    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.php">Kanciapa ERP v3</a>
                    <ul class="navbar-nav px-3 text-white">
                        <li class="nav-item text-nowrap">
                            <a class="nav-link font-weight-light" href="../forms/logout.php">Wyloguj</a>
                        </li>
                    </ul>
                </nav>
                <?php }
                else{ ?>
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
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
                
                <div id="print">
                    <p id="title"><b>PROTOKÓŁ PRZEKAZANIA SPRZĘTU</b></p><br><br>
                    <table>
                    <tr><td class="ftfc"><b>Przekazujący:</b></td><td class="ftsc">Dział informatyki</td></tr>
					<tr><td class="ftfc"><b>Zlecający:</b></td><td class="ftsc">
                        <?php 
                            echo $result[0]->getZlec();
                        ?>
                    </td></tr>
                    <tr><td class="ftfc"><b>Przyjmujący:</b></td><td class="ftsc">
                        <?php 
                            echo "Oddział ".$result[0]->getLokName()." ".$result[0]->getShortName()." ".$result[0]->getOso();
                        ?>
                    </td></tr>
                    <tr><td class="ftfc"><b>Przedmiot przekazania:</b></td><td class="ftsc">
                        <?php
                            for($i=0;$i<sizeof($result2);$i++){
                                echo "1x ".$result2[$i]->getTypeName()." ".$result2[$i]->getModelName().", s.n. ".$result2[$i]->getSN()."<br>";
                            }
                            echo $result[0]->getOtherDev();
                        ?>
                    </td></tr>
                    </table>
                    <p>Przyjmujący zapoznał się ze sprzętem, stwierdza, że jest kompletny i bez uszkodzeń<p>

                    <p>Przyjmujący zobowiązuje się do dbałości o powierzony sprzęt, zobowiązuje się przechowywać go i użytkować w sposób uniemożliwiający jego utratę.</p>

                    <br><p>Zamość <?php echo $result[0]->getDate(); ?></p><br><br><br>

                    <table id="second">
                    <tr><td>Przekazujacy</td><td class="stsc" id="przyjmujacy">Przyjmujący</td></tr>
                    <tr><td></td><td class="stsc">(proszę o czytelny podpis)</td></tr>
                    <tr><td></td><td><br><br><br><br><br><br></td></tr>
                    <tr><td colspan="2"><p>Uwagi:<br>.......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................
                    .......................................................................................................................................................................................................</p></td></tr>
                    </table>
                </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>