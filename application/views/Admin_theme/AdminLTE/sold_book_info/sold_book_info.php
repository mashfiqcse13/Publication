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
                                <div class="col-md-6">
                                    <div class="form-group col-md-6 text-left">

                                        <label>Search By District:</label>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <?php echo $district_dropdown; ?>
                                    </div><!-- /.form group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group col-md-6">
                                        <label>Party Name or ID : </label>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $customer_dropdown; ?>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group col-md-6 text-left">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
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
                    if (isset($sold_book_info)) {
                        ?>
                        <div class="box-header">
                            <p class="text-center"><strong><?php echo $report_title; ?></strong></p>
                            <table style="margin: 0 auto">
                                <?php
                                if (isset($name)) {
                                    echo '<tr><td><strong>Customer Name </strong><td> &nbsp; : &nbsp; </td><td> ' . $name . '</td></tr>';
                                }
                                if (!empty($this->input->post('filter_district'))) {
                                    echo '<tr><td><strong>District Name </strong><td> &nbsp; : &nbsp; </td><td> ' . $this->input->post('filter_district') . '</td></tr>';
                                }
                                ?>
                            </table>

                            <?php
                            if (!empty($date_range)) {
                                echo '<p class="pull-left" style="margin-left:20px"> ' . $this->Common->date_range_formater_for_report($date_range) . "</p>";
                            }
                            ?>
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-hover" style="background: #fff;">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Sale</th> 
                                        <th>Old Book Return</th>
                                        <th>Actual Sale <br><span style="font-size:10px"> ( Actual Sale = Accurate Sale - Old Book Return) </span></th>

                                    </tr> 
                                </thead> 
                                <tbody>
                                    <?php
                                    $total_accurate_sale = 0;
                                    $total_old_book_return = 0;
                                    $total_actual_return = 0;
                                    foreach ($sold_book_info as $key => $return) {
                                        $total_accurate_sale += ($return['sale_quantity'] - $return['return_quantity']);
                                        $total_old_book_return+= $return['old_quantity'];
                                        $total_actual_return += ($return['sale_quantity'] - $return['return_quantity'] - $return['old_quantity']);
                                        ?>
                                        <tr>
                                            <td><?php echo $return['id_item'] ?></td>
                                            <td><?php echo $return['name'] ?></td>
                                            <td ><?php echo $return['sale_quantity'] - $return['return_quantity']; ?></td>
                                            <td><?php echo $return['old_quantity']; ?></td> 
                                            <td><?php
                                                $ActualSale = $return['sale_quantity'] - $return['return_quantity'] - $return['old_quantity'];
                                                echo ($ActualSale < 0) ? "" : $ActualSale
                                                ?></td>

                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <tr>
                                        <th colspan="2" class="text-center">Total</th>
                                        <th ><?php echo $total_accurate_sale; ?></th>
                                        <th><?php echo $total_old_book_return; ?></th> 
                                        <th><?php echo $total_actual_return ?></th>
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
