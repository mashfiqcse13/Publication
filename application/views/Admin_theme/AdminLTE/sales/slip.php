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
                    <?php 
                    if(isset($glosary->output)){
                        echo anchor('sales/add_slip', 'Add New Slip', ' class="btn btn-primary"');
                    }
                    ?>
                    <?php   if(isset($customer)){ ?>                       
                          
                 <div class="box only_print">
                            <div class="box-body">
                                <?php
                
                    $attributes = array(
                        'clase' => 'form-inline',
                        'method' => 'post');
                    echo form_open('', $attributes)
                    ?>
                    
                     <div class="form-group col-md-12">
                        <div class="col-sm-2">
                            <label for="">Customer Name:</label>
                        </div>
                        <div class="col-sm-6">
                            <?=$customer?>
                        </div>
                     </div>
                    <div class="form-group col-md-12">
                        <div class="col-sm-2">
                            <label for="">Slip Amount:</label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="slip_amount" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="col-sm-2">
                            <label for="">Description:</label>
                        </div>
                        <div class="col-sm-6">
                            <textarea name="description" class="textarea"></textarea>
                        </div>
                    </div>
                    
                                <input type="submit" name="submit" class="btn btn-primary" value="Save and Print">
                                <a href="<?= site_url('sales/slip') ?> "class="btn btn-primary "><i class="fa fa-dashboard"></i> Back to Dashboard </a>
                    
                    <?= form_close(); ?>
                <?php  ?>
                            </div>
                        </div>
                        
                    <?php }
                    
                    if(isset($glosary->output)){
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
      <script>         
$('.special_process_for_coma_production td').not('.special_process_for_coma_production td:last-child()').digits();
      </script>