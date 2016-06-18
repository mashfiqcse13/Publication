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
                        <h4 class="panel-title">Loan History</h4>
                    </div>
                    <div class="panel-body">
                        <form target="_new" action="<?php echo base_url(); ?>index.php/Salary/paid_salary_payment" method="post" class="form-horizontal" name="form">
                            <div class="form-group ">
                                <label class="col-md-3">Employee Name</label>
                                <div class="col-md-9">
                                    <select class="form-control select2"style="width:100%;" name="id_employee" id="loan_select">
                                        <option>Select Employee Name</option>
                                        <?php
                                        foreach ($employees as $employee) {
                                            ?>
                                            <option value="<?php echo $employee->id_employee; ?>"><?php echo $employee->name_employee; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="loan_info">
                                <h1 class="text-center">Loan History of Employee</h1>
                                <hr>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Total Amount of Loan Taken</label>
                                    <div class="col-md-9">
                                        <p  id="total_loan"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Loan History</label>
                                    <div class="col-md-9" id="loan_history">
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Last Loan Status</label>'
                                    <div class="col-md-9">
                                        <p id="loan_status"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Total Loan Payment</label>
                                    <div class="col-md-9">
                                        <p  id="loan_payment"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"> Loan Payment Date</label>
                                    <div class="col-md-9" id="loan_payment_date">
                                        
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--    <div class="box">
    
    <?php
//                    echo $glosary->output;
    ?>
    
        </div>-->

</div>
</div>




</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>