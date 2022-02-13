
<!DOCTYPE html>

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="apple-touch-icon" sizes="57x57" href="https://demo.worksuite.biz/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://demo.worksuite.biz/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://demo.worksuite.biz/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://demo.worksuite.biz/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://demo.worksuite.biz/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://demo.worksuite.biz/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://demo.worksuite.biz/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://demo.worksuite.biz/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://demo.worksuite.biz/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="https://demo.worksuite.biz/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://demo.worksuite.biz/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://demo.worksuite.biz/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://demo.worksuite.biz/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://demo.worksuite.biz/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="https://demo.worksuite.biz/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>Admin Panel | Contracts</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet prefetch'
          href='assets/css/flag-icon.min.css'>
    <link rel='stylesheet prefetch'
          href='assets/css/bootstrap-select.min.css'>

    <!-- This is Sidebar menu CSS -->
    <link href="assets/css/sidebar-nav.min.css" rel="stylesheet">

    <link href="assets/css/jquery.toast.css" rel="stylesheet">
    <link href="assets/css/sweetalert.css" rel="stylesheet">

    <!-- This is a Animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="assets/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="assets/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
<link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
<link rel="stylesheet" href="assets/css/custom-select.css">
    <style>
        #contracts-table_wrapper .dt-buttons{
            display: none !important;
        }
    </style>
            <!-- This is a Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (default.css) for this starter
       page. However, you can choose any other skin from folder css / colors .
       -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <link href="assets/css/helper.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link href="assets/css/custom-new.css" rel="stylesheet">

        <link href="assets/css/rounded.css" rel="stylesheet">
    
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    
    
    <style>
        .sidebar .notify  {
        margin: 0 !important;
        }
        .sidebar .notify .heartbit {
        top: -23px !important;
        right: -15px !important;
        }
        .sidebar .notify .point {
        top: -13px !important;
        }
    </style>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="assets/js/js?id=UA-118670843-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-118670843-2');
    </script>

    <!-- Hotjar Tracking Code for https://demo.worksuite.biz/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:1983775,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>

</head>
<body class="fix-sidebar">
<script>
    var checkMiniSidebar = localStorage.getItem('mini-sidebar');

    if (checkMiniSidebar == "yes" || checkMiniSidebar == "") {
        // document.body.classList.add("content-wrapper");
        document.body.className += ' ' + 'content-wrapper';
    }
</script>

<!-- Preloader -->
<div class="preloader">
    <div class="cssload-speeding-wheel"></div>
</div>
<div id="wrapper">
    <!-- Left navbar-header -->
    <style>
    .slimScrollDiv{
        overflow: initial !important;
    }
