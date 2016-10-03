<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<style>
    #table_custom .table td.separator {
        background: black none repeat scroll 0 0;
        height: 3px;
        padding: 0;
    }
    #table_custom .table td.left_separator {
        border-left: 2px solid;
        font-weight: bold;
        text-align: right;
    }
    .report_payment tr td:nth-child(2) {
        text-align: right;
    }
</style>


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
                            'method' => 'get');
                        echo form_open(site_url('sales/memo_report'), $attributes)
                        //echo form_open(base_url() . "index.php/bank/management_report", $attributes)
                        ?>

                        <div class="form-group col-md-2 text-left">

                            <label>Search By Memo:</label>
                        </div>
                        <div class="form-group col-md-3">

                            <?php echo $memo_list; ?>


                        </div><!-- /.form group -->

                        <button type="submit" name="btn_submit" value="true" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <?= anchor(site_url('sales/tolal_sales'), '<i class="fa fa-refresh"></i>', ' class="btn btn-success"') ?>



                        <?= form_close(); ?>
                        <?php ?>
                    </div>
                </div>

                <div class="box">
                    <?php if (isset($memo_header_details)) { ?>

                        <div id="table_custom" style="background:#ddd">



                            <div class="container memo_print_option" style="background:#fff;width:100%;min-height:793px;padding:25px 40px;margin-top:30px;font-size:15px;margin:10px auto;box-shadow:0px -1px 8px #000;" >





                                <div class="row" style="padding-top:50px">



                                    <div style="padding:0px 0px 10px 0px">

                                        <input class="only_print  btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>
                                        <p class="pull-right">Report Date :<?php echo date('Y:m:d') ?> </p>        
                                    </div>
                                    <table class="table table_custom" style="font-size:13px">


                                        <tr>

                                            <td><strong>Name:</strong></td>

                                            <td><?= $memo_header_details['party_name'] ?></td>



                                            <td><strong>Code No:</strong></td>

                                            <td><?= $memo_header_details['code'] ?></td>



                                            <td><strong>Memo No:</strong></td>

                                            <td><?= $memo_header_details['memoid'] ?></td>

                                        </tr>

                                        <tr>

                                            <td><strong>Mobile:</strong></td>

                                            <td> <?= $memo_header_details['phone'] ?></td>



                                            <td><strong>District:</strong></td>

                                            <td><?= $memo_header_details['district'] ?></td>



                                            <td><strong>Date:</strong></td>

                                            <td><?php echo " " . $memo_header_details['issue_date'] ?></td>

                                        </tr>

                                    </table>
                                </div>



                                <div class="row" style="font-size:16px;">


                                    <?php echo $memo_body_table['memo']; ?>  

                                </div>
<!--
                                <div class="row">

                                    <?php
                                    if (isset($check_dues_payment)) {
                                        echo $check_dues_payment['table1'];
                                        echo $check_dues_payment['table2'];
                                    }
                                    ?>

                                </div>-->
                            </div>

                        </div>

                    <?php } ?>
                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->
<div class="report-logo-for-print">
    <h3 class="text-center"><?= $this->config->item('SITE')['name'] ?></h3>
    <p class="text-center"> <?= $Title ?> Report</p>
    <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
    <?php if (isset($memo_header_details)) { ?>

        <div id="table_custom" style="background:#ddd">



            <div class="container memo_print_option" style="background:#fff;width:100%;min-height:793px;padding:5px 40px;margin-top:0px;font-size:15px;margin:10px auto;box-shadow:0px -1px 8px #000;" >





                <div class="row" style="padding-top:50px">



                    <div style="padding:0px 0px 10px 0px">

                        <input class="only_print  btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>
                        <p class="pull-right">Report Date :<?php echo date('Y:m:d') ?> </p>        
                    </div>
                    <table class="table table_custom" style="font-size:13px">


                        <tr>

                            <td><strong>Name:</strong></td>

                            <td><?= $memo_header_details['party_name'] ?></td>



                            <td><strong>Code No:</strong></td>

                            <td><?= $memo_header_details['code'] ?></td>



                            <td><strong>Memo No:</strong></td>

                            <td><?= $memo_header_details['memoid'] ?></td>

                        </tr>

                        <tr>

                            <td><strong>Mobile:</strong></td>

                            <td> <?= $memo_header_details['phone'] ?></td>



                            <td><strong>District:</strong></td>

                            <td><?= $memo_header_details['district'] ?></td>



                            <td><strong>Date:</strong></td>


                            <td><?php echo " " . $memo_header_details['issue_date'] ?></td>

                        </tr>

                    </table>
                </div>



                <div class="row" style="font-size:16px;">


                    <?php echo $memo_body_table['memo']; ?>    

                </div>
<!--
                <div class="row">

                    <?php
                    if (isset($check_dues_payment)) {
                        echo $check_dues_payment['table1'];
                        echo $check_dues_payment['table2'];
                    }
                    ?>

                </div>-->
            </div>

        </div>

    <?php } ?>
</div>

<?php include_once __DIR__ . '/../footer.php'; ?>
      

