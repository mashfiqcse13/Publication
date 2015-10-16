<!--add header -->
<?php include_once 'header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
             <?=$Title ?>
            <small><?=$Title ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Contact Management</li>
          </ol>
        </section>
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="box">
                    
                     <?php  
                       echo $glosary->output;
                    ?>
                   
                    </div>
                    

                    <form action="" class="form-inline">
                      <label for="datefrom">Date From: </label>
                      <input type="text" name="datefrom" class="datepicker datetime-input form-control" data-date-format="mm/dd/yyyy">

                      <label for="dateto">Date To:</label>
                      <input type="text" name="dateto" class="datepicker datetime-input form-control" data-date-format="mm/dd/yyyy">
                    
                      <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>
            </div>
          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php include_once 'footer.php'; ?>