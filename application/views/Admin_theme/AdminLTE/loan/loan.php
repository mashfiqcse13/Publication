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
            <?php
            if ($this->uri->segment(3) == '') {
                ?>
                <div class="col-md-12">
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
                    <div  style="margin: 40px;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $attributes = array(
                            'clase' => 'form-inline',
                            'method' => 'post');
                        echo form_open('', $attributes)
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
                        $attributes = array(
                            'clase' => 'form-inline',
                            'method' => 'post');
                        echo form_open('', $attributes)
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
                    </div>
                </div>
                <!--</div>-->
                <div class="col-md-12" style="background: #fff;">
                    <div>
                        <div class="box-header" >
                            <h1 class="text-center">Employee List of Loan</h1>
                        </div>
                        <div class="box-body">
                            <a href="<?php echo base_url(); ?>index.php/loan/loan/add" class="btn btn-primary" style="margin:5px;">Add Loan</a>
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Loan Title</th>
                                        <th>Amount of Loan</th>
                                        <th>Date of Loan</th>
                                        <th>Loan Status</th>
                                        <th>Dead Line</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                foreach ($loans as $loan) {
                                    ?>
                                    <tr>
                                        <td><?php echo $loan->name_employee;?></td>
                                        <td><?php echo $loan->title_loan;?></td>
                                        <td><?php echo $loan->amount_loan;?></td>
                                        <td><?php echo $date = date('d/m/Y', strtotime($loan->date_taken_loan));         ?></td>
                                        <td><?php echo $loan->status;?></td>
                                        <td><?php echo date('d/m/Y', strtotime($loan->dead_line_loan));?></td>
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
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
                <?php
            }
            ?>
            <div class="col-md-12">

                <div class="box">

                    <?php
                    if ($this->uri->segment(3) === 'add' || $this->uri->segment(3) === 'edit') {
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