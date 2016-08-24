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
                                        <label>Transfer Type : </label>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="process" id="process" class="form-control select2">
                                            <option value="">Select Process Type</option>
                                            <option value="2">Send to Rebind</option>
                                            <option value="1">Sale</option>

                                        </select>
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
                                    <?php echo anchor(site_url('old_book/return_book_sale_list'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                                    </div> 
                                </div>
                                 
                            </div>
                             
                           </form>

                    </div>
                </div>

                <div class="box" id="block" style="min-height:900px">
                    <?php
                    if (!isset($date_range)) {
                        ?>
                        <div class="box-header">
                            <h3 class="box-title">Old Book Return</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <?php
                            echo $glosary->output;
                            ?>
                        </div><!-- /.box-body -->
                        <?php
                    }if (isset($date_range)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>Old Book send to rebind or sale ( <?php
                            if(isset($id_type) && $id_type==2){
                                echo 'Report on Send to Rebind';                              
                                
                            }
                            if(isset($id_type) && $id_type==1){
                                echo 'Report on Sale';
                            }
                            
                            ?> )</strong></p>
                            <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) : </strong> <?php echo $date_range; ?></p>

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                            
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Book Name</th>
                                        <th>Quantity</th>
                                        <th class="pull-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sum_quantity = 0;
                                    $sum_total_amount = 0;
                                    foreach ($return_list as $list) {
                                        $sum_quantity += $list->quantity;
                                        $sum_total_amount += $list->price;
                                        ?>
                                        <tr>
                                            <td><?php echo $list->name; ?></td>
                                            <td><?php echo $list->quantity; ?></td>
                                            <td class="text-right taka_formate"> TK <?php echo $list->price; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr style="font-weight: bold">                                        
                                        <td>Total : </td>
                                        <td><?php echo $sum_quantity; ?></td>
                                        <td class="text-right taka_formate"> TK <?php echo $sum_total_amount; ?></td>
                                        


                                    </tr>
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
