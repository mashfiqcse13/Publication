<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= $Title ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="shortcut icon" type="image/png" href="<?= base_url() ?>/asset/img/<?= $this->config->item('SITE')['logo'] ?>"/>
        <!-- Bootstrap 3.3.4 -->
        <link href="<?php echo $theme_asset_url ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- FontAwesome 4.3.0 -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo $theme_asset_url ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo $theme_asset_url ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo $theme_asset_url ?>plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo $theme_asset_url ?>plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo $theme_asset_url ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo $theme_asset_url ?>plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo $theme_asset_url ?>plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo $theme_asset_url ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $theme_asset_url ?>plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $theme_asset_url ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />




        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="<?php echo $theme_asset_url ?>https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="<?php echo $theme_asset_url ?>https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
        <style type="text/css">
            .select2-container--default .select2-selection--single {
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 0;
                height: 35px;
            }
            .wrapper{
                padding-bottom:50px;
            }
            body {
                text-transform: capitalize;
            } 

            .text-memo-special-formate {
                font-size: 55px;
                text-align: center;
                -ms-transform: rotate(-18deg); /* IE 9 */
                -webkit-transform: rotate(-18deg); /* Safari */
                transform: rotate(-18deg);
                position: relative;
                top: 20px;
                z-index: 0;
            }
            .z-index-top{
                z-index: 9999;
            }

            .form-input-box {
                min-width: 200px;
            }
            #test{visibility: hidden;}

            .margin-10{margin:0 10px;}
            .margin-top-10{margin-top:10px;}
            .form-horizontal .control-label {
                text-align: left;
            }
            
            
            #table_custom .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th:first-child {
                max-width: 240px;
            }
            .upper{text-transform: uppercase;}
            .dropdown-width{width:200px}
            .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {

                border: 1px solid #ddd;
            }
            .text-right-for-money tr > td:nth-child(3) {
                text-align: right;
            }
            .text-right-for-money tr > td:nth-child(4) {
                text-align: right;
            }
            .text-right-for-money tr > td:nth-child(5) {
                text-align: right;
            }
            .move-tk-to-right-for-soldbook tr > td:nth-child(2) {
                text-align: right;
            }
            .right-text-for-account tr>td{
                text-align:right;
            }
            .right-text-for-account tr>td:first-child{
                text-align:left;
            }
            .right-text-for-account th.success:first-child {
                text-align: left;
            }
            .right-text-for-account th.success {
                text-align: right;
            }
            .report-logo-for-print{
                display: none;
            }
            .bDiv tr td:nth-child(1)>.text-left {
                float: left;
            }
            .bDiv tr td:nth-child(2)>.text-left {
                float: left;
            }
            .bDiv tr td .text-left {
                text-align: right;
            }

            .position_top{
                position: relative;
                z-index: 999;
            }
            
            #table_custom .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {

                line-height: 1!important;
                padding:5px 4px!important;
                vertical-align: top;
            }
            @media (max-width:960px){
                .input-group {
                    width: 100%;
                }
            }


        </style>

        <?php
