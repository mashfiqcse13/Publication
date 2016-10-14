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
    <section class="content" style="min-height: 1200px;">
        <div class="row">
            <div class="col-md-12">

                <div class="box">
                    <?php
                    if ($this->uri->segment(3) == 'add') {
                        ?>
                        <div class="box-header">
                            <h1>Cash Transfer</h1>                        
                        </div>
                        <div class="box-body">
                            <?php
                            $attributes = array(
                                'class' => 'form-horizontal',
                                'name' => 'form',
                                'method' => 'post');
                            echo form_open('', $attributes)
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="col-md-3">Available Cash:</label>
                                        <div class="col-md-9" >

                                            <p id="cash"><?php echo $get_all_cash_info->balance; ?></p>

                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-3">Today Expense:</label>
                                        <div class="col-md-9" >
                                            <p id="expense"><?php echo $get_all_expense_info; ?></p>                                               
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="col-md-3">Transfer Amount:</label>
                                        <div class="col-md-9" >
                                            <?php
                                            $data = array(
                                                'name' => 'transfered_amount',
                                                'type' => 'number',
                                                'class' => 'form-control',
                                                'placeholder' => 'Transfer Maximum ' . $get_all_cash_info->balance,
                                                'max' => $get_all_cash_info->balance,
                                                'min' => '0',
                                            );

                                            echo form_input($data);
                                            ?>
                                            <!--<input type="number"  max="<?php echo $get_all_cash_info->balance; ?>" placeholder="Transfer Maximum <?php echo $get_all_cash_info->balance; ?>" class="form-control" name="transfered_amount" />-->
                                            <!--<span>* Maximum value <?php echo $get_all_cash_info->balance; ?></span>-->
                                        </div>
                                    </div>
                                    <input type="submit"  value="Save" name="submit" id="submit" class="btn btn-success pull-right" style="margin-right: 10px"/>
                                </div>
                            </div>
                            <?= form_close(); ?>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="box-header">
                            <?php
                            $attributes = array(
                                'class' => 'form-horizontal',
                                'name' => 'form',
                                'method' => 'get');
                            echo form_open('', $attributes)
                            ?>
                            <div class="row col-md-offset-2">
                                <div class="col-md-8 ">
                                    <div class="form-group ">
                                        <label class="col-md-3">Search with Date Range:</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                            </div><!-- /.input group -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    <?= anchor(current_url() . '', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                                </div>
                            </div>

                            <?= form_close(); ?>
                        </div>
                        <?php
                        if (!isset($date_range)) {
                            echo $glosary->output;
                        } else if (isset($date_range)) {
                            ?>
                            <div id="block">
                                <div class="box-header">
                                    <p class="text-center"><strong>Cash To Expense Adjustment Report</strong></p>
                                    <?php
                                    if (!empty($date_range)) {
                                        echo '<p class="pull-left" style="margin-left:20px"> ' . $this->Common->date_range_formater_for_report($date_range) . "</p>";
                                    }
                                    ?>

                                    <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                    <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y', now()); ?></div>
                                </div>
                                <div class="box-body">
                                    <table  class ="table table-bordered table-hover" style="background: #fff;">
                                        <thead style="background: #DFF0D8;">
                                            <tr>
            <!--                                        <th></th>-->
                                                <!--<th>Bank Name</th>-->
                                                <th>Transfer Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sum_total_amount = 0;
                                            foreach ($get_all_cash_to_bank_info as $rep) {
                                                $sum_total_amount += $rep->transfered_amount;
                                                ?>
                                                <tr>
            <!--                                                    <td><?php
                                                    echo $rep->name_bank;
                                                    echo ' - ' . $rep->account_number
                                                    ?></td>-->
                                                    <td  class="text-right faka_formate"><?php echo 'TK ' . $rep->transfered_amount; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($rep->date)); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <tr style="font-weight: bold">
                                                <td class="text-right">Total : <?php echo $sum_total_amount; ?></td>
                                                <td></td>


                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <?php
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
<!--<script type="text/javascript">

    var html = $('#expense').html();
    var cash = $('#cash').html();
    $('#amount').attr("placeholder", "Transfer Maximum " + cash + "tk");

    $('#amount').keyup(function (event) {
        var expense = Number(html);
        var cash_amount = Number(cash);
        var amount = $('#amount').val();
        if (amount > (expense - amount) || amount > cash_amount) {
            alert('You Have Crossed The Limit!!');
            $('#submit').click(function (e) {
                e.preventDefault();
            });

            $('#amount').css("border", "1px solid red");
            return false;
        } else if (amount <= (expense - amount) && amount <= cash_amount) {
            $('#submit').submit();
        }
    });

</script>-->