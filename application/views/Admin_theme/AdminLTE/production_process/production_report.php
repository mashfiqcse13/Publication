
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

                <div class="box">
                    <div class="box-header">
                        <?php
                        $attributes = array(
                            'class' => 'form-horizontal',
                            'method' => 'get',
                            'name' => 'form');
                        echo form_open('', $attributes)
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="col-md-3">Search with Date Range:</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                        </div><!-- /.input group -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="col-md-3">Process Type:</label>
                                    <div class="col-md-9">
                                        <select name="id_process_type" id="" class="form-control select2">
                                            <option value="">Select Process Type</option>
                                            <?php
//                                            print_r($get_all_production_process);exit();
                                            foreach ($get_process_type as $item) {
                                                ?>
                                                <option value="<?php echo $item->id_process_type; ?>"><?php echo $item->name_process_type; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="col-md-3">Order ID:</label>
                                    <div class="col-md-9">
                                        <select name="id_processes" id="" class="form-control select2">
                                            <option value="">Select Order ID</option>
                                            <?php
//                                            print_r($get_all_production_process);exit();
                                            foreach ($get_order_id as $item) {
                                                ?>
                                                <option value="<?php echo $item->id_processes; ?>"><?php echo $item->id_processes; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Vendor From:</label>
                                    <div class="col-md-9">
                                        <select name="from_id_vendor" id="" class="form-control select2">
                                            <option value="">Select Vendor From</option>
                                            <?php
//                                            print_r($get_all_production_process);exit();
                                            foreach ($get_vendor_from as $item) {
                                                ?>
                                                <option value="<?php echo $item->from_id_vendor; ?>"><?php echo $item->from_id_vendor . ' - ' . $item->from_name . '(' . $item->from_type . ')'; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="col-md-3">Item Name:</label>
                                    <div class="col-md-9">
                                        <select name="id_item" id="" class="form-control select2">
                                            <option value="">Select Item Name</option>
                                            <?php
//                                            print_r($get_all_production_process);exit();
                                            foreach ($get_item as $item) {
                                                ?>
                                                <option value="<?php echo $item->id_item; ?>"><?php echo $item->id_item . ' - ' . $item->item_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Vendor To:</label>
                                    <div class="col-md-9">
                                        <select name="to_id_vendor" id="" class="form-control select2">
                                            <option value="">Select Vendor To</option>
                                            <?php
//                                            print_r($get_all_production_process);exit();
                                            foreach ($get_vendor_to as $item) {
                                                ?>
                                                <option value="<?php echo $item->to_id_vendor; ?>"><?php echo $item->to_id_vendor . ' - ' . $item->to_name . '(' . $item->to_type . ')'; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="submit" name="btn"  value="Search Information" class="btn btn-success" style="margin: 10px 0 ;"/>
                        <?= anchor(current_url() . '', 'Refresh', ' class="btn btn-primary"') ?>
                        <?= form_close(); ?>       
                    </div>

                    <div class="box-body" style="overflow: auto;">
                        <?php
                        if (!isset($get_process_details_for_report_by_search)) {
                            ?>
                            <table class="table teble-bordered table-hover data">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Process Type</th>
                                        <th>Item Name</th>
                                        <th>Vendor From</th>
                                        <th>Step ID From</th>
                                        <th>Vendor To</th>
                                        <th>Step ID To</th>
                                        <th>Transferred Amount</th>
                                        <th>Amount Billed</th>
                                        <th>Amount Paid</th>
                                        <th>Amount Reject</th>
                                        <th>Amount Damage</th>
                                        <th>Amount Missing</th>
                                        <th>Transfer Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //print_r($get_all_production_process);
                                    foreach ($get_all_production_process as $process_details) {
                                        ?>
                                        <tr>
                                            <td><?php echo $process_details->id_processes; ?></td>
                                            <td><?php echo $process_details->name_process_type; ?></td>
                                            <td><?php echo $process_details->item_name; ?></td>
                                            <td><?php echo $process_details->from_name . '(' . $process_details->from_type . ')'; ?></td>
                                            <td><?php echo $process_details->id_process_step_from; ?></td>
                                            <td><?php echo $process_details->to_name . '(' . $process_details->to_type . ')'; ?></td>
                                            <td><?php echo $process_details->id_process_step_to; ?></td>
                                            <td ><?php echo $process_details->amount_transfered; ?></td>
                                            <td ><?php echo $process_details->amount_billed; ?></td>
                                            <td ><?php echo $process_details->amount_paid; ?></td>
                                            <td ><?php echo $process_details->amount_rejected; ?></td>
                                            <td ><?php echo $process_details->amount_damaged; ?></td>
                                            <td ><?php echo $process_details->amount_missing; ?></td>
                                            <td><?php echo $process_details->date_transfered; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }if (isset($get_process_details_for_report_by_search)) {
                            ?>
                            <div id="block">
                                <div class="box-header">
                                    <p class="text-center"><strong>Process Report</strong></p>
                                    <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>

                                    <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                    <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                                </div>
                                <table  class ="table table-bordered table-hover" style="background: #fff;">
                                    <thead style="background: #DFF0D8;">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Process Type</th>
                                            <th>Item Name</th>
                                            <th>Vendor From</th>
                                            <th>Step ID From</th>
                                            <th>Vendor To</th>
                                            <th>Step ID To</th>
                                            <th>Transferred Amount</th>
                                            <th>Amount Billed</th>
                                            <th>Amount Paid</th>                                            
                                            <th>Amount Reject</th>
                                            <th>Amount Damage</th>
                                            <th>Amount Missing</th>
                                            <th>Transfer Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sum_total_amount_transfered = 0;
                                        $sum_total_amount_billed = 0;
                                        $sum_total_amount_paid = 0;
                                        $sum_total_rejected = 0;
                                        $sum_total_damaged = 0;
                                        $sum_total_missing = 0;
                                        foreach ($get_process_details_for_report_by_search as $process_details) {
                                            $sum_total_amount_transfered += $process_details->amount_transfered;
                                            $sum_total_amount_billed += $process_details->amount_billed;
                                            $sum_total_amount_paid += $process_details->amount_paid;
                                            $sum_total_rejected+=$process_details->amount_rejected;
                                            $sum_total_damaged+=$process_details->amount_damaged;
                                            $sum_total_missing+=$process_details->amount_missing;
                                            ?>
                                            <tr>
                                                <td><?php echo $process_details->id_processes; ?></td>
                                                <td><?php echo $process_details->name_process_type; ?></td>
                                                <td><?php echo $process_details->item_name; ?></td>
                                                <td><?php echo $process_details->from_name . '(' . $process_details->from_type . ')'; ?></td>
                                                <td><?php echo $process_details->id_process_step_from; ?></td>
                                                <td><?php echo $process_details->to_name . '(' . $process_details->to_type . ')'; ?></td>
                                                <td><?php echo $process_details->id_process_step_to; ?></td>
                                                <td><?php echo $process_details->amount_transfered; ?></td>
                                                <td ><?php echo $process_details->amount_billed; ?></td>
                                                <td><?php echo $process_details->amount_paid; ?></td>
                                                <td ><?php echo $process_details->amount_rejected; ?></td>
                                                <td ><?php echo $process_details->amount_damaged; ?></td>
                                                <td ><?php echo $process_details->amount_missing; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($process_details->date_transfered)); ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        <tr style="font-weight: bold">
                                            <td>Total :</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td ><?php echo $sum_total_amount_transfered; ?></td>
                                            <td ><?php echo $sum_total_amount_billed; ?></td>
                                            <td ><?php echo $sum_total_amount_paid; ?></td>
                                            <td ><?php echo $sum_total_rejected; ?></td>
                                            <td ><?php echo $sum_total_damaged; ?></td>
                                            <td ><?php echo $sum_total_missing; ?></td>
                                            <td></td>


                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                        ?>

                    </div>
                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
    $('.data').DataTable({
        bFilter: false,
        order: [[0, "desc"]]
    });
</script>
