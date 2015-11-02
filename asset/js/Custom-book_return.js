/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$('#field-issue_date').val(CurrentDate);

$('[name="returned_book_ID"]').change(function () {
    $.ajax({
        url: "http://thejamunapub.com/Publication/index.php/admin/total_book_return/" + $('[name="returned_book_ID"]').val(),
        beforeSend: function (xhr) {
            xhr.overrideMimeType("text/plain; charset=x-user-defined");
        }
    })
            .done(function (data) {
                $("#total_book_return").html(data);
            });
});
