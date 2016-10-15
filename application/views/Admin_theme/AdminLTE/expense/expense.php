<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper only_print">
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
    <section class="content" style="min-height:1250px;">
        <div class="row">
            <div class="col-md-12">

                <div class="box only_print">
                    <div class="box-body">
                        <?php
                        $attributes = array(
                            'clase' => 'form-inline',
                            'method' => 'post');
                        echo form_open('', $attributes)
                        //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                        ?>

                        <div class="form-group col-md-3 text-left">

                            <label>Search Report With Date Range:</label>
                        </div>
                        <div class="form-group col-md-5">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                <br>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        <div class="col-md-2">
                            <input type="checkbox" name="short_form" value="1" /><span style="font-weight: bold;"> Check For Head Wise</span>
                        </div>

                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <?= anchor(current_url() . '/expense', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                        <?= form_close(); ?>
                        <?php ?>
                    </div>
                </div>

                <div class="box" id="block">
                    <?php
                    if (!isset($date_range)) {
                        ?>


                        <div class="box-body">
                            <?php
                            echo $glosary->output;
                            ?>
                        </div><!-- /.box-body -->
                        <?php
                    }if (isset($date_range)) {
                        if (!isset($short_form)) {
                            ?>
                            <div class="box-header">
                                <p class="text-center"><strong>Expense Report</strong></p>
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
                                            <th>Expense Name</th>
                                            <th>Amount Expense</th>
                                            <th>Date Expense</th>
                                            <th>Description Expense</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sum_total_amount = 0;
                                        foreach ($report as $rep) {
                                            $sum_total_amount += $rep->amount_expense;
                                            ?>
                                            <tr>
                                                <td><?php echo $rep->name_expense; ?></td>
                                                <td class="taka_formate"><?php echo 'TK ' . $rep->amount_expense; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($rep->date_expense)); ?></td>
                                                <td><?php echo $rep->description_expense; ?></td>
                                                <td><?php echo $sum_total_amount; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>

                                        <tr style="font-weight: bold">
                                            <td>Total :</td>
                                            <td class="taka_formate"><?php echo $sum_total_amount; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td class="taka_formate"><?php echo $sum_total_amount; ?></td>


                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <?php
                        }if (isset($short_form)) {
                            ?>
                            <div class="box-header">
                                <p class="text-center"><strong>Income Report</strong></p>
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
                                            <th>Ledger Name</th>
                                            <th>Expense Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sum_total_amount = 0;
                                        for ($i = $max_expense_name->id_name_expense; $i >= 1; $i--) {
                                            if (!empty($report[$i][0])) {
                                                $sum_total_amount += $report[$i][0]->amount_expense;
                                                $total = $report[$i][0]->amount_expense;
                                                ?>
                                                <tr>
                                                    <td><?php echo $report[$i][0]->name_expense; ?></td>
                                                    <td class="taka_formate"><?php echo 'TK ' . $total; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <tr style="font-weight: bold">
                                            <td>Total :</td>
                                            <td class="taka_formate"><?php echo 'TK ' . $sum_total_amount; ?></td>
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
        <!--            <div class="row">
                        <div class="panel-body">
                           
        <?php if (isset($report)) { ?>
                                                                  <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
                                              <p class="text-center"> <?= $Title ?> Report</p>
                                              <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
                                                         <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>
            <?php
            echo $report;
        }
        ?> 
                        </div>
                    </div>-->




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->

<!--      <div class="report-logo-for-print">
                    <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
          <p class="text-center"> <?= $Title ?> Report</p>
          <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
<?php
if (isset($report)) {
    echo $report;
}
?> 
      </div>-->

<?php include_once __DIR__ . '/../footer.php'; ?>