</style>
<div class="navbar-default sidebar" role="navigation">
    <div class="navbar-header">
        <!-- Toggle icon for mobile view -->
        <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse"
            data-target=".navbar-collapse"><i class="ti-menu"></i></a>

        <div class="top-left-part">
            <!-- Logo -->
            <a class="logo hidden-xs text-center" href="https://demo.worksuite.biz/admin/dashboard">
                <span class="visible-md"><img src="https://demo.worksuite.biz/img/worksuite-logo.png" alt="home" class=" admin-logo"/></span>
                <span class="visible-sm"><img src="https://demo.worksuite.biz/img/worksuite-logo.png" alt="home" class=" admin-logo"/></span>
            </a>

        </div>
        <!-- /Logo -->

        <!-- This is the message dropdown -->
        <ul class="nav navbar-top-links navbar-right pull-right visible-xs">
            

            <li class="dropdown">
                <select class="selectpicker language-switcher" data-width="fit">
                    <option value="en"  selected  data-content='<span class="flag-icon flag-icon-gb"></span> En'>En</option>
                                            <option value="es"   data-content='<span class="flag-icon flag-icon-es"></span> es'>es</option>
                                            <option value="fr"   data-content='<span class="flag-icon flag-icon-fr"></span> fr'>fr</option>
                                            <option value="ru"   data-content='<span class="flag-icon flag-icon-ru"></span> ru'>ru</option>
                                    </select>
            </li>

            <!-- .Task dropdown -->
            <li class="dropdown" id="top-notification-dropdown">
                <a class="dropdown-toggle waves-effect waves-light show-user-notifications" data-toggle="dropdown" href="#">
                    <i class="icon-bell"></i>
                                    </a>
                <ul class="dropdown-menu  dropdown-menu-right mailbox animated slideInDown">
                    <li>
                        <a href="javascript:;">...</a>
                    </li>

                </ul>
            </li>
            <!-- /.Task dropdown -->


            <li class="dropdown">
                <a href="https://demo.worksuite.biz/logout" title="Logout" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"
                ><i class="fa fa-power-off"></i>
                </a>
            </li>



        </ul>

    </div>
    <!-- /.navbar-header -->

    <div class="top-left-part">
        <a class="logo hidden-xs hidden-sm text-center" href="https://demo.worksuite.biz/admin/dashboard">
            <img src="https://demo.worksuite.biz/img/worksuite-logo.png" alt="home" class=" admin-logo"/>
        </a>


    </div>
    <div class="sidebar-nav navbar-collapse slimscrollsidebar">

        <!-- .User Profile -->
        <ul class="nav" id="side-menu">
            <li class="sidebar-search hidden-sm hidden-md hidden-lg">
                <!-- input-group -->
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
                            <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span> </div>
                <!-- /input-group -->
            </li>

            <li class="user-pro hidden-sm hidden-md hidden-lg">
                                    <a href="#" class="waves-effect"><img src="https://demo.worksuite.biz/img/default-profile-3.png" alt="user-img" class="img-circle"> <span class="hide-menu">Mr. Pete Eichmann
                    <span class="fa arrow"></span></span>
                    </a>
                                <ul class="nav nav-second-level">
                    <li>
                        <a href="https://demo.worksuite.biz/member/dashboard">
                            <i class="fa fa-sign-in fa-fw"></i> Login As Employee                        </a>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="https://demo.worksuite.biz/logout" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"
                        ><i class="fa fa-power-off fa-fw"></i> Logout</a>

                    </li>
                </ul>
            </li>


                            
                                    <li><a href="javascript:;" class="waves-effect"><i class="icon-speedometer fa-fw"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level sub-menu-ul">
                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/dashboard" class="waves-effect"> <span class="hide-menu">Dashboard </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/project-dashboard" class="waves-effect"> <span class="hide-menu">Project Dashboard </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/client-dashboard" class="waves-effect"> <span class="hide-menu">Client Dashboard </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/hr-dashboard" class="waves-effect"> <span class="hide-menu">HR Dashboard </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/ticket-dashboard" class="waves-effect"> <span class="hide-menu">Ticket Dashboard </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/finance-dashboard" class="waves-effect"> <span class="hide-menu">Finance Dashboard </span></a> </li>
                                                                                    </ul>
                    </li>
                                            
                                    <li><a href="javascript:;" class="waves-effect"><i class="icon-people fa-fw"></i> <span class="hide-menu"> Customers <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level sub-menu-ul">
                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/clients" class="waves-effect"> <span class="hide-menu">Clients </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/leads" class="waves-effect"> <span class="hide-menu">Leads </span></a> </li>
                                                                                    </ul>
                    </li>
                                            
                                    <li><a href="javascript:;" class="waves-effect"><i class="ti-user fa-fw"></i> <span class="hide-menu"> HR <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level sub-menu-ul">
                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/employees/employees" class="waves-effect"> <span class="hide-menu">Employee List </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/employees/department" class="waves-effect"> <span class="hide-menu">Department </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/employees/designations" class="waves-effect"> <span class="hide-menu">Designation </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/attendances/summary" class="waves-effect"> <span class="hide-menu">Attendance </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/holidays" class="waves-effect"> <span class="hide-menu">Holiday </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/leaves/pending" class="waves-effect"> <span class="hide-menu">Leaves </span></a> </li>
                                                                                    </ul>
                    </li>
                                            
                                    <li><a href="javascript:;" class="waves-effect"><i class="icon-layers fa-fw"></i> <span class="hide-menu"> Work <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level sub-menu-ul">
                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/contracts" class="waves-effect"> <span class="hide-menu">Contracts </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/projects" class="waves-effect"> <span class="hide-menu">Projects </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/task/all-tasks" class="waves-effect"> <span class="hide-menu">Tasks </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/task/taskboard" class="waves-effect"> <span class="hide-menu">Task Board </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/task/task-calendar" class="waves-effect"> <span class="hide-menu">Task Calendar </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/all-time-logs" class="waves-effect"> <span class="hide-menu">Time Logs </span></a> </li>
                                                                                    </ul>
                    </li>
                                            
                                    <li><a href="javascript:;" class="waves-effect"><i class="fa fa-money fa-fw"></i> <span class="hide-menu"> Finance <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level sub-menu-ul">
                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/finance/estimates" class="waves-effect"> <span class="hide-menu">Estimates </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/finance/all-invoices" class="waves-effect"> <span class="hide-menu">Invoices </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/finance/payments" class="waves-effect"> <span class="hide-menu">Payments </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/finance/expenses" class="waves-effect"> <span class="hide-menu">Expenses </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/finance/all-credit-notes" class="waves-effect"> <span class="hide-menu">Credit Note </span></a> </li>
                                                                                    </ul>
                    </li>
                                            
                                    
                                            <li><a href="https://demo.worksuite.biz/admin/products" class="waves-effect"><i class="icon-basket fa-fw"></i> <span class="hide-menu">Products </span></a> </li>
                    
                                            
                                    
                                            <li><a href="https://demo.worksuite.biz/admin/tickets" class="waves-effect"><i class="ti-ticket fa-fw"></i> <span class="hide-menu">Tickets </span></a> </li>
                    
                                            
                                    
                                            <li><a href="https://demo.worksuite.biz/admin/user-chat" class="waves-effect"><i class="icon-envelope fa-fw"></i> <span class="hide-menu">Messages </span></a> </li>
                    
                                            
                                    
                                            <li><a href="https://demo.worksuite.biz/admin/events" class="waves-effect"><i class="icon-calender fa-fw"></i> <span class="hide-menu">Events </span></a> </li>
                    
                                            
                                    
                                            <li><a href="https://demo.worksuite.biz/admin/notices" class="waves-effect"><i class="ti-layout-media-overlay fa-fw"></i> <span class="hide-menu">Notice Board </span></a> </li>
                    
                                            
                                    <li><a href="javascript:;" class="waves-effect"><i class="ti-pie-chart fa-fw"></i> <span class="hide-menu"> Reports <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level sub-menu-ul">
                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/reports/task-report" class="waves-effect"> <span class="hide-menu">Task Report </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/reports/time-log-report" class="waves-effect"> <span class="hide-menu">Time Log Report </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/reports/finance-report" class="waves-effect"> <span class="hide-menu">Finance Report </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/reports/income-expense-report" class="waves-effect"> <span class="hide-menu">Income Vs Expense Report </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/reports/leave-report" class="waves-effect"> <span class="hide-menu">Leave Report </span></a> </li>
                                                                                            
                                                                    <li><a href="https://demo.worksuite.biz/admin/reports/attendance-report" class="waves-effect"> <span class="hide-menu">Attendance Report </span></a> </li>
                                                                                    </ul>
                    </li>
                                            
                                    
                                            <li><a href="https://demo.worksuite.biz/admin/settings" class="waves-effect"><i class="ti-settings fa-fw"></i> <span class="hide-menu">Settings </span></a> </li>
                    
                            
                                        
        </ul>

        <div class="clearfix"></div>





    </div>

    <div class="menu-footer">
        <div class="menu-user row">
            <div class="col-lg-4 m-b-5">
                <div class="btn-group dropup user-dropdown">

                    <img aria-expanded="false" data-toggle="dropdown" src="https://demo.worksuite.biz/img/default-profile-3.png" alt="user-img" class="img-circle dropdown-toggle h-30 w-30">

                    <ul role="menu" class="dropdown-menu">
                        <li><a class="bg-inverse"><strong class="text-white font-semi-bold">Mr. Pete Eichmann</strong></a></li>
                        <li>
                            <a href="https://demo.worksuite.biz/member/dashboard">
                                <i class="fa fa-sign-in fa-fw"></i> Login As Employee                            </a>
                        </li>
                        <li><a href="https://demo.worksuite.biz/logout" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"
                            ><i class="fa fa-power-off fa-fw"></i> Logout</a>
                            <form id="logout-form" action="https://demo.worksuite.biz/logout" method="POST" style="display: none;">
                                <input type="hidden" name="_token" value="nl5UI2sXj3a2EueSG3sZJtlvM9MCEjLbp5AQxC0y">
                            </form>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-lg-4 text-center  m-b-5">
                <div class="btn-group dropup shortcut-dropdown">
                    <a class="dropdown-toggle waves-effect waves-light text-uppercase" data-toggle="dropdown" href="#">
                        <i class="fa fa-plus"></i>
                    </a>
                    <ul class="dropdown-menu">

                                                    <li>
                                <div class="message-center">
                                    <a href="https://demo.worksuite.biz/admin/projects/create">
                                        <div class="mail-contnet">
                                            <span class="mail-desc m-0">Add Project</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        
                                                    <li>
                                <div class="message-center">
                                    <a href="https://demo.worksuite.biz/admin/task/all-tasks/create">
                                        <div class="mail-contnet">
                                            <span class="mail-desc m-0">Add Task</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        
                                                    <li>
                                <div class="message-center">
                                    <a href="https://demo.worksuite.biz/admin/clients/create">
                                        <div class="mail-contnet">
                                            <span class="mail-desc m-0">Add Client</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        
                                                    <li>
                                <div class="message-center">
                                    <a href="https://demo.worksuite.biz/admin/employees/employees/create">
                                        <div class="mail-contnet">
                                            <span class="mail-desc m-0">Add Employee</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        
                                                    <li>
                                <div class="message-center">
                                    <a href="https://demo.worksuite.biz/admin/finance/payments/create">
                                        <div class="mail-contnet">
                                            <span class="mail-desc m-0">Add Payment</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        
                                                    <li>
                                <div class="message-center">
                                    <a href="https://demo.worksuite.biz/admin/tickets/create">
                                        <div class="mail-contnet">
                                            <span class="mail-desc m-0">Add Ticket</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 text-right m-b-5">
                <div class="btn-group dropup notification-dropdown">
                    <a class="dropdown-toggle show-user-notifications" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>
                                            </a>
                    <ul class="dropdown-menu mailbox ">
                        <li>
                            <a href="javascript:;">...</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="menu-copy-right">
            <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="ti-angle-double-right ti-angle-double-left"></i> <span class="collapse-sidebar-text">Collapse Sidebar</span></a>
        </div>

    </div>


