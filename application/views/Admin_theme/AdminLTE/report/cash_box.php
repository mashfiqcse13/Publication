<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $Title ?>
            <small> <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Salary section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php echo $cash->total_in; ?> TK</h3>
                        <p>Total Cash In</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo $cash->total_out; ?> TK</h3>
                        <p>Total Cash Out</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $cash->balance; ?> TK</h3>
                        <p>Cash In Hand</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $today_sales; ?> TK</h3>
                        <p>Today Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $today_due; ?> TK</h3>
                        <p>Today Total Due</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $today_cash; ?> TK</h3>
                        <p>Today Total Cash Payment</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $today_bank; ?> TK</h3>
                        <p>Today Total Bank Payment</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php echo $advance_payment_balance; ?> TK</h3>
                        <p>Party Total Advance Payment</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-pricetag-outline"></i>
                    </div>
                    <a class="small-box-footer" href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>