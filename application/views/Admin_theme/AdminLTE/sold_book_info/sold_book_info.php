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
            <li class="active"><?php echo $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

               <div class="box only_print">
                    <div class="box-body">
                        
                       
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group col-md-4">
                                        <label>Party Name : </label>
                                    </div>
                                    <div class="col-md-6">
                                        <?=$customer_dropdown;?>
                                    </div>
                                    
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group col-md-3 text-left">
                                        <label>Search with Date Range:</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="date_range" value="" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        <?php echo anchor(site_url('sold_book_info'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                                    </div>
                                </div>
                                 
                            </div>
                             
                           </form>

                    </div>
                </div>

                <div class="box" id="block" style="min-height:900px">
                    <?php
                    if (isset($table_today)) {
                        ?> 
                    
                    <div class="box-header">
                            <p class="text-center"><strong>আজকের বিক্রীত বইসমূহ</strong></p>
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Book Name</th>
                                        <th>Accurate Sale <br><span style="font-size:10px"> (Accurate Sale = Sale - Sale Return ) </span> </th> 
                                        <th>Old Book Return</th>
                                        <th>Actual Sale <br><span style="font-size:10px"> ( Actual Sale = Accurate Sale - Old Book Return ) </span></th>
                                        
                                        
                                    </tr>
                                </thead>
                               <tbody>
                                    <?php
                                       
                                    foreach ($table_today as $key => $return) {                                       
                                        ?>
                                        <tr>
                                            <td><?php echo $return['name'] ?></td>
                                            <td ><?php  echo $return['sale_quantity'] - $return['return_quantity'];    ?></td>
                                            <td><?php echo $return['old_quantity'];   ?></td> 
                                            <td><?php echo  $return['sale_quantity'] - $return['return_quantity']-$return['old_quantity'] ?></td>
                                            
                                        </tr>
                                        <?php
                                        
                                    }
                                    ?>

                                    
                                </tbody>
                            </table>

                        </div>
                        <?php
                    }if (isset($table)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>বিক্রীত বইসমূহ</strong></p>
                             <?php if(isset($name)){ echo '<p class="text-center">Customer Name:'.$name.'</p>'; }?>
                            
                            <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>
                           
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Book Name</th>
                                        <th>Accurate Sale <br><span style="font-size:10px"> (Accurate Sale = Sale - Sale Return ) </span> </th> 
                                        <th>Old Book Return</th>
                                        <th>Actual Sale <br><span style="font-size:10px"> ( Actual Sale = Accurate Sale - Old Book Return) </span></th>
                                        
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php
                                       
                                    foreach ($table as $key => $return) {                                       
                                        ?>
                                        <tr>
                                            <td><?php echo $return['name'] ?></td>
                                            <td ><?php  echo $return['sale_quantity'] - $return['return_quantity'];    ?></td>
                                            <td><?php echo $return['old_quantity'];   ?></td> 
                                            <td><?php echo  $return['sale_quantity'] - $return['return_quantity']-$return['old_quantity'] ?></td>
                                            
                                        </tr>
                                        <?php
                                        
                                    }
                                    ?>

                                    
                                </tbody>
                            </table>

                        </div>
                        <?php
                    }
                    ?>

                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
