<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper only_print">
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


                <div class="box" id="block" style="width:585px;margin:0 auto;"> 
                    <?php
                    if (isset($first_step_report)) {
                        foreach ($first_step_report as $row) {
                            ?>
                            <div class="box-header">
                                <h2 class="text-center">Report on Production Process step</h2>
                                <h4 class="text-center text-bold">( Entry Stage )</h4>

                                <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                <div class="pull-right" id="test">Report Date: <?php echo date('d-M-Y', now()); ?></div>
                            </div>
                            <div class="box-body">
                                <table  class ="table table-bordered table-hover" style="background: #fff;">                                
                                    <tbody>
                                        <tr>
                                            <td>Order Id</td>
                                            <td colspan="5" ><?= $row->id_process_steps; ?></td>
                                        </tr>
                                    <td>Process Type</td>
                                    <td colspan="5" ><?= $row->name_process_type; ?></td>

                                    <tr>
                                        <td>From</td>
                                        <td colspan="5" >Authority</td>
                                    </tr>

                                    <tr>
                                        <td>To</td>
                                        <td colspan="5" ><?= $row->vendor_name; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Book Name</td>
                                        <td colspan="5" ><?php
                                            $item_name = ($row->item_type == 2) ? $row->item_name . " (Cover)" : $row->item_name;
                                            echo $item_name;
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td colspan="5" ><?= $row->date_created; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-center text-bold">Amount Info</td>
                                    </tr>
                                    <tr>
                                        <th>Order Amount</th>
                                        <th>Transfered</th>
                                        <th>Rejected</th>
                                        <th>Damaged</th>
                                        <th>Missing</th>


                                    </tr>
                                    <tr>
                                        <td class="taka_formate"><?= $row->order_amount; ?></td>
                                        <td class="taka_formate"><?= $row->transfered_amount; ?></td>
                                        <td class="taka_formate"><?= $row->reject_amount; ?></td>
                                        <td class="taka_formate"><?= $row->damaged_amount; ?></td>
                                        <td class="taka_formate"><?= $row->missing_amount; ?></td>

                                    </tr>



                                    </tbody>
                                </table><br>
                                <?php echo anchor('production_process/steps/' . $row->id_processes, "Go To Process Details Page", array('class' => "only_print btn btn-primary")); ?>

                            </div>
                            <?php
                        }
                    } elseif ($transfer_step) {
                        foreach ($transfer_step as $row) {
                            ?>
                            <div class="box-header">
                                <h2 class="text-center">Report on Production Process step</h2>


                                <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                <div class="pull-right" id="test">Report Date: <?php echo date('d-M-Y', now()); ?></div>
                            </div>
                            <div class="box-body">
                                <table  class ="table table-bordered table-hover" style="background: #fff;">                                
                                    <tbody>
                                        <tr>
                                            <td>Order Id</td>
                                            <td colspan="5" ><?= $row->id_processes; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Step Id</td>
                                            <td colspan="5" ><?= $row->id_process_step_transfer_log; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Process Type</td>
                                            <td colspan="5" ><?= $row->name_process_type; ?></td>
                                        </tr>

                                        <tr>
                                            <td>From</td>
                                            <td colspan="5" ><?= $row->from_name; ?> <strong>(<?= $row->from_type; ?> )</strong> </td>
                                        </tr>

                                        <tr>
                                            <td>To</td>
                                            <td colspan="5" ><?= $row->to_name; ?><strong> ( <?= $row->to_type; ?> )</strong> </td>
                                        </tr>
                                        <tr>
                                            <td>Book Name</td>
                                            <td colspan="5" ><?php
                                                $item_name = ($row->item_type == 2) ? $row->item_name . " (Cover)" : $row->item_name;
                                                echo $item_name;
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td colspan="5" ><?= $row->date_transfered; ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-center text-bold">Amount Info</td>
                                        </tr>
                                        <tr>
                                            <th class="col-md-4">Amount Transfered</th>
                                            <th class="col-md-4">Amount Billed</th>
                                            <th class="col-md-4">Amount Paid</th>
                                            <th class="col-md-4">Amount Reject</th>
                                            <th class="col-md-4">Amount Damaged</th>
                                            <th class="col-md-4">Amount Missing</th>



                                        </tr>
                                        <tr>
                                            <td class="taka_formate"><?= $row->amount_transfered; ?></td>
                                            <td class="taka_formate"><?= $row->amount_billed; ?></td>
                                            <td class="taka_formate"><?= $row->amount_paid; ?></td>
                                            <td class="taka_formate"><?= $row->amount_rejected; ?></td>
                                            <td class="taka_formate"><?= $row->amount_damaged; ?></td>
                                            <td class="taka_formate"><?= $row->amount_missing; ?></td>


                                        </tr>



                                    </tbody>
                                </table><br>
                                <?php echo anchor('production_process/steps/' . $row->id_processes, "Go To Process Details Page", array('class' => "only_print btn btn-primary")); ?>

                            </div>
                            <?php
                        }
                    }
                    ?>

                </div>
            </div>





    </section><!-- /.content -->
</div><!-- /.content-wrapper -->



<?php include_once __DIR__ . '/../footer.php'; ?>