
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
            <li class="active">Stock section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php
//                if (!$date_filter) {
//                    $attributes = array(
//                        'clase' => 'form-inline',
//                        'method' => 'post');
//                    echo form_open('', $attributes)
                ?>
                <div class="form-group col-md-3 text-left">
                    <label>Search with Date Range:</label>
                </div>
                <form action="<?= $base_url ?>index.php/stock/stock_perpetual" method="get">
                    <div class="form-group col-md-7">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    <?php echo anchor(site_url('stock/stock_perpetual'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                </form>

            </div>

            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">
                        <h3 class="box-title">Stock Perpitual Current View</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php
                        echo $glosary->output;
                        ?>
                    </div><!-- /.box-body -->

                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->

<?php include_once __DIR__ . '/../footer.php'; ?>