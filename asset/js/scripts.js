/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//alert('sonjoy');
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
                $('#loan_history').prepend('<p>'+loan['date_taken_loan']+'  '+'('+loan['amount_loan']+')'+' Taken'+'<br/>'+loan['payment_date_loan_payment']+'  '+'('+loan['paid_amount_loan_payment']+')'+' Given'+'<br/>'+'</p>');
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
$(function(){
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
    
    $('#refresh').click(function(){
        $('#reservation').empty();
    });
//    return false;
//});

