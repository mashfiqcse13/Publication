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
                        <?php echo anchor('users_info/user_access_group', '<span class="btn btn-primary"> <i class="fa fa-plus-circle"></i>  Users Access Group Add</span>'); ?>           
                       <?php
                       if($this->session->userdata('user_access_message')){ ?>
                        <div class="" >
                            <div class="box box-default box-solid">
                              <div class="box-header with-border">
                                <?php 
                           echo $this->session->userdata('user_access_message');
                           $this->session->unset_userdata('user_access_message');
                           ?>

                                <div class="box-tools pull-right">
                                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                                <!-- /.box-tools -->
                              </div>
                              
                            </div>
                            <!-- /.box -->
                        </div>
                            
                      <?php }

                       echo $glosary->output;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->
<?php include_once __DIR__ . '/../footer.php'; ?>