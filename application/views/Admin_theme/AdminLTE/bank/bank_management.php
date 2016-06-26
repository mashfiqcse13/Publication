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
                                <label>Account:</label>                        
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <?php echo $account_dropdown; ?>

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
                    <div class="col-md-6">
                          <div class="form-group col-md-4 text-left">
                                <label>Transaction Type:</label>                        
                            </div>
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <?php echo $transaction_type_dropdown; ?>

                                    </select>
                                </div><!-- /.input group -->
                            </div><!-- /.form group -->
                    </div>
                    <div class="col-md-6">
                    <div class="form-group col-md-4 text-left">

                        <label>Search Report With Date Range:</label>
                    </div>
                    <div class="form-group col-md-5">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                            <br>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <div class="form-group col-md-3">
                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <?= anchor(current_url() . '/', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                    </div></div></div>
                    <?= form_close(); ?>
                    <?php ?>
                </div>
            </div>

                    <div class="box">
                    
                    <?php  
                    if(isset($glosary->output)){echo $glosary->output; }

                       //echo $glosary->output;
                    ?>
               
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="panel-body">

                    <?php if(isset($report)){?>
                    
                        <h3 class="text-center"><?=$this->config->item('SITE')['name'] ?></h3>
                        <p class="text-center"> <?=$Title ?> Report</p>
                        <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>

                        <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>

                      
                    <?php    echo $report; }?> 
                </div>
            </div>


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->

      <div class="report-logo-for-print" >
          <h3 class="text-center"><?=$this->config->item('SITE')['name'] ?></h3>
          <p class="text-center"> <?=$Title ?> Report</p>
          <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
          <?php if(isset($report)){echo $report; }?> 
      </div>

<?php include_once __DIR__ . '/../footer.php'; ?>

      <script>     
           
            var today ='<?php echo DATE('m-d-Y') ?>';
            $('#field-transaction_date').val(today);
            
       
      </script>