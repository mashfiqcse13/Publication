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
                        $attributes = array(
                            'clase' => 'form-inline',
                            'method' => 'post');
                        echo form_open('', $attributes)
                        //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                        ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Access Group Title : </label>
                                    <input type="text" class="form-control" name="access_group_title" value=""/>
                                </div>
                                <br><br>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Description :</label>
                                    <textarea name="description" id="" class="form-control textarea"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="">Select Access Area : </label>                                        
                                </div>
                            </div>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <label><input type="checkbox" id="select_all" /> Select All</label>
                                </div>
                            </div>
                            <div class="col-lg-10 col-lg-offset-2">
                                <div class="form-group">
                                    <div class="checkbox"></div>
                                    <?php
                                    echo $access_area;
                                    ?> 
                                </div>
                            </div>
                        </div>


                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary pull-right">Submit</button>

                        <?= form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->
<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
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