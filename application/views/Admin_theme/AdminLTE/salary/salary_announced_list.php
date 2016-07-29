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
                        <select name="year" id="" class="form-control pull-right" >
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
                <?= anchor(current_url() . '/salary/salary_announced', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                <?= form_close(); ?>
                <div  style="margin: 40px;">
                </div>
            </div>
            <div class="col-md-12" id="block">

                <div class="box">
                    <div class="box-body">
                        <?php
//                        if ($employees == null) {
//                            echo '<h1 class="text-center" >No Record Exist</h1>';
//                        } else {
//                            
                        ?>
                    </div>

                    <div class="box-header" >
                        <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                        <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                        <?php
                        $message = $this->session->userdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        $this->session->unset_userdata('message');

                        function set_month($value) {
                            if ($value == 1) {
                                return'<b>January</b>';
                            }
                            if ($value == 2) {
                                return'<b>February</b>';
                            }
                            if ($value == 3) {
                                return'<b>March</b>';
                            }
                            if ($value == 4) {
                                return'<b>April</b>';
                            }
                            if ($value == 5) {
                                return'<b>May</b>';
                            }
                            if ($value == 6) {
                                return'<b>June</b>';
                            }
                            if ($value == 7) {
                                return'<b>July</b>';
                            }
                            if ($value == 8) {
                                return'<b>August</b>';
                            }
                            if ($value == 9) {
                                return'<b>September</b>';
                            }
                            if ($value == 10) {
                                return'<b>October</b>';
                            }
                            if ($value == 10) {
                                return'<b>October</b>';
                            }
                            if ($value == 11) {
                                return'<b>November</b>';
                            }
                            if ($value == 12) {
                                return'<b>December</b>';
                            }
                        }
                        ?>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php
                        if (isset($month) && isset($year)) {
                            ?>
                            <h2 class="text-center">Salary Announcement of  <?php
                                echo set_month($month);
                                echo ' ';
                                echo $year;
                                ?></h2>
                            <?php
                        } else {
                            ?>
                            <h2 class="text-center">Salary Announcement of  <?php
                                echo date('F', now());
                                echo ' ';
                                echo date('Y', now());
                                ?></h2>
                            <?php
                        }
                        ?>
                        <form action="<?php echo base_url(); ?>index.php/Salary/save_announced" method="post" id="salary">
                            <table id="example1" class="table table-bordered table-hover">

                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <!--<th>Designation</th>-->
                                        <th>Basic</th>
                                        <th>Bonus</th>
                                        <th>Salary Announced or Not</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $sl = 0;
                                    foreach ($employees as $employee) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="id_employee[]" value="<?php echo $employee->id_employee; ?>">
                                                <?php echo $employee->name_employee; ?>
                                            </td>

                                                                        <!--<td id="click"><?php ?></td>-->
                                            <td>
                                                <input type="hidden" name="amount_salary_payment[]" value="<?php echo $employee->basic + $employee->medical + $employee->house_rent + $employee->transport_allowance + $employee->lunch; ?>">
                                                <?php echo $employee->basic + $employee->medical + $employee->house_rent + $employee->transport_allowance + $employee->lunch; ?>
                                            </td>
                                            <td style="display:none;">
                                                <input type="hidden" name="bonus_type[<?php echo $sl;?>]">
                                                <?php
//                                                value of month and year
                                                if (isset($month) && isset($year)) {
                                                    ?>
                                                    <input type="hidden" name="month" value="<?php echo $month; ?>">
                                                    <input type="hidden" name="year" value="<?php echo $year; ?>">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="hidden" name="month" value="<?php echo date('n', now()); ?>">
                                                    <input type="hidden" name="year" value="<?php echo date('Y', now()); ?>">
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <!--bonus and announce-->
                                            <?php
//                                                salary payment is announced or not
                                            if (isset($month) && isset($year)) { // search result 
                                                $value = $this->Salary_model->announce_by_month_year($employee->id_employee, $month, $year);
                                            } else {
                                                $value = $this->Salary_model->announce($employee->id_employee);
                                            }
                                            $current_month = date('n', now());
                                            //
//                                                if value is not null then bonus money and announced will be shown
                                            if ((empty($month) && empty($year))) {
                                                if (!empty($value)) {
//                                                    any value is exit in bonus table or not
                                                    $bonus = $this->Salary_model->bonus($value->id_salary_payment);
//                                                    ---------------
//                                                    if (isset($bonus->status_bonus_payment) && $value->month_salary_payment == $current_month) {
//                                                    if bonus status is exist then show bonus money
                                                    if (isset($bonus->status_bonus_payment)) {
                                                        ?>
                                                        <?php
                                                        if (empty($bonus->amount_salary_bonus) || $bonus->amount_salary_bonus == 0) {
                                                            ?>
                                                            <td>Bonus(0)</td>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <td>Bonus(<?php echo $bonus->amount_salary_bonus; ?>)</td>

                                                            <?php
                                                        }
//                                                        if bonus status is empty then show bonus type option
                                                    } if (empty($bonus->status_bonus_payment)) {
                                                        ?>

                                                        <td>
                                                            <select class="form-control select2"style="width:100%;" name="bonus_type[<?php echo $sl;?>]" id="bonus" required>
                                                                <option value="0">Select Bonus Type</option>
                                                                <?php
                                                                foreach ($bonus_type as $bonus) {
                                                                    if ($bonus->amount == null) {
                                                                        ?>
                                                                        <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(0)</option>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(<?php echo $bonus->amount; ?>)</option>

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </td>
                                                    <?php }
                                                    ?>
                                                    <td>
                                                        <?php
                                                        if (isset($value->status_salary_payment)) {                  //salary payment status is exist then show announce
                                                            if ($employee->id_employee == $value->id_employee) {        //if employee id and salary payment employee id is same then show announce
//                                                        
                                                                ?>
                                                                <label>Announced</label>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php
//                                                    if the value is empty option will be shown
                                                }if (empty($value)) {
                                                    ?>
                                                    <td>
                                                        <select class="form-control select2"style="width:100%;" name="bonus_type[<?php echo $sl;?>]" id="bonus" required>
                                                            <option value="0">Select Bonus Type</option>
                                                            <?php
                                                            foreach ($bonus_type as $bonus) {
                                                                if (empty($bonus->amount)) {
                                                                    ?>
                                                                    <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(0)</option>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(<?php echo $bonus->amount; ?>)</option>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td >
                                                        <label>
                                                            <input type="checkbox" name="status_salary_payment[]" value="<?php echo $employee->id_employee; ?>" id="check" > Announced
                                                        </label>
                                                    </td>
                                                    <?php
                                                }
                                            }
//                                                    <!--search result--> 
//                                                      if value is not null then bonus money and announced will be shown
                                            if (isset($month) && isset($year)) {
                                                if (!empty($value)) {
//                                                    any value is exit in bonus table or not
                                                    $bonus = $this->Salary_model->bonus($value->id_salary_payment);
//                                                    ---------------
                                                    if (isset($bonus->status_bonus_payment) && $value->month_salary_payment == $month && $value->year_salary_payment == $year) {
//                                                    if bonus status is exist then show bonus money
                                                        if (isset($bonus->status_bonus_payment)) {
                                                            ?>
                                                            <?php
                                                            if (empty($bonus->amount_salary_bonus) || $bonus->amount_salary_bonus == 0) {
                                                                ?>
                                                                <td>Bonus(0)</td>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <td>Bonus(<?php echo $bonus->amount_salary_bonus; ?>)</td>

                                                                <?php
                                                            }

//                                                        if bonus status is empty then show bonus type option
                                                        }
                                                        if (empty($bonus->status_bonus_payment) && empty($value->month_salary_payment) && empty($value->year_salary_payment)) {
                                                            ?>

                                                            <td>
                                                                <select class="form-control select2"style="width:100%;" name="bonus_type[<?php echo $sl;?>]" id="bonus" required>
                                                                    <option value="0">Select Bonus Type</option>
                                                                    <?php
                                                                    foreach ($bonus_type as $bonus) {
                                                                        if ($bonus->amount == null) {
                                                                            ?>
                                                                            <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(0)</option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(<?php echo $bonus->amount; ?>)</option>

                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        <?php }
                                                        ?>
                                                        <td>
                                                            <?php
                                                            if (isset($value->status_salary_payment)) {                  //salary payment status is exist then show announce
                                                                if ($employee->id_employee == $value->id_employee) {        //if employee id and salary payment employee id is same then show announce
//                                                        
                                                                    ?>
                                                                    <label>Announced</label>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <?php
//                                                    if the value is empty option will be shown
                                                    }
                                                }if (empty($value)) {
                                                    ?>
                                                    <td>
                                                        <select class="form-control select2"style="width:100%;" name="bonus_type[<?php echo $sl;?>]" id="bonus" required>
                                                            <option value="0">Select Bonus Type</option>
                                                            <?php
                                                            foreach ($bonus_type as $bonus) {
                                                                if (empty($bonus->amount)) {
                                                                    ?>
                                                                    <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(0)</option>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <option value="<?php echo $bonus->id_salary_bonus_type; ?>"><?php echo $bonus->name_salary_bonus_type; ?>(<?php echo $bonus->amount; ?>)</option>

                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td >
                                                        <label>
                                                            <input type="checkbox" name="status_salary_payment[]" value="<?php echo $employee->id_employee; ?>" id="check" > Announced
                                                        </label>
                                                    </td>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </tr>
                                        <?php
                                  $sl++;  }
                                    ?>



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Employee Name</th>
                                        <!--<th>Designation</th>-->
                                        <th>Basic</th>
                                        <th>Bonus</th>
                                        <th>Salary Announced or Not</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="submit" class="btn btn-sm btn-success pull-right" id="submit"> Save</button> 
                        </form>
                    </div>
                    <?php
//                    }
                    ?>
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