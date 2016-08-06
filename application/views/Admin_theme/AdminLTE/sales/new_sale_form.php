<!--add header -->
<script type="text/javascript">
    var customer_due = <?php echo json_encode($customer_due) ?>;
    var customer_current_balance = <?php echo json_encode($customer_current_balance) ?>;
    var item_details = <?php echo json_encode($item_details) ?>;
    var previously_paid = 0;
    var item_selection = new Array();
    var data_to_post = {
        'action': null,
        'id_customer': 0,
        'discount_percentage': 0,
        'discount_amount': 0,
        'sub_total': 0,
        'dues_unpaid': 0,
        'total_amount': 0,
        'customer_balance_reduction': 0,
        'cash_payment': 0,
        'bank_payment': 0,
        'bank_account_id': 0,
        'bank_check_no': '',
        'total_paid': 0,
        'total_due': 0,
        'item_selection': ''
    };
    var ajax_url = '<?php echo site_url('sales/ajax_url') ?>';
</script>
<?php include_once __DIR__ . '/../header.php'; ?>
<style>
    #remove_item{color: red}
</style>
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
        <!--massge box started-->
        <style>
            #massage_box{
                background-color: rgba(0, 0, 0, 0.5);
                color: white;
                height: 100%;
                left: 0;
                padding: 200px 50%;
                position: absolute;
                top: 0;
                width: 100%;
                z-index: 1077;
            }
        </style>
        <div ID="massage_box"><h1 class="msg_body">Processing......</h1></div>
        <!--massge box ended-->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-8">
                                <label for="id_contact">Party name</label> 
                                <a href="<?php echo site_url('contacts/index/add') ?>" class="btn btn-xs btn-default">Add New</a>
                                <?php echo $customer_dropdown ?>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="int_id_contact">Issue Date</label>
                                <input type="text" disabled="" value="<?php echo date("m/d/Y"); ?>" class="form-control" id="int_id_contact" placeholder="Password">
                            </div>

                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Payment info</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="discount_percentage">Discount percentage :</label>
                                <div class="input-group">
                                    <input type="email" name="discount_percentage" class="form-control" id="discount_percentage" value="0" min="0" max="100">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="discount_amount">Discount amount :</label>
                                <div class="input-group">
                                    <input type="number" name="discount_amount" class="form-control" id="discount_amount"  value="0" min="0">
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="discount_percentage">Dues Unpaid :</label> <span id="dues_unpaid">0</span> Tk
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="discount_percentage">Total amount :</label> <span id="total_amount">0</span> Tk
                            </div>
                            <div class="form-group col-lg-12" id="customer_current_balance">
                                <label for="discount_percentage">Previously paid :</label> <span>0</span> Tk
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="discount_amount">Cash payment :</label>
                                <div class="input-group">
                                    <input type="number" min="0" name="cash_payment" class="form-control" id="cash_payment" placeholder="Cash amount">
                                    <span class="input-group-addon">Tk</span>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <div id="bank_payment">
                                    <label for="discount_percentage">Bank payment :</label> <span>0</span> Tk <br>
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#bankTransactionForm">
                                        <i class="fa fa-plus"></i> Add
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal modal-primary fade" id="bankTransactionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Bank Transaction</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Note :</strong> If you use this form , this balance will be added to the account balance automatically as an approved transaction .</p>
                                                    <form class="form-horizontal" id="bankTransactionFormWrapper">
                                                        <div class="form-group">
                                                            <label for="bank_account" class="col-sm-4 control-label">Receiving Account</label>
                                                            <div class="col-sm-8">
                                                                <?php echo $bank_account_dropdown ?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bank_payment" class="col-sm-4 control-label">Amount</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="bank_payment" name="bank_payment" placeholder="Amount">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="check_no" class="col-sm-4 control-label">Check No</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" id="check_no" name="check_no" placeholder="Check No">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-outline" data-dismiss="modal">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6" id="total_paid">
                                <label for="discount_percentage">Total paid :</label> <span>0</span> Tk
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="discount_percentage">Total Due :</label> <span id="total_due">0</span> Tk
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-warning">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-8">
                                <label for="id_contact">Select Item</label>
                                <?php echo $item_dropdown ?>
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="int_id_contact">Quantity</label>
                                <div class="input-group input-group-sm">
                                    <input type="number" placeholder="Quantity" id="item_quantity" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info btn-flat" id="add_to_cart" type="button">Add</button>
                                    </span>
                                </div>
                                <span>
                                    <strong>Item Available : </strong>
                                </span>
                                <span id="total_in_hand">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-hover cart">
                            <thead>
                                <tr class="success">
                                    <th>Quantity</th>
                                    <th>Book Name</th>
                                    <th>Book Price</th>
                                    <th>Sales Price</th>
                                    <th>Total Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div id="item_selection_status">No Item selected yet</div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-12 text-center">
                <div class="box box-success">
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" class="btn btn-success submit_btn" data-action="save_and_reset">Save and Reset</button>
                        <button type="button" class="btn btn-success submit_btn" data-action="save_and_back_to_list">Save and Back to list</button>
                        <button type="button" class="btn btn-success submit_btn" data-action="save_and_print">Save and Print</button>
                    </div>
                </div>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>

