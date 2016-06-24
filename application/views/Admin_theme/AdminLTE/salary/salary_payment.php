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
                                <form target="_new" action="<?php echo site_url('/Salary/paid_salary_payment'); ?>" method="post" class="form-horizontal" name="form">
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
<script>
    $('#info').hide();
    $('#success').hide();
    
    //    alert(loan);
$.ajaxSetup({cache: false});
$('#select').change(function () {
    var select = $("#select option:selected").val();
    $.post("<?php echo base_url();?>index.php/salary/employee_salary", {"id_employee": select});
    var id = select;
    $.ajax({
        url: '<?php echo base_url();?>index.php/salary/employee_salary',
        data: {'id_employee': id},
        dataType: 'text',
        type: 'POST',
        success: function (data) {
//                alert(data);
//            for (var i = 0; i < data.length; i++) {
            var obj = $.parseJSON(data);
            $.each(obj.edit_salary, function (index, salary) {

//                alert(salary['amount_given_salary_advance']);

                function month() {
                    if (salary['month_salary_payment'] == 1) {
                        return 'January';
                    } else if (salary['month_salary_payment'] == 2) {
                        return 'February';
                    } else if (salary['month_salary_payment'] == 3) {
                        return 'March';
                    } else if (salary['month_salary_payment'] == 4) {
                        return 'April';
                    } else if (salary['month_salary_payment'] == 5) {
                        return 'May';
                    } else if (salary['month_salary_payment'] == 6) {
                        return 'June';
                    } else if (salary['month_salary_payment'] == 7) {
                        return 'July';
                    } else if (salary['month_salary_payment'] == 8) {
                        return 'August';
                    } else if (salary['month_salary_payment'] == 9) {
                        return 'September';
                    } else if (salary['month_salary_payment'] == 10) {
                        return 'October';
                    } else if (salary['month_salary_payment'] == 11) {
                        return 'November';
                    } else if (salary['month_salary_payment'] == 12) {
                        return 'December';
                    }
                }
                function announce() {
                    if (salary['amount_salary_bonus'] == 0) {
                        return "No Bonus";
                    } else {
                        return salary['amount_salary_bonus'];
                    }
                }

                function advance() {
                    if (salary['amount_given_salary_advance'] != null) {
                        return salary['amount_given_salary_advance'];
                    } else {
                        return 'No Advance';
                    }

                }
                function loan() {
                    if (salary['amount_loan'] != null) {
                        return salary['amount_loan'];
                    } else {
                        return 'No Loan';
                    }

                }


                function get_total() {
                    var payment, bonus, amount, advance, loan;
                    payment = Number(salary['amount_salary_payment']);
                    bonus = Number(salary['amount_salary_bonus']);
                    advance = Number(salary['amount_given_salary_advance']);
                    loan = Number(salary['amount_loan']);

                    amount = payment + bonus;
                    if (advance != null) {
                        amount = amount - advance;
                        return amount;
                    }
//                        
                    return amount;

                }

//                    var d = formatDate('MMM d, y');
//                    alert(object.status_salary_payment);
                //alert(Getstring(object['issue_salary_payment']));
//                    alert(salary['amount_loan']);

                $('#employee_id').val(salary['id_employee']);
                $('#loan_id').val(salary['id_loan']);
                $('#advance_id').val(salary['id_salary_advance']);
                $('#advance_amount').val(advance());

                if (salary['status_salary_payment'] == 1) {
//                        $('#total_discharge').attr('type', 'text');

                    var input = $('#loan').html();
//                        alert(input);
                    $('#info').show();
                    $('#month').html(month());
                    $('#year').html(salary['year_salary_payment']);
                    $('#issue').html(salary['issue_salary_payment']);
                    $('#aos').html(salary['amount_salary_payment']);
                    $('#aob').html(announce());
                    $('#advance').html(advance());
                    $('#total').html(get_total());
                    $('#pay').html(salary['amount_loan']);
                    if (salary['amount_loan'] != null) {
                        $('#loan').show();
                    } else {
                        $('#loan').hide();
                    }
                    $('#paid').show();
                    $('#success').hide();
                }
                if (salary['status_salary_payment'] == 2) {
                    $('#heanding_success').html('Already Paid!!' + get_total());
                    $('#salary_month').html(month());
                    $('#salary_year').html(salary['year_salary_payment']);
                    $('#salary_issue').html(salary['issue_salary_payment']);
                    $('#salary_date').html(salary['date_salary_payment']);
                    $('#salary_aos').html(salary['amount_salary_payment']);
                    $('#salary_aob').html(announce());
                    $('#salary_advance').html(advance());
                    $('#salary_loan_bill').html(loan());
                    $('#salary_total').html(get_total());
                    $('#pay').html(salary['amount_loan']);
//                       
                    $('#success').show();
                    $('#paid').hide();
                    $('#info').hide();
                }
                if (salary['status_salary_payment'] == '') {
                    $('#info').html('');
                    $('#paid').hide();
                }
            });
        }});
    return false;
});

$('#discharge').keyup(function () {
    var discharge = $("#discharge").val();
    var select = $('#employee_id').val();
//        var select = 4;
    $.post("<?php echo base_url();?>index.php/salary/employee_salary", {"id_employee": select});
    var id = select;
    $.ajax({
        url: '<?php echo base_url();?>index.php/salary/employee_salary',
        data: {'id_employee': id},
        dataType: 'text',
        type: 'POST',
        success: function (data) {
//                alert(data);
//            for (var i = 0; i < data.length; i++) {
            var obj = $.parseJSON(data);
            $.each(obj.edit_salary, function (index, salary) {
                function pay_loan() {
                    if (discharge != null) {
                        if (salary['amount_loan'] >= discharge) {
                            var loanAmount = salary['amount_loan'] - discharge;
                            return loanAmount
                        }
                        if (discharge > salary['amount_loan']) {
                            alert('Cross the limit!!');
                        }

                    } else {
                        return salary['amount_loan'];
                    }
                }
                function get_total() {
                    var payment, bonus, amount, advance, loan;
                    payment = Number(salary['amount_salary_payment']);
                    bonus = Number(salary['amount_salary_bonus']);
                    advance = Number(salary['amount_given_salary_advance']);
                    loan = Number(salary['amount_loan']);

                    amount = payment + bonus;
                    if (advance != null && discharge != null) {
                        amount = amount - advance;
                        amount = amount - discharge;
                        return amount;
                    }
                    if (advance != null) {
                        amount = amount - advance;
                        return amount;
                    }
                    if (discharge != null) {
                        amount = amount - discharge;
                        return amount;
                    }
//                        
                    return amount;

                }

                $('#amount_salary').val(get_total());
                $('#total').html(get_total());
                $('#pay').html(salary['amount_loan']);
                $('#remain').html(pay_loan());
            });
        }
//         loan = $(this).val();

    });
});
</script>