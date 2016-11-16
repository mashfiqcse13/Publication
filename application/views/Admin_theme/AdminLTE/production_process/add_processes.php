
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
            <li class="active">Customer section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $attributes = array(
                                    'clase' => 'form-inline',
                                    'method' => 'post',
                                    'id' => 'form',
                                    'name' => 'form');
                                echo form_open('', $attributes)
                                ?>
                                <div class="form-group">
                                    <label class="col-md-3">Item Name* :</label>
                                    <div class="input-group col-md-9">
                                        <?php
                                        $data[] = "Select Items By Name Or Code";
                                        foreach ($get_item as $item) {

                                            $data[$item->id_item] = $item->id_item . " ( ". $this->Common->en2bn($item->id_item) . ")  - " . $item->name;
                                        }
                                        echo form_dropdown('id_item', $data, '', ' class="form-control select2" ', 'required');
                                        ?>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Item Type* :</label>
                                    <div class="input-group col-md-9">
                                        <?php
                                        $data = array(
                                            "1" => "Book",
                                            "2" => "Cover",
                                        );
                                        echo form_dropdown('item_type', $data, '1', ' class="form-control select2" ', 'required');
                                        ?>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Order quantity* : </label>
                                    <div class="input-group col-md-9">
                                        <input type="text" class="form-control" name="order_quantity" placeholder="Order quantity" required="required" />
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-3">Vendor Name* :</label>
                                    <div class="input-group col-md-9">
                                        <?php
                                        $datas[''] = 'Select vendor by name or code';
                                        foreach ($get_vendor as $vendor) {
                                            $datas[$vendor->id_vendor] = $vendor->id_vendor . " ( ". $this->Common->en2bn($vendor->id_vendor) . ")  - " . $vendor->name . " ( {$vendor->type} ) ";
                                            //$datas[$vendor->child_id_process_steps] = $vendor->child_id_vendor . " - " . $vendor->child_vendor_name . " ( {$vendor->child_vendor_type} ) ";
                                        }
                                        echo form_dropdown('id_vendor', $datas, '', ' class="form-control select2" ', 'required');
                                        ?>
                                    </div>

                                </div>
                                <button type="submit" name="print" value="true" class="btn btn-primary">Save and Print</button>
                                <input value="Save and go back to list"  class="btn btn-info" type="submit" name="btn">
                                <input value="Cancel" class="btn btn-danger" id="cancel" type="button">
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
    $('#cancel').click(function () {
        var cancel = confirm("Are you sure to cancel?");
        if (cancel) {
            window.location = '<?php echo site_url('production_process'); ?>';
        }
    });
    function string_to_int(input_field_value) {
        var integer_val = parseInt(input_field_value);
        return (isNaN(integer_val)) ? 0 : integer_val;
    }
    $('#form').submit(function () {
        var id_item = $('[name="id_item"]').val();
        var id_vendor = $('[name="id_vendor"]').val();
        if (string_to_int(id_item) < 1) {
            alert("Select Item");
            return false;
        }
        if (string_to_int(id_vendor) < 1) {
            alert("Select Vendor");
            return false;
        }
        return true;

    });

</script>