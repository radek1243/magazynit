<div class="container-fluid">
            <div class="row">
                <nav class="col-md-2 d-none d-md-block bg-white sidebar">
                <?php if(isset($_SESSION['login'])){ ?>
                    <div id="menu1" class="sidebar-sticky">
                        <ul id="menulist" class="nav flex-column">
                            <li class="nav-item"><a class="nav-link" href="../index.php">Strona główna</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/devices.php">Dodaj urządzenie</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/models.php">Modele</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/locations.php">Lokalizacje</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/types.php">Typy urządzeń</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/protocollist.php">Lista protkołów</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/protocol.php">Dodaj protokół</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/fv.php">Fakturowanie</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/service.php">W serwisie</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/finddevice.php">Wyszukaj urządzenie</a></li>
                            <li class="nav-item"><a class="nav-link" href="../forms/checkhist.php">Historia urządzenia</a></li>
			    <li class="nav-item"><a class="nav-link" href="../forms/dayhist.php">Historia urządzeń wg daty</a></li>
                        </ul>
                    </div>
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
                        <div id="menu1" class="sidebar-sticky">
                            <ul id="menulist" class="nav flex-column">
                                <li class="nav-item">Zaloguj się, aby zobaczyć</a></li>
                            </ul>
                        </div>
                        <nav class="navbar navbar-dark fixed-top elegant-color flex-md-nowrap p-0 shadow">
                            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index.php">Kanciapa ERP v3</a>
                            <ul class="navbar-nav px-3">
                                <li class="nav-item text-nowrap">
                                    <form method="post" action="actions/login.php" class="text-white">
                                        <input type="text" maxlength="20" name="user" class="form-control-dark" placeholder="Login">
                                        <input type="password" name="pass" class="form-control-dark" placeholder="Hasło">
                                        <input type="submit" name="login" class="btn btn-sm btn-light" value="Zaloguj">
                                    </form>
                                </li>
                            </ul>
                        </nav>
                        <?php } 
                    ?>
                </nav>

