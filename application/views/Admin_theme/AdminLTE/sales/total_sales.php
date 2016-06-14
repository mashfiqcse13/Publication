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
                                                            
                <div class="box only_print">
                <div class="box-body">
                    <?php
                    $attributes = array(
                        'clase' => 'form-inline',
                        'method' => 'post');
                    echo form_open(base_url().'index.php/sales/memo_report', $attributes)
                            //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                    ?>
                    
                    <div class="form-group col-md-2 text-left">

                        <label>Search By Memo:</label>
                    </div>
                    <div class="form-group col-md-3">
                        
                            <?php echo $memo_list; ?>
                            
                        
                    </div><!-- /.form group -->

                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <?= anchor(current_url() . '/expense', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                    
                            
                            
                    <?= form_close(); ?>
                    <?php ?>
                </div>
            </div>

                    <div class="box">
                    
                    <?php  

                       echo $glosary->output;
                    ?>
               
                    </div>
                    
                </div>
            </div>
         


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>