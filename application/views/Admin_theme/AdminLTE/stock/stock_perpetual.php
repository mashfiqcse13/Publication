
<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 1050px;" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $Title ?>
            <small> <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Stock perpitual</li>
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



            <div class="box col-md-12" id="block" style="overflow-x:scroll">
                <?php
                if (!isset($date_range)) {
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
                }if (isset($stock_perpetual)) {
                    ?>
                    <div class="box-header">
                        <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                        <p class="text-center"> <?= $Title ?> Report</p>
                        <div style="margin-bottom: 60px;">
                            <p class="pull-left" >Report Generated by: <?php echo $_SESSION['username'] ?></p>
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                        </div>
                        <div style="color: #777777;">
                            <p class="pull-left" > <strong>Date Range: (From - To) </strong> <?= isset($date_range) ? $date_range : ''; ?></p>
                            <br>
                            <p class="alert-info pull-left">Closing Stock = (Opening Stock + Receive) - (Accurate Sale + Accurate Specimen )  </p>

                            <p class="pull-right">Report Date: <?php echo date('Y-m-d H:i:s', now()); ?></p>
                        </div>
                    </div>
                    <div class="box-body">
                        <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                            <thead>
                                <tr style="background:#ddd">
                                    <th>Item Name</th>
                                    <th>Opening</th>
                                    <th>Receive </th>
                                    <th>Sale</th>
                                    <th>Accurate Specimen <br><span style="font-size:10px"> (Accurate Specimen = Specimen - Specimen Return ) </span></th>
                                    <th>Sale Return</th>
                                    <th>Accurate Sale <br><span style="font-size:10px"> (Accurate Sale = Sale - Sale Return ) </span></th>
                                    <th>Old Book Return</th>
                                    <th>Actual Sale <br><span style="font-size:10px"> ( Actual Sale = Accurate Sale - Old Book Return) </span> </th>
                                    <th>Closing Stock</th>                                    

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total_Opening = 0;
                                $total_Receive = 0;
                                $total_Sale = 0;
                                $total_Accurate_Specimen = 0;
                                $total_Sale_Return = 0;
                                $total_Accurate_Sale = 0;
                                $total_Old_Book_Return = 0;
                                $total_Actual_Sale = 0;
                                $total_Closing_Stock = 0;

                                foreach ($stock_perpetual as $stock) {
                                    $total_Opening += $stock->opening_amount;
                                    $total_Receive += $stock->receive_amount;
                                    $total_Sale += $stock->sales_amount;
                                    $total_Sale_Return += $stock->return_amountreject;
                                    ?>
                                    <tr>
                                        <td><?php echo $stock->name; ?></td>
                                        <td><?php echo $stock->opening_amount; ?></td>
                                        <td><?php echo $stock->receive_amount; ?></td>
                                        <td><?php echo $stock->sales_amount; ?></td>
                                        <td><?php
                                            $accurate_specimen = 0;
                                            if (!empty($return_specimen)) {
                                                foreach ($return_specimen as $sp) {
                                                    if ($stock->id_item == $sp->id_item) {
                                                        echo $accurate_specimen = $stock->specimen - $sp->return_quantity;
                                                    }
                                                }
                                            } else {
                                                echo $accurate_specimen = $stock->specimen;
                                            }
                                            $total_Accurate_Specimen += $accurate_specimen;
                                            ?></td>
                                        <td><?php echo $stock->return_amountreject;
                                    $total_Sale_Return +=$stock->return_amountreject ?></td>
                                        <td><?php
                                            echo $acturatesale = $stock->sales_amount - $stock->return_amountreject;
                                            $total_Accurate_Sale += $acturatesale;
                                            ?></td>
                                        <td><?php
                                            $Old_Book_Return = 0;
                                            if (!empty($old_info)) {
                                                foreach ($old_info as $row) {
                                                    if ($stock->id_item == $row->id_item) {
                                                        echo $row->old_quantity;
                                                        $Old_Book_Return+=$row->old_quantity;
                                                    }
                                                }
                                            } else {
                                                echo 0;
                                            }

                                            $total_Old_Book_Return += $Old_Book_Return;
                                            ?></td>

                                        <td><?php
                                            $tmp_Actual_Sale = 0;
                                            if (!empty($old_info)) {
                                                foreach ($old_info as $row) {
                                                    if ($stock->id_item == $row->id_item) {
                                                        echo $acturatesale - $row->old_quantity;
                                                        $tmp_Actual_Sale += ($acturatesale - $row->old_quantity);
                                                    }
                                                }
                                            } else {
                                                echo $acturatesale;
                                                $tmp_Actual_Sale += $acturatesale;
                                            }
                                            $total_Actual_Sale += $tmp_Actual_Sale;
                                            ?>
                                        </td>
                                        <td><?php
                                            echo
                                            ($stock->opening_amount + $stock->receive_amount + $stock->return_amountreject) -
                                            $stock->sales_amount - $accurate_specimen;

                                            $total_Closing_Stock += (($stock->opening_amount + $stock->receive_amount + $stock->return_amountreject) - $stock->sales_amount - $accurate_specimen);
                                            ?></td>




                                    </tr>
                                    <?php
                                }
                                ?>

                                <tr>
                                    <th>Total</th>
                                    <th ><?php echo $total_Opening; ?></th>
                                    <th><?php echo $total_Receive; ?></th> 
                                    <th><?php echo $total_Sale ?></th>
                                    <th><?php echo $total_Accurate_Specimen ?></th>
                                    <th><?php echo $total_Sale_Return; ?></th> 
                                    <th><?php echo $total_Accurate_Sale ?></th>
                                    <th><?php echo $total_Old_Book_Return ?></th>
                                    <th><?php echo $total_Actual_Sale ?></th>
                                    <th><?php echo $total_Closing_Stock ?></th>
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