</div>
            <!-- Left navbar-header end -->
    <!-- Page Content -->
    <div id="page-wrapper" class="row">
        <div class="container-fluid">
                                                    <div class="col-md-3 filter-section">
                    <h5 class="pull-left"><i class="fa fa-sliders"></i> Filter Results</h5>
                    <h5 class="pull-right hidden-sm hidden-md hidden-xs">
                        <button class="btn btn-default btn-xs btn-outline btn-circle filter-section-close" ><i class="fa fa-chevron-left"></i></button>
                    </h5>
                                    <div class="row" id="ticket-filters">

                    <form action="" id="filter-form">
                        <div class="col-md-12">
                            <h5 >Select Date Range</h5>
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" id="start-date" placeholder="Start Date"
                                       value=""/>
                                <span class="input-group-addon bg-info b-0 text-white">To</span>
                                <input type="text" class="form-control" id="end-date" placeholder="End Date"
                                       value=""/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5 >Client</h5>
                            <div class="form-group">
                                <div>
                                    <select class="select2 form-control" data-placeholder="Client" name="client" id="clientID">
                                        <option value="all">All</option>
                                        
                                            <option value="16">Betsy O&#039;Kon</option>
                                        
                                            <option value="14">Blanca Harvey</option>
                                        
                                            <option value="10">Carmella Pagac Jr.</option>
                                        
                                            <option value="17">Carson Dickinson</option>
                                        
                                            <option value="11">Curt Hane</option>
                                        
                                            <option value="27">Dr. Eloise Jacobi DDS</option>
                                        
                                            <option value="25">Edwardo Keeling PhD</option>
                                        
                                            <option value="8">Eloise Will</option>
                                        
                                            <option value="5">Elsa Cassin</option>
                                        
                                            <option value="3">Finn Kilback V</option>
                                        
                                            <option value="21">Gilberto Champlin</option>
                                        
                                            <option value="4">Haylie Kertzmann</option>
                                        
                                            <option value="26">Idella Upton</option>
                                        
                                            <option value="22">Jairo Ledner PhD</option>
                                        
                                            <option value="18">Josiane Reichel</option>
                                        
                                            <option value="23">Kattie Toy IV</option>
                                        
                                            <option value="28">Kellen Stracke III</option>
                                        
                                            <option value="9">Leone Pfannerstill</option>
                                        
                                            <option value="24">Mason Price I</option>
                                        
                                            <option value="20">Mckenna Turner Sr.</option>
                                        
                                            <option value="30">Mr. Junius Price Jr.</option>
                                        
                                            <option value="32">Mr. Monty Graham PhD</option>
                                        
                                            <option value="31">Patsy Kulas</option>
                                        
                                            <option value="29">Prof. Brook Hessel</option>
                                        
                                            <option value="12">Shayna Satterfield</option>
                                        
                                            <option value="19">Sonny West</option>
                                        
                                            <option value="15">Theron Schiller</option>
                                        
                                            <option value="7">Trycia Emmerich Jr.</option>
                                        
                                            <option value="33">Ubaldo Schamberger</option>
                                        
                                            <option value="6">Verda Bode</option>
                                        
                                            <option value="13">Vicenta Mraz</option>
                                                                            </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h5 >Contract Type</h5>
                            <div class="form-group">
                                <div>
                                    <select class="select2 form-control" data-placeholder="Contract Type" name="contractType" id="contractType">
                                        <option value="all">All</option>
                                        
                                            <option value="1">Adhesion Contracts</option>
                                        
                                            <option value="2">Aleatory Contracts</option>
                                        
                                            <option value="3">Bilateral And Unilateral Contracts</option>
                                        
                                            <option value="4">Contracts Under Seal</option>
                                        
                                            <option value="5">Executed And Executory Contracts</option>
                                        
                                            <option value="6">Express Contracts</option>
                                        
                                            <option value="7">Implied Contracts</option>
                                        
                                            <option value="8">Unconscionable Contracts</option>
                                        
                                            <option value="9">Void And Voidable Contracts</option>
                                                                            </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group m-t-10">
                                <label class="control-label col-xs-12">&nbsp;</label>
                                <button type="button" id="apply-filters" class="btn btn-success col-md-6"><i class="fa fa-check"></i> Apply</button>
                                <button type="button" id="reset-filters" class="btn btn-inverse col-md-5 col-md-offset-1"><i class="fa fa-refresh"></i> Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                                </div>
             
             

            <div class="
                        col-md-9
                                data-section">
                <button class="btn btn-default btn-xs btn-outline btn-circle m-t-5 filter-section-show hidden-sm hidden-md hidden-xs" style="display:none"><i class="fa fa-chevron-right"></i></button>
                                    <div class="row hidden-md hidden-lg">
                        <div class="col-xs-12 p-l-25 m-t-10">
                            <button class="btn btn-inverse btn-outline" id="mobile-filter-toggle"><i class="fa fa-sliders"></i></button>
                        </div>
                    </div>
                
                    <div class="row bg-title">
        <!-- .page title -->
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title"><i class="fa fa-file"></i> Contracts</h4>
        </div>
        <!-- /.page title -->
        <!-- .breadcrumb -->
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12 text-right">
            <a href="https://demo.worksuite.biz/admin/contracts/create" class="btn btn-outline btn-success btn-sm">Create Contract <i class="fa fa-plus" aria-hidden="true"></i></a>

            <ol class="breadcrumb">
                <li><a href="https://demo.worksuite.biz/admin/dashboard">Home</a></li>
                <li class="active">Contracts</li>
            </ol>
        </div>
        <!-- /.breadcrumb -->
    </div>

                        <!-- .row -->
                    <div class="row dashboard-stats">
        <div class="col-md-12 m-b-30">
            <div class="white-box">
                <div class="col-sm-4 text-center">
                    <h4><span class="text-dark" id="totalProjects">20</span> <span class="font-12 text-muted m-l-5"> Total Contracts</span></h4>
                </div>
                <div class="col-sm-4 b-l text-center">
                    <h4><span class="text-warning" id="daysPresent">0</span> <span class="font-12 text-muted m-l-5"> About To Expire</span></h4>
                </div>
                <div class="col-sm-4 b-l text-center">
                    <h4><span class="text-danger" id="overdueProjects">0</span> <span class="font-12 text-muted m-l-5"> Expired</span></h4>
                </div>

            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="white-box">

                
                <div class="table-responsive">
                    <table  class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="contracts-table"><thead><tr><th  title="Id">Id</th><th  title="#">#</th><th  title="Subject">Subject</th><th  title="Client">Client</th><th  title="Amount">Amount</th><th  title="Start Date">Start Date</th><th  title="End Date">End Date</th><th  title="Action" width="150">Action</th></tr></thead></table>
                </div>
            </div>
        </div>
    </div>
    <!-- .row -->


                <!-- .right-sidebar -->
