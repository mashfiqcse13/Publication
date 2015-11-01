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
            <small>manage <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Contact Management</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <?php
                    echo $glosary->output;
                    ?>
                </div>
            </div>

            <?php if (isset($total_book_return_section)) { ?>
                <div class="col-md-8 col-md-offset-2 form-inline">

                    <div class="form-group">
                        <label>Book name:</label>
                        <div class="input-group">
                            <?= $book_returned_dropdown ?>
                        </div><!-- /.input group -->
                    </div><!-- /.form group -->
                </div>
                <div class="col-md-8 col-md-offset-2 form-inline">
                    <div class="form-group">
                        <label>Total Book Returned :</label>
                        <div class="input-group" id="total_book_return">
                        </div><!-- /.input group -->
                    </div><!-- /.form group123 -->
                </div>
            <?php } ?>

        </div>












    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include_once 'footer.php'; ?>