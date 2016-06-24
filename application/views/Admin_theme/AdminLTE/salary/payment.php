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
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <?php 
                        if ($this->uri->segment(3) === 'add') {
                    ?>
                    <div class="box-body">
                        <form action="">
                            <table id="example1" class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Date of Issue</th>
                                        <th>Amount of Salary</th>
                                        <th>Amount of bonus</th>
                                        <th>Loan</th>
                                        <th>Advance</th>
                                        <th>Net Salary</th>
                                        <th>Paid or Not</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($all_salary_info as $value) {
                                        $salary = $value->amount_salary_payment;
                                        $bonus = $value->amount_salary_bonus;
                                        $total = $salary + $bonus;
                                        $loan = $value->amount_loan;
                                        $advance = $value->amount_given_salary_advance;
                                        $deduction = $loan + $advance;
                                        $total = $total - $deduction;
                                        
                                        ?>
                                        <tr>
                                            <td><?php echo $value->name_employee; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($value->issue_salary_payment)); ?></td>
                                            <td><?php echo $value->amount_salary_payment; ?></td>
                                            <td><?php echo $value->amount_salary_bonus; ?></td>
                                            <td><?php echo $value->amount_loan; ?></td>
                                            <td><?php echo $value->amount_given_salary_advance; ?></td>
                                            <td><?php echo $total;?></td>
                                            <td>
                                                <label for="">
                                                    <input type="checkbox" /> paid
                                                </label>
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                        <button type="submit" class="btn btn-sm btn-success pull-right" id="submit"> Paid</button> 
                    </div>
                    <?php 
                        }else{
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