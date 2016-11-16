
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
    <section class="content" style="min-height: 1300px;">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header">
                        <?php
                        $attributes = array(
                            'clase' => 'form',
                            'method' => 'get');
                        echo form_open('', $attributes)
                        ?>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Party Name or Code</label>
                                </div>
                                
                                <div class="form-group">
                                     <?=$customer_dropdown;?>
<!--                                <select class="form-control select2" style="width:100%;"  name="customer">
                                    <option value="">Select Party Name Or Code</option>
                                    <?php
                                    foreach ($customers as $customer) {
                                        ?>
                                        <option value="<?php echo $customer->id_customer; ?>"><?php echo $customer->id_customer . ' - ' . $customer->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>-->
                            </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                </div>
                                <div class="form-group">
                                <select class="form-control select2" name="payment_method">
                                    <option value="">Select Payment Method</option>
                                    <option value="1">Cash</option>
                                    <option value="2">Advance Payment</option>
                                    <option value="3">Bank</option>
                                    <option value="4">Old Book Sale</option>
                                </select>
                            </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date Range:</label>
                                </div>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                             
                            <div class="col-md-3" style="margin-top:40px" >
                                <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            <?= anchor(current_url(), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                            </div>
                        </div> 
                        </form>
                    </div>
                </div>
                <div class="box"  id="block">

                    <?php
                    if (isset($get_customer_payment_info)) {
                        ?>
                        <div class = "box-header">
                            <p class = "text-center"><strong>Payment Log Report</strong></p>
                            <p class = "pull-left" style = "margin-left:0px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                    <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
        <!--                                        <th></th>-->
                                        <th>Customer Name</th>
                                        <th>Memo No</th>
                                        <th>Payment_method</th>
                                        <th>Amount</th>
                                        <th>Due Payment</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum_total_amount = 0;
                                    $sum_total_due = 0;
                                    foreach ($get_customer_payment_info as $rep) {
                                        $sum_total_amount += $rep->paid_amount;
                                        $sum_total_due += $rep->tatal_paid_amount;
                                        ?>
                                        <tr>
                                            <td><?php echo $rep->name; ?></td>
                                            <td><?php echo $rep->id_total_sales; ?></td>
                                            <td><?php
                                                if ($rep->id_payment_method == 1) {
                                                    echo 'Cash';
                                                } elseif ($rep->id_payment_method == 2) {
                                                    echo 'Advance Payment';
                                                } elseif ($rep->id_payment_method == 3) {
                                                    echo 'Bank';
                                                }elseif ($rep->id_payment_method == 4) {
                                                    echo 'Old Book Sale';
                                                }
                                                ?></td>
                                            <td class="taka_formate text-right"><?php echo 'TK ' . $rep->paid_amount; ?></td>
                                            <td class="taka_formate text-right"><?php echo 'TK ' . $rep->tatal_paid_amount; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($rep->date)); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr style="font-weight: bold">
                                        <td>Total :</td>
                                        <td></td>
                                        <td></td>
                                        <td class="taka_formate text-right"><?php echo 'TK ' . $sum_total_amount; ?></td>
                                        <td class="taka_formate text-right"><?php echo 'TK ' . $sum_total_due; ?></td>
                                        <td></td>


                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <?php
                    }if (!isset($get_customer_payment_info)) {
                        echo $glosary->output;
                    }
                    ?>

                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>