// echo "<pre>";
// print_r($asset);
// echo "</pre>";
        if (isset($glosary))
            foreach ($glosary->css_files as $file):
                ?>
                <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />

            <?php endforeach; ?>


        <style type='text/css'>
            body
            {
                font-family: Arial;
                font-size: 14px;
            }
            a {
                color: blue;
                text-decoration: none;
                font-size: 14px;
            }
            a:hover
            {
                text-decoration: underline;
            }
            
            /*pringint page style*/
            
            .print_page_wrapper{
                background:#fff;width:630px;margin:0 auto;min-height:800px;box-shadow:0px -1px 8px #000;padding:0px ;
            }
            .custom_memo{
                background:#fff;width:585px;min-height:793px;padding:0px 40px;margin-top:0px;margin:0px auto;font-size:12px!important;margin-bottom:50px;
            }
            .padding10{
                padding-top:20px;
                padding-bottom:20px;
            }
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
                padding:5px;
                line-height: 1;
            }
            footer.main-footer {
                left: 0!important;
                position: fixed;
                bottom: 0;
                width: 100%;
                margin-left: 0px;
                text-align: center;
            }
            aside.main-sidebar.only_print {
                z-index: 999;
            }
            @media print{
                .only_print{display: none;}
                .memo_print_option{margin:0 auto;width:100%;}
                #print { visibility: hidden;}
                #test{visibility: visible;}

                .report-logo-for-print{
                    display: block;
                }
                aside.main-sidebar.only_print {
                    display:none;
                }
                .table>tbody>tr>td{padding-bottom: 9px}
                footer.main-footer {
                    display:none;
                }
                .page_break_after{page-break-after: always;}

                #table_custom .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                    border: 1px solid #222!important;
                }
                .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {

                    border:1px solid #222!important;
                }
                body table,body tr,body td,body th,body tbody,body thead,.table,.table-bordered {
                    border: 1px solid #222!important;
                }
                body .table-bordered{
                    border:1px solid #222!important;
                }
                .top_margin_remover{
                    margin-top: 0px!important;
                }

                body table,body tr,body th,body td,body tbody,body thead{
                    border:1px solid #222!important;
                }
                .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
                    padding: 5px;
                    line-height: 1;
                }
                .flexigrid div.bDiv tr:hover td, .flexigrid div.bDiv tr:hover td.sorted, .flexigrid div.bDiv tr.trOver td.sorted, .flexigrid div.bDiv tr.trOver td {

                    border-left: 0px solid #222!important;
                    border-bottom: 0px solid #222!important;
                }

                .flexigrid div.bDiv tr:hover td, .flexigrid div.bDiv tr:hover td.sorted, .flexigrid div.bDiv tr.trOver td.sorted, .flexigrid div.bDiv tr.trOver td {
                    border:0px solid #222!important;
                }
                .flexigrid tr,.flexigrid td{
                    border: 0px!important;
                }
                .flexigrid div.bDiv td div {
                    border:0px solid #222!important;
                    width: 100%; 
                }
                .flexigrid td,.flexigrid th{
                    border:1px solid #222!important;
                }
                .flexigrid tr td {
                    border: 1px solid #222!important;
                }
                .page_break{page-break-after: always;}
                
                .print_small_font th,.print_small_font td{
                    font-size:11px!important;
                    padding:5px!important;
                }
                


            }
            
            @page {       
                margin: 30mm 20mm 15mm 20mm;  
                size: A4;
            }
            
  
            
            @media only screen and (max-width:600px){
                .flexigrid div.form-div input[type=text]{
                    width: 100%!important;
                }
                .flexigrid div.form-div textarea {
                    width: 100%!important;
                    margin: 0 auto;
                }
                div#address_input_box {
                    width: 100%!important;
                }
                
                table.cke_editor {
                    zoom: 70%;
                }
            }

            

        </style>

    </head>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo base_url() ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Admin</b> Panel</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- hide this section for display -->
                    <noscript>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success"></span>
                                </a>


                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo $theme_asset_url ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                                                    </div>
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li><!-- end message -->
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo $theme_asset_url ?>dist/img/user3-128x128.jpg" class="img-circle" alt="User Image" />
                                                    </div>
                                                    <h4>
                                                        AdminLTE Design Team
                                                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo $theme_asset_url ?>dist/img/user4-128x128.jpg" class="img-circle" alt="User Image" />
                                                    </div>
                                                    <h4>
                                                        Developers
                                                        <small><i class="fa fa-clock-o"></i> Today</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo $theme_asset_url ?>dist/img/user3-128x128.jpg" class="img-circle" alt="User Image" />
                                                    </div>
                                                    <h4>
                                                        Sales Department
                                                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <img src="<?php echo $theme_asset_url ?>dist/img/user4-128x128.jpg" class="img-circle" alt="User Image" />
                                                    </div>
                                                    <h4>
                                                        Reviewers
                                                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                    </h4>
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>

                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-users text-red"></i> 5 new members joined
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-user text-red"></i> You changed your username
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- Tasks: style can be found in dropdown.less -->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">9</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Create a nice theme
                                                        <small class="pull-right">40%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">40% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Some task I need to do
                                                        <small class="pull-right">60%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">60% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                            <li><!-- Task item -->
                                                <a href="#">
                                                    <h3>
                                                        Make beautiful transitions
                                                        <small class="pull-right">80%</small>
                                                    </h3>
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">80% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li><!-- end task item -->
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all tasks</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo $theme_asset_url ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image" />
                                    <span class="hidden-xs">Alexander Pierce</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?php echo $theme_asset_url ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                                        <p>
                                            Alexander Pierce - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Followers</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <?php echo anchor('login/logout', 'Sign Out', 'class="btn btn-default btn-flat"'); ?>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                    </noscript>
                    <!--  -->
                </nav>
            </header>