<div class="right-sidebar">
    <div class="slimscrollright" id="right-sidebar-content">

    </div>
</div>
<!-- /.right-sidebar -->            </div>
            <!-- /.data section -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->


<div id="footer-sticky-notes" class="row hidden-xs hidden-sm">
    <div class="col-md-12" id="sticky-note-header">
        <div class="col-xs-10" style="line-height: 30px">
        Sticky Notes <a href="javascript:;" onclick="showCreateNoteModal()" class="btn btn-success btn-outline btn-xs m-l-10"><i class="fa fa-plus"></i> Add Note</a>
            </div>
        <div class="col-xs-2">
            <a href="javascript:;" class="btn btn-default btn-circle pull-right" id="open-sticky-bar"><i class="fa fa-chevron-up"></i></a>
            <a style="display: none;" class="btn btn-default btn-circle pull-right" href="javascript:;" id="close-sticky-bar"><i class="fa fa-chevron-down"></i></a>
        </div>

    </div>

    <div id="sticky-note-list" style="display: none">

        
    </div>
</div>

<a href="javascript:;" id="sticky-note-toggle"><i class="icon-note"></i></a>




<div class="modal fade bs-modal-lg in" id="projectTimerModal" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="button" class="btn blue">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            Loading ...
        </div>
    </div>
