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
    <section class="content" style="min-height: 1000px">
        <div class="row">
            <?php
            if ($this->uri->segment(3) == '') {
                if (!isset($employee_info) && !isset($status)) {
                    ?>
                    <div class="col-md-12">
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
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $attributes = array(
                            'clase' => 'form-inline',
                            'method' => 'post');
                        echo form_open('', $attributes);
                        if (!isset($employee_info) && !isset($date_range)) {
                            ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3">Payment Status</label>
                                    <div class="col-md-7">
                                        <select class="form-control select2"style="width:100%;"  name="payment_status">
                                            <option>Select Payment</option>
                                            <option value="paid">Paid</option>
                                            <option value="not_paid">Not paid</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>

                                </div>
                            </div>

                            <?= form_close(); ?>

                            <?php
                        }
                        $attributes = array(
                            'clase' => 'form-inline',
                            'method' => 'post');
                        echo form_open('', $attributes);
                        if (!isset($status) && !isset($date_range)) {
                            ?>
                            <div class="col-md-6">
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
                            </div>

                            <?= form_close(); ?>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <!--</div>-->
                <?php
                if (!isset($date_range) && !isset($status) && !isset($employee_info)) {
                    ?>
                    <div class="col-md-12" style="background: #fff;">
                        <?php echo $glosary->output; ?>
                        <!--                        <div>
                                                    <div class="box-header" >
                                                        <h1 class="text-center">Loan List</h1>
                                                    </div>
                                                    <div class="box-body">
                                                        <a href="<?php echo site_url('/loan/loan/add'); ?>" class="btn btn-primary" style="margin:5px;">Add Loan</a>
                                                        <table id="example1" class="table table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Loan Title</th>
                                                                    <th>Amount of Loan</th>
                                                                    <th>Date of Loan</th>
                                                                    <th>Loan Status</th>
                                                                    <th>Dead Line</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                        <?php
                        foreach ($loans as $loan) {
                            ?>
                                                                                    <tr>
                                                                                        <td><?php echo $loan->name_employee; ?></td>
                                                                                        <td><?php echo $loan->title_loan; ?></td>
                                                                                        <td><?php echo $loan->amount_loan; ?></td>
                                                                                        <td><?php echo $date = date('d/m/Y', strtotime($loan->date_taken_loan)); ?></td>
                                                                                        <td><?php echo $loan->status; ?></td>
                                                                                        <td><?php echo date('d/m/Y', strtotime($loan->dead_line_loan)); ?></td>
                                                                                        <td>
                                                                                            <a href="<?php echo base_url(); ?>index.php/loan/loan/edit/<?php echo $loan->id_loan; ?>" class="btn btn-success"><span class="glyphicon glyphicon-edit" ></span></a>
                                                                                            <a href="<?php echo base_url(); ?>index.php/loan/loan/loan_delete/<?php echo $loan->id_loan; ?>" class="btn btn-danger" id="delete"><span class="glyphicon glyphicon-trash" ></span></a>
                                                                                        </td>
                                                                                    </tr>
                            <?php
                        }
                        ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Employee Name</th>
                                                                    <th>Loan Title</th>
                                                                    <th>Amount of Loan</th>
                                                                    <th>Date of Loan</th>
                                                                    <th>Loan Status</th>
                                                                    <th>Dead Line</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                        
                                                </div>-->

                    </div>
                    <?php
                }
                if (isset($date_range) || isset($status) || isset($employee_info)) {
                    ?>
                    <div class="col-md-12" style="background: #fff;" id="block">
                        <div>
                            <div class="box-header" >
                                <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                                <p class="text-center"> <?= $Title ?> Report</p>
                                <div style="margin-bottom: 60px;">
                                    <p class="pull-left" style="margin-left:5px">Report Generated by: <?php echo $_SESSION['username'] ?></p>
                                    <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                </div>
                                <div style="color: #777777;">
                                    <?php
                                    if (isset($date_range)) {
                                        ?>
                                        <p class="pull-left" style="margin-left:5px"> <strong>Date Range: (From - To) </strong> <?php echo $date_range; ?></p>
                                        <?php
                                    } if (isset($employee_info)) {
                                        ?>
                                        <p class="pull-left" style="margin-left:5px"> <strong>Employee Id:  </strong> <?php echo $employee_info; ?></p>
                                        <?php
                                    } if (isset($status)) {
                                        ?>
                                        <p class="pull-left" style="margin-left:5px"> <strong>Status </strong> <?php echo $status; ?></p>
                                        <?php
                                    }
                                    ?>
                                    <div class="pull-right">Report Date: <?php echo date('Y-m-d H:i:s', now()); ?></div>
                                </div>
                            </div>
                            <div class="box-body">
                                <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                                    <thead>
                                        <tr style="background:#ddd">
                                            <th>Employee Name</th>
                                            <th>Amount of Loan</th>
                                            <th>Date of Loan</th>
                                            <th>Loan Status</th>
                                            <th>Dead Line</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($loans_search as $loan) {
                                            ?>
                                            <tr>
                                                <td><?php echo $loan->name_employee; ?></td>
                                                <td><?php echo $loan->amount_loan; ?></td>
                                                <td><?php echo $date = date('d/m/Y', strtotime($loan->date_taken_loan)); ?></td>
                                                <td><?php echo $loan->status; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($loan->dead_line_loan)); ?></td>

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
            }
            ?>
            <div class="col-md-12">

                <div class="box">

                    <?php
                    if ($this->uri->segment(3) === 'add') {
                        $attributes = array(
                            'class' => 'form-horizontal',
                            'name' => 'form',
                            'method' => 'post');
                        echo form_open('', $attributes)
                        ?>
                        <div class="box-header">
                            <h2>Add Loan</h2>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="col-md-3">Employee Name:</label>
                                        <div class="col-md-9">
                                            <?php echo $employee_name; ?>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-3">Title Loan:</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Title Loan" class="form-control" name="title_loan" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-3">Amount Loan:</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Amount Loan" class="form-control" name="amount_loan" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-3">Installment Amount Loan:</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Installment Amount Loan" class="form-control" name="installment_amount_loan" required=""/>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-3">Dead Line Loan:</label>
                                        <div class="col-md-9">
                                            <input type="text" placeholder="Dead Amount Loan" class="form-control" id="date" name="dead_line_loan" required=""/>
                                        </div>
                                    </div>  
                                    <button type="submit" name="btn_submit" value="true" class="btn btn-success pull-right">Save</button>
                                </div>
                            </div>
                        </div>
                        <?= form_close(); ?>
                        <?php
                    } else if ($this->uri->segment(3) === 'edit' || $this->uri->segment(3) === 'success') {
                        echo $glosary->output;
                    }
                    ?>

                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<script>

</script>
<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>
<script type="text/javascript">
    $('#date').datepicker();
</script>
