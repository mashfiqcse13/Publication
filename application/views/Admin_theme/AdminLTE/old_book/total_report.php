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


                        <form action="" method="post">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group col-md-3 text-left">
                                        <label>Search with Date Range:</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="date_range" value="" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                        </div> 
                                    </div>
                                    <div class="col-md-3"> 
                                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        <?php echo anchor(site_url('old_book/total_report'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                                    </div>


                                </div>

                            </div>

                        </form>

                    </div>
                </div>

                <div class="box" id="block" style="min-height:900px">
                    <?php
                    if (isset($report)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>Old Book Total Report</strong></p>


                            <?php
                            if (!empty($date_range)) {
                                echo '<p class="pull-left" style="margin-left:20px"> ' . $this->Common->date_range_formater_for_report($date_range) . "</p>";
                            }
                            ?>


                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d-M-Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Item Id</th>
                                        <th>Book Name</th>
                                        <th>Opening</th>
                                        <th>Received Amount</th>
                                        <th>Send to Rebind</th>
                                        <th>Sale Amount</th>
                                        <th>Remaining</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum_opening = 0;
                                    $sum_received_amount = 0;
                                    $sum_send_to_rebind = 0;
                                    $sum_sale_amount = 0;
                                    $sum_remaining = 0;

                                    foreach ($report as $item) {
                                        $sum_opening += $item->opening;
                                        $sum_received_amount += $item->received_amount;
                                        $sum_send_to_rebind += $item->send_to_rebind;
                                        $sum_sale_amount += $item->sale_amount;
                                        $sum_remaining += $item->remaining;
                                        ?>
                                        <tr>
                                            <td><?php echo $item->id_item ?></td>
                                            <td><?php echo $item->name ?></td>
                                            <td><?php echo $item->opening ?></td>
                                            <td><?php echo $item->received_amount ?></td>
                                            <td><?php echo $item->send_to_rebind ?></td>
                                            <td><?php echo $item->sale_amount ?></td>
                                            <td><?php echo $item->remaining ?></td>
                                        </tr>


                                        <?php
                                    }
                                    ?>
                                    <tr style="font-weight: bold"> 

                                        <td colspan="2" class="text-right">Total : </td>
                                            <td><?php echo $sum_opening ?></td>
                                            <td><?php echo $sum_received_amount ?></td>
                                            <td><?php echo $sum_send_to_rebind ?></td>
                                            <td><?php echo $sum_sale_amount ?></td>
                                            <td><?php echo $sum_remaining ?></td>

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




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