<script type="text/javascript">
    $('#massage_box').hide();
    $('#customer_current_balance').hide();

    function string_to_int(input_field_value) {
        var integer_val = parseInt(input_field_value);
        return (isNaN(integer_val)) ? 0 : integer_val;
    }


    function update_cart() {
        var output = '', sub_total = 0;
        item_selection.forEach(function (item, index) {
            output += '<tr>\n\
                                <td>' + item.item_quantity + '</td>\n\
                                <td>' + item.name + '</td>\n\
                                <td>' + item.regular_price + '</td>\n\
                                <td>' + item.sale_price + '</td>\n\
                                <td>' + item.total + '</td>\n\
                                <td><a id="remove_item" onclick="remove_from_cart(' + item.item_id + ');" href="#" \n\
                                             data-item-id="' + item.item_id + '"\n\
                                             title="Remove ' + item.name + '">\n\
                                                <i class="fa fa-minus-circle"></i></a></td>\n\
                            </tr>';
            sub_total += item.total;
        });
        output += '<tr  style="font-weight: bold;border-top: 2px solid;">\n\
                                <td colspan="4" style="text-align: right;">Sub Total = </td>\n\
                                <td>' + sub_total + '</td>\n\
                                <td>Taka</td>\n\
                            </tr>';
        data_to_post.sub_total = sub_total;
        update_total_amount_and_total_due();
        data_to_post.item_selection = item_selection;
        $('table.cart tbody').html(output);
        $('#item_selection_status').html(' ');
        $('#discount_percentage').trigger('change');
    }

    $(".select2").select2({
        'width': '100%'
    });
    $("#add_to_cart").click(function () {
        var item_id = string_to_int($('[name="id_item"]').val());
        var item_quantity = string_to_int($('#item_quantity').val());
        if (item_id == 0) {
            alert('No book selected');
            return;
        }
        if (item_quantity == 0) {
            alert('Enter quantity');
            return;
        }
        var this_item_details = item_details[item_id];
        if (item_quantity > this_item_details.total_in_hand) {
            alert('Please don\'t select quantity bigger than ' + this_item_details.total_in_hand);
            return;
        }
        if (item_quantity < 1) {
            alert('Please don\'t select quantity smaller than 1');
            return;
        }
        item_selection[item_id] = {
            'item_id': item_id,
            'item_quantity': item_quantity,
            'name': item_details[item_id].name,
            'regular_price': item_details[item_id].regular_price,
            'sale_price': item_details[item_id].sale_price,
            'total': item_details[item_id].sale_price * item_quantity
        };
        update_cart();
    });
    $('[name="id_item"]').change(function () {
        $('#item_quantity').val('0');
        var id_item = $('[name="id_item"]').val();
        var this_item_details = item_details[id_item];
        $('#total_in_hand').html(this_item_details.total_in_hand);
    });
    $('[name="id_customer"]').change(function () {
        data_to_post.id_customer = $('[name="id_customer"]').val();
        data_to_post.dues_unpaid = string_to_int(customer_due[data_to_post.id_customer]);
        previously_paid = string_to_int(customer_current_balance[data_to_post.id_customer]);
        $('#dues_unpaid').html(data_to_post.dues_unpaid);
        if (previously_paid > 0) {
            $('#customer_current_balance').show();
            $('#customer_current_balance > span').html(previously_paid);
        } else {
            $('#customer_current_balance').hide();
        }
        update_total_amount_and_total_due();
    });

    $('#bankTransactionFormWrapper').change(function () {
        data_to_post.bank_account_id = string_to_int($('[name="id_account"]').val());
        data_to_post.bank_payment = string_to_int($('[name="bank_payment"]').val());
        data_to_post.bank_check_no = $('[name="check_no"]').val();
        console.log(data_to_post.bank_account_id);
        console.log(data_to_post.bank_payment);
        console.log(data_to_post.bank_check_no);
        $("#bank_payment > span").html(data_to_post.bank_payment);
        update_total_amount_and_total_due();
    });

    $('#discount_amount').change(function () {
        if (string_to_int(data_to_post.sub_total) > 0) {
            data_to_post.discount_amount = string_to_int($('#discount_amount').val());
            data_to_post.discount_percentage = string_to_int(data_to_post.discount_amount / string_to_int(data_to_post.sub_total) * 100);
        } else {
            data_to_post.discount_amount = 0;
            $('#discount_amount').val(data_to_post.discount_amount);
            data_to_post.discount_percentage = 0;
        }
        $('#discount_percentage').val(data_to_post.discount_percentage);
        update_total_amount_and_total_due();
    });
    $('#discount_percentage').change(function () {
        if (string_to_int(data_to_post.sub_total) > 0) {
            data_to_post.discount_percentage = string_to_int($('#discount_percentage').val());
            data_to_post.discount_amount = string_to_int(data_to_post.discount_percentage / 100 * string_to_int(data_to_post.sub_total));
        } else {
            data_to_post.discount_percentage = 0;
            $('#discount_percentage').val(data_to_post.discount_percentage);
            data_to_post.discount_amount = 0;
        }
        $('#discount_amount').val(data_to_post.discount_amount);
        update_total_amount_and_total_due();
    });
    function remove_from_cart(item_to_remove) {
        delete item_selection[item_to_remove];
        update_cart();
    }
    $('#cash_payment').change(function () {
        data_to_post.cash_payment = string_to_int($('#cash_payment').val());
        update_total_amount_and_total_due();
    });
    function update_total_amount_and_total_due() {
        data_to_post.total_amount = string_to_int(data_to_post.dues_unpaid)
                + string_to_int(data_to_post.sub_total)
                - string_to_int(data_to_post.discount_amount);
        data_to_post.total_paid = string_to_int(data_to_post.cash_payment) + string_to_int(data_to_post.bank_payment) + previously_paid;
        data_to_post.total_due = string_to_int(data_to_post.total_amount) - data_to_post.total_paid;
        $('#total_amount').html(data_to_post.total_amount);
        $('#total_due').html(data_to_post.total_due);
        $('#total_paid > span').html(data_to_post.total_paid);
    }

    $('.submit_btn').click(function () {
        if (data_to_post.total_paid > data_to_post.total_amount && (data_to_post.cash_payment > 0 || data_to_post.bank_payment > 0)) {
            alert('We are not allowed to accept extra money . Reduce the cash or bank payment .');
            return;
        }

        if (data_to_post.bank_payment > 0) {
            if (data_to_post.bank_account_id < 1) {
                alert('No account selected');
                return;
            }
            if (data_to_post.bank_check_no < 1) {
                alert('No check no given');
                return;
            }
        }

        if (data_to_post.id_customer < 1) {
            alert('No customer selected.');
            return;
        }

        if (data_to_post.sub_total < 1) {
            alert('No item selected . Please select one');
            return;
        }
        $(' #massage_box').show();
        data_to_post.action = $(this).data('action');
        $.post(ajax_url, data_to_post, function (data) {
            $(' #massage_box').fadeOut();
            alert(data.msg);
            window.location = data.next_url;
        }, 'json');
    });


</script>