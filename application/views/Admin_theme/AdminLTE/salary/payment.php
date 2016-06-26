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
            <li class="active">Salary section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" style="min-height:1350px;" >
        <div class="row">
            <?php
                if($this->uri->segment(3) == 'add'){
            ?>
             <div class="col-md-12">
                <?php
                $attributes = array(
                    'clase' => 'form-inline',
                    'method' => 'get',
                    'name' => 'form');
                echo form_open('', $attributes)
                ?>
<!--                <div class="form-group col-md-3 text-left">
                    <label>Search month:</label>
                </div>-->
               <div class="form-group col-md-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <!--<input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>-->
                        <select name="month" id="" class="form-control pull-right">
                            <option value="">Select Month Here</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        

                    </div><!-- /.input group -->
                </div><!-- /.form group -->
                <div class="form-group col-md-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <!--<input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>-->
                        <select name="year" id="" class="form-control pull-right">
                            <option value="">Select Year</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                        

                    </div><!-- /.input group -->
                </div><!-- /.form group -->
                <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                <?= anchor(current_url() . '/salary/salary_payment', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                <?= form_close(); ?>
                <div  style="margin: 40px;">
                </div>
            </div>
            <?php
                }
            ?>
            <div class="col-md-12" id="block">

                <div class="box">
                    <?php
                    if ($this->uri->segment(3) === 'add') {
                        ?>
                        <div class="box-header">
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                            <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>

                        </div>
                        <div class="box-body">
                            <h2 class="text-center">Salary Payment</h2>
                            <form action="<?php echo site_url('salary/paid_salary_payment') ?>" method="post">
                                <table id="example1" class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Date of Issue</th>
                                            <th>Amount of Salary</th>
                                            <th>Amount of bonus</th>
                                            <th>Loan</th>
                                            <th>Loan Installment</th>
                                            <th>Advance</th>
                                            <th>Net Salary</th>
                                            <th>Paid or Not</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        foreach ($all_salary_info as $value) {
//                                        print_r($value);
                                            $salary = $value->amount_salary_payment;
                                            $bonus = $value->amount_salary_bonus;
                                            $total = $salary + $bonus;
                                            $loan_installment = $value->installment_amount_loan;
                                            $advance = $value->amount_given_salary_advance;
                                            $deduction = $loan_installment + $advance;
                                            $total = $total - $deduction;
                                            ?>
                                            <tr>
                                                <td><?php echo $value->name_employee; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($value->issue_salary_payment)); ?></td>
                                                <td><?php echo $value->amount_salary_payment; ?></td>
                                                <td><?php echo $value->amount_salary_bonus; ?></td>
                                                <td><?php echo $value->amount_loan; ?></td>
                                                <td><?php echo $value->installment_amount_loan; ?></td>
                                                <td><?php echo $value->amount_given_salary_advance; ?></td>
                                                <td><?php echo $total; ?></td>
                                                <td style="display: none;">
                                                    <input type="hidden" name="id_employee[]" value="<?php echo $value->id_employee; ?>"/>
                                                    <input type="hidden" name="id_loan[]" value="<?php echo $value->id_loan; ?>"/>
                                                    <input type="hidden" name="id_salary_advance[]" value="<?php echo $value->id_salary_advance; ?>"/>
                                                    <input type="hidden" name="amount_salary_payment[]" value="<?php echo $total; ?>"/>
                                                    <input type="hidden" name="paid_amount_loan_payment[]" value="<?php echo $value->installment_amount_loan; ?>"/>
                                                    <input type="hidden" name="amount_paid_salary_advance[]" value="<?php echo $value->amount_given_salary_advance; ?>"/>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($value->status_salary_payment == 2) {
                                                        ?>
                                                        <label for="">
                                                            PAID
                                                        </label>
                                                        <?php
                                                    } else if ($value->status_salary_payment == 1) {
                                                        ?>
                                                        <label for="">
                                                            <input type="checkbox" name="status[]" value="<?php echo $value->id_employee; ?>" /> paid
                                                        </label>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>

                                <button type="submit" class="btn btn-sm btn-success pull-right" id="submit"> Paid</button> 
                            </form>
                        </div>
                        <div class="box-body">
                            <?php
                        } else {
                            echo $glosary->output;
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
    $('#example2').DataTable();
//    document.forms['form'].elements['month'].value = "<?php echo $value->month_salary_payment;?>";

</script>