
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
            <li class="active"><?= $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Report Generation Filter</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="post">
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="col-md-4  control-label">Agent/Marketing Officer Name</label>
                                    <div class="col-md-8">
                                        <?php echo $agent_dropdown ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-4  control-label" for="exampleInputEmail1">Item Name</label>
                                    <div class="col-md-8">
                                        <?php echo $item_dropdown ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="col-md-4 control-label">Date Range</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="date_range" value="" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="report_asked" value="true">
                                <div class="form-group col-md-6 text-right">
                                    <div class="col-md-12" style="margin: 0;">
                                        <button type="submit" class="btn btn-primary" name="get_report" value="all">Search Information</button> 
                                        <a href="<?php echo site_url('specimen/report') ?>" class="btn btn-success">Reset filter</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                 <div class="box" id="block">
                    <?php
                    if (isset($report1)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong>Specimen Report</strong></p>
                            <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php if(isset($date_range)){ echo $date_range . ' (m-d-Y) ';} ?></p>

                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d-M-Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
    <!--                                        <th></th>-->
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Accurate Specimen Issue = <br> (Issue Amount - Return Amount) </th>
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
                    <?php } ?>
                </div>


            </div>

        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>