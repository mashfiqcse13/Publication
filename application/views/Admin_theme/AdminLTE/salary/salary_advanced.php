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
                    if ($this->uri->segment(3) == '') {
                        if (!isset($employee_info)) {
                            ?>

                            <div class="col-md-12" style="margin-top: 10px;">
                                <?php
                                $attributes = array(
                                    'clase' => 'form-inline',
                                    'method' => 'post');
                                echo form_open('', $attributes)
                                ?>
                                <div class="form-group col-md-3 text-left">
                                    <label>Search with Date Range:</label>
                                </div>
                                <div class="form-group col-md-7">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                    </div><!-- /.input group -->
                                </div><!-- /.form group -->
                                <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                <button type="reset" name="btn_submit" value="true" class="btn btn-success"><i class="fa fa-refresh"></i></button>

                                <?= form_close(); ?>
                            </div>
                            <?php
                        }
                        if (!isset($date_range)) {
                            ?>
                            <div class="col-md-12">
                                <?php
                                $attributes = array(
                                    'clase' => 'form-inline',
                                    'method' => 'post');
                                echo form_open('', $attributes)
                                ?>
                                <div class="form-group ">
                                    <label class="col-md-3">Employee</label>
                                    <div class="col-md-7">
                                        <select class="form-control select2"style="width:100%;"  name="employee">
                                            <option>Select Employee</option>
                                            <?php
                                            foreach ($employees as $employee) {
                                                ?>
                                                <option value="<?php echo $employee->id_employee; ?>"><?php echo $employee->name_employee; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                            <?php
                            if (!isset($employee_info)) {
                                ?>
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-header" >
                                            <h1 class="text-center">Employee List of Salary Advance</h1>
                                        </div>
                                        <div class="box-body">
                                            <a href="<?php echo base_url(); ?>index.php/salary/salary_advanced/add" class="btn btn-primary" style="margin:5px;">Add Advance</a>
                                            <table id="example1" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Amount Given Salary Advance</th>
                                                        <th>Amount Paid Salary Advance</th>
                                                        <th>Salary Advance Given Date</th>
                                                        <th>Status of Salary Advance</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($salaries as $salary) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $salary->name_employee; ?></td>
                                                            <td><?php echo $salary->amount_given_salary_advance; ?></td>
                                                            <td><?php echo $salary->amount_paid_salary_advance; ?></td>
                                                            <td><?php echo $date = date('d/m/Y', strtotime($salary->date_given_salary_advance)); ?></td>
                                                            <td><?php echo ($salary->status_salary_advance == 1) ? ("Partially Paid") : ("full_paid"); ?></td>
                                                            <td>
                                                                <a href="<?php echo base_url(); ?>index.php/loan/loan/edit/<?php echo $salary->id_salary_advance; ?>" class="btn btn-success"><span class="glyphicon glyphicon-edit" ></span></a>
                                                                <a href="<?php echo base_url(); ?>index.php/loan/loan/add/<?php echo $salary->id_salary_advance; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash" ></span></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Amount Given Salary Advance</th>
                                                        <th>Amount Paid Salary Advance</th>
                                                        <th>Salary Advance Given Date</th>
                                                        <th>Status of Salary Advance</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                    if (isset($employee_info) || isset($date_range)) {
                        ?>
                    <div class="col-md-12" id="block">
                            <div class="box">
                                <div class="box-header">
                                    <h1 class="text-center"><strong>ABC Publications</strong></h1>
                                    <h3 class="text-center"><strong>Total Salary Paid</strong></h3>
                                    <?php
                                    if (isset($date_range)) {
                                        ?>
                                        <p class="pull-left" style="margin-left:20px"> <strong>Search Range: (From - To) </strong> <?php echo $date_range; ?></p>
                                        <?php
                                    } if (isset($employee_info)) {
                                        ?>
                                        <p class="pull-left" style="margin-left:20px"> <strong>Search Employee: </strong> <?php echo $employee_info; ?></p>
                                        <?php
                                    }
                                    ?>
                                    <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                        <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y',now());?></div>
                                </div>
                                <div class="box-body">
                                    <table  class ="table table-bordered table-hover" style="background: #fff;">
                                        <thead style="background: #DFF0D8;">
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Amount Given Salary Advance</th>
                                                <th>Amount Paid Salary Advance</th>
                                                <th>Salary Advance Given Date</th>
                                                <th>Status of Salary Advance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($salaries_search as $salary) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $salary->name_employee; ?></td>
                                                    <td><?php echo $salary->amount_given_salary_advance; ?></td>
                                                    <td><?php echo $salary->amount_paid_salary_advance; ?></td>
                                                    <td><?php echo $date = date('d/m/Y', strtotime($salary->date_given_salary_advance)); ?></td>
                                                    <td><?php echo ($salary->status_salary_advance == 1) ? ("Partially Paid") : ("full_paid"); ?></td>

                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

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

//                        echo $glosary->output;
            }
            ?>


        </div>

</div>
</div>




</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>