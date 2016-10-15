
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

                <?php
                if (isset($get_process_details_for_report_by_step_from)) {
                    ?>
                    <div class="box" id="block">
                        <div class="box-header">
                            <p class="text-center"><strong>Process Transection Report</strong></p>
                            <!--<p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php // echo $date_range;                             ?></p>-->

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d-M-Y', now()); ?></div>



                            <table class="table table-bordered table-striped" style="font-size:13px">

                                <tr>
                                    <td><strong>Order ID:</strong></td>
                                    <td><?php echo $get_process_details_for_row->id_processes; ?></td>
                                    <td><strong>Process Type:</strong></td>
                                    <td><?php echo $get_process_details_for_row->name_process_type; ?></td>
                                </tr>

                                <tr>
                                    <td><strong>Vendor From:</strong></td>
                                    <td><?php echo $get_process_details_for_row->from_name . " ( " . $get_process_details_for_row->from_type . " )"; ?></td>
                                    <td><strong>Item Name:</strong></td>
                                    <td><?php
                                        $item_name = ($get_process_details_for_row->item_type == 2) ? $get_process_details_for_row->item_name . " (Cover)" : $get_process_details_for_row->item_name;
                                        echo $item_name;
                                        ?></td>
                                </tr>

                            </table>
                        </div>
                        <div class="box-body">

                            <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Vendor To</th>
                                        <th class="text-right">Amount Transfer</th>
                                        <th class="text-right">Amount Billed</th>
                                        <th class="text-right">Amount Paid</th>
                                        <th class="text-right">Reject</th>
                                        <th class="text-right">Damage</th>
                                        <th class="text-right">Missing</th>
                                        <th>Date Transfer</th>
                                    </tr>
                                </thead>
                                <?php
                                $sum_total_amount_transfered = 0;
                                $sum_total_amount_billed = 0;
                                $sum_total_amount_paid = 0;
                                $sum_total_amount_rejected = 0;
                                $sum_total_amount_damaged = 0;
                                $sum_total_amount_missing = 0;
                                foreach ($get_process_details_for_report_by_step_from as $step_info) {
                                    $sum_total_amount_transfered += $step_info->amount_transfered;
                                    $sum_total_amount_billed += $step_info->amount_billed;
                                    $sum_total_amount_paid += $step_info->amount_paid;
                                    $sum_total_amount_rejected += $step_info->amount_rejected;
                                    $sum_total_amount_damaged += $step_info->amount_damaged;
                                    $sum_total_amount_missing += $step_info->amount_missing;
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $step_info->to_name . " ( " . $step_info->to_type . " )"; ?></td>
                                            <td class="text-right taka_formate"><?php echo $step_info->amount_transfered; ?></td>
                                            <td class="text-right taka_formate"><?php echo $step_info->amount_billed; ?></td>
                                            <td class="text-right taka_formate"><?php echo $step_info->amount_paid; ?></td>
                                            <td class="text-right taka_formate"><?php echo $step_info->amount_rejected; ?></td>
                                            <td class="text-right taka_formate"><?php echo $step_info->amount_damaged; ?></td>
                                            <td class="text-right taka_formate"><?php echo $step_info->amount_missing; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($step_info->date_transfered)); ?></td>
                                        </tr>
                                    </tbody>
                                    <?php
                                }
                                ?>
                                <tr style="font-weight: bold">
                                    <td>Total :</td>
                                    <td class="text-right taka_formate"><?php echo $sum_total_amount_transfered; ?></td>
                                    <td class="text-right taka_formate"><?php echo $sum_total_amount_billed; ?></td>
                                    <td class="text-right taka_formate"><?php echo $sum_total_amount_paid; ?></td>
                                    <td class="text-right taka_formate"><?php echo $sum_total_amount_rejected; ?></td>
                                    <td class="text-right taka_formate"><?php echo $sum_total_amount_damaged; ?></td>
                                    <td class="text-right taka_formate"><?php echo $sum_total_amount_missing; ?></td>
                                    <td></td>


                                </tr>
                            </table>

                        </div>
                    </div>
                    <?php
                }
                echo anchor('production_process/steps/' . $get_process_details_for_row->id_processes, "Go To Process Details Page", array('class' => "btn btn-primary"));
                ?>
            </div>
        </div>
</div>




</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>