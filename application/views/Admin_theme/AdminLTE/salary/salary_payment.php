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

                <div class="box">

                    <?php
                    if ($this->uri->segment(3) === 'add') {
                        ?>

                        <?php
//                        $message = $this->session->userdata('message');
//                        if (isset($message)) {
//                            echo $message;
//                        }
//                        $this->session->unset_userdata('message');
//                        
                        ?>
                        <!-- begin panel -->
                        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                            <div class="panel-heading">
                                <h4 class="panel-title">Salary Table</h4>
                            </div>
                            <div class="panel-body">
                                <form target="_new" action="<?php echo base_url(); ?>index.php/Salary/save_salary_amount" method="post" class="form-horizontal">

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

                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Month of Salary</label>
                                        <div class="col-md-9">
                                            <select name="month_salary_payment" class="form-control">
                                                <option>Select Salary Month</option>
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
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Year of Salary</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" placeholder="Year of Salary" name="year_salary_payment" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Issue Salary Payment</label>
                                        <div class="col-md-9">
                                            <input class="form-control datepicker" id="" placeholder="Issue Salary Payment" name="issue_salary_payment" type="text">
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group">
                                                                            <label class="col-md-3 control-label">Date Salary Payment</label>
                                                                            <div class="col-md-9">
                                                                                <input class="form-control datepicker" id="" placeholder="Date Salary Payment" name="date_salary_payment" type="text">
                                                                            </div>
                                                                        </div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Amount of Salary</label>
                                        <div class="col-md-9">

                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" name="basic_salary[]" id="bas"> Basic
                                                    <p id="basic"></p>
                                                </label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" name="basic_salary[]" id="medi"> Medical
                                                    <p id="medical"></p>
                                                </label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" name="basic_salary[]" id="house"> House Rent
                                                    <p id="house_rent"></p>
                                                </label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" name="basic_salary[]" id="trans"> Transport Allowance
                                                    <p id="transport"></p>
                                                </label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label>
                                                    <input type="checkbox" name="basic_salary[]" id="lunchs"> Lunch
                                                    <p id="lunch"></p>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group">
                                                                            <label class="col-md-3 control-label"></label>
                                                                            <div class="col-md-9">
                                                                                <div class="box box-default collapsed-box">
                                                                                    <div class="box-header with-border" style="background: #00A65A;color: #fff;">
                                                                                        <h3 class="box-title">Add Bonus</h3>
                                                                                        <div class="box-tools pull-right">
                                                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                                                        </div> /.box-tools 
                                                                                    </div> /.box-header 
                                                                                    <div class="box-body">
                                    
                                                                                        <div class="form-group ">
                                                                                            <label class="col-md-3">Salary Bonus Type</label>
                                                                                            <div class="col-md-9">
                                                                                                <select class="form-control select2"style="width:100%;" name="id_salary_bonus_type">
                                                                                                    <option>Select Bonus Type</option>
                                    <?php
                                    //foreach ($salary_bonus as $bonus) {
                                    ?>
                                                                                                        <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?></option>
                                    <?php // }
                                    ?>
                                                                                                </select>
                                                                                            </div>
                                    
                                                                                        </div> /.form-group 
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-3 control-label">Amount Salary Bonus</label>
                                                                                            <div class="col-md-9">
                                                                                                <input type="text" name="amount_salary_bonus" class="form-control" placeholder="Amount Salary Bonus" />
                                                                                            </div>
                                                                                        </div>
                                    
                                                                                                                                                <div class="form-group">
                                                                                                                                                    <label class="col-md-3 control-label"></label>
                                                                                                                                                    <div class="col-md-9">
                                                                                                                                                        <button type="submit" class="btn btn-sm btn-success"> Save</button>
                                                                                                                                                    </div>
                                                                                                                                                </div>
                                    
                                                                                    </div> /.box-body 
                                    
                                                                                </div> /.box 
                                    
                                                                            </div> /.col 
                                                                        </div>-->
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- end panel -->

                        <?php
                    } else if ($this->uri->segment(3) === 'edit') {
                        foreach ($edit_salary as $edit) {
                            ?>

                            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Salary Table</h4>
                                </div>
                                <div class="panel-body">
                                    <form target="_new" action="<?php echo base_url(); ?>index.php/Salary/update_salary_payment" method="post" class="form-horizontal" name="form">

                                        <div class="form-group ">
                                            <label class="col-md-3">Employee Name</label>
                                            <div class="col-md-9">


                                                <?php
                                                foreach ($employees as $employee) {
                                                    if ($employee->id_employee == $edit->id_employee) {
                                                        ?>

                                                        <p><?php echo $employee->name_employee; ?></p>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Month of Salary</label>
                                            <div class="col-md-9">
                                                <p><?php
                                                    if (($edit->month_salary_payment) == 1) {
                                                        echo 'January';
                                                    }
                                                    if (($edit->month_salary_payment) == 2) {
                                                        echo 'February';
                                                    }
                                                    if (($edit->month_salary_payment) == 3) {
                                                        echo 'March';
                                                    }
                                                    if (($edit->month_salary_payment) == 4) {
                                                        echo 'April';
                                                    }
                                                    if (($edit->month_salary_payment) == 5) {
                                                        echo 'May';
                                                    }
                                                    if (($edit->month_salary_payment) == 6) {
                                                        echo 'June';
                                                    }
                                                    if (($edit->month_salary_payment) == 7) {
                                                        echo 'July';
                                                    }
                                                    if (($edit->month_salary_payment) == 8) {
                                                        echo 'August';
                                                    }
                                                    if (($edit->month_salary_payment) == 9) {
                                                        echo 'September';
                                                    }
                                                    if (($edit->month_salary_payment) == 10) {
                                                        echo 'October';
                                                    }
                                                    if (($edit->month_salary_payment) == 11) {
                                                        echo 'November';
                                                    }
                                                    if (($edit->month_salary_payment) == 12) {
                                                        echo 'December';
                                                    }
                                                    ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Year of Salary</label>
                                            <div class="col-md-9">
                                                <p><?php echo $edit->year_salary_payment; ?></p>
                                                <input type="hidden" name="id_salary_payment" value="<?php echo $edit->id_salary_payment; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Issue Salary Payment</label>
                                            <div class="col-md-9">
                                                <p><?php echo date('d/m/Y', strtotime($edit->issue_salary_payment)); ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date Salary Payment</label>
                                            <div class="col-md-9">
                                                <input class="form-control datepicker" id="" placeholder="Date Salary Payment" name="date_salary_payment"  type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Amount of Salary</label>
                                            <div class="col-md-9">
                                                <p><?php echo $edit->amount_salary_payment; ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-9">
                                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>




                            <?php
                        }
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
<script type="text/javascript">
    document.forms['form'].elements['id_employee'].value = <?php echo $edit->id_employee; ?>;
    document.forms['form'].elements['month_salary_payment'].value = <?php echo $edit->id_employee; ?>;
    document.forms['form'].elements['status_salary_payment'].value = <?php echo $edit->status_salary_payment; ?>;

</script>



<?php include_once __DIR__ . '/../footer.php'; ?>
