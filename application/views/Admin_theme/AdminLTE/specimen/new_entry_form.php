<!--add header -->
<script type="text/javascript">
    var item_details = <?php echo json_encode($item_details) ?>;
    var item_selection = new Array();
    var data_to_post = {
        'action': null,
        'id_agent': 0,
        'item_selection': ''
    };
    var ajax_url = '<?php echo site_url('specimen/ajax_url') ?>';
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
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-lg-8">
                                <label for="id_contact">Select Agent/Marketing Officer Name</label>
<!--                                <a href="<?php echo site_url('contacts/agents/add') ?>" class="btn btn-xs btn-default">Add New Agent</a> -->
                                <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#AddAgent">Add New Agent</button>
                                
                                    <div class="modal modal-primary fade" id="AddAgent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Add New Agent</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <iframe src="<?php echo site_url('contacts/agents/add')?>" frameborder="0" width="100%" height="500"></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="" class="btn btn-outline pull-left">Close and Reload</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
<!--                                <a href="<?php echo site_url('contacts/marketing_officer/add') ?>" class="btn btn-xs btn-default">Add New Marketing Office</a>-->
                                <button class="btn btn-xs btn-default" data-toggle="modal" data-target="#AddMarketing">Add New Marketing</button>
                                
                                        <div class="modal modal-primary fade" id="AddMarketing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Add New marketing officer</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <iframe src="<?php echo site_url('contacts/marketing_officer/add')?>" frameborder="0" width="100%" height="500"></iframe>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="" class="btn btn-outline pull-left">Close and Reload</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                
                                <?php echo $agent_dropdown ?>
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
            </div>
            <div class="col-md-12">
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
        data_to_post.item_selection = item_selection;
        $('table.cart tbody').html(output);
        $('#item_selection_status').html(' ');
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
        $('#item_quantity').val("");
        var id_item = $('[name="id_item"]').val();
        var this_item_details = item_details[id_item];
        $('#total_in_hand').html(this_item_details.total_in_hand);
    });
    $('[name="id_agent"]').change(function () {
        data_to_post.id_agent = $('[name="id_agent"]').val();
    });
    function remove_from_cart(item_to_remove) {
        delete item_selection[item_to_remove];
        update_cart();
    }

    $('.submit_btn').click(function () {
        if (data_to_post.total_paid > data_to_post.total_amount) {
            alert('We are not allowed to accept extra money . Reduce the cash .');
            return;
        }
        if (data_to_post.id_agent < 1) {
            alert('No agent selected.');
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
//            alert(data.msg);
            window.location = data.next_url;
        }, 'json');
    });


</script>