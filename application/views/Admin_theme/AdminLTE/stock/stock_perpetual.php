
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
            <li class="active">Stock section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
//                if (!$date_filter) {
//                    $attributes = array(
//                        'clase' => 'form-inline',
//                        'method' => 'post');
//                    echo form_open('', $attributes)
                ?>
                <div class="form-group col-md-3 text-left">
                    <label>Search with Date Range:</label>
                </div>
                <form action="<?= $base_url ?>index.php/stock/stock_perpetual" method="get">
                    <div class="form-group col-md-7">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <?php echo anchor(site_url('stock/stock_perpetual'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                </form>

            </div>

            <div class="col-md-12" id="block">

                <div class="box">
                    <?php 
                    if(!isset($date_range)){
                        ?>
                    <div class="box-header">
                        <h3 class="box-title">Stock Perpitual Current View</h3>
                    </div><!-- /.box-header -->
                    
                    <div class="box-body">
                        <?php
                        echo $glosary->output;
                        ?>
                    </div><!-- /.box-body -->
                    <?php
                    }if(isset($date_range)){
                    ?>
                    <div class="box-header">
                          <p class="text-center"><strong>Stock Perpetual Report</strong></p>
                    <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>

                    <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                    <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y',now());?></div>
                    </div>
                    <div class="box-body">
                     <table  class ="table table-bordered table-hover" style="background: #fff;">
                                        <thead style="background: #DFF0D8;">
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Opening Amount</th>
                                                <th>Receive Amount</th>
                                                <th>Sales Amount</th>
                                                <th>Specimen</th>
                                                <th>Return Amount Reject</th>
                                                <th>Reject Amount</th>
                                                <th>Closing Stock</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($stock_perpetual as $stock) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $stock->name; ?></td>
                                                    <td><?php echo $stock->opening_amount; ?></td>
                                                    <td><?php echo $stock->receive_amount; ?></td>
                                                    <td><?php echo $stock->sales_amount; ?></td>
                                                    <td><?php echo $stock->specimen; ?></td>
                                                    <td><?php echo $stock->return_amountreject; ?></td>
                                                    <td><?php echo $stock->reject_amount; ?></td>
                                                    <td><?php echo $stock->closing_stock; ?></td>
                                                    <td><?php echo $date = date('d/m/Y', strtotime($stock->date)); ?></td>
                                                    

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