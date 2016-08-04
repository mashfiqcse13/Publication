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
            <li class="active"><?= $Title ?> section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Title ?></h3>
                    </div><!-- /.box-header -->
                    
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
                                    <div class="form-group">
                                        <label for="">Access Group Titel : </label>
                                        <input type="text" class="form-control" name="access_group_title"/>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Select Access Area : </label>                                        
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <?php echo $access_area;?> 
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                    
                                    
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Description :</label>
                                        <textarea name="description" id="" class="textarea"></textarea>
                                    </div>
                                    
                                </div>
                                
                                
                            </div>
                            

                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary pull-right">Submit</button>
                        
                        <?= form_close(); ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->
<?php include_once __DIR__ . '/../footer.php'; ?>