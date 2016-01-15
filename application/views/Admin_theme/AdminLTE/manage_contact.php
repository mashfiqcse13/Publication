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
            <small>Manage <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="btn btn- pull-right" title="Teacher Contact">Click here for Teacher Contact</a>
            </div>
            <div class="col-md-12">
                <div class="box">
                    <?php
                    echo $glosary->output;
                    ?>
                </div>
            </div>

            <?php if (isset($total_book_return_section)) { ?>
                <div class="col-md-3">
                    <label>Select Book Name :</label>
                </div>
                <div class="col-md-6">
                    <?= $book_returned_dropdown ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <label>Number of Returned Book :</label>
                </div>
                <div class="col-md-9" id="total_book_return">
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <label>Total Number of Returned Book :</label>
                </div>
                <div class="col-md-9">
                    <?= $total_book_returned ?>
                </div>
            <?php } ?>

        </div>












    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include_once 'footer.php'; ?>