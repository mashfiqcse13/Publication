<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header" >
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
    <section class="content" style="min-height: 1050px;" >
        <div class="row">
            <div class="col-md-12">
                <?php
//                if (!$date_filter) {
//                    $attributes = array(
//                        'clase' => 'form-inline',
//                        'method' => 'post');
//                    echo form_open('', $attributes)
                ?>
                <form action="<?= site_url('/due/customer_due') ?>" method="get">
                    <div class="form-group ">
                        <label class="col-md-3">Customer</label>
                        <div class="col-md-7">
                            <select class="form-control select2"style="width:100%;"  name="customer">
                                <option>Select Customer</option>
                                <?php
                                foreach ($customers as $customer) {
                                    ?>
                                    <option value="<?php echo $customer->id_customer; ?>"><?php echo $customer->name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <?= anchor(current_url() . '/due/customer_due', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                    </div>
                </form>

            </div>

            <div class="col-md-12" id="block">

                <div class="box">
                    <?php
                    if (!isset($customer_id)) {
                        ?>
                        <div class="box-header">
                            <h3 class="box-title">Customer Due Current View</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <?php
                            echo $glosary->output;
                            ?>
                        </div><!-- /.box-body -->
                        <?php
                    }if (isset($customer_id)) {
                        ?>
                        <div class="box-header">
                            <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                            <p class="text-center"> <?= $Title ?> Report</p>
                            <div style="margin-bottom: 60px;">
                                <p class="pull-left" style="margin-left:5px">Report Generated by: <?php echo $_SESSION['username'] ?></p>
                                <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            </div>
                            <div style="color: #777777;">
                                <p class="pull-left" style="margin-left:5px"> <strong>Customer Id: </strong> <?php echo $customer_id; ?></p>
                                <div class="pull-right">Report Date: <?php echo date('Y-m-d H:i:s', now()); ?></div>
                            </div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                            <thead>
                                <tr style="background:#ddd">
                                        <th>Customer Name</th>
                                        <th>Total Due Billed</th>
                                        <th>Total Paid</th>
                                        <th>Total Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($customer_dues as $due) {
                                        ?>
                                        <tr>
                                            <td><?php echo $due->name; ?></td>
                                            <td><?php echo $due->total_due_billed; ?></td>
                                            <td><?php echo $due->total_paid; ?></td>
                                            <td><?php echo $due->total_due; ?></td>
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