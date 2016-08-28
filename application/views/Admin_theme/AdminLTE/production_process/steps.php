
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
                            <?php if ($process_steps_table == FALSE) { ?>
                                <button class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#modalAddStep" >Add step</button>
                            <?php } ?>
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php
                        if ($process_steps_table != FALSE) {
                            echo $process_steps_table;
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
                    <input type="hidden" name="id_process_step_from">
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
                <form class="form-horizontal" id="transfer_form" action="<?php echo site_url('production_process/step_transfer/' . $id_processes); ?>" method="post">
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
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="col-sm-6 control-label" for="inputPassword3">Rejected</label>

                                <div class="col-sm-6">
                                    <input type="number" value="0" name="rejected_amount" min="0" id="inputPassword3" class="form-control">
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
                                    <input type="number" value="0" name="missing_amount" min="0" id="inputPassword3" class="form-control">
                                </div>
                            </div>

                        </div>
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
                    <script>var vendor_dropdown_used_only_list = <?php echo json_encode($vendor_dropdown_used_only_list); ?>;</script>
                    <div class="row" id="id_process_step_to_box">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-3 control-label">Vendor Name</label>

                                <div class="col-sm-9" id="vendor_dropdown_used_only_list">
                                </div>
                            </div>
                            <h4 style="text-align: center">--------------- OR --------------------</h4>
                        </div>
                    </div>
                    <div class="row" id="add_step_box">
                        <div class="col-md-12">

                            <h4>Create a new step</h4>
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
    var amount_transfered = 0;
    var rejected_amount = 0;
    var damaged_amount = 0;
    var missing_amount = 0;

    function string_to_int(input_field_value) {
        var integer_val = parseInt(input_field_value);
        return (isNaN(integer_val)) ? 0 : integer_val;
    }
    $('.btnStepToStepTransfer').click(function () {
        var id_process_steps = $(this).data('id_process_steps');
        transferable_amount = string_to_int($(this).data('transferable_amount'));
        console.log(id_process_steps);
        console.log(transferable_amount);
        $('[name="id_process_step_from"]').val(id_process_steps);
        if ($(this).html() == "Final Transfer") {
            $('#add_step_box').hide();
            $('#id_process_step_to_box').hide();
            $('#modalStepToStepTransfer .modal-title').html("Finsih this process by inputing last transfer details");
            $('#modalStepToStepTransfer [type="submit"]').html("Transfer to the final stock");
            $('#modalStepToStepTransfer').removeClass('modal-success');
            $('#modalStepToStepTransfer').addClass('modal-danger');
        } else {
            $('#add_step_box').show();
            $('#modalStepToStepTransfer .modal-title').html("Transfer");
            $('#modalStepToStepTransfer [type="submit"]').html("Transfer");
            $('#modalStepToStepTransfer').removeClass('modal-danger');
            $('#modalStepToStepTransfer').addClass('modal-success');
            if (vendor_dropdown_used_only_list[id_process_steps] != null) {
                $('#id_process_step_to_box').show();
                $('#vendor_dropdown_used_only_list').html(vendor_dropdown_used_only_list[id_process_steps]);
                $(".select2").select2({
                    'width': '100%'
                });
            } else {
                $('#id_process_step_to_box').hide();
            }
        }
    });

    $('.btnAddStepFromStep').click(function () {
        var id_process_steps = $(this).data('id_process_steps');
        console.log(id_process_steps);
        $('[name="id_process_step_from"]').val(id_process_steps);
    });

    $('input[type="number"]').change(function () {
        amount_transfered = string_to_int($('[name="amount_transfered"]').val());
        rejected_amount = string_to_int($('[name="rejected_amount"]').val());
        damaged_amount = string_to_int($('[name="damaged_amount"]').val());
        missing_amount = string_to_int($('[name="missing_amount"]').val());
        console.log(amount_transfered);
        console.log(rejected_amount);
        console.log(damaged_amount);
        console.log(missing_amount);
    });
    $('#transfer_form').submit(function () {
        var selected_amount = (amount_transfered + rejected_amount + damaged_amount + missing_amount);
        if (transferable_amount < selected_amount) {
            alert('Transferable amount must be greater than Selectable amount . \n Tranferable amount : ' + transferable_amount + "\n Selected Total Amount : " + selected_amount);
            return false;
        }
        if (selected_amount < 1) {
            alert("Selectable amount must greater than 0 .\n  Selected Total Amount : " + selected_amount);
            return false;
        }
    });
</script>
<style>
    .box-body {
                overflow-x: scroll;
            }
    </style>