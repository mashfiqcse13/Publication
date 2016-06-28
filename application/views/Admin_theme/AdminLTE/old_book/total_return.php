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
                        <div class="form-group col-md-3 text-left">
                            <label>Search with Date Range:</label>
                        </div>
                        <form action="<?= $base_url ?>index.php/sales/tolal_sales" method="get">
                            <div class="form-group col-md-7">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            <?php echo anchor(site_url('stock/stock_perpetual'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                        </form>

                    </div>
                </div>

                <div class="box" id="block">
                    <?php
                    if (!isset($date_range)) {
                        ?>
                        <div class="box-header">
                            <h3 class="box-title">Old Book Return</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <?php
                            echo $glosary->output;
                            ?>
                        </div><!-- /.box-body -->
                        <?php
                    }if (isset($date_range)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>Old Book Report</strong></p>
                            <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Sub Total</th>
                                        <th>Total Amount</th>
                                        <th>Discount Percentage</th>
                                        <th>Discount Amount</th>
                                        <th>Cash</th>
                                        <th>Bank Pay</th>
                                        <th>Total Paid</th>
                                        <th>Total Due</th>
                                        <th>Issue Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum_sub_total = 0;
                                    $sum_total_amount = 0;
                                    $sum_discount_amount = 0;
                                    $sum_cash = 0;
                                    $sum_bank_pay = 0;
                                    $sum_total_paid = 0;
                                    $sum_total_due = 0;
                                    foreach ($total_sales as $sales) {
                                        $sum_sub_total += $sales->sub_total;
                                        $sum_total_amount += $sales->total_amount;
                                        $sum_discount_amount += $sales->discount_amount;
                                        $sum_cash += $sales->cash;
                                        $sum_bank_pay += $sales->bank_pay;
                                        $sum_total_paid += $sales->total_paid;
                                        $sum_total_due += $sales->total_due;
                                        ?>
                                        <tr>
                                            <td><?php echo $sales->name; ?></td>
                                            <td><?php echo $sales->sub_total; ?></td>
                                            <td><?php echo $sales->total_amount; ?></td>
                                            <td><?php echo $sales->discount_percentage; ?></td>
                                            <td><?php echo $sales->discount_amount; ?></td>
                                            <td><?php echo $sales->cash; ?></td>
                                            <td><?php echo $sales->bank_pay; ?></td>
                                            <td><?php echo $sales->total_paid; ?></td>
                                            <td><?php echo $sales->total_due; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($sales->issue_date)); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr style="font-weight: bold">
                                        <td>Total :</td>
                                        <td><?php echo $sum_sub_total; ?></td>
                                        <td><?php echo $sum_total_amount; ?></td>
                                        <td></td>
                                        <td><?php echo $sum_discount_amount; ?></td>
                                        <td><?php echo $sum_cash; ?></td>
                                        <td><?php echo $sum_bank_pay; ?></td>
                                        <td><?php echo $sum_total_paid; ?></td>
                                        <td><?php echo $sum_total_due; ?></td>
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




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