</div>


<div class="modal fade bs-modal-md in" id="projectTimerModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="button" class="btn blue">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade bs-modal-md in"  id="subTaskModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase" id="subTaskModelHeading">Sub Task e</span>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="button" class="btn blue">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->.
</div>


<!-- jQuery -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="assets/js/bootstrap.min.js"></script>
<script src='assets/js/bootstrap-select.min.js'></script>

<!-- Sidebar menu plugin JavaScript -->
<script src="assets/js/sidebar-nav.min.js"></script>
<!--Slimscroll JavaScript For custom scroll-->
<script src="assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="assets/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/jasny-bootstrap.js"></script>
<script src="assets/js/froiden-helper/helper.js"></script>
<script src="assets/js/jquery.toast.js"></script>


<script src="assets/js/cbpFWTabs.js"></script>
<script src="assets/js/icheck.min.js"></script>
<script src="assets/js/icheck.init.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.magnific-popup-init.js"></script>

<script src="assets/js/pusher.min.js"></script>


<script>

    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    })
    // Hide menu that not have any sub menu
    $(".sub-menu-ul").each(function() {
        if (!$(this).find('li').length) {
            $( this).closest("li").css( "display", "none" );
        }
    });
    
    var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
        isMobile = true;
    }

    $('body').on('click', '.timer-modal', function(){
        var url = 'https://demo.worksuite.biz/admin/all-time-logs/show-active-timer';
        $('#modelHeading').html('Active Timer');
        $.ajaxModal('#projectTimerModal',url);
    });

    $('.datepicker, #start-date, #end-date').on('click', function(e) {
        e.preventDefault();
        $(this).attr("autocomplete", "off");
    });
    var filter =  '1';
    document.addEventListener("keydown", function(event) {
        if (event.keyCode === 190 && (event.altKey && event.shiftKey)) {
            $('.ti-angle-double-right').click();
        }else if (event.keyCode === 84 && (event.altKey && event.shiftKey)) {
            window.location.href = "https://demo.worksuite.biz/admin/task/all-tasks/create"
        }else if(event.keyCode === 80 && (event.altKey && event.shiftKey)) {
            window.location.href = "https://demo.worksuite.biz/admin/projects/create"
        }
        if ((filter)){
             if(event.keyCode === 191 && (event.altKey && event.shiftKey)) {
                if(localStorage.getItem('filter-'+currentUrl) == 'hide'){
                    $('.filter-section-show').click();
                    localStorage.setItem('filter-'+currentUrl, 'show');
                }
                else{
                    $('.filter-section-close').click();
                    localStorage.setItem('filter-'+currentUrl, 'hide');
                }

            }
        }
        
    });
    function addOrEditStickyNote(id)
    {
        var url = '';
        var method = 'POST';
        if(id === undefined || id == "" || id == null) {
            url =  'https://demo.worksuite.biz/admin/sticky-note'
        } else{

            url = "https://demo.worksuite.biz/admin/sticky-note/:id";
            url = url.replace(':id', id);
            var stickyID = $('#stickyID').val();
            method = 'PUT'
        }

        var noteText = $('#notetext').val();
        var stickyColor = $('#stickyColor').val();
        $.easyAjax({
            url: url,
            container: '#responsive-modal',
            type: method,
            data:{'notetext':noteText,'stickyColor':stickyColor,'_token':'nl5UI2sXj3a2EueSG3sZJtlvM9MCEjLbp5AQxC0y'},
            success: function (response) {
                $("#responsive-modal").modal('hide');
                getNoteData();
            }
        })
    }

    // FOR SHOWING FEEDBACK DETAIL IN MODEL
    function showCreateNoteModal(){
        var url = 'https://demo.worksuite.biz/admin/sticky-note/create';

        $("#responsive-modal").removeData('bs.modal').modal({
            remote: url,
            show: true
        });

        $('#responsive-modal').on('hidden.bs.modal', function () {
            $(this).find('.modal-body').html('Loading...');
            $(this).data('bs.modal', null);
        });

        return false;
    }

    // FOR SHOWING FEEDBACK DETAIL IN MODEL
    function showEditNoteModal(id){
        var url = 'https://demo.worksuite.biz/admin/sticky-note/:id/edit';
        url  = url.replace(':id',id);

        $("#responsive-modal").removeData('bs.modal').modal({
            remote: url,
            show: true
        });

        $('#responsive-modal').on('hidden.bs.modal', function () {
            $(this).find('.modal-body').html('Loading...');
            $(this).data('bs.modal', null);
        });

        return false;
    }

    function selectColor(id){
        $('.icolors li.active ').removeClass('active');
        $('#'+id).addClass('active');
        $('#stickyColor').val(id);

    }


    function deleteSticky(id){

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover the deleted Sticky Note",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: true
        }, function(isConfirm){
            if (isConfirm) {

                var url = "https://demo.worksuite.biz/admin/sticky-note/:id";
                url = url.replace(':id', id);

                var token = "nl5UI2sXj3a2EueSG3sZJtlvM9MCEjLbp5AQxC0y";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    data: {'_token': token, '_method': 'DELETE'},
                    success: function (response) {
                        $('#stickyBox_'+id).hide('slow');
                        $("#responsive-modal").modal('hide');
                        getNoteData();
                    }
                });
            }
        });
    }


    //getting all chat data according to user
    function getNoteData(){

        var url = "https://demo.worksuite.biz/admin/sticky-note";

        $.easyAjax({
            type: 'GET',
            url: url,
            messagePosition: '',
            data:  {},
            container: ".noteBox",
            error: function (response) {

                //set notes in box
                $('#sticky-note-list').html(response.responseText);
            }
        });
    }
