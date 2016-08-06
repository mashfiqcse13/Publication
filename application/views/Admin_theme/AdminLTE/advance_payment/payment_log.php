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
            <li class="active"><?php echo $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box only_print">
                    <div class="box-body">
                        <form class="fo" action="<?= $base_url ?>index.php/advance_payment/payment_log" method="get">
                            <div class="form-group col-md-4 text-left">

                                <label>Search By Party Id or Name:</label>
                                <?php echo $customer_dropdown; ?>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Search by payment method:</label>

                                <input type="text" name="payment_method" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right"  title="This is not a date"/>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group col-md-3">
                                <label>Search with Date Range:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            <?php echo anchor(site_url('advance_payment/payment_log'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                        </form>

                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <?php
                    echo $glosary->output;
                    ?>

                </div>

            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>