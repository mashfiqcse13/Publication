
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
            <div class="col-md-12">
                <div class="box  box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Process Steps Details &nbsp; 
                            <?php if ($process_status == 1) { ?>
                                <button class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#modalAddStep" >Add step</button>
                            <?php } ?>
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php
                        if ($process_steps_table != FALSE) {
                            echo $process_steps_table
                            ?>
                            <?php if ($process_status == 1) { ?>
                                <a href="<?php echo site_url('production_process/stop_process/' . $id_processes); ?>" class="btn btn-lg btn-danger btn-block" >Finish This Process</a>
                            <?php } ?>

                            <?php
                        } else {
                            echo 'No steps Found';
                        }
                        ?>
                    </div>
                    <!-- /.box -->
                </div>
            </div>




    </section><!--/.content -->
</div><!--/.content-wrapper -->

<!--insert book -->


<!-- Modal for add step-->
<div class="modal modal-primary fade" id="modalAddStep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add step</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo site_url('production_process/add_step'); ?>" method="post">
                    <input type="hidden" name="id_processes" value="<?php echo $id_processes ?>">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">Vendor Name</label>

                                <div class="col-sm-9">
                                    <?php echo $vendor_dropdown ?>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">Step Name</label>

                                <div class="col-sm-9">
                                    <?php echo $step_name_dropdown ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline">Add step</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal for add step-->


<!-- Modal for add step-->
<div class="modal modal-success fade" id="modalStepToStepTransfer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Transfer</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="<?php echo site_url('production_process/step_transfer/' . $id_processes); ?>" method="post">
                    <input type="hidden" name="id_process_step_from">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="col-sm-6 control-label" for="inputPassword3">Transferring</label>

                                <div class="col-sm-6">
                                    <input type="number" value="0" name="amount_transfered" min="0" id="inputPassword3" class="form-control">
                                </div>
                            </div>

                        </div>
                        <!--                        <div class="col-md-6">
                        
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label" for="inputPassword3">Rejected</label>
                        
                                                        <div class="col-sm-6">
                                                            <input type="number" value="0" name="damaged_amount" min="0" id="inputPassword3" class="form-control">
                                                        </div>
                                                    </div>
                        
                                                </div>
                                                <div class="col-md-6">
                        
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label" for="inputPassword3">Damaged</label>
                        
                                                        <div class="col-sm-6">
                                                            <input type="number" value="0" name="damaged_amount" min="0" id="inputPassword3" class="form-control">
                                                        </div>
                                                    </div>
                        
                                                </div>
                                                <div class="col-md-6">
                        
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label" for="inputPassword3">Missing</label>
                        
                                                        <div class="col-sm-6">
                                                            <input type="number" value="0" name="damaged_amount" min="0" id="inputPassword3" class="form-control">
                                                        </div>
                                                    </div>
                        
                                                </div>-->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="col-sm-6 control-label" for="inputPassword3">Amount Billed</label>

                                <div class="col-sm-6">
                                    <input type="number" value="0" name="amount_billed" min="0" id="inputPassword3" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="col-sm-6 control-label" for="inputPassword3">Amount Paid</label>

                                <div class="col-sm-6">
                                    <input type="number" value="0" name="amount_paid" min="0" id="inputPassword3" class="form-control">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline">Transfer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal for add step-->


<?php include_once __DIR__ . '/../footer.php'; ?>
<script>
    var transferable_amount = 0;
    $('.btnStepToStepTransfer').click(function () {
        var id_process_steps = $(this).data('id_process_steps');
        transferable_amount = $(this).data('transferable_amount');
        console.log(id_process_steps);
        console.log(transferable_amount);
        $('[name="id_process_step_from"]').val(id_process_steps);
    });
</script>