<!--add header -->

<?php include_once __DIR__ . '/../header.php'; ?>



<!-- Left side column. contains the logo and sidebar -->



<!-- Content Wrapper. Contains page content -->



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
</style>



        
    <div class="container memo_print_option custom_memo"  >
        <div class="only_print padding10"></div>




        <div class="row" style="padding-top:0px">
            <h3 class="text-center top_margin_remover">পুরাতন বই ফেরত স্লিপ</h3>

            <table class="table table_custom" style="font-size:13px">
                <tr>

                    <td><strong>Name:</strong></td>

                    <td><?= $memo_header_details['party_name'] ?></td>



                    <td><strong>Code No:</strong></td>

                    <td><?= $memo_header_details['code'] ?></td>



                    <td><strong>Slip Number:</strong></td>

                    <td><?= $memo_header_details['memoid'] ?></td>

                </tr>

                <tr>

                    <td><strong>Mobile:</strong></td>

                    <td> <?= $memo_header_details['phone'] ?></td>



                    <td><strong>District:</strong></td>

                    <td><?= $memo_header_details['district'] ?></td>



                    <td><strong>Date:</strong></td>
                    
                    <td><?php echo " " . date('d-M-Y H:i:s', strtotime($memo_header_details['issue_date'])) ?></td>
                   

                </tr>

            </table>

        </div>
        <div class="row" style="font-size:14px;">
            <?php echo $memo_body_table; ?>

<!--            <h2>Returned Book Value : <strong> <?php echo $balance; ?></strong></h2>-->

        </div>

        <div class="margin-top-10">

            <a href="<?php echo site_url('old_book/old_book_dashboard') ?>" class="only_print btn btn-primary "><i class="fa fa-dashboard"></i> Go Book Return Dashboard</a>


            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>


        </div>
        <div class="only_print padding10"></div>

    </div>

<?php include_once __DIR__ . '/../footer.php'; ?>



