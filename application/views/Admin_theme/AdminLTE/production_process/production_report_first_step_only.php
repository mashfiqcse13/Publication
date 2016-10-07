
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
                                <!--Search with Date Range-->
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
                                <!--Process Type-->
                                <div class="form-group ">
                                    <label class="col-md-3">Process Type:</label>
                                    <div class="col-md-9">
                                        <select name="id_process_type" id="" class="form-control select2">
                                            <option value="">Select Process Type</option>
                                            <?php
//                                            print_r($all_production_process_first_step_info);exit();
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
                                <!--Order ID-->
                                <div class="form-group ">
                                    <label class="col-md-3">Order ID:</label>
                                    <div class="col-md-9">
                                        <select name="id_processes" id="" class="form-control select2">
                                            <option value="">Select Order ID</option>
                                            <?php
//                                            print_r($all_production_process_first_step_info);exit();
                                            foreach ($get_order_id as $item) {
                                                ?>
                                                <option value="<?php echo $item->id_processes; ?>"><?php echo $item->id_processes; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!--Vendor Name-->
                                <div class="form-group ">
                                    <label class="col-md-3">Vendor Name:</label>
                                    <div class="col-md-9">
                                        <select name="id_vendor" id="" class="form-control select2">
                                            <option value="">Select Vendor From</option>
                                            <?php
//                                            print_r($all_production_process_first_step_info);exit();
                                            foreach ($get_vendor as $item) {
                                                ?>
                                                <option value="<?php echo $item->id_vendor; ?>"><?php echo $item->id_vendor . " - " . $item->vendor_name . ' - ' . $item->vendor_type; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--Item type-->
                                <div class="form-group ">
                                    <label class="col-md-3">Item type:</label>
                                    <div class="col-md-9">
                                        <select name="item_type" id="" class="form-control select2">
                                            <option value="">Select Item type</option>
                                            <option value="1">Book</option>
                                            <option value="2">Cover</option>
                                        </select>
                                    </div>
                                </div>
                                <!--Item Name-->
                                <div class="form-group ">
                                    <label class="col-md-3">Item Name:</label>
                                    <div class="col-md-9">
                                        <select name="id_item" id="" class="form-control select2">
                                            <option value="">Select Item Name</option>
                                            <?php
                                            foreach ($get_item as $item) {
                                                ?>
                                                <option value="<?php echo $item->id_item; ?>"><?php echo $item->id_item . ' - ' . $item->item_name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="submit" name="btn"  value="Search Information" class="btn btn-success" style="margin: 10px 0 ;"/>
                    <?= anchor(current_url() . '', 'Refresh', ' class="btn btn-primary"') ?>
                    <?= form_close(); ?>       
                </div>

                <div class="box"  style="overflow: auto;">
                    <?php
                    if (!isset($all_production_process_first_step_info_by_search)) {
                        ?>
                        <table class="table teble-bordered table-hover data">
                            <thead>
                                <tr>
                                    <th>Step ID</th>
                                    <th>Order ID</th>
                                    <th>Process Type</th>
                                    <th>Item Name</th>
                                    <th>Vendor Name</th>
                                    <th>Order Amount</th>
                                    <th>Transferred</th>
                                    <th>Rejected</th>
                                    <th>Damaged</th>
                                    <th>Missing</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($all_production_process_first_step_info as $first_step_details) {
                                    ?>
                                    <tr>
                                        <td><?php echo $first_step_details->id_process_steps; ?></td>
                                        <td><?php echo $first_step_details->id_processes; ?></td>
                                        <td><?php echo $first_step_details->name_process_type; ?></td>
                                        <td><?php
                                            $item_name = ($first_step_details->item_type == 2) ? $first_step_details->item_name . " (Cover)" : $first_step_details->item_name;
                                            echo $item_name;
                                            ?></td>
                                        <td><?php echo $first_step_details->vendor_name . '(' . $first_step_details->vendor_type . ')'; ?></td>
                                        <td><?php echo $first_step_details->order_amount; ?></td>
                                        <td><?php echo $first_step_details->transfered_amount; ?></td>
                                        <td><?php echo $first_step_details->reject_amount; ?></td>
                                        <td><?php echo $first_step_details->damaged_amount; ?></td>
                                        <td><?php echo $first_step_details->missing_amount; ?></td>
                                        <td><?php echo $first_step_details->date_created; ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    }if (isset($all_production_process_first_step_info_by_search)) {
                        ?>
                        <div id="block">
                            <div class="box-header">
                                <p class="text-center"><strong>Production Process Report</strong></p>
                                <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>

                                <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                            </div>
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Step ID</th>
                                        <th>Order ID</th>
                                        <th>Process Type</th>
                                        <th>Item Name</th>
                                        <th>Vendor Name</th>
                                        <th>Order Amount</th>
                                        <th>Transferred</th>
                                        <th>Rejected</th>
                                        <th>Damaged</th>
                                        <th>Missing</th>
                                        <th>Date Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($all_production_process_first_step_info_by_search as $first_step_details) {
                                        ?>
                                        <tr>
                                            <td><?php echo $first_step_details->id_process_steps; ?></td>
                                            <td><?php echo $first_step_details->id_processes; ?></td>
                                            <td><?php echo $first_step_details->name_process_type; ?></td>
                                            <td><?php
                                                $item_name = ($first_step_details->item_type == 2) ? $first_step_details->item_name . " (Cover)" : $first_step_details->item_name;
                                                echo $item_name;
                                                ?></td>
                                            <td><?php echo $first_step_details->vendor_name . '(' . $first_step_details->vendor_type . ')'; ?></td>
                                            <td><?php echo $first_step_details->order_amount; ?></td>
                                            <td><?php echo $first_step_details->transfered_amount; ?></td>
                                            <td><?php echo $first_step_details->reject_amount; ?></td>
                                            <td><?php echo $first_step_details->damaged_amount; ?></td>
                                            <td><?php echo $first_step_details->missing_amount; ?></td>
                                            <td><?php echo $first_step_details->date_created; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>

        </div>
    </section>
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
