<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
    @font-face {
        font-family: hotel_de_paris;
        src: url('font/hotel_de_paris.ttf') format('truetype');
    }
    </style>




    <!---css aku start--->

    <link rel="stylesheet" href="css/bootstrap.css">
    <link href="css/styles.css" rel="stylesheet">


    <link href="css/css.css" rel="stylesheet">


    <script src="js/asset/all.min.js" crossorigin="anonymous"></script>
        <!---javascript bootstrap start--->
        <script src="js/jquery-3.5.1.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/scripts.js"></script>
    
    <!---css aku end--->
    <title>Body Administration & Information System</title>
    <link rel="icon" href="img/logo.png" type="image/png">
</head>
<!------------------------------------------------------------------------------main content program------------------------>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="#" id="sidebarToggle">
            <img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            BAIS
            <!--<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i
                class="fas fa-bars"></i></button>-->
            <!--toggle side bar-->

        </a>
        <!---logo BAIS--->





        <!-- Navbar-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon "></span>
        </button>
        <!---toggle collapse header--->


        <div class="collapse navbar-collapse bg-dark m-0" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto  px-xs-3 px-sm-3">
                <li class="nav-item">
                    <a class="nav-link" href="#">Absensi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">General Information</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Visi-Misi</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        HR-Site
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Personal Site</a>
                        <a class="dropdown-item" href="#">HRIS</a>
                    </div>

                </li>

            </ul>

            <ul class="navbar-nav ml-auto  py-2 px-xs-3 px-sm-3">

                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">change password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Log in / log out</a>
                    </div>
                </li>
            </ul>
        </div>        
    </nav>
    <!-- Navbar-->

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!---Step 1 Monitoring Absen--->
                        <div class="sb-sidenav-menu-heading">Dashboard</div>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-clock"></i></div>
                            Andon Absen
                        </a>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-medal"></i></div>
                            Apresiasi
                        </a>
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Effisiensi MP
                        </a>
                        <!---Step 1 end--->
                        <!---Step 2 Informasi Transfer--->
                        <div class="sb-sidenav-menu-heading">Monitoring</div>
                        <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseLayouts"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                            Informasi Transfer
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="">Uang Makan</a>
                                <a class="nav-link" href="">SS Transfer</a>
                            </nav>
                        </div>
                        <!---Step 2 SPL & Absensi--->
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Administrasi
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                            data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="" data-toggle="collapse"
                                    data-target="#pagesCollapseAuth" aria-expanded="false"
                                    aria-controls="pagesCollapseAuth">
                                    Absensi
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                    data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="">Monitoring</a>
                                        <a class="nav-link" href="">Request SUPEM</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="" data-toggle="collapse"
                                    data-target="#pagesCollapseError" aria-expanded="false"
                                    aria-controls="pagesCollapseError">
                                    Lembur
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                    data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="">Pengajuan</a>

                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <!---Step 2 Approval--->
                        <div class="sb-sidenav-menu-heading">Approval & Control</div>
                        <a class="nav-link" href="">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Progress Pengajuan
                        </a>
                        <a class="nav-link" href="">
                            <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></i></div>
                            Approval Pengajuan
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Nama
                </div>
            </nav>
        </div>


        <!--main content--->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid p-2">