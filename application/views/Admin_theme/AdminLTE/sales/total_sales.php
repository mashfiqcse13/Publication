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
    <section class="content" style="min-height: 1100px;">-
        <div class="row">
            <div class="col-md-12">

                <div class="box only_print">
                    <div class="box-body">
                        <form action="<?= $base_url ?>index.php/sales/tolal_sales" method="get">
                            <div class="row">
                                <div class="form-group col-md-3 text-left">

                                    <label>Search By District:</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <?php echo $district_dropdown; ?>
                                </div><!-- /.form group -->
                                <div class="form-group col-md-3 text-left">

                                    <label>Search By Party Id or Name:</label>
                                </div>
                                <div class="form-group col-md-3">

                                    <?php echo $customer_dropdown; ?>


                                </div><!-- /.form group -->

                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 text-left">
                                    <label>Search with Date Range:</label>
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->
                                <div class="col-md-2">
                                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    <?php echo anchor(site_url('sales/tolal_sales'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                                </div>
                            </div>
                        </form>

                    </div>
                    <?php
                    if (!isset($date_range)) {
                        ?>
                        <div class="box-body">
                            <?php
                            $attributes = array(
                                'clase' => 'form-inline',
                                'method' => 'post');
                            echo form_open(site_url('sales/memo_report'), $attributes)
                            //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                            ?>

                            <div class="row">
                                <div class="form-group col-md-3 text-left">

                                    <label>Search By Memo:</label>
                                </div>
                                <div class="form-group col-md-3">

                                    <?php echo $memo_list; ?>


                                </div><!-- /.form group -->
                                <div class="col-md-2">
                                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    <?= anchor(site_url('sales/tolal_sales'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                                </div>

                            </div>

                            <?= form_close(); ?>
                            <?php ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="box" id="block">
                    <?php
                    if (!isset($date_range)) {
                        ?>
                        <div class="box-header">
                            <h3 class="box-title">Sales Dashboard</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <?php
                            echo $glosary->output;
                            ?>
                        </div><!-- /.box-body -->
                        <?php
                    }
                    if (!empty($this->input->get('btn_submit'))) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>Total Sales Report</strong></p>
                            <table style="margin: 0 auto">
                                <?php
                                if (!empty($this->input->get('filter_district'))) {
                                    echo '<tr><td><strong>District Name </strong><td> &nbsp; : &nbsp; </td><td> ' . $this->input->get('filter_district') . '</td></tr>';
                                }
                                ?>
                            </table>
                            <?php
                            if (!empty($date_range)) {
                                echo '<p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> ' . $date_range . '</p>';
                            }
                            ?>

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                        <div class="box-body" style="overflow: auto;">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
    <!--                                        <th></th>-->
                                        <th>Memo No</th>
                                        <th>Customer Name</th>
                                        <th>Sub Total</th>
                                        <th>Discount Amount</th>
                                        <th>Total Amount</th>
                                        <th>Cash Paid</th>
                                        <th>Bank Paid</th>
                                        <th>Advance Deduction</th>
                                        <th>Total Paid</th>
                                        <th>Total Due</th>
                                        <th>Packeting Cost On Due</th>
                                        <th>Accurate Due</th>
                                        <th>Slip Expense</th>
                                        <th>Issue Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum_sub_total = 0;
                                    $sum_total_amount = 0;
                                    $sum_discount_amount = 0;
                                    $sum_cash_paid = 0;
                                    $sum_bank_paid = 0;
                                    $sum_customer_advance_paid = 0;
                                    $sum_total_paid = 0;
                                    $sum_total_due = 0;
                                    $sum_bill_for_packeting = 0;
                                    $sum_slip_expense_amount = 0;
                                    foreach ($total_sales as $sales) {
                                        $sum_sub_total += $sales->sub_total;
                                        $sum_total_amount += $sales->total_amount;
                                        $sum_discount_amount += $sales->discount_amount;
                                        $sum_cash_paid += $sales->cash_paid;
                                        $sum_bank_paid += $sales->bank_paid;
                                        $sum_customer_advance_paid += $sales->customer_advance_paid;
                                        $sum_total_paid += $sales->total_paid;
                                        $sum_total_due += $sales->total_due;
                                        $sum_bill_for_packeting += $sales->bill_for_packeting;
                                        $sum_slip_expense_amount += $sales->slip_expense_amount;
                                        ?>
                                        <tr>
                                            <td><?php echo $sales->id_total_sales; ?></td>
                                            <td><?php echo $sales->name; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->sub_total; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->discount_amount; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->total_amount; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->cash_paid; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->bank_paid; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->customer_advance_paid; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->total_paid; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->total_due; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->bill_for_packeting; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->bill_for_packeting + $sales->total_due; ?></td>
                                            <td class="text-right faka_formate"><?php echo $sales->slip_expense_amount; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($sales->issue_date)); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr style="font-weight: bold">
                                        <td colspan="2">Total :</td>
                                        <td class="text-right faka_formate"><?php echo $sum_sub_total; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_discount_amount; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_total_amount; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_cash_paid; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_bank_paid; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_customer_advance_paid; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_total_paid; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_total_due; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_bill_for_packeting; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_bill_for_packeting + $sum_total_due; ?></td>
                                        <td class="text-right faka_formate"><?php echo $sum_slip_expense_amount; ?></td>
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
