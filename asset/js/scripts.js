/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//alert('sonjoy');
//footer part



$('#info').hide();
$('#success').hide();

//    $('#loan').hide();
//  var test =  $('#loan').placeholder();
//  alert(test);
$('#discharge').keyup(function () {
    var discharge = $("#discharge").val();
    var select = $('#employee_id').val();
//        var select = 4;
    $.post(baseURL +"index.php/salary/employee_salary", {"id_employee": select});
    var id = select;
    $.ajax({
        url: baseURL +'index.php/salary/employee_salary',
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
    $.post(baseURL +"index.php/salary/employee_salary", {"id_employee": select});
    var id = select;
    $.ajax({
        url: baseURL +'index.php/salary/employee_salary',
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
$('#msg').fadeOut(5000);

///////////////////////////////////////////////




$('#loan_info').hide();
$.ajaxSetup({cache: false});
$('#loan_select').change(function () {
    var select = $("#loan_select option:selected").val();
    $.post(baseURL + "index.php/loan/loan_info", {"id_employee": select});
    var id = select;
    $.ajax({
        url: baseURL + 'index.php/loan/loan_info',
        data: {'id_employee': id},
        dataType: 'text',
        type: 'POST',
        success: function (data) {
//            console.log(data);
//            alert(data.hasOwnProperty('id_employee').length);
//           alert(Object.keys(data[0].id_employee));

            var sum = 0;
            var total_payment = 0;
            var j = '';

            var obj = $.parseJSON(data);
//            alert(Object.keys(obj['loan_info'].id_employee));
//            alert(obj.hasOwnProperty('id_employee'));
//            alert(Object.keys(obj[0]).length);
//            for (var i = 0; i < obj; i++) {
            $('#loan_history').empty();
            $('#loan_payment_date').empty();
            $.each(obj.loan_info, function (i, loan) {
//                alert(obj.loan_info[i].id_employee.length)
//                alert(i.length)
//                console.log(index, loan);
//                alert(index['date_taken_loan']);
                $('#loan_info').show();
//                for(var i = 0; i <= loan['id_employee'].length; i++){obj.loan_info[j].date_taken_loan
//                j = j + loan['date_taken_loan'] + '<br/>';
//                alert(j);
                sum = sum + Number(loan['amount_loan']);
                total_payment = total_payment + Number(loan['paid_amount_loan_payment']);
                date = loan['date_taken_loan'];


                $('#total_loan').html(sum);
                $('#loan_history').prepend('<p>' + loan['date_taken_loan'] + '  ' + '(' + loan['amount_loan'] + ')' + ' Taken' + '<br/>' + loan['payment_date_loan_payment'] + '  ' + '(' + loan['paid_amount_loan_payment'] + ')' + ' Given' + '<br/>' + '</p>');
                $('#loan_status').html(loan['status']);
                $('#loan_payment').html(total_payment);
                //$('#loan_payment_date').append('<p>'+loan['payment_date_loan_payment']+'</p>');
//                }
//                alert(sum);
//                $('#loan_info').html('<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Total Amount of Loan Taken' + '</label>'
//                        + '<div class="col-md-9">' + '<p>' + sum + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Loan Taken History' + '</label>'
//                        + '<div class="col-md-9">' + loan['date_taken_loan'] + '<br/>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Last Loan Status' + '</label>'
//                        + '<div class="col-md-9">' + '<p>' + loan['status'] + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Total Loan Payment' + '</label>'
//                        + '<div class="col-md-9">' + '<p>' + total_payment + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + ' Loan Payment Date' + '</label>'
//                        + '<div class="col-md-9">' + '<p>' + loan['payment_date_loan_payment'] + '</p>' + '</div>' + '</div>');
//                        + '<div class="col-md-9">' + '<p>' + advance() + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Amount of Discharge' + '</label>'
//                        + '<div class="col-md-9">' + '<p>' + '<input type="text" id="discharge" class="form-control" name="amount_loan" value=""/>' + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Rest of Loan' + '</label>'
//                        + '<div class="col-md-9">' + '<p>' + '<input type="text" id="discharge" class="form-control" name="amount_loan" value=""/>' + '</p>' + '</div>' + '</div>' + '<div class="form-group">' + '<label class="col-md-3 control-label">' + 'Total' + '</label>'
//                        + '<div class="col-md-9">' + '<p>' + get_total() + '</p>' + '</div>' + '</div>');

                ++j;
            });

//        }
        }});
    return false;
});


//$('#employee_table').hide();
//$.ajaxSetup({cache: false});
//$('#month_select').change(function () {
//    var select = $("#month_select option:selected").val();
//    $.post(baseURL + "index.php/salary/current", {"month_salary_payment": select});
//    var month = select;
$(function () {
    $.ajax({
        url: baseURL + 'index.php/salary/current',
//        data: {'month_salary_payment': month},
        dataType: 'text',
        type: 'POST',
        success: function (data) {
//            console.log(data);
//           
            var obj = $.parseJSON(data);
            $('#current_salary_info').empty();
            $.each(obj.current_salary, function (i, salary) {
                function status() {
                    if (salary['status_salary_payment'] == 1) {
                        return  'Announced';
                    } else if (salary['status_salary_payment'] == 2) {
                        return  'paid';
                    }
                }

                $('#employee_table').show();
                $('#current_salary_info').append('<tr>' + '<td>' + salary['name_employee'] + '</td>' + '<td>' + salary['amount_salary_bonus'] + '</td>' + '<td>' + salary['amount_salary_payment'] + '</td>' + '<td>' + salary['date_salary_payment'] + '</td>' + '<td>' + status() + '</td>' + '</tr>');
            });

//        }
        }});
});

$('#refresh').click(function () {
    $('#reservation').empty();
});


//    return false;
//});

