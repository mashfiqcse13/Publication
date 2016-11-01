
<!--add header -->

<?php include_once __DIR__ . '/../header.php'; ?>



<!-- Left side column. contains the logo and sidebar -->



<!-- Content Wrapper. Contains page content -->







    <div class="container memo_print_option custom_memo"  >



        <div id="block">

            <div class="row" style="padding-top:0px;margin-top:14mm">


                <?php
                foreach ($party_advance as $party) {
                    ?>
                    <h4 class="text-center">Advance Payment Slip</h4>
                    <table class="table table-border table_custom" style="font-size:13px">

                        <tr>

                            <td><strong>Party Name:</strong></td>

                            <td><?php echo $party->name; ?></td>



                            <td><strong>Code No:</strong></td>

                            <td><?php echo $party->id_customer; ?></td>



                            <td><strong>Transection Id:</strong></td>

                            <td><?php echo $party->id_party_advance_payment_register; ?></td>

                        </tr>

                        <tr>

                            <td><strong>Mobile:</strong></td>

                            <td><?php echo $party->phone; ?></td>



                            <td><strong>District:</strong></td>

                            <td><?php echo $party->district; ?></td>



                            <td><strong>Date:</strong></td>

                            <td><?php echo $party->date_payment; ?></td>

                        </tr>

                    </table>

                </div>



                <div class="row" style="font-size:16px;">



                    <table class="table table-border table_custom">
                        <tr>
                            <th>Payment Method</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        <tr>
                            <td><?php
                                if ($party->id_payment_method == 1) {
                                    echo 'CASH';
                                } elseif ($party->id_payment_method == 3) {
                                    echo 'BANK';
                                }
                                ?></td>
                            <td class="text-right taka_formate">TK <?php echo $party->amount_paid; ?></td>
                        </tr>
                    </table>


                    <?php
                }
                ?>

                <?php if (isset($due_report_list)) { ?>                        
                    <h4 class="text-center">Due Payment Report</h4>
                    <table  class ="table table-bordered table-striped" border="0" cellpadding="4" cellspacing="0" style="background: #fff;">
                        <tr>
                            <th>Memo No:</th>

                            <th>Payment Method</th>
                            <th>Payment Date</th>
                            <th>Paid Amount</th>
                        </tr>

                        <?php
                        $total_amount = 0;
                        foreach ($due_report_list as $row) {
                            if ($row->paid_amount < 1) {
                                $paid = 0;
                            } else {
                                $paid = $row->paid_amount;
                            }

                            $total_amount+=$paid;
                            ?>
                            <tr>
                                <td><?= $row->id_total_sales; ?></td>
                                <td><?= $row->name_payment_method; ?></td>
                                <td><?= $row->payment_date; ?></td>
                                <td class="text-right taka_formate">TK <?= $paid ?></td>

                            </tr>
                        <?php } ?> 


                        <tr>
                            <td colspan="3" class="text-center">Total Paid Amount = </td>
                            <td class="text-right taka_formate">TK <?= $total_amount; ?></td>
                        </tr>
                    </table>

                <?php }
                ?> 
            </div>

        </div>

        <div class="margin-top-10 only_print">

            <a href="<?= site_url('advance_payment') ?> " class="only_print btn btn-primary "><i class="fa fa-pencil"></i> Return To Advance Payment Dashboard</a>

            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>



        </div>







    </div>

