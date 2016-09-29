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
        font-weight: normal;
        text-align: right;
    }
</style>





<div id="table_custom" style="background:#ddd">



    <div class="container memo_print_option" style="background:#fff;width:585px;min-height:793px;padding:25px 40px;margin-top:30px;font-size:15px;margin:10px auto;box-shadow:0px -1px 8px #000;" >





        <div class="row" style="padding-top:100px"> 

            <table class="table table_custom text-bold" style="font-size:13px">

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

                    <td><?php echo " " . date('d-m-Y H:i:s', strtotime($memo_header_details['issue_date'])) ?></td>

                </tr>

            </table>











        </div>



        <div class="row" style="font-size:16px;">

            
            <?php echo $memo_body_table['memo']; 
            
            if(isset($memo_body_table['due_report']) && !empty($memo_body_table['due_report'])){
               
                echo '<div style="page-break-before: always;margin-top:120px">';
                echo '<h2 class="text-center">Due\'s Payment Report</h2>';
                ?>
            
                
            <table class="table table_custom" style="font-size:13px;margin-top:50px">
                <thead>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><?= $memo_header_details['party_name'] ?></td>
                    <td><strong>Code No:</strong></td>
                    <td><?= $memo_header_details['code'] ?></td>
                    <td><strong>Memo No:</strong></td>
                    <td><?= $memo_header_details['memoid'] ?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>Mobile:</strong></td>
                    <td> <?= $memo_header_details['phone'] ?></td>
                    <td><strong>District:</strong></td>
                    <td><?= $memo_header_details['district'] ?></td>
                    <td><strong>Date:</strong></td>
                    <td><?php 
                    $old = $memo_header_details['issue_date'];
                    $new=date('d-m-Y H:i:s', strtotime($old));
                    echo " " .  $new;
                    
                    ?></td>

                </tr>
                </tbody>

            </table>
        
            <?php
                
                echo $memo_body_table['due_report'];
                echo '</div>';
            }
            ?>



        </div>



        <div class="margin-top-10">

            <a href="<?= $base_url ?>" class="only_print btn btn-primary "><i class="fa fa-dashboard"></i> Go Dashboard</a>

            <a href="<?php echo site_url('sales/new_sale') ?>" class="only_print btn btn-primary "><i class="fa fa-pencil"></i> New Memo</a>

            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>
            <?php if ($customer_total_due > 0) { ?>
                <a href="<?= $edit_btn_url ?>" class="only_print pull-right btn btn-primary margin-10">Pay Due</a>
            <?php } ?>

        </div>







    </div>

</div>

<?php include_once __DIR__ . '/../footer.php'; ?>

<style>
    
    table,tr,td{
        border:1px solid #ddd!important;
    }
    table td{
        font-size: 14px;
    }
thead {
    display: table-row-group;
}

    </style>