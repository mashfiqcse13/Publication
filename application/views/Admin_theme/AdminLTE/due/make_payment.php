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
            <div class="col-md-7">

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
            <div class="col-md-5">
                <div class="box box-success">
                    
                    <div class="box-body">
                        <?php echo form_open(); ?>
                        <div class="box-header with-border">
                                <h3 class="box-title text-center text-bold">Due Payment Amount (Bank )</h3>
                                <p class="btn btn-info bank_add">Bank Pay</p>
                        </div>
                        <div class="bank_hide">
                        <p><strong>Note :</strong> If you use this form , this balance will be added to the account balance automatically as an approved transaction .</p>
                                          
                            <div class="form-group" style="padding: 15px">
                                    <label for="bank_account" class="col-sm-4 control-label">Receiving Account</label>
                                    <div class="col-sm-8">
                                        <?php echo $bank_account_dropdown ?>
                                    </div>
                                </div>
                                <div class="form-group"style="padding: 15px">
                                    <label for="bank_payment" class="col-sm-4 control-label">Amount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="bank_payment" name="bank_payment" placeholder="Amount" max="<?php echo $customer_total_due; ?>">
                                    </div>
                                </div>
                                <div class="form-group"style="padding: 15px">
                                    <label for="check_no" class="col-sm-4 control-label">Check/DD/TT No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="check_no" name="check_no" placeholder="Check No">
                                    </div>
                                </div>
                        </div>
                        <hr>
                        <div class="box-header with-borde r">
                        <h3 class="box-title text-center text-bold">Due Payment Amount (Cash )</h3>
                    </div>
                        
                        <div class="form-group">
                            <input type="number" class="form-control" name="amount" value="" min='1' max="<?php echo $customer_total_due; ?>">                           
                                
                           
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               
                                <input  id="btn_submit" name="btn_submit" type="submit" class="btn btn-info btn-block submit_btn" value="Pay">
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo site_url('due/make_payment') ?>" class=" btn btn-primary btn-block "> Reset </a>
                            </div>
                        </div>
                        
                               
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.box-body -->
                </div>
                
            </div>
             <?php if(isset($due_report_list)){ ?>
<div class="row" style="width:585px;z-index: 9999;margin: 0 auto">
                        <div class="box col-md-12" id="block" style="width:585px;z-index: 9999;margin: 0 auto">             
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
</div>
        <?php } elseif(isset($report_message)){
            echo $report_message;
        }
?> 
        
    </section>
                       
        </div>
        
        
       




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>
<script>
    $('.first_table .table tbody').append('<tr style="border-top: 3px solid #d5d5d5;"><td colspan="6" class="text-center">Total Due =</td><td><?php echo $customer_total_due ?></td></tr>');
    $('.bank_hide').hide();
    $('.bank_add').click(function(){
       $('.bank_hide').toggle(); 
    });


    $('[name="id_account"]').change(function(){
       $('[name="bank_payment"]').val(' ');
       $('[name="check_no"]').val(' ');
    });
    
    $('#btn_submit').click(function(){
        
       if($('[name="bank_payment"]').val() == ' ' ){
           alert('Please Select Bank Payment');
           return;
       } 
       if($('[name="check_no"]').val() == ' '){
           alert('Please give check number');
           return;
       }
       
       
    });
</script>