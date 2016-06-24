
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
                    <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"   value="Print Report"/>
        
                    <?php  

                       echo $glosary->output;
                    ?>
               
                    </div>
                    
                </div>
            </div>
         


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->

 <div class="box-body report-logo-for-print" style="background:#fff">
         <h3 class="text-center"><?=$this->config->item('SITE')['name'] ?></h3>
          <p class="text-center"> <?=$Title ?> Report</p>
          <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
           <?php
                   if(!isset($date_range)){
                    echo $glosary->output;
                    
                    
                   }
                    ?>
          
        </div>
<style>
    .report-logo-for-print .tDiv {
    display: none;
    }

    .report-logo-for-print  form#filtering_form {
        display: none;
    }

    .report-logo-for-print  th:nth-child(8) {
        display: none;
    }

    .report-logo-for-print  td:nth-child(8) {
        display: none;
    }

    .report-logo-for-print  td {
        border: 1px solid #ddd!important;
    }

 

    .report-logo-for-print  .flexigrid div.mDiv {
        display: none;
    }

    .report-logo-for-print  .flexigrid div.bDiv {
        border: 0px!important;
    }
</style>

<?php include_once __DIR__ . '/../footer.php'; ?>z
