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
                        <!--<form target="_new" action="<?php echo base_url(); ?>index.php/Salary/paid_salary_payment" method="post" class="form-horizontal" name="form">-->
<!--                            <div class="form-group ">
                                <label class="col-md-3">Month</label>
                                <div class="col-md-9">
                                    <select class="form-control select2"style="width:100%;"  id="month_select">
                                        <option>Select Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>-->
                        <div id="employee_table" style="margin-top: 50px;">
                                <div class="box">
                                    <div class="box-header" >
                                        <h1 class="text-center">Current Month Salary</h1>
                                    </div>
                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Employee Name</th>
                                                    <th>Amount of Bonus</th>
                                                    <th>Amount of Salary</th>
                                                    <th>Date of Salary</th>
                                                    <th>Salary Status</th>
                                                </tr>
                                            </thead>
                                            <tbody id="current_salary_info">
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Employee Name</th>
                                                    <th>Amount of Bonus</th>
                                                    <th>Amount of Salary</th>
                                                    <th>Date of Salary</th>
                                                    <th>Salary Status</th>
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