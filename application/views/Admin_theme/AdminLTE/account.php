<!--add header -->

<?php include_once 'header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $Title ?>
            <small>Manage <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?= $account_today['todaysell'] ?> Tk</h3>
                        <p><strong>Today sell </strong><br>after subtract discount and book return</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><strong><?= $account_monthly['monthlysell'] ?> Tk</strong> </h3>
                        <p><strong>Monthly sell </strong><br>after subtract discount and book return</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><strong><?= $account_today['today_due'] ?> Tk</strong></h3>
                        <p><strong>Today due</strong><br></p>

                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><strong><?= $account_monthly['monthly_due'] ?> Tk</strong></h3>
                        <p><strong>Monthly due</strong><br></p>

                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="row">
                        <br>
                        <div class="col-md-8">
                            <div class="" style="opacity:.8;">
                                <h2 class="content-header"><strong>Payment Information</strong></h2>

                                <table class="table table-striped">
                                    <tr>
                                        <td>Total Cash Paid:</td>
                                        <td><?= $total['total_cash_paid'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Bank Pay:</td>
                                        <td><?= $total['total_bank_pay'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total Due:</td>
                                        <td><?= $total['total_due'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Sale:<strong></td>
                                                    <td><?= $total['total_sell'] ?></td>
                                                    </tr>
                                                    </table>

                                                    </div>
                                                    </div>

                                                    </div>



                                                    </div>

                                                    </div>
                                                    </div>




                                                    </section><!-- /.content -->
                                                    </div><!-- /.content-wrapper -->

                                                    <!-- insert book -->



                                                    <?php include_once 'footer.php'; ?>