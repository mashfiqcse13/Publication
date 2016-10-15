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
            <li class="active">Final Report</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-body">
                        <?php
                        $attributes = array(
                            'clase' => 'form-inline',
                            'method' => 'get');
                        echo form_open('', $attributes)
                        //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                        ?>

                        <div class="form-group col-md-4 text-left">

                            <label>Search Report With Date Range:</label>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" required="true" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                <br>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->

                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <?= anchor(current_url() . '/income', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                        <?= form_close(); ?>
                        <?php ?> 
                    </div>
                </div>
                <?php
                if (isset($date_range)) {
                    ?>
                    <div class="box" id="block">
                        <div class="box-body">
                            <h3 class="text-center">Final Account's Report</h3>
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <h5><?php echo $this->Common->date_range_formater_for_report($date_range); ?></h5>

                            <br>
                            <h3 class="text-center">Sale Info</h3>
                            <table  class="table table-bordered report">

                                <tbody>
                                    <tr>
                                        <td width="50%">Total Sale</td>
                                        <th class="taka_formate"><?php echo $total_sale; ?></th>  
                                        <th></th>                            
                                    </tr>
                                    <tr>
                                        <td width="50%">Sale Against Cash Collection</td>
                                        <th></th>                            
                                        <th class="taka_formate"><?php echo $total_sale_against_cash_collection; ?></th>
                                    </tr>
                                    <tr>
                                        <td width="50%">Sale Against Bank Collection</td>
                                        <th></th>                            
                                        <th class="taka_formate"><?php echo $total_sale_against_bank_collection; ?></th>
                                    </tr>
                                    <tr>
                                        <td width="50%">Sale Against Advance Deduction</td>
                                        <th></th>                            
                                        <th class="taka_formate"><?php echo $total_sale_against_advance_deduction; ?></th>
                                    </tr>
                                    <tr>                     
                                        <td width="50%">Sale Against Due Collection</td>
                                        <th></th>                            
                                        <th class="taka_formate"><?php echo $total_sale_against_due_collection; ?></th>
                                    </tr>
                                    <tr style="border-top: 2px solid black">
                                        <td width="50%" class="text-center">Total :</td>
                                        <th class="taka_formate"><?php echo $total_sale; ?></th>                            
                                        <th class="taka_formate"><?php
                                            $total_sale_collection = $total_sale_against_cash_collection + $total_sale_against_bank_collection + $total_sale_against_advance_deduction + $total_sale_against_due_collection;

                                            echo $total_sale_collection;
                                            ?></th>
                                    </tr>
                                </tbody>
                            </table>

                            <h3 class="text-center">Due collection</h3>
                            <table class="table table-bordered report">
                                <tbody>
                                    <tr>
                                        <td width="50%"></td>
                                        <td>Cash</td>
                                        <td>Bank</td>
                                        <td>Total</td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Previous Due collection</td>
                                        <th class="taka_formate"><?php echo $previous_due_collection_cash; ?></th>
                                        <th class="taka_formate"><?php echo $previous_due_collection_bank; ?></th>
                                        <th class="taka_formate"><?php echo $previous_due_collection; ?></th>
                                    </tr>
                                    <tr>
                                        <td width="50%">Total Due Collection (Previous due + Sale against due)</td>
                                        <th class="taka_formate"><?php echo $total_due_collection_cash; ?></th>
                                        <th class="taka_formate"><?php echo $total_due_collection_bank; ?></th>
                                        <th class="taka_formate"><?php echo $total_due_collection; ?></th>
                                    </tr>
                                </tbody>
                            </table>
                            <h3 class="text-center">Advance collection</h3>
                            <table class="table table-bordered report">
                                <tbody>
                                    <tr>
                                        <td width="50%"></td>
                                        <td>Cash</td>
                                        <td>Bank</td>
                                        <td>Total</td>
                                    </tr>
                                    <tr>
                                        <td width="50%">Total Advance Collection ( Without returned book value )</td>
                                        <th class="taka_formate"><?php echo $total_advance_collection_without_book_sale_cash; ?></th>
                                        <th class="taka_formate"><?php echo $total_advance_collection_without_book_sale_bank; ?></th>
                                        <th class="taka_formate"><?php echo $total_advance_collection_without_book_sale; ?></th>
                                    </tr>
                                </tbody>
                            </table>

                            <h3 class="text-center">Collections</h3>
                            <table class="table table-bordered report page_break_after">
                                <tr>
                                    <td width="50%">Total Cash Collection (General payment + Advance Payment)</td>
                                    <th class="taka_formate"><?php echo "$total_cash_collection_from_customer_payment + $total_cash_collection_from_advance_payment = $total_cash_collection"; ?></th>
                                </tr>
                                <tr>
                                    <td width="50%">Total Bank Collection (General payment + Advance Payment)</td>
                                    <th class="taka_formate"><?php echo "$total_bank_collection_from_customer_payment + $total_bank_collection_from_advance_payment = $total_bank_collection"; ?></th>
                                </tr>
                            </table>


                            <h3 class="text-center">Master Reconcilation</h3>
                            <table class="table table-bordered report">
                                <tr>
                                    <td width="50%">Total Cash Collection</td>
                                    <th class="taka_formate"><?php echo ($total_cash_2_bank_trasfer + $total_cash_2_expense_adjustment + $closing->ending_cash - $opening->opening_cash); ?></th>
                                    <th></th>                            
                                </tr>
                                <tr>
                                    <td width="50%">Total Bank Collection</td>
                                    <th class="taka_formate"><?php echo ($total_bank_withdraw + $closing->closing_bank_balance - $opening->opening_bank_balance); ?></th>
                                    <th></th>                            
                                </tr>
                                <tr>
                                    <td width="50%">Total Expense</td>
                                    <th></th>                            
                                    <th class="taka_formate"><?php echo $total_expence; ?></th>
                                </tr>
                                <tr>
                                    <td width="50%">Total Collection</td>
                                    <th class="taka_formate"><?php echo $total_collection_cash_bank; ?></th>
                                    <th class="taka_formate"><?php echo $total_expence; ?></th>
                                </tr>
                            </table>
                            <div style="overflow: auto">
                                <table class="table table-bordered new table-hover" style="margin-top: 10px;">

                                    <tr>
                                        <td width="34%"></td>
                                        <td width="33%" style="text-align: center">Opening (TK)</td>
                                        <td width="33%" style="text-align: center">Closing (TK)</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left">Cash:</td>
                                        <th class="taka_formate" style="text-align: center"><?php echo $opening->opening_cash; ?></th>
                                        <th class="taka_formate" style="text-align: center"><?php echo $closing->ending_cash; ?></th>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left">Bank:</td>
                                        <th class="taka_formate" style="text-align: center"><?php echo $opening->opening_bank_balance; ?></th>
                                        <th class="taka_formate" style="text-align: center"><?php echo $closing->closing_bank_balance; ?></th>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left">Due:</td>
                                        <th class="taka_formate" style="text-align: center"><?php echo $opening->opening_due; ?></th>
                                        <th class="taka_formate" style="text-align: center"><?php echo $closing->ending_due; ?></th>
                                    </tr>

                                </table>
                            </div>

                            <table class="table table-bordered report" style="margin-top: 10px;">
                                <tr>
                                    <td width="50%">Total Cash to Bank Transfer</td>
                                    <th class="taka_formate"><?php echo $total_cash_2_bank_trasfer; ?></th>
                                </tr>
                                <tr>
                                    <td width="50%">Total Cash to Expense Adjustment</td>
                                    <th class="taka_formate"><?php echo $total_cash_2_expense_adjustment; ?></th>
                                </tr>
                                <tr>
                                    <td width="50%">Total Bank Withdraw</td>
                                    <th class="taka_formate"><?php echo $total_bank_withdraw; ?></th>
                                </tr>
                            </table>
                            <br>
                            <strong>Notes :</strong>
                            <ol>
                                <li>Total expense adjustment amount should not be greater than total expense amount</li>
                                <li>Total Cash Collection = ( Closing Cash - Opening Cash ) + Total Cash to Bank Transfer + Total Cash to Expense Adjustment</li>
                                <li>Total Bank Collection = ( Closing Bank - Opening Bank ) + Total Bank Withdraw</li>
                            </ol>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
<style type="text/css">
    .report thead tr th{
        padding: 20px 0!important;
        background: #5A99D4;
    }
    .report tbody tr th,tabel tbody tr td{
        min-width: 50%!important;
    }
    .report tbody tr:nth-child(odd), th table tbody tr:nth-child(odd) td{
        background: #DEECF9;
    }
    .new th{
        min-width: 100px!important;
        text-align: center;
        background: #fff!important;

    }
    .table_title{text-align: center; margin-top: 20px}
    @media print{
        .table_title{text-align: center; margin-top: 20px}
    }
    @media only print{
        #page_break_after{page-break-after: always;color: red}
    }
</style>