</script>


<script>
    $('.show-user-notifications').click(function () {
        var openStatus = $(this).attr('aria-expanded');

        if(typeof openStatus == "undefined" || openStatus == "false") {

            var token = 'nl5UI2sXj3a2EueSG3sZJtlvM9MCEjLbp5AQxC0y';
            $.easyAjax({
                type: 'POST',
                url: 'https://demo.worksuite.biz/show-admin-notifications',
                data: {'_token': token},
                success: function (data) {
                    if (data.status == 'success') {
                        $('.mailbox').html(data.html);
                    }
                }
            });

        }

    });

    $('.mailbox').on('click', '.mark-notification-read', function () {
        var token = 'nl5UI2sXj3a2EueSG3sZJtlvM9MCEjLbp5AQxC0y';
        $.easyAjax({
            type: 'POST',
            url: 'https://demo.worksuite.biz/mark-notification-read',
            data: {'_token': token},
            success: function (data) {
                if (data.status == 'success') {
                    $('.top-notifications').remove();
                    $('.top-notification-count').html('0');
                    $('#top-notification-dropdown .notify').remove();
                    $('.notify').remove();
                }
            }
        });

    });

    $('.mailbox').on('click', '.show-all-notifications', function () {
        var url = 'https://demo.worksuite.biz/show-all-member-notifications';
        $('#modelHeading').html('View Unread Notifications');
        $.ajaxModal('#projectTimerModal', url);
    });

    $('.submit-search').click(function () {
        $(this).parent().submit();
    });

    $(function () {
        $('.selectpicker').selectpicker();
    });

    $('.language-switcher').change(function () {
        var lang = $(this).val();
        $.easyAjax({
            url: 'https://demo.worksuite.biz/admin/settings/change-language',
            data: {'lang': lang},
            success: function (data) {
                if (data.status == 'success') {
                    window.location.reload();
                }
            }
        });
    });

