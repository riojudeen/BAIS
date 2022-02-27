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


    <script src="js/asset/all.min.js" crossorigin="anonymous">
    </script>
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

                    <!-- Andon Monitor Absensi--->
                    <div class="card mt-1 ">
                        <div class="card-body p-lg-3 p-md-3 p-sm-2 p-1 shadow clearfix">
                            <h3 class="m-auto float-left text-black">Monitoring Absensi</h3>
                            <form class="form-inline float-right m-auto">
                                <label class="my-1 mx-2"
                                    for="inlineFormCustomSelectPref"><strong>Tanggal</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="far fa-calendar-alt"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option selected>yyyy/mm/dd</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>

                                </div>
                                <label class="my-1 mx-2" for="inlineFormCustomSelectPref"><strong>Shift</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="fas fa-chevron-circle-right"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">N</option>
                                    </select>

                                </div>

                                <label class="my-1 mx-2"
                                    for="inlineFormCustomSelectPref"><strong>Section</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="fas fa-users-cog"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option value="1">Produksi</option>
                                        <option value="2">Quality</option>
                                        <option value="3">Project</option>
                                        <option value="1">People Dev</option>
                                        <option value="2">Cost Control</option>
                                        <option value="3">Performance Mng</option>
                                    </select>

                                </div>
                                <label class="my-1 mx-2"><strong>Page</strong></label>
                                <div class="btn-group btn-group-toggle btn-group-sm my-sm-2 mx-sm-2 my-1 mx-2"
                                    data-toggle="buttons">
                                    <label class="btn btn-secondary active">
                                        <input type="radio" name="options" id="option1" checked> <i
                                            class="fas fa-th"></i>
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="options" id="option2"> <i class="fas fa-stream"></i>
                                    </label>

                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="row">

                        <!---table 1--->

                        <table
                            class="col-xl table table-sm table-bordered table table-striped m-3 text-center align-text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Frm</th>
                                    <th scope="col">G/L</th>
                                    <th scope="col bg-primary" colspan="6">Team Member</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 1</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 2</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 3</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 3</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        <!---table 2--->
                        <table
                            class="col-xl table table-sm table-bordered table table-striped m-3 text-center align-text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Frm</th>
                                    <th scope="col">G/L</th>
                                    <th scope="col bg-primary" colspan="6">Team Member</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 1</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 2</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 3</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 3</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        <!---table 3--->
                        <table
                            class="col-xl table table-sm table-bordered table table-striped m-3 text-center align-text-center">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Frm</th>
                                    <th scope="col">G/L</th>
                                    <th scope="col bg-primary" colspan="6">Team Member</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 1</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 2</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 3</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Foreman 1</td>
                                    <td>G/L 3</td>
                                    <td class="p-0">
                                        <table class="table table-sm table-bordered m-lg-0">
                                            <tr>
                                                <td>Nama 1</td>
                                                <td>Nama 2</td>
                                                <td>Nama 3</td>
                                                <td>Nama 4</td>
                                                <td>Nama 5</td>
                                                <td>Nama 6</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 7</td>
                                                <td>Nama 8</td>
                                                <td>Nama 9</td>
                                                <td>Nama 10</td>
                                                <td>Nama 11</td>
                                                <td>Nama 12</td>
                                            </tr>
                                            <tr>
                                                <td>Nama 13</td>
                                                <td>Nama 14</td>
                                                <td>Nama 15</td>
                                                <td>Nama 16</td>
                                                <td>Nama 17</td>
                                                <td>Nama 18</td>
                                            </tr>


                                        </table>
                                    </td>

                                </tr>

                            </tbody>
                        </table>








                    </div>



                    <!-- Andon Apresiasi Absensi--->

                    <div class="card mt-1 ">
                        <div class="card-body p-lg-3 p-md-3 p-sm-2 p-1 shadow clearfix">
                            <h3 class="m-auto float-left text-black">Apresiasi Man Power</h3>
                            <form class="form-inline float-right m-auto">
                                <label class="my-1 mx-2"
                                    for="inlineFormCustomSelectPref"><strong>Tanggal</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="far fa-calendar-alt"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option selected>yyyy/mm/dd</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>

                                </div>
                                <label class="my-1 mx-2" for="inlineFormCustomSelectPref"><strong>Shift</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="fas fa-chevron-circle-right"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">N</option>
                                    </select>

                                </div>

                                <label class="my-1 mx-2"
                                    for="inlineFormCustomSelectPref"><strong>Section</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="fas fa-users-cog"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option value="1">Produksi</option>
                                        <option value="2">Quality</option>
                                        <option value="3">Project</option>
                                        <option value="1">People Dev</option>
                                        <option value="2">Cost Control</option>
                                        <option value="3">Performance Mng</option>
                                    </select>

                                </div>
                            </form>

                        </div>
                    </div>
                    <!---MP--->
                    <div class="row mt-2">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Grafik Summary <i class="fas fa-chart-pie fa-3x"></i></div>

                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="img\dvh.png" class="card-img h-100" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <a class="small text-white stretched-link" href="#">Div Head</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="img\mng.png" class="card-img h-100" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <a class="small text-white stretched-link" href="#">Dept Head</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-warning text-white mb-4">
                                <div class="row no-gutters">
                                    <div class="col-md-4">
                                        <img src="img\spv.png" class="card-img h-100" alt="...">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <a class="small text-white stretched-link" href="#">Sect Head</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 row-cols-xl-5 mx-auto mt-2">
                        <!---MP--->
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">

                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 shadow-sm" style="max-width: 350px;">
                            <div class="row no-gutters">
                                <div class="col-md-5">
                                    <img src="img\tm.png" class="card-img py-3 h-100" alt="...">


                                </div>
                                <div class="col-md-7 bg-light">
                                    <div class="card-body">
                                        <p class="card-title text-uppercase text-truncate">Rio Setiawan Judin</p>
                                        <p class="card-text d-inline-block"><small class="text-muted"><i
                                                    class="far fa-bookmark"></i> Best
                                                Record</small>
                                        </p>
                                        <a href="#" class="badge badge-pill badge-primary">Top 1</a>
                                        <div class="row no-gutters border-top border-bottom bg-light">
                                            <div class="col-auto card-body text-center"><i
                                                    class="fas fa-clock fa-2x"></i>


                                            </div>
                                            <div class="col-auto card-body text-center">
                                                <h6>06-30</h6>
                                            </div>
                                        </div>

                                        <a href="#" class="badge"><i class="far fa-eye"></i> detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Andon Effiesiensi Man Power--->
                    <div class="card mt-1 ">
                        <div class="card-body p-lg-3 p-md-3 p-sm-2 p-1 shadow clearfix">
                            <h3 class="m-auto float-left text-black">Effiensi Man Power</h3>
                            <form class="form-inline float-right m-auto">
                                <label class="my-1 mx-2"
                                    for="inlineFormCustomSelectPref"><strong>Tanggal</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="far fa-calendar-alt"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option selected>yyyy/mm/dd</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>

                                </div>
                                <label class="my-1 mx-2" for="inlineFormCustomSelectPref"><strong>Shift</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="fas fa-chevron-circle-right"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">N</option>
                                    </select>

                                </div>

                                <label class="my-1 mx-2"
                                    for="inlineFormCustomSelectPref"><strong>Section</strong></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect-sizing-sm"><i
                                                class="fas fa-users-cog"></i></label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect-sizing-sm">
                                        <option value="1">Produksi</option>
                                        <option value="2">Quality</option>
                                        <option value="3">Project</option>
                                        <option value="1">People Dev</option>
                                        <option value="2">Cost Control</option>
                                        <option value="3">Performance Mng</option>
                                    </select>

                                </div>
                            </form>




                        </div>
                    </div>





                    <div class="row mt-2">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area mr-1"></i>
                                    Efficiency Man Power
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    Summary Bulanan
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            DataTable Example
                        </div>

                    </div>
                    <!--sementara inactive end-->


                </div>
            </main>
            <!--footer--->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Body Administration & Information System</div>
                        <div>
                            <a href="#">Contact Administrator</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!------------------------------------------------------------------------------main content program end------------------------>






    <!---javascript bootstrap start--->
    <script src="js/jquery-3.5.1.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/scripts.js"></script>
    <!---javascript bootstrap end--->
    <script src="js/asset/Chart.min.js" crossorigin="anonymous"></script>
    <script src="js/asset/chart-area-demo.js"></script>
    <script src="js/asset/chart-bar-demo.js"></script>
    <script src="js/asset/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="js/assetdataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="js/asset/datatables-demo.js"></script>

</body>

</html>