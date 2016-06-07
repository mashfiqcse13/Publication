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
            <li class="active"><?php echo $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">

                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Memo haveing due for <strong>"<?php echo $customer_name; ?>"</strong></h3>
                    </div>
                    <div class="box-body">
                        <?php
                        echo $due_detail_table;
                        ?>

                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Due Payment Amount</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open(); ?>
                        <div class="input-group input-group-lg">
                            <input type="number" class="form-control" name="amount" value="0" min='1' max="<?php echo $customer_total_due; ?>">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat">Pay</button>
                            </span>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>
<script>
    $('.table tbody').append('<tr style="border-top: 3px solid #d5d5d5;"><td colspan="6" class="text-center">Total Due =</td><td><?php echo $customer_total_due ?></td></tr>');
</script>