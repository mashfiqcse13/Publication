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
                        <form target="_new" action="<?php echo site_url('/Salary/paid_salary_payment'); ?>" method="post" class="form-horizontal" name="form">
                            <div class="form-group ">
                                <label class="col-md-3">Employee Name</label>
                                <div class="col-md-9">
                                    <select class="form-control select2"style="width:100%;" name="id_employee" id="loan_select">
                                        <option value="0">Select Employee Name</option>
                                        <?php
                                        foreach ($employees as $employee) {
                                            ?>
                                            <option value="<?php echo $employee->id_employee; ?>"><?php echo $employee->name_employee; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div id="block">
                                <div id="loan_info">
                                    <h1 class="text-center">Loan History of Employee</h1>
                                    <!--<h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>-->
                                    <!--<p class="text-center"> <?= $Title ?> Report</p>-->
                                    <div style="margin-bottom: 60px;">
                                        <p class="pull-left" style="margin-left:5px">Report Generated by: <?php echo $_SESSION['username'] ?></p>
                                        <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Employee Name :</label>
                                        <div class="col-md-9">
                                            <p  id="employee_name"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Total Amount of Loan Taken :</label>
                                        <div class="col-md-9">
                                            <p  id="total_loan"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Loan History  :</label>
                                        <div class="col-md-9" id="loan_history">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Last Loan Status  :</label>
                                        <div class="col-md-9">
                                            <p id="loan_status"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Total Loan Payment :</label>
                                        <div class="col-md-9">
                                            <p  id="loan_payment"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Remaining Loan Amount :</label>
                                        <div class="col-md-9">
                                            <p  id="remain_loan"></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"> Loan Payment Date :</label>
                                        <div class="col-md-9" id="loan_payment_date">

                                        </div>
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

<script type="text/javascript">
    $('#loan_info').hide();
    $.ajaxSetup({cache: false});
    $('#loan_select').change(function () {
        $('#loan_info').hide();
        var select = $("#loan_select option:selected").val();
//        alert(select);
        if (select != 0) {
            $.post("<?php echo base_url(); ?>index.php/loan/loan_info", {"id_employee": select});
            var id = select;
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/loan/loan_info',
                data: {'id_employee': id},
                dataType: 'text',
                type: 'POST',
                success: function (data) {
                    if(data!= null){
                    var sum = 0;
                    var total_payment = 0;
                    var remain_amount = 0;
                    var j = '';

                    var obj = $.parseJSON(data);
                    $('#loan_history').empty();
                    $('#loan_payment_date').empty();
                    $.each(obj.loan_info, function (i, loan) {
//                    alert(loan['id_loan']);
                            $('#loan_info').show();
                            sum = sum + Number(loan['amount_loan']);
                            total_payment = total_payment + Number(loan['paid_amount_loan_payment']);
                            remain_amount = sum - total_payment;
                            date = loan['date_taken_loan'];

//                        
                            $('#employee_name').html(loan['name_employee']);
                            $('#total_loan').html(sum);
                            $('#loan_history').prepend('<p>' + loan['date_taken_loan'] + '  ' + '(' + loan['amount_loan'] + ')' + ' Taken' + '<br/>' + loan['payment_date_loan_payment'] + '  ' + '(' + loan['paid_amount_loan_payment'] + ')' + ' Given' + '<br/>' + '</p>');
                            $('#loan_status').html(loan['status']);
                            $('#loan_payment').html(total_payment);
                            $('#remain_loan').html(remain_amount);
                            $('#loan_payment_date').prepend('<p>' + loan['payment_date_loan_payment'] + '</p>');

                         
                        ++j;
                    });
        }
                }});
            return false;
        }
        if (select == 0) {          //if select option has value 0
            $('#loan_info').hide();
        }
    });
</script>