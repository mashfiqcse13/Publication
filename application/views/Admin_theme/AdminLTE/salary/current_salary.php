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
                <?= anchor(current_url() . '/salary/current_salary_payment', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                <?= form_close(); ?>
                <div  style="margin: 40px;">
                </div>
            </div>
            <div class="col-md-12" id="block">

                <div id="employee_table" style="margin-top: 50px;">
                    <div class="box">
                        <div class="box-body">
                            <?php
                            if ($all_salary_info == null) {
                                echo '<h1 class="text-center" >No Record Exist</h1>';
                            } else {
                                ?>
                            </div>

                            <div class="box-header">
                                <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                                <p class="text-center"> <?= $Title ?> Report</p>
                                <div style="margin-bottom: 60px;">
                                    <p class="pull-left" style="margin-left:5px">Report Generated by: <?php echo $_SESSION['username'] ?></p>
                                    <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                </div>
                                <div style="color: #777777;">
                                    <!--<p class="pull-left" style="margin-left:5px"> <strong>Month : </strong> <?php echo date('F', now()); ?></p>-->
                                    <div class="pull-right">Report Date: <?php echo date('Y-m-d H:i:s', now()); ?></div>
                                </div>
                            </div>
                            <div class="box-body">

                                <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                                    <thead>
                                        <tr style="background:#ddd">
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
                                                <td>
                                                    <?php
                                                    if ($value->status_salary_payment == 2) {
                                                        ?>
                                                        <label for="">
                                                            PAID
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

                            </div>
                        <?php }
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
    document.forms['form'].elements['month'].value = "<?php echo $month; ?>";
    document.forms['form'].elements['year'].value = "<?php echo $year; ?>";
</script>