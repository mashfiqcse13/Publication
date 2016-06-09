<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.2.0
    </div>
    <strong>Copyright &copy; 2014-<?php echo date("Y"); ?>
        <a href="<?= $this->config->item('SITE')['website'] ?>">
            <?= $this->config->item('SITE')['name'] ?>
        </a>.
    </strong>
    All rights reserved.Developed by <a href="<?= $this->config->item('DEVELOPER')['website'] ?>" target="_blank">
        <?= $this->config->item('DEVELOPER')['name'] ?>
    </a>.
</footer>

<!-- Control Sidebar -->
<?php include_once 'right_sidebar.php' ?>

<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo $theme_asset_url ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<?php if (isset($glosary)): ?>
    <!-- glosary crud js file -->
    <?php foreach ($glosary->js_files as $file): ?>

        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script type="text/javascript">
    $.widget.bridge('uibutton', $.ui.button);</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo $theme_asset_url ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo $theme_asset_url ?>plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?php echo $theme_asset_url ?>plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!--datatable-->
<script src="<?php echo $theme_asset_url ?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo $theme_asset_url ?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>


<!-- jvectormap -->
<script src="<?php echo $theme_asset_url ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?php echo $theme_asset_url ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<script src="<?= base_url() . $this->config->item('ASSET_FOLDER') ?>js/custom.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $theme_asset_url ?>plugins/knob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
<script src="<?php echo $theme_asset_url ?>plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?php echo $theme_asset_url ?>dist/js/app.min.js" type="text/javascript"></script>

<!-- datepicker -->
<script src="<?php echo $theme_asset_url ?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $theme_asset_url ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="<?php echo $theme_asset_url ?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src="<?php echo $theme_asset_url ?>plugins/fastclick/fastclick.min.js" type="text/javascript"></script>

<script src="<?php echo $theme_asset_url ?>date.js" type="text/javascript"></script>





<!-- AdminLTE App -->
<script src="<?php echo $theme_asset_url ?>dist/js/app.min.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $theme_asset_url ?>dist/js/pages/dashboard.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $theme_asset_url ?>dist/js/demo.js" type="text/javascript"></script>


<!-- For Add memo form validation -->
<script src="<?= base_url() . $this->config->item('ASSET_FOLDER') ?>js/memo-validation.js" type="text/javascript"></script>
<script src="<?php echo $theme_asset_url ?>plugins/select2/select2.full.min.js" type="text/javascript"></script>


<!-- For Add memo form validation -->
<script src="<?= base_url() . $this->config->item('ASSET_FOLDER') ?>js/memo-validation.js" type="text/javascript"></script>

<script type="text/javascript">
    //Date range picker
    $('#reservation').daterangepicker();
    //Initialize Select2 Elements
    $(".select2").select2({
        'width': '100%'
    });
    //datatables
    $('#example1').DataTable();
    // Datepicker
    $('.datepicker').datepicker();

    $('#info').hide();
    $('#success').hide();
//    $('#loan').hide();
//  var test =  $('#loan').placeholder();
//  alert(test);
    $('#discharge').keyup(function () {
        var discharge = $("#discharge").val();
        var select = $('#employee_id').val();
//        var select = 4;
        $.post("<?php echo base_url(); ?>index.php/salary/employee_salary", {"id_employee": select});
        var id = select;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/salary/employee_salary',
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
//    alert(loan);
    $.ajaxSetup({cache: false});
    $('#select').change(function () {
        var select = $("#select option:selected").val();
        $.post("<?php echo base_url(); ?>index.php/salary/employee_salary", {"id_employee": select});
        var id = select;
        $.ajax({
            url: '<?php echo base_url(); ?>index.php/salary/employee_salary',
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

//                        $('#info').html('<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Month of Salary' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + month() + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Year of Salary' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + salary['year_salary_payment'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Issue Salary Payment' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + salary['issue_salary_payment'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Amount of Salary' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + salary['amount_salary_payment'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Amount of Bonus' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + announce() + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Amount of Advance' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + advance() + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Amount of Discharge' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + '<input type="text" id="discharge" class="form-control" name="amount_loan" value=""/>' + '</p>' + '</div>' + '</div>'+ '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Rest of Loan' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + '<input type="text" id="discharge" class="form-control" name="amount_loan" value=""/>' + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Total' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + get_total() + '</p>' + '</div>' + '</div>');
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
//                        $('#success').html('<h1 class="text-center">Already Paid!!' + get_total() + '</h1>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Month of Salary' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + month() + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Year of Salary' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + salary['year_salary_payment'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Issue Salary Payment' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + salary['issue_salary_payment'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Date Salary Payment' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + salary['date_salary_payment'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Amount of Salary' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + salary['amount_salary_payment'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Amount of Bonus' + '</label>'
//                                + '<div class="col-md-9">' + '<p>' + announce() + '</p>' + '</div>' + '</div>' + '<b style="border-top:3px solid black;">' + '<hr>' + '</b>' + '<h3 class="text-center">Deduction</h3>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Advance' + '</label>'
//                                + '<div class="col-md-9">' + '<p >' + advance() + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Loan' + '</label>'
//                                + '<div class="col-md-9">' + '<p >' + loan()+'</p>' + '</div>' + '</div>' + '<span style="border-top:3px solid black;">' + '<hr>' + '</span>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Total Amount Payable' + '</label>'
//                                + '<div class="col-md-9">' + '<h3>' + get_total() + '</h3>' + '</div>' + '</div>');
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
    $('#msg').fadeOut(5000);
//    $("#salary").on("change", "input:checkbox", function(){
//        $("#salary").submit();
//    });

    /*     
     * Add collapse and remove events to boxes
     */
    $("[data-widget='collapse']").click(function (e) {
        e.preventdefault;
        //Find the box parent        
        var box = $(this).parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });
//        due management Property
    $('[name="buyer_id"]').change(function () {
        var buyer_id = $('[name="buyer_id"]').val();
        alert("<?php echo site_url('admin/total_due/') ?>/" + buyer_id);
//        $.ajax({
//            url: "<?php echo site_url('admin/total_due/') ?>/" + buyer_id,
//            cache: false
//        }).done(function (data) {
//                    $("#total_due").html(data);
//                });
    });
</script>
<?php if (isset($scriptInline)) echo $scriptInline; ?>

<?php
if (isset($script)) {
    echo $script;
}
?>


</body>
</html>
