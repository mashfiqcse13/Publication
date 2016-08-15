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
            <div class="col-md-8">

                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Memo haveing due for <strong>"<?php echo $customer_name; ?>"</strong></h3>
                    </div>
                    <div class="box-body first_table">
                        <?php
                        echo $due_detail_table;
                        ?>
                        

                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Due Payment Amount (Cash Only )</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open(); ?>
                        <div class="input-group input-group-lg">
                            <input type="number" class="form-control" name="amount" value="0" min='1' max="<?php echo $customer_total_due; ?>">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat">Pay</button>
                            </span>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        
        
        <?php if(isset($due_report_list)){ ?>
        <div class="row">
                        <div class="box col-md-12" id="block">             
                    <div class="box-header">
                        
                        <p class="text-center"> Due Payment Report</p>                        
                          <div style="margin-bottom: 60px;">
                           
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                        </div>
                        <div style="color: #777777;"> 
                            
                            <p class="pull-right">Report Date: <?php echo date('Y-m-d H:i:s', now()); ?></p>
                            <table class="table table-bordered">
                            <tr>
                                <td>Customer Name: </td>
                                <td><?php echo $customer_name; ?></td>
                                <td>Customer Code</td>
                                <td><?php echo $customer_code; ?></td>
                                   
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="box-body">
                        
                        
                        <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                            <tr>
                                <th>Memo No:</th>
                                
                                <th>Payment Method</th>
                                <th>Payment Date</th>
                                <th>Paid Amount</th>
                            </tr>
                           
                                <?php 
                                $total_amount=0;
                                foreach($due_report_list as $row) { 
                                $total_amount+=$row->paid_amount;
                                ?>
                                <tr>
                                    <td><?=$row->id_total_sales;?></td>
                                    <td><?=$row->name_payment_method;?></td>
                                    <td><?=$row->payment_date;?></td>
                                    <td class="text-right taka_formate">TK <?=$row->paid_amount;?></td>
                                
                                 </tr>
                                <?php } ?> 
                           
                            
                            <tr>
                                <td colspan="3" class="text-center">Total Paid Amount = </td>
                                <td class="text-right taka_formate">TK <?=$total_amount;?></td>
                            </tr>
                        </table>
            </div>
        </div>
        <?php } ?>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>
<script>
    $('.first_table .table tbody').append('<tr style="border-top: 3px solid #d5d5d5;"><td colspan="6" class="text-center">Total Due =</td><td><?php echo $customer_total_due ?></td></tr>');
</script>