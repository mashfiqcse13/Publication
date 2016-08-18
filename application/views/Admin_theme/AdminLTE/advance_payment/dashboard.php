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
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add advance payment (Cash Only)</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="form-horizontal" action="<?php echo current_url(); ?>" method="post">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Customer :</label>
                                        <div class="col-sm-8">
                                            <?php echo $customer_dropdown ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            
                            <div class="col-md-4">
                                <div class="box-body">
                                     
                        
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="inputEmail3">Cash :</label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="amount" class="form-control" min="0" >
                                               
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box-body">
                                     
                        
                                    <div class="form-group">
                                        <label class="col-sm-7 control-label">Bank Payment  :</label>

                                        <div class="col-sm-5">
                                            <div class="input-group input-group-sm">
                                                <p class="btn btn-info bank_add">Bank Pay</p>
                                               
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                                       
                            </div>
                        <div class="row bank_hide" style="display:none">
                              <hr>
                                <div class="col-md-12" style="padding:0 30px;">
                                    <p  class="alert alert-info"><strong>Note :</strong> If you use this form , this balance will be added to the account balance automatically as an approved transaction .</p>
                                <div class="col-md-5">
                                    <div class="form-group" style="padding: 15px">
                                                            <label for="bank_account" class="col-sm-4 control-label">Receiving Account</label>
                                                            <div class="col-sm-8">
                                                                <?php echo $bank_account_dropdown ?>
                                                            </div>
                                                        </div> 
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group"style="padding: 15px">
                                                            <label for="bank_payment" class="col-sm-4 control-label">Amount</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="bank_payment" name="bank_payment" placeholder="Amount" ">
                                                            </div>
                                                        </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group"style="padding: 15px">
                                                            <label for="check_no" class="col-sm-6 control-label">Check/DD/TT No</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="check_no" name="check_no" placeholder="Check No">
                                                            </div>
                                                        </div>
                                </div>
                                </div>
                            </div>
                        <div class="row" style="padding:0 30px;padding-bottom: 15px;">
                            <?php if(isset($report_message)){         echo $report_message;        } ?>
                            <hr>
                            <a href="<?=site_url('Advance_payment') ?>" class="btn btn-primary pull-right" style="margin-right:5px;margin-left: 5px;">Refresh</a>
                            <input type="submit"  class="btn btn-primary pull-right" value="Add Payment" name="btn_submit"/>
                           
                        </div>
                        
           
                          
                        <!-- /.box-body -->


                    </form>
                </div>
                </div>
            <div class="col-md-12">

                <div class="box">

                    <?php
                    echo $glosary->output;
                    ?>

                </div>

            </div>
        </div>

               
    </section>
            
            
        </div>





<?php include_once __DIR__ . '/../footer.php'; ?>
<script>
    $(".select2").select2({
        'width': '100%'
    });
    
     $('.bank_hide').hide();
    $('.bank_add').click(function(){
       $('.bank_hide').toggle(); 
       $('.bank_hide').toggleClass('validation');
    });
    
    
</script>