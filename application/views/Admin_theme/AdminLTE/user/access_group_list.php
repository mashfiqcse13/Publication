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
            <li class="active"><?= $Title ?> section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Title ?></h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <?php
                        if ($this->uri->segment(3) == '') {
                            echo anchor('users_info/user_access_group', '<span class="btn btn-primary"> <i class="fa fa-plus-circle"></i>  Users Access Group Add</span>');
                        }
                        if ($this->uri->segment(3) == 'edit') {
                            ?>
                            <div class="box-body">
                                <?php
                                $attributes = array(
                                    'clase' => 'form-inline',
                                    'method' => 'post');
                                echo form_open('', $attributes)
                                //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                                ?>
                                <?php
                                foreach ($get_all_group_info as $info) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Access Group Title : </label>
                                                <input type="text" class="form-control" name="access_group_title" value="<?php echo $info->user_access_group_title; ?>"/>
                                                <input type="hidden"  name="id_user_access_group" value="<?php echo $info->id_user_access_group; ?>"/>
                                                <?php
                                                $id = 1;
                                                foreach ($get_all_access_area as $check) {
                                                    ?>
                                                    <input type="text" name="id_user_group_elements[<?php echo $id; ?>]" value="<?php echo $check->id_user_group_elements; ?>" />
                                                    <?php
                                                    $id++;
                                                }
                                                ?>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="">Select Access Area : </label>                                        
                                                    </div>
                                                </div>

                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="select_all" /> Select All
                                                        <?php
                                                        echo $access_area;
                                                        ?> 
                                                    </div>
                                                </div>


                                            </div>




                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Description :</label>
                                                <textarea name="description" id="" class="textarea"><?php echo $info->user_access_group_description; ?></textarea>
                                            </div>

                                        </div>


                                    </div>
                                    <?php
                                }
                                ?>


                                <button type="submit" name="btn_submit" value="true" class="btn btn-primary pull-right">Update</button>

                                <?= form_close(); ?>

                            </div>
                            <?php
                        } else {
                            if ($this->session->userdata('user_access_message')) {
                                ?>
                                <div class="" >
                                    <div class="box box-default box-solid">
                                        <div class="box-header with-border">
                                            <?php
                                            echo $this->session->userdata('user_access_message');
                                            $this->session->unset_userdata('user_access_message');
                                            ?>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                            <!-- /.box-tools -->
                                        </div>

                                    </div>
                                    <!-- /.box -->
                                </div>
                                <?php
                            }
                            echo $glosary->output;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->
<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
    $('input[name = "access_area[]"]').each(function () {
        var test = $(this).val()
<?php foreach ($get_all_access_area as $check) { ?>
            var value = <?php echo $check->id_user_access_area; ?>;
            if (test == value) {
                $(this).attr('checked', true);
            }
<?php } ?>
    });

//    select all && unselect all
    $('#select_all').change(function () {
        var status = this.checked;
        $('.check').each(function () {
            this.checked = status;
        });
    });
    $('.check').change(function () {
        if (this.checked == false) {
            $('#selec_all')[0].checked = false;
        }
        if ($('.check:checked').length == $('.checkbox').length) {
            $('#select_all')[0].checked = true;
        }
    });
</script>