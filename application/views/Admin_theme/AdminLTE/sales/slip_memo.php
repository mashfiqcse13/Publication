
<!--add header -->

<?php include_once __DIR__ . '/../header.php'; ?>


    <div class="container memo_print_option custom_memo memo"  >
        <div class="only_print padding10"></div>
        <div class="row" style="margin: 13mm 2mm 5mm 2mm;padding-top:0px"> 
            
        <?php  ?>

                <?php
                foreach ($slip_info as $party) {
                    ?>
                    <h4 class="text-center"> স্লিপ খরচ নিবন্ধন </h4>
                    <table class="table table-border table_custom" style="font-size:13px">

                        <tr>
                            <td><strong>Party Name:</strong></td>
                            <td><?php echo $party->name; ?></td>
 
                            <td><strong>Code No:</strong></td>
                            <td><?php echo $party->id_customer; ?></td>

                            <td><strong>Transection Id:</strong></td>
                            <td><?php echo $party->id_slip; ?></td>
                        </tr>

                        <tr>
                            <td><strong>Mobile:</strong></td>
                            <td><?php echo $party->phone; ?></td>

                           <td><strong>District:</strong></td>
                            <td><?php echo $party->district; ?></td> 
                         
                            <td><strong>Date:</strong></td>
                            <td><?php echo $party->date; ?></td>
                        </tr>

                    </table>
                    
                    <table class="table table-border table-condensed table-striped">
                        <tr>
                            <td>Slip Amount</td>
                            <td class="text-right">TK <?=$this->Common->taka_format($party->slip_amount)?></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td class="text-right "><?php echo $party->description; ?></td>
                        </tr>
                    </table>
                    <h5>বি:দ্র: নিবন্ধনকৃত স্লিপ খরচের টাকা ক্রেতার অ্যাকাউন্ট এ ক্যাশ টাকা হিসেবে গৃহীত হবে ।</h5>


                    <?php    }     ?>
            </div>
                
        </div>

            <div class="margin-top-10 only_print" style="    width: 400px;    margin: 0 auto;    position: relative;    bottom: 200px;">

            <a href="<?= site_url('sales/slip') ?> " class="only_print btn btn-primary "><i class="fa fa-dashboard"></i> Return To Slip Dashboard</a>

            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>

        </div>
    </div>

