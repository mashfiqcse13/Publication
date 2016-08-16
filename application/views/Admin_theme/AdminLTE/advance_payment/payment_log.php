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
    <section class="content" style="min-height: 1100px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box only_print">
                    <div class="box-body">
                        <form class="fo" action="<?= $base_url ?>index.php/advance_payment/payment_log" method="get">
                            <div class="form-group col-md-5 text-left">

                                <label>Search By Party Id or Name:</label>
                                <?php echo $customer_dropdown; ?>
                            </div>
<!--                            <div class="form-group col-md-3">
                                <label>Search by payment method:</label>

                                <?php // echo $method_dropdown; ?>
                                 /.input group 
                            </div>-->
                            <div class="form-group col-md-5">
                                <label>Search with Date Range:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                            <div class="form-group col-md-2" style="margin-top: 25px;">
                                <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                <?php echo anchor(site_url('advance_payment/payment_log'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                            </div>
                        </form>

                    </div>
                </div>


            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="box" id="block">
                    <?php
                    if (!isset($search_report)) {
                        ?>
                        <div class="box-body">
                            <?php
                            echo $glosary->output;
                            ?>
                        </div><!-- /.box-body -->
                        <?php
                    }if (isset($search_report)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>Advance Payment Log Report</strong></p>
                            <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
    <!--                                        <th></th>-->
                                        <th>Transection Id</th>
                                        <th>Customer Name</th>
                                        <th>Payment Method</th>
                                        <th>Amount Paid</th>
                                        <th>Date Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum_total_paid = 0;
                                    foreach ($search_report as $sales) {
                                        $sum_total_paid += $sales->amount_paid;
                                        ?>
                                        <tr>
                                            <td><?php echo $sales->id_party_advance_payment_register; ?></td>
                                            <td><?php echo $sales->name; ?></td>
                                            <td><?php echo $sales->name_payment_method; ?></td>
                                            <td><?php echo 'TK ' . $sales->amount_paid; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($sales->date_payment)); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr style="font-weight: bold">
                                        <td>Total :</td>
                                        <td></td>
                                        <td></td>
                                        <td><?php echo 'TK ' . $sum_total_paid; ?></td>
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
<script type="text/javascript">
    $('#reservation').datepicker();
</script>