//    sticky notes script
    var stickyNoteOpen = $('#open-sticky-bar');
    var stickyNoteClose = $('#close-sticky-bar');
    var stickyNotes = $('#footer-sticky-notes');
    var viewportHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    var stickyNoteHeaderHeight = stickyNotes.height();

    $('#sticky-note-list').css('max-height', viewportHeight-150);

    stickyNoteOpen.click(function () {
        $('#sticky-note-list').toggle(function () {
            $(this).animate({
                height: (viewportHeight-150)
            })
        });
        stickyNoteClose.toggle();
        stickyNoteOpen.toggle();
    })

    stickyNoteClose.click(function () {
        $('#sticky-note-list').toggle(function () {
            $(this).animate({
                height: 0
            })
        });
        stickyNoteOpen.toggle();
        stickyNoteClose.toggle();
    })



    $('body').on('click', '.right-side-toggle', function () {
        $(".right-sidebar").slideDown(50).removeClass("shw-rside");
    })


    function updateOnesignalPlayerId(userId) {
        $.easyAjax({
            url: 'https://demo.worksuite.biz/member/profile/updateOneSignalId',
            type: 'POST',
            data:{'userId':userId, '_token':'nl5UI2sXj3a2EueSG3sZJtlvM9MCEjLbp5AQxC0y'},
            success: function (response) {
            }
        })
    }

    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })

    $('#mobile-filter-toggle').click(function () {
        $('.filter-section').toggle();
    })

    $('#sticky-note-toggle').click(function () {
        $('#footer-sticky-notes').toggle();
        $('#sticky-note-toggle').hide();
    })

    $(document).ready(function () {
        //Side menu active hack
        setTimeout(function(){
            var getActiveMenu = $('#side-menu  li.active li a.active').length;
        // console.log(getActiveMenu);
            if(getActiveMenu > 0) {
                $('#side-menu  li.active li a.active').parent().parent().parent().find('a:first').addClass('active');
            }

         }, 200);

    })

    $('body').on('click', '.toggle-password', function() {
        var $selector = $(this).parent().find('input.form-control');
        $(this).toggleClass("fa-eye fa-eye-slash");
        var $type = $selector.attr("type") === "password" ? "text" : "password";
        $selector.attr("type", $type);
    });

    var currentUrl = 'admin.contracts.index';
    $('body').on('click', '.filter-section-close', function() {
        localStorage.setItem('filter-'+currentUrl, 'hide');

        $('.filter-section').toggle();
        $('.filter-section-show').toggle();
        $('.data-section').toggleClass("col-md-9 col-md-12")
    });

    $('body').on('click', '.filter-section-show', function() {
        localStorage.setItem('filter-'+currentUrl, 'show');

        $('.filter-section-show').toggle();
        $('.data-section').toggleClass("col-md-9 col-md-12")
        $('.filter-section').toggle();
    });

    var currentUrl = 'admin.contracts.index';
    var checkCurrentUrl = localStorage.getItem('filter-'+currentUrl);
    if (checkCurrentUrl == "hide") {
        $('.filter-section-show').show();
        $('.data-section').removeClass("col-md-9")
        $('.data-section').addClass("col-md-12")
        $('.filter-section').hide();
    } else if (checkCurrentUrl == "show") {
        $('.filter-section-show').hide();
        $('.data-section').removeClass("col-md-12")
        $('.data-section').addClass("col-md-9")
        $('.filter-section').show();
    }

    function showTaskDetail (taskId) {
        $(".right-sidebar").slideDown(50).addClass("shw-rside");

        var id = taskId;
        var url = "https://demo.worksuite.biz/admin/task/all-tasks/:id";
        url = url.replace(':id', id);

        $.easyAjax({
            type: 'GET',
            url: url,
            success: function (response) {
                if (response.status == "success") {
                    $('#right-sidebar-content').html(response.view);
                }
            }
        });
    }

</script>


<script src="assets/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="assets/plugin/datatables/dataTables.responsive.min.js"></script>
<script src="assets/plugin/datatables/responsive.bootstrap.min.js"></script>
<script src="assets/plugin/datatables/bootstrap-datepicker.min.js"></script>
    <script src="assets/plugin/datatables/bootstrap-datepicker.en-AU.min.js"></script>
