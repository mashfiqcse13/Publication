<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
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
            <li class="active">Insert Info</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <?php
                    if ($this->uri->segment(3) == 'add') {
                        $attributes = array(
                            'class' => 'form-horizontal',
                            'method' => 'get',
                            'name' => 'form',
                            'method' => 'post');
                        echo form_open('supply_info/save_info', $attributes)
                        ?>
                        <div class="box-header">
                            <h2>Insert Info</h2>
                        </div>
                        <div class="box-body">
                            <div class="form-group ">
                                <label class="col-md-3">Style No:</label>
                                <div class="col-md-9">
                                    <select name="id_supply_style_no" id="" class="form-control">
                                        <option value="">Select Style No</option>
                                        <?php
                                        foreach ($all_style_no as $style_no) {
                                            ?>
                                            <option value="<?php echo $style_no->style_no; ?>"><?php echo $style_no->style_no; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Session:</label>
                                <div class="col-md-9">
                                    <select name="id_supply_session" id="" class="form-control">
                                        <option value="">Select Session No</option>
                                        <?php
                                        foreach ($all_session as $session) {
                                            ?>
                                            <option value="<?php ?>"><?php echo $session->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Department:</label>
                                <div class="col-md-9">
                                    <select name="id_department" id="" class="form-control">
                                        <option value="">Select Department No</option>
                                        <?php
                                        foreach ($all_department as $department) {
                                            ?>
                                            <option value="<?php $department->id_department; ?>"><?php echo $department->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Style Description:</label>
                                <div class="col-md-9">
                                    <textarea name="style_description" class="form-control" id="" rows="5"></textarea>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Supplier:</label>
                                <div class="col-md-9">
                                    <select name="id_supplyer" id="" class="form-control">
                                        <option value="">Select Supplier</option>
                                        <?php
                                        foreach ($all_supplyer as $supplyer) {
                                            ?>
                                            <option value="<?php $supplyer->id_supplyer; ?>"><?php echo $supplyer->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Fit Name:</label>
                                <div class="col-md-9">
                                    <select name="id_supply_fit_name" id="fit_name" class="form-control">
                                        <option value="0">Select Fit Name</option>
                                        <?php
                                        foreach ($all_fit_name as $fit) {
                                            ?>
                                            <option value="<?php echo $fit->id_supply_fit_name; ?>"><?php echo $fit->name; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group " id="send">
                                <label class="col-md-3" >Send:</label>
                                <div class="col-md-9">
                                    <input type="" class="form-control datepicker" name="supply_fit_register_date_send" placeholder="Add Date"/>
                                </div>
                            </div>
                            <div class="form-group " id="receive">
                                <label class="col-md-3" >Receive:</label>
                                <div class="col-md-9">
                                    <input type="" class="form-control datepicker" name="supply_fit_register_date_receive" placeholder="Add Date"/>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Sample Result:</label>
                                <div class="col-md-9">
                                    <select name="sample_result" id="" class="form-control">
                                        <option value="">Select Sample Result</option>
                                        <option value="1">Pass</option>
                                        <option value="2">Fail</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Approved By:</label>
                                <div class="col-md-9">
                                    <select name="approved_by" id="" class="form-control">
                                        <option value="">Select Approved By</option>
                                        <option value="1">United Kingdom</option>
                                        <option value="2">Bangladesh</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Lab Test Report:</label>
                                <div class="col-md-9">
                                    <select name="lab_test_report" id="" class="form-control">
                                        <option value="">Select Lab Test Report</option>
                                        <option value="1">Pass</option>
                                        <option value="2">Fail</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Patter Block:</label>
                                <div class="col-md-9">
                                    <select name="pattern_block" id="" class="form-control">
                                        <option value="">Select Pattern Block</option>
                                        <option value="1">United Kingdom</option>
                                        <option value="2">Bangladesh</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label class="col-md-3">Remark:</label>
                                <div class="col-md-9">
                                    <textarea name="remark" class="form-control "id="" rows="5"></textarea>
                                </div>
                            </div>
                            <input type="submit"  value="Save" class="btn btn-primary pull-right"/>
                        </div>

                        <?= form_close(); ?>
                        <?php
                    } else if ($this->uri->segment(3) == 'edit') {
                        $attributes = array(
                            'class' => 'form-horizontal',
                            'method' => 'get',
                            'name' => 'form',
                            'method' => 'post');
                        echo form_open('supply_info/update_info', $attributes)
                        ?>
                        <div class="box-header">
                            <h2>Insert Info</h2>
                        </div>
                        <div class="box-body">
                            <?php
                            foreach ($all_supply_info as $value) {
                                ?>
                                <div class="form-group ">
                                    <label class="col-md-3">Style No:</label>
                                    <div class="col-md-9">
                                        <select name="id_supply_style_no" id="" class="form-control">
                                            <option value="">Select Style No</option>
                                            <?php
                                            foreach ($all_style_no as $style_no) {
                                                ?>
                                                <option value="<?php echo $style_no->style_no; ?>"><?php echo $style_no->style_no; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Session:</label>
                                    <div class="col-md-9">
                                        <select name="id_supply_session" id="" class="form-control">
                                            <option value="">Select Session No</option>
                                            <?php
                                            foreach ($all_session as $session) {
                                                ?>
                                                <option value="<?php ?>"><?php echo $session->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                            <input type="hidden" name="id_supply_info" value="<?php echo $value->id_supply_info; ?>" />
                                            <input type="hidden" name="id_fit" value="<?php echo $value->id_supply_fit_register; ?>" />
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Department:</label>
                                    <div class="col-md-9">
                                        <select name="id_department" id="" class="form-control">
                                            <option value="">Select Department No</option>
                                            <?php
                                            foreach ($all_department as $department) {
                                                ?>
                                                <option value="<?php $department->id_department; ?>"><?php echo $department->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Style Description:</label>
                                    <div class="col-md-9">
                                        <textarea name="style_description" class="form-control" id="" rows="5"><?php echo $value->style_description; ?></textarea>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Supplier:</label>
                                    <div class="col-md-9">
                                        <select name="id_supplyer" id="" class="form-control">
                                            <option value="">Select Supplier</option>
                                            <?php
                                            foreach ($all_supplyer as $supplyer) {
                                                ?>
                                                <option value="<?php $supplyer->id_supplyer; ?>"><?php echo $supplyer->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Fit Name:</label>
                                    <div class="col-md-9">
                                        <select name="id_supply_fit_name" id="fit_name" class="form-control">
                                            <option value="0">Select Fit Name</option>
                                            <?php
                                            foreach ($all_fit_name as $fit) {
                                                ?>
                                                <option value="<?php echo $fit->id_supply_fit_name; ?>"><?php echo $fit->name; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group " id="send">
                                    <label class="col-md-3" >Send:</label>
                                    <div class="col-md-9">
                                        <input type="" class="form-control datepicker" name="supply_fit_register_date_send" value="<?php echo $value->supply_fit_register_date_send; ?>" placeholder="Add Date"/>
                                    </div>
                                </div>
                                <div class="form-group " id="receive">
                                    <label class="col-md-3" >Receive:</label>
                                    <div class="col-md-9">
                                        <input type="" class="form-control datepicker" name="supply_fit_register_date_receive" value="<?php echo $value->supply_fit_register_date_receive; ?>" placeholder="Add Date"/>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Sample Result:</label>
                                    <div class="col-md-9">
                                        <select name="sample_result" id="" class="form-control">
                                            <option value="">Select Sample Result</option>
                                            <option value="1">Pass</option>
                                            <option value="2">Fail</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Approved By:</label>
                                    <div class="col-md-9">
                                        <select name="approved_by" id="" class="form-control">
                                            <option value="">Select Approved By</option>
                                            <option value="1">United Kingdom</option>
                                            <option value="2">Bangladesh</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Lab Test Report:</label>
                                    <div class="col-md-9">
                                        <select name="lab_test_report" id="" class="form-control">
                                            <option value="">Select Lab Test Report</option>
                                            <option value="1">Pass</option>
                                            <option value="2">Fail</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Patter Block:</label>
                                    <div class="col-md-9">
                                        <select name="pattern_block" id="" class="form-control">
                                            <option value="">Select Pattern Block</option>
                                            <option value="1">United Kingdom</option>
                                            <option value="2">Bangladesh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3">Remark:</label>
                                    <div class="col-md-9">
                                        <textarea name="remark" class="form-control "id="" rows="5"><?php echo $value->remark; ?></textarea>
                                    </div>
                                </div>
                                <input type="submit"  value="Update" class="btn btn-success pull-right"/>
                                <?php
                            }
                            ?>
                        </div>

                        <?= form_close(); ?>
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
<script type="text/javascript">
    $('.datepicker').datepicker();
    $('#send').hide();
    $('#receive').hide();
    $('#fit_name').change(function () {
        var select = $("#fit_name option:selected").val();
//        alert(select);
        if (select != 0) {
            $.post("<?php echo base_url(); ?>index.php/supply_info/fit_info", {"id_supply_fit_name": select});
            var id = select;
            $.ajax({
                url: '<?php echo base_url(); ?>index.php/supply_info/fit_info',
                data: {'id_supply_fit_name': id},
                dataType: 'text',
                type: 'POST',
                success: function (data) {
//                    alert(data);
                    var obj = $.parseJSON(data);
                    $.each(obj.supply_fit, function (i, fit) {
                        var fit_id = fit['id_supply_fit_name'];
                        var fit_name = fit['id_supply_fit_name'];
                        $('#send').show();
                        $('#send label').html(function () {
                            var fit_name = fit['name'];
                            return fit_name + " send date:";
                        });
                        $('#receive').show();
                        $('#receive label').html(function () {
                            var fit_name = fit['name'];
                            return fit_name + " receive date:";
                        });

                    });
                }
            });
        }
        if (select == 0) {
            $('#send').hide();
            $('#receive').hide();
        }
    });
    var currentLocation = window.location;
    alert(currentLocation);
</script>


