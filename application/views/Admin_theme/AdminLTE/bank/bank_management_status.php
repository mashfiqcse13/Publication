<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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

                    <div class="box">
                    
                        <div class="panel-body">
                           
                           <table class="table table-bordered">
                               <tr style="background:#ddd;">
                                   <th>Date</th>
                                   <th>Bank Name</th>
                                   <th>Account No.</th>
                                   <th>Amount</th>
                                   <th>Transaction Type</th>
                                   <th>user Entered</th>
                                   <th>Approval Status</th>
                               </tr>
                               
                               <?php foreach ($main_content->result() as $row){ ?>
                               <tr>
                                   <td><?php echo $row->transaction_date; ?></td>
                                   <td><?php echo $row->name_bank; ?></td>
                                   <td><?php echo $row->account_number; ?></td>
                                   <td><?php echo $row->amount_transaction; ?></td>
                                   <td><?php echo $row->name_trnsaction_type; ?></td>
                                   <td><?php echo $row->username; ?></td>
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

                             
                            
                             <?php //echo $main_content ?>
                        </div>
                      
                    
               
                    </div>
                    
                </div>
            </div>
         


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->



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