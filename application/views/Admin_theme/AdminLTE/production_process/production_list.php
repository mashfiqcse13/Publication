
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
                        <a href="<?php echo site_url('production_process/add_processes'); ?>" class="btn bg-purple btn-flat" style="margin-bottom: 20px;"><i class="fa fa-plus-circle"></i> Add Production Process</a>
                        <table id="example3" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Process Type</th>
                                    <th>Item Name</th>
                                    <th>Date Created</th>
                                    <th>Date Finished</th>
                                    <th>Order Amount</th>
                                    <th>Total Received By S. Store </th>
                                    <th>Total damaged item </th>
                                    <th>Total reject item </th>
                                    <th>Total missing item </th>
                                    <th>Process Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($production_process as $process) {
                                    ?>
                                    <tr>
                                        <td><?php echo $process->id_processes; ?></td>
                                        <td><?php echo $process->process_type; ?></td>
                                        <td><?php echo $process->name; ?></td>
                                        <td><?php echo $process->date_created; ?></td>
                                        <td><?php echo $process->date_finished; ?></td>
                                        <td><?php echo $process->order_quantity; ?></td>
                                        <td><?php echo $process->actual_quantity; ?></td>
                                        <td><?php echo $process->total_damaged_item; ?></td>
                                        <td><?php echo $process->total_reject_item; ?></td>
                                        <td><?php echo $process->total_missing_item; ?></td>
                                        <td><?php
                                            if ($process->process_status == 1) {
                                                echo '<span class="label label-warning">Ongoing</span>';
                                            } else if ($process->process_status == 2) {
                                                echo '<span class="label label-success">Finished</span>';
                                            } else if ($process->process_status == 3) {
                                                echo '<span class="label label-danger">Rejected</span>';
                                            }
                                            ?></td>
                                        <td><a href="<?php echo site_url('production_process/steps/' . $process->id_processes); ?>" class="btn btn-primary">Steps</a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->


<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
    $('#example3').DataTable({
        scrollX: true,
        bFilter: false,
        order: [[0, "desc"]]
    });
</script>
<style>
    .box-body {
        overflow-x: hidden!important;
    }
</style>