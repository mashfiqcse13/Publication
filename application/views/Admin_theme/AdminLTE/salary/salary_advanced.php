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
    <section class="content" style="min-height: 1050px;">
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
                                    'method' => 'get');
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
                                <?= anchor(current_url() . '', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>

                                <?= form_close(); ?>
                            </div>
                            <?php
                        }
                        if (!isset($date_range)) {
                            ?>
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <?php
                                $attributes = array(
                                    'class' => 'form-inline',
                                    'name' => 'form',
                                    'method' => 'get');
                                echo form_open('', $attributes)
                                ?>
                                <div class="form-group col-md-3 text-left">
                                    <label>Employee</label>
                                </div>
                                <div class="form-group col-md-7">
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
                                <?= anchor(current_url() . '', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                                <?= form_close(); ?>
                            </div>
                            <?php
                        }
                    }
                    if (isset($employee_info) || isset($date_range)) {
                        ?>
                        <div class="col-md-12" id="block">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                                    <p class="text-center"> <?= $Title ?> Report</p>
                                    <div style="margin-bottom: 60px;">
                                        <p class="pull-left" style="margin-left:5px">Report Generated by: <?php echo $_SESSION['username'] ?></p>
                                        <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                    </div>
                                    <?php
                                    if (isset($date_range)) {
                                        ?>
                                        <p class="pull-left" style="margin-left:5px"> <strong>Date Range: (From - To) </strong> <?php echo $date_range; ?></p>
                                        <?php
                                    } if (isset($employee_info)) {
                                        ?>
                                        <p class="pull-left" style="margin-left:5px"> <strong>Employee Id:  </strong> <?php echo $employee_info; ?></p>
                                        <?php
                                    }
                                    ?>
                                    <div class="pull-right">Report Date: <?php echo date('Y-m-d H:i:s', now()); ?></div>
                                </div>
                                <div class="box-body">
                                    <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                                        <thead>
                                            <tr style="background:#ddd">
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
                    }if (!isset($date_range)) {
                        if ($this->uri->segment(3) === 'add') {
                            $attributes = array(
                                'class' => 'form-horizontal',
                                'name' => 'form',
                                'method' => 'post');
                            echo form_open('', $attributes)
                            ?>
                            <div class="box-header">
                                <h2>Add Salary Advance</h2>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group ">
                                            <label class="col-md-3">Amount Given Salary Advance:</label>
                                            <div class="col-md-9">
                                                <input type="text" placeholder="Amount" class="form-control" name="amount_given_salary_advance"/>
                                            </div>

                                        </div>
                                        <div class="form-group ">
                                            <label class="col-md-3">Employee Name:</label>
                                            <div class="col-md-9">
                                                <?php echo $employee_name; ?>
                                            </div>

                                        </div>
                                        <div class="form-group ">
                                            <label class="col-md-3">Status salary advance :</label>
                                            <div class="col-md-9">
                                                <select name="status_salary_advance" id="" class="form-control select2">
                                                    <option value="1">Active</option>
                                                    <option value="2">Inactive</option>
                                                </select>
                                            </div>

                                        </div>
                                        <button type="submit" name="btn_submit" value="true" class="btn btn-success pull-right">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close(); ?>
                            <?php
                        } else if (!isset($employee_info) || $this->uri->segment(3) === 'edit') {
                            echo $glosary->output;
                        }
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
    document.forms['form'].elements['employee'].value = "<?php echo $employee_info; ?>";
</script>