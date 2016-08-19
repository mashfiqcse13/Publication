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
                <?php
                $attributes = array(
                    'clase' => 'form-inline',
                    'method' => 'get');
                echo form_open('', $attributes)
                ?>
                <div class="form-group col-md-3 text-left">
                    <label>Search with Date Range:</label>
                </div>
                <div class="form-group col-md-7">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>

                    </div><!-- /.input group -->
                </div><!-- /.form group -->
                <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                <?= anchor(current_url() . '/loan/loan_employee_list', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                <?= form_close(); ?>
                <div  style="margin: 40px;">
                </div>
            </div>
            <?php
            if (!isset($date_range)) {
                ?>
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header" >
                            <h1 class="text-center">Employee List of Loan</h1>
                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Loan Title</th>
                                        <th>Amount of Loan</th>
                                        <th>Date of Loan</th>
                                        <th>Loan Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($employees_loan as $loan) {
                                        ?>
                                        <tr>
                                            <td><?php echo $loan->name_employee; ?></td>
                                            <td><?php echo $loan->title_loan; ?></td>
                                            <td class="text-right faka_formate"><?php echo $loan->amount_loan; ?></td>
                                            <td><?php echo $date = date('d/m/Y', strtotime($loan->date_taken_loan)); ?></td>
                                            <td><?php echo $loan->status; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Loan Title</th>
                                        <th>Amount of Loan</th>
                                        <th>Date of Loan</th>
                                        <th>Loan Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
                <?php
            }if (isset($date_range)) {
                
                ?>
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                            <p class="text-center"> <?= $Title ?> Report</p>
                            <div style="margin-bottom: 60px;">
                                <p class="pull-left" style="margin-left:5px">Report Generated by: <?php echo $_SESSION['username'] ?></p>
                                <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            </div>
                            <div style="color: #777777;">
                                <p class="pull-left" style="margin-left:5px"> <strong>Date Range: (From - To) </strong> <?php echo $date_range; ?></p>
                                <div class="pull-right">Report Date: <?php echo date('Y-m-d H:i:s', now()); ?></div>
                            </div>
                        </div>
                        <div class="box-body">
                            <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                                <thead>
                                    <tr style="background:#ddd">
                                        <th>Employee Name</th>
                                        <th>Amount of Loan</th>
                                        <th>Date of Loan</th>
                                        <th>Loan Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($employees_loan as $loan) {
                                        ?>
                                        <tr>
                                            <td><?php echo $loan->name_employee; ?></td>
                                            <td class="text-right faka_formate"><?php echo $loan->amount_loan; ?></td>
                                            <td><?php echo $date = date('d/m/Y', strtotime($loan->date_taken_loan)); ?></td>
                                            <td><?php echo $loan->status; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>