<script src="assets/plugin/datatables/daterangepicker.js"></script>
<script src="assets/plugin/datatables/custom-select.min.js"></script>
<script src="assets/plugin/datatables/bootstrap-select.min.js"></script>
<script src="assets/plugin/datatables/dataTables.buttons.min.js"></script>
<script src="assets/plugin/datatables/buttons.server-side.js"></script>


<script type="text/javascript">$(function(){window.LaravelDataTables=window.LaravelDataTables||{};window.LaravelDataTables["contracts-table"]=$("#contracts-table").DataTable({"serverSide":true,"processing":true,"ajax":{"url":"https:\/\/demo.worksuite.biz\/admin\/contracts","type":"GET","data":function(data) {
            for (var i = 0, len = data.columns.length; i < len; i++) {
                if (!data.columns[i].search.value) delete data.columns[i].search;
                if (data.columns[i].searchable === true) delete data.columns[i].searchable;
                if (data.columns[i].orderable === true) delete data.columns[i].orderable;
                if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
            }
            delete data.search.regex;}},"columns":[{"name":"id","data":"id","visible":false,"title":"Id","orderable":true,"searchable":true},{"name":"DT_RowIndex","data":"DT_RowIndex","orderable":false,"searchable":false,"title":"#"},{"name":"subject","data":"subject","title":"Subject","orderable":true,"searchable":true},{"name":"client.name","data":"client.name","title":"Client","orderable":true,"searchable":true},{"name":"amount","data":"amount","title":"Amount","orderable":true,"searchable":true},{"name":"start_date","data":"start_date","title":"Start Date","orderable":true,"searchable":true},{"name":"end_date","data":"end_date","title":"End Date","orderable":true,"searchable":true},{"data":"action","name":"action","title":"Action","orderable":false,"searchable":false,"width":150,"className":"text-center"}],"dom":"<'row'<'col-md-6'l><'col-md-6'Bf>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>","order":[[0,"desc"]],"destroy":true,"responsive":true,"stateSave":true,"language":{"url":"\/\/cdn.datatables.net\/plug-ins\/1.10.15\/i18n\/English.json"},"buttons":[{"extend":"export","buttons":["excel","csv"],"text":"<i class=\"fa fa-download\"><\/i> Export&nbsp;<span class=\"caret\"><\/span>"}],"initComplete":function () {
                   window.LaravelDataTables["contracts-table"].buttons().container()
                    .appendTo( ".bg-title .text-right")
                },"fnDrawCallback":function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    })
                }});});
</script>

<script>
    $(".select2").select2({
        formatNoMatches: function () {
            return "No record found.";
        }
    });
    $(function() {
        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: 'dd-mm-yyyy',
            language: 'en',
            autoclose: true
        });

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('contract-id');
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover the deleted contract!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel please!",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    var url = "https://demo.worksuite.biz/admin/contracts/:id";
                    url = url.replace(':id', id);

                    var token = "nl5UI2sXj3a2EueSG3sZJtlvM9MCEjLbp5AQxC0y";

                    $.easyAjax({
                        type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                window.LaravelDataTables["contracts-table"].draw();
                            }
                        }
                    });
                }
            });
        });

    });

    $('.toggle-filter').click(function () {
        $('#ticket-filters').toggle('slide');
    })

    $('#apply-filters').click(function () {
        $('#contracts-table').on('preXhr.dt', function (e, settings, data) {
            var startDate = $('#start-date').val();
            if (startDate == '') {
                startDate = null;
            }
            var endDate = $('#end-date').val();
            if (endDate == '') {
                endDate = null;
            }
            var clientID = $('#clientID').val();
            var contractType = $('#contractType').val();
            var status = $('#status').val();
            data['startDate'] = startDate;
            data['endDate'] = endDate;
            data['status'] = status;
            data['clientID'] = clientID;
            data['contractType'] = contractType;
        });
        window.LaravelDataTables["contracts-table"].draw();
    });

    $('#reset-filters').click(function () {
        $('#filter-form')[0].reset();
        $('.select2').val('all');
        $('#filter-form').find('select').select2();
        window.LaravelDataTables["contracts-table"].draw();
    });

    function exportData(){

        var startDate = $('#start-date').val();

        if (startDate == '') {
            startDate = null;
        }

        var endDate = $('#end-date').val();

        if (endDate == '') {
            endDate = null;
        }

        var status = $('#status').val();

        var url = 'https://demo.worksuite.biz/admin/finance/estimates/export/:startDate/:endDate/:status';
        url = url.replace(':startDate', startDate);
        url = url.replace(':endDate', endDate);
        url = url.replace(':status', status);

        window.location.href = url;
    }

</script>
<script>
    // when session expire then it reload user to login page
    var checkDatatable = $.fn.DataTable;
    if(checkDatatable != undefined){
        checkDatatable.ext.errMode = function (settings, tn, msg) {
            console.log(settings, tn, msg);
            if (settings && settings.jqXHR && settings.jqXHR.status == 401) {
                // Handling for 401 specifically
                window.location.reload();
            }
            else{
                alert(msg);
            }
        };
    }
</script>

</body>
</html>
