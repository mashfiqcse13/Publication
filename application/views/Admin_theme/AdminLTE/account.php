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
            <small>manage <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="thumbnail">
                        <div class="row">

                            <div class="col-md-6">
                                <h2 class="alert alert-success"><strong>Today sell :  <?= $account_today['todaysell'] ?></strong> <span style="font-size:11px;">after subtract discount & book return</span></h2>

                            </div>
                            <div class="col-md-6">
                                <h2 class="alert alert-info"><strong>Monthly sell : <?= $account_monthly['monthlysell'] ?></strong> <span style="font-size:11px;">after subtract discount & book return</span></h2>

                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <h2 class="alert alert-danger"><strong>Today due :  <?= $account_today['today_due'] ?></strong></h2><br>
                            </div>
                            <div class="col-md-6">
                                <h2 class="alert alert-danger"><strong>Monthly due : <?= $account_monthly['monthly_due'] ?></strong></h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

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