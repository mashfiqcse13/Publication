<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper only_print">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?=$Title ?>
            <small> <?=$Title ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $Title ?></li>
          </ol>
        </section>
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                     <div class="box only_print">
                <div class="box-body">
                    <?php
                    $attributes = array(
                        'clase' => 'form-inline',
                        'method' => 'post');
                    echo form_open('', $attributes)
                            //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                    ?>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group col-md-4 text-left">
                                <label>Status Type:</label>                        
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <select name="status_type" class="form-control">
                                        <option value="">All Selected </option>
                                        <option value="1">Approve</option>
                                        <option value="2">Cancel</option>
                                        <option value="3">Pending</option>
                                    </select>

                                    </select>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-4 text-left">
                                <label>User:</label>                        
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <?php echo $user_dropdown; ?>

                                    </select>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                        </div>
                    
                        
                    </div>
                    
                    <div class="row">

                    <div class="col-md-12">
                    <div class="form-group col-offset-2 col-md-4 text-left">

                        <label>Search Report With Date Range:</label>
                    </div>
                    <div class="form-group col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                            <br>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <div class="form-group col-md-2">
                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <?= anchor(current_url() . '/', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                    </div></div></div>
                    <?= form_close(); ?>
                    <?php ?>
                </div>
            </div>

                    <div class="box">
                <?php    if(isset($main_content)){ ?>
                        <div class="panel-body">
                           
                           <table class="table table-bordered">
                               <tr style="background:#ddd;">
                                   <th>Generate Date</th>
                                   <th>Bank Name</th>
                                   <th>Account No.</th>
                                   <th>Amount</th>
                                   <th>Transaction Type</th>
                                   <th>User Entered</th>
                                   <th>Action Date</th>
                                   <th>Approval Status</th>
                               </tr>
                               
                               <?php foreach ($main_content->result() as $row){ ?>
                               <tr>
                                   <td><?php echo $row->transaction_date; ?></td>
                                   <td><?php echo $row->name_bank; ?></td>
                                   <td><?php echo $row->account_number; ?></td>
                                   <td style="text-align:right"><?php echo $row->amount_transaction; ?></td>
                                   <td><?php echo $row->name_trnsaction_type; ?></td>
                                   <td><?php echo $row->username; ?></td>
                                   <td><?php echo $row->action_date; ?></td>
                                   <td class="approval">
                                      <?php if($row->approval_status==1){echo '<span style="color:green">Approved</span>'; }
                                      elseif($row->approval_status==2){echo '<span style="color:red">Canceled</span>'; }
                                      else{ ?>
                                       <form class="formforstatus" method="" action="">
                                           <input type="hidden" name="id_management_status" value="<?php echo $row->id_bank_management_status; ?>">
                                           Approved <input type="radio" name="approval_status" value="1" <?php if($row->approval_status==1){echo 'checked';}?> >
                                           Canceled <input type="radio" name="approval_status" value="2"  <?php if($row->approval_status==2){echo 'checked';}?>>
                                           Pending <input type="radio" name="approval_status" value="3"  <?php if($row->approval_status==3){echo 'checked';}?>>
                                           <a href="#" class="save_status">Update</a>
                                       </form>
                                       <?php } ?>
                                   </td>
                               </tr>
                               <?php } ?>
                           </table>
                           
                            <div class="pull-right"><?php echo $links; ?></div>                  

                             
                            
                             
                        </div>
                      <?php }//echo $main_content ?>
                    
               
                    </div>
                    
                </div>
            </div>
         
            <div class="row">
                
                    <?php if(isset($report)){ ?>
                        <div class="panel-body">
                <h3 class="text-center"><?=$this->config->item('SITE')['name'] ?></h3>
                <p class="text-center"> <?=$Title ?> Report</p>
                <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
                <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>

                        
                     <?php   echo $report;                       
                    }?> 
                </div>
            </div>

          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->

            <div class="row">
                <div class="panel-body">

                    <?php if(isset($report)){ ?>
                        <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>
                       <h3 class="text-center"><?=$this->config->item('SITE')['name'] ?></h3>
                       <p class="text-center"> <?=$Title ?> Report</p>
                       <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
                        
                        <?php echo $report; }?> 
                </div>
            </div>

<?php include_once __DIR__ . '/../footer.php'; ?>


<script>

   $('.save_status').click(function(){
      
       $.ajax({
          url:"<?php echo base_url();?>index.php/bank/update_status",
          type:"POST",
           data : $("form.formforstatus").serialize(),
           dataType: "json",
           encode : true,
       });
       
       $(this).parent().html('updating...');

    
   }); 
    


    
</script>