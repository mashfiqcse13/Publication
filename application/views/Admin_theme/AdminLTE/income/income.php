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
    <section class="content">
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

                        <div class="form-group col-md-4 text-left">

                            <label>Search Report With Date Range:</label>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="date_range" value="<?= isset($date_range) ? $date_range : ''; ?>" class="form-control pull-right" id="reservation"  title="This is not a date"/>
                                <br>
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->

                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <?= anchor(current_url() . '/income', '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>
                        <?= form_close(); ?>
                        <?php ?>
                    </div>
                </div> 

                <div class="box" id="block">
                    <?php
                    if (isset($income_report)) {
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
                                        <th>Name Of Income</th>                                        
                                        <th>Date of Income</th>
                                        <th>Amount of Income</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_income=0; foreach($income_report as $report){ $total_income+=$report->amount_income; ?>
                                    
                                    <tr>
                                        <td><?=$report->name_expense?></td>                                         
                                        <td><?= date('d-M-Y',strtotime($report->date_income))?></td>
                                        <td class="taka_formate text-right"><?=$report->amount_income?></td>
                                    </tr>
                                        
                                    <?php }        ?>
                                    <tr>
                                        <td class="text-right text-bold" colspan="2">Total:</td>
                                        <td class="taka_formate text-right text-bold"  ><?=$total_income?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="box-header">
                            <h3 class="box-title">Income</h3>
                        </div><!-- /.box-header -->

                        <div class="box-body">
                            <?php
                            echo $glosary->output;
                            ?>
                        </div><!-- /.box-body -->
                        <?php
                    }
                    ?>

                </div>
            </div>





    </section><!-- /.content -->
</div><!-- /.content-wrapper -->



<?php include_once __DIR__ . '/../footer.php'; ?>