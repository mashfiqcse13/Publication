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
                        <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>

                    </div><!-- /.input group -->
                </div><!-- /.form group -->
                <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                <button type="reset" name="btn_submit" value="true" class="btn btn-success"><i class="fa fa-refresh"></i></button>

                <?= form_close(); ?>
                <div  style="margin: 40px;">
                </div>
            </div>
            <?php
            if (!isset($date_range)) {
                ?>
                <div class="col-md-12">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body">
                            <div id="employee_table">
                                <div class="box">
                                    <div class="box-header" >
                                        <h1 class="text-center">Total Salary Paid</h1>
                                    </div>
                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Employee Name</th>
                                                    <th>Month</th>
                                                    <th>Date Salary Payment</th>
                                                    <th>Year</th>
                                                    <th>Total Salary paid</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sum = 0;
                                                $sl = 1;
                                                foreach ($total_paid_salary as $total) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sl; ?></td>
                                                        <td><?php echo $total->name_employee; ?></td>
                                                        <td><?php
                                                            if (($total->month_salary_payment) == 1) {
                                                                echo 'January';
                                                            }if (($total->month_salary_payment) == 2) {
                                                                echo 'February';
                                                            }if (($total->month_salary_payment) == 3) {
                                                                echo 'March';
                                                            }if (($total->month_salary_payment) == 4) {
                                                                echo 'April';
                                                            }if (($total->month_salary_payment) == 5) {
                                                                echo 'May';
                                                            }if (($total->month_salary_payment) == 6) {
                                                                echo 'June';
                                                            }if (($total->month_salary_payment) == 7) {
                                                                echo 'July';
                                                            }if (($total->month_salary_payment) == 8) {
                                                                echo 'August';
                                                            }if (($total->month_salary_payment) == 9) {
                                                                echo 'September';
                                                            }if (($total->month_salary_payment) == 10) {
                                                                echo 'October';
                                                            }if (($total->month_salary_payment) == 11) {
                                                                echo 'November';
                                                            }if (($total->month_salary_payment) == 12) {
                                                                echo 'December';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo date('d/m/Y', strtotime($total->date_salary_payment));
                                                            ?></td>
                                                        <td><?php echo $total->year_salary_payment; ?></td>
                                                        <td><?php echo $total->total; ?></td>
                                                    </tr>
                                                    <?php
                                                    $sl++;
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Employee Name</th>
                                                    <th>Month</th>
                                                    <th>Date Salary Payment</th>
                                                    <th>Year</th>
                                                    <th>Total Salary paid</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($date_range)) {
                ?>
            <div class="col-md-12" id="block">
                    <h1 class="text-center"><strong>ABC Publications</strong></h1>
                    <h3 class="text-center"><strong>Total Salary Paid</strong></h3>
                    <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>
                    <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                    <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>


                    <table  class ="table table-bordered table-hover" style="background: #fff;">
                        <thead style="background: #DFF0D8;">
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Month</th>
                                <th>Date Salary Payment</th>
                                <th>Total Salary paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sum = 0;
                            $sl = 1;
                            foreach ($totals as $total) {
                                ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $total->name_employee; ?></td>
                                    <td><?php
                                        if (($total->month_salary_payment) == 1) {
                                            echo 'January';
                                        }if (($total->month_salary_payment) == 2) {
                                            echo 'February';
                                        }if (($total->month_salary_payment) == 3) {
                                            echo 'March';
                                        }if (($total->month_salary_payment) == 4) {
                                            echo 'April';
                                        }if (($total->month_salary_payment) == 5) {
                                            echo 'May';
                                        }if (($total->month_salary_payment) == 6) {
                                            echo 'June';
                                        }if (($total->month_salary_payment) == 7) {
                                            echo 'July';
                                        }if (($total->month_salary_payment) == 8) {
                                            echo 'August';
                                        }if (($total->month_salary_payment) == 9) {
                                            echo 'September';
                                        }if (($total->month_salary_payment) == 10) {
                                            echo 'October';
                                        }if (($total->month_salary_payment) == 11) {
                                            echo 'November';
                                        }if (($total->month_salary_payment) == 12) {
                                            echo 'December';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($total->date_salary_payment));
                                        ?></td>
                                    <td><?php echo $total->total; ?></td>
                                </tr>
                                <?php
                                $sl++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php }
            ?>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>