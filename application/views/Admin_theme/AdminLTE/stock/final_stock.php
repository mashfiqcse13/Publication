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
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Add item to the stock</strong></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" class="form-horizontal" action="<?php echo current_url(); ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Item Name</label>

                                        <div class="col-sm-9">
                                            <?php echo $item_dropdown ?>
                                        </div>
                                    </div>



                                </div>
                            </div><div class="col-md-6">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="inputEmail3">Quantity</label>

                                        <div class="col-sm-10">
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="amount" class="form-control" min="0" required="">
                                                <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-info btn-flat">Add</button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->


                    </form>
                </div>


            </div>
                       <div class="box" id="block">
                    <?php
//                    if (isset($due)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>Income Report</strong></p>
                            <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php if(isset($date_range)){ echo $date_range;} ?></p>

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
    <!--                                        <th></th>-->
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Issue Amount</th>
                                        <th>Return Amount</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($report1 as $row){
                                    ?>
                                    <tr>
                                       
                                        <td ><?=$row->id_item;?></td>
                                        <td ><?=$row->item_name;?></td>
                                        <td ><?=$row->issue_quantity;?></td>
                                        <td><?php
                                        if(!empty($report2)){
                                                foreach($report2 as $return){
                                               if($row->id_item==$return->id_item){
                                                   echo $return->return_quantity;
                                               }
                                        }
                                        }else{
                                             echo 0;
                                         }
                                            
                                            ?></td>
                                    </tr>
                                    
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
<script>
    $(".select2").select2({
        'width': '100%'
    });
</script>