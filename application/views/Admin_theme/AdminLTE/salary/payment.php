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
                                            $loan_installment = $value->installments_amount_loan;
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
                                                <td><?php echo $value->installments_amount_loan; ?></td>
                                                <td><?php echo $value->amount_given_salary_advance; ?></td>
                                                <td><?php echo $total; ?></td>
                                                <td style="display: none;">
                                                    <input type="hidden" name="id_employee[]" value="<?php echo $value->id_employee; ?>"/>
                                                    <input type="hidden" name="id_loan[]" value="<?php echo $value->id_loan; ?>"/>
                                                    <input type="hidden" name="id_salary_advance[]" value="<?php echo $value->id_salary_advance; ?>"/>
                                                    <input type="hidden" name="amount_salary_payment[]" value="<?php echo $total; ?>"/>
                                                    <input type="hidden" name="paid_amount_loan_payment[]" value="<?php echo $value->paid_amount_loan_payment; ?>"/>
                                                    <input type="hidden" name="amount_paid_salary_advance[]" value="<?php echo $value->amount_paid_salary_advance; ?>"/>
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
</script>