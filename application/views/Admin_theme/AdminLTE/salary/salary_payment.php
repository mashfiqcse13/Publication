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
    <section class="content" style="min-height: 800px">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <?php
                    if ($this->uri->segment(3) === 'add') {
                        ?>

                        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                            <div class="panel-heading">
                                <h4 class="panel-title">Salary Table</h4>
                            </div>
                            <div class="panel-body">
                                <form target="_new" action="<?php echo base_url(); ?>index.php/Salary/paid_salary_payment" method="post" class="form-horizontal" name="form">
                                    <div class="form-group ">
                                        <label class="col-md-3">Employee Name</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2"style="width:100%;" name="id_employee" id="select">
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
                                    <div  id="success">
                                        <h1 class="text-center" id="heanding_success"></h1>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Month of Salary</label>

                                            <div class="col-md-9">
                                                <p id="salary_month"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Year of Salary</label>
                                            <div class="col-md-9">
                                                <p id="salary_year"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Issue Salary Payment</label>
                                            <div class="col-md-9">
                                                <p id="salary_issue"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date Salary Payment</label>
                                            <div class="col-md-9">
                                                <p id="salary_date"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Amount of Salary</label>
                                            <div class="col-md-9">
                                                <p id="salary_aos"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Amount of Bonus</label>
                                            <div class="col-md-9">
                                                <p id="salary_aob"></p>
                                            </div>
                                        </div><hr>
                                        <h3 class="text-center">Deduction</h3>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Advance</label>
                                            <div class="col-md-9">
                                                <p id="salary_advance"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Loan</label>
                                            <div class="col-md-9">
                                                <p id="salary_loan_bill"></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Total Amount Payable</label>
                                            <div class="col-md-9">
                                                <h3 id="salary_total"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="info">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Month of Salary</label>
                                            <div class="col-md-9"> 
                                                <p id="month"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Year of Salary</label>
                                            <div class="col-md-9"> 
                                                <p id="year"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Issue Salary Payment</label>
                                            <div class="col-md-9"> 
                                                <p id="issue"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Amount of Salary</label>
                                            <div class="col-md-9"> 
                                                <p id="aos"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Amount of Bonus</label>
                                            <div class="col-md-9"> 
                                                <p id="aob"></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Amount of Advance</label>
                                            <div class="col-md-9"> 
                                                <p id="advance"></p>
                                            </div>
                                        </div>
                                        <div id="loan">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Loan</label>
                                                <div class="col-md-9"> 
                                                    <input type="text" id="discharge" class="form-control" placeholder="Maximum" name="paid_amount_loan_payment" max="" value=""/>
                                                    <span style="color: red;font-weight: bold;">  *Loan to Pay  =   <span id="pay"></span>  &  Remaining Loan = <span id="remain"></span> </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Total</label>
                                            <div class="col-md-9"> 
                                                <p id="total"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="employee_id" name="id_salary_payment" value=""/>
                                    <input type="hidden" id="loan_id" name="id_loan" value=""/>
                                    <input type="hidden" id="advance_amount" name="amount_paid_salary_advance" value=""/>
                                    <input type="hidden" id="advance_id" name="id_salary_advance" value=""/>
                                    <input type="hidden" id="amount_salary" name="amount_salary_payment" value=""/>
                                    <!--<input type="text" id="discharge" class="form-control" name="amount_loan" value="" />-->
                                     <!--<div id="loan"><input type="text" id="discharge" class="form-control total_discharge"  name="amount_loan" value=""/></div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-sm btn-success" id="paid">Paid</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>




                        <?php
                    } else {

                        echo $glosary->output;
                    }
                    ?>

                </div>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
