
<!--add header -->

<?php include_once __DIR__ . '/../header.php'; ?>



<!-- Left side column. contains the logo and sidebar -->



<!-- Content Wrapper. Contains page content -->







        <div style="background:#fff;width:640px;margin:0 auto;min-height:500px;box-shadow:0px -1px 8px #000;padding:20px 0;">        
                <div class="container memo_print_option" id="block" style="background:#fff;width:635px;min-height:493px;font-size:15px;" >
                    <div style="margin-top:14mm;margin-left: 5mm;margin-right: 5mm;">


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


                    <?php    }     ?>
            </div>
                
        </div>

            <div class="margin-top-10 only_print" style="padding:20px;">

            <a href="<?= site_url('advance_payment') ?> " class="only_print btn btn-primary "><i class="fa fa-pencil"></i> Return To Advance Payment Dashboard</a>

            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>



        </div>







    </div>

