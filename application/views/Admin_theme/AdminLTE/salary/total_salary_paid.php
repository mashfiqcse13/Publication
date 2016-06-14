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
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <!--<h4 class="panel-title">Salary</h4>-->
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
                                                    <td><?php
//                                            if (($total->month_salary_payment) == 1) {
//                                                echo 'January';
//                                            }if (($total->month_salary_payment) == 2) {
//                                                echo 'February';
//                                            }if (($total->month_salary_payment) == 3) {
//                                                echo 'March';
//                                            }if (($total->month_salary_payment) == 4) {
//                                                echo 'April';
//                                            }if (($total->month_salary_payment) == 5) {
//                                                echo 'May';
//                                            }if (($total->month_salary_payment) == 6) {
//                                                echo 'June';
//                                            }if (($total->month_salary_payment) == 7) {
//                                                echo 'July';
//                                            }if (($total->month_salary_payment) == 8) {
//                                                echo 'August';
//                                            }if (($total->month_salary_payment) == 9) {
//                                                echo 'September';
//                                            }if (($total->month_salary_payment) == 10) {
//                                                echo 'October';
//                                            }if (($total->month_salary_payment) == 11) {
//                                                echo 'November';
//                                            }if (($total->month_salary_payment) == 12) {
//                                                echo 'December';
//                                            }
                                                    echo date('d/m/Y',strtotime($total->date_salary_payment));
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
                                                <th>Month</th>
                                                <th>Year</th>
                                                <th>Total Salary paid</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                        </div>
                        <div id="loan_info">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>