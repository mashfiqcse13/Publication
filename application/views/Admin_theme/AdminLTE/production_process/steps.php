
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
            <li class="active">Customer section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box  box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Production Process Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php echo $process_detail_table ?>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <?php if ($process_steps_table != FALSE) { ?>
                <div class="col-md-12">
                    <div class="box  box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Process Steps Details</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php echo $process_steps_table ?>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
                <?php
            }
            if ($remaining_order > 0) {
                ?>
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add step</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" action="<?php echo site_url('production_process/add_step/' . $id_processes); ?>" method="post">

                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Vendor Name</label>

                                            <div class="col-sm-9">
                                                <?php echo $vendor_dropdown ?>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-6 control-label">Transfered</label>

                                            <div class="col-sm-6">
                                                <input type="number" value="<?php echo $remaining_order ?>" name="transfered_amount" min="0" max="<?php echo $remaining_order ?>" class="form-control" id="inputPassword3">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label class="col-sm-6 control-label" for="inputPassword3">Rejected</label>

                                            <div class="col-sm-6">
                                                <input type="number" value="0" name="reject_amount" min="0" max="<?php echo $remaining_order ?>" id="inputPassword3" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label class="col-sm-6 control-label" for="inputPassword3">Damaged</label>

                                            <div class="col-sm-6">
                                                <input type="number" value="0" name="damaged_amount" min="0" max="<?php echo $remaining_order ?>" id="inputPassword3" class="form-control">
                                            </div>
                                        </div>

                                    </div><div class="col-md-3">

                                        <div class="form-group">
                                            <label class="col-sm-6 control-label" for="inputPassword3">Missing</label>

                                            <div class="col-sm-6">
                                                <input type="number" value="0" name="missing_amount" min="0" max="<?php echo $remaining_order ?>" id="inputPassword3" class="form-control">
                                            </div>
                                        </div>

                                    </div><div class="col-md-3">

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-6 control-label">Amount billed</label>

                                            <div class="col-sm-6">
                                                <input type="number" value="0" name="amount_billed" min="0" max="<?php echo $remaining_order ?>" class="form-control" id="inputPassword3">
                                            </div>
                                        </div>

                                    </div><div class="col-md-3">

                                        <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-6 control-label">Amount paid</label>

                                            <div class="col-sm-6">
                                                <input type="number" value="0" name="amount_paid" min="0" max="<?php echo $remaining_order ?>" class="form-control" id="inputPassword3">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right">Add step</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            <?php } ?>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>