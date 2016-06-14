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
//                if (!$date_filter) {
                    $attributes = array(
                        'clase' => 'form-inline',
                        'method' => 'post');
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
                            <input type="text" name="date_range"  class="form-control pull-right" id="reservation"  title="This is not a date"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <?= anchor(current_url() . '/reset_date_range', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                    <?= form_close(); ?>
                <?php // } ?>
            </div>
            <div class="col-md-12">
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <!--<h4 class="panel-title">Salary</h4>-->
                    </div>
                    <div class="panel-body">
                        <!--<form target="_new" action="<?php echo base_url(); ?>index.php/Salary/paid_salary_payment" method="post" class="form-horizontal" name="form">-->

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
                                            <td><?php echo $loan->name_employee;?></td>
                                            <td><?php echo $loan->title_loan;?></td>
                                            <td><?php echo $loan->amount_loan;?></td>
                                            <td><?php echo $date = date('d/m/Y', strtotime($loan->date_taken_loan));?></td>
                                            <td><?php echo $loan->status;?></td>
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
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>