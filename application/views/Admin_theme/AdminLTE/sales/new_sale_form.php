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
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Select customer</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-8">
                                <label for="id_contact">By name</label>
                                <?php echo $customer_dropdown ?>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="int_id_contact">By ID</label>
                                <input type="number" class="form-control" id="int_id_contact" placeholder="Password">
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Payment info</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="duscount_percentage">Sub total :</label>
                                <input type="email" name="duscount_percentage" class="form-control" id="duscount_percentage" placeholder="Enter email">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="duscount_percentage">Duscount percentage :</label>
                                <div class="input-group">
                                    <input type="email" name="duscount_percentage" class="form-control" id="duscount_percentage" placeholder="Enter email">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="discount_amount">Discount amount :</label>
                                <div class="input-group">
                                    <input type="number" name="discount_amount" class="form-control" id="discount_amount" placeholder="Password">
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="duscount_percentage">Total amount :</label>
                                <div class="input-group">
                                    <input type="number" name="discount_amount" class="form-control" id="discount_amount" placeholder="Password">
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="discount_amount">Cash payment :</label>
                                <div class="input-group">
                                    <input type="number" name="discount_amount" class="form-control" id="discount_amount" placeholder="Password">
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="discount_amount">Bank payment :</label>
                                <div class="input-group">
                                    <input type="number" name="discount_amount" class="form-control" id="discount_amount" placeholder="Password">
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Item Selection</h3>
                    </div>
                    <div class="box-body">Nice to meet you</div>
                </div>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->
<script type="text/javascript">
    $(document).ready(function () {
        $(".select2").select2();
    });
</script>



<?php include_once __DIR__ . '/../footer.php'; ?>
