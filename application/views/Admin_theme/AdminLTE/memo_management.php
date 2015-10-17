<!--add header -->
<?php include_once 'header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $Title ?>
            <small><?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Contact Management</li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?php if (!$date_filter) { ?>
                    <div class="form-group">
                        <label>Date range:</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right" id="reservation" />
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                <?php } ?>
            </div>
            <div class="col-md-12">

                <div class="box">

                    <?php
                    echo $glosary->output;
                    ?>

                </div>

            </div>

            <?php if (isset($total_due_section)) { ?>
                <div class="col-md-8 col-md-offset-2 form-inline">

                    <div class="form-group">
                        <label>Party name:</label>
                        <div class="input-group">
                            <?= $contact_dropdown ?>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <div class="form-group">
                        <label>Total Due:</label>
                        <div class="input-group" id="total_due">
                        </div><!-- /.input group -->
                    </div><!-- /.form group123 -->
                </div>
            <?php } ?>
        </div>


    </section><!-- /.content -->
    <script type="text/javascript">
    </script>
</div><!-- /.content-wrapper -->

<?php include_once 'footer.php'; ?>
