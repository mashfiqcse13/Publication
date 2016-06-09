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
    <section class="content" style="min-height: 800px">
        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <?php
                    if ($this->uri->segment(3) === 'add') {
                        ?>

                        <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                            <div class="panel-heading">
                                <h4 class="panel-title">Salary Table</h4>
                            </div>
                            <div class="panel-body">
                                <form target="_new" action="<?php echo base_url(); ?>index.php/Salary/save_salary_advance" method="post" class="form-horizontal" name="form">
                                    <div class="form-group ">
                                        <label class="col-md-3">Employee Name</label>
                                        <div class="col-md-9">
                                            <select class="form-control select2"style="width:100%;" name="id_employee" id="select">
                                                <option>Select Employee Name</option>
                                                <?php
                                                foreach ($employees as $employee) {
                                                    ?>
                                                    <option value="<?php echo $employee->id_employee; ?>"><?php echo $employee->name_employee; ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Amount Given Salary Advance</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="amount_given_salary_advance"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-sm btn-success" id="paid">Paid</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>




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