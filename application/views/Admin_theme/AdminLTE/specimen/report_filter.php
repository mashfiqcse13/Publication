
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
            <li class="active"><?=$Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report Generation Filter</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post">
                        <div class="box-body"><div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="col-md-3  control-label">Agent/Marketing Officer Name</label>
                                    <div class="col-sm-9">
                                        <?php echo $agent_dropdown ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-3  control-label" for="exampleInputEmail1">Item Name</label>
                                    <div class="col-sm-9">
                                        <?php echo $item_dropdown ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="col-md-3 control-label">Date Range</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="date_range" value="" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="report_asked" value="true">
                                <div class="form-group col-md-3 pull-right">
                                    <button type="submit" class="btn btn-primary" name="get_report" value="all">Generate Report</button> 
                                    <a href="<?php echo site_url('specimen/report') ?>" class="btn btn-success">Reset filter</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box -->

                <!-- Form Element sizes -->

                <!-- /.box -->


                <!-- /.box -->

                <!-- Input addon -->

                <!-- /.box -->

            </div>

        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>