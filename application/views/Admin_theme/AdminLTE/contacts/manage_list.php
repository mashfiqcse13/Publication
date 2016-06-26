
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
            <li class="active">Customer section</li>
          </ol>
        </section>
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <?php 
                                           
                       if ($this->uri->segment(3) !== 'read' && $this->uri->segment(3) !== 'add' && $this->uri->segment(3) !== 'edit' )   {
                           
                      ?>
<!--                        <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"   value="Print Report"/>
        -->
                     <?php  } 

                       echo $glosary->output;
                    ?>
               
                    </div>
                    
                </div>
            </div>
         


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->

  

<?php include_once __DIR__ . '/../footer.php'; ?>
