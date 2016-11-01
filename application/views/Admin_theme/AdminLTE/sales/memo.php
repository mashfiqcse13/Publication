<!--add header -->

<?php include_once __DIR__ . '/../header.php'; ?>



<!-- Left side column. contains the logo and sidebar -->



<!-- Content Wrapper. Contains page content -->



<style>
    #table_custom .table td.separator {
        background: black none repeat scroll 0 0;
        height: 1px;
        padding: 0;
    }
    #table_custom .table td.left_separator {
        border-left: 2px solid;
        font-weight: normal;
        text-align: right;
    }
    
    <?php 
    $link = $this->config->item('SITE')['website'];
    if($link == 'http://advancedpublication.com/'){
        ?>
    @page {       
                margin: 47mm 25mm 15mm 25mm;                  
               
            }
    <?php
    }
    
    
    ?>
 
           

</style>

 

    
    <div class="container memo_print_option custom_memo memo"  >
        <div class="only_print padding10"></div>

        <div class="row" style="padding-top:0px"> 

            <table class="font_12 table table_custom text-bold" style="font-size:12px">

                <tr>
                    
                    <td><strong>Memo No:</strong></td>

                    <td><?= $memo_header_details['memoid'] ?></td>
                    
                    

                    <td><strong>Name:</strong></td>

                    <td><?= $memo_header_details['party_name'] ?></td>



                    <td><strong>Code No:</strong></td>

                    <td><?= $memo_header_details['code'] ?></td>                    

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

        <div class="row" style="font-size:16px;">
            <?php echo $memo_body_table['memo']; ?>
        </div>
        
        <div class="row">
        <div class="due_payment_section">
            <div class="only_print padding10"></div>
            <?php 
            
            echo '<div class="hide_for_jamuna">';
            if(isset($memo_body_table['due_report']) && !empty($memo_body_table['due_report'])){
               
                echo '<div  class="due_memo_part" style=" page-break-before: always;padding-top:0px">';
                echo '<h2 class="text-center top_margin_remove" >Due\'s Payment Report</h2>';
                ?>
            
                
            <table class="table table_custom" style="font-size:13px;margin-top:0px">
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
            echo '</div>';
            ?>



        </div>
        </div>

        <div class="margin-top-10">

            <a href="<?= $base_url ?>" class="only_print btn btn-primary "><i class="fa fa-dashboard"></i> Go Dashboard</a>

            <a href="<?php echo site_url('sales/new_sale') ?>" class="only_print btn btn-primary "><i class="fa fa-pencil"></i> New Memo</a>

            <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print This Page"/>
            <?php if ($customer_total_due > 0) { ?>
                <a href="<?= $edit_btn_url ?>" class="only_print pull-right btn btn-primary margin-10">Pay Due</a>
            <?php } ?>

        </div>
        
        <div class="only_print padding10"></div>
    </div>


<?php include_once __DIR__ . '/../footer.php'; ?>

<style>
    
    table,tr,td{
        border:1px solid #ddd!important;
    }
    table td{
        font-size: 14px;
    }
    .font_12 tr td{
        font-size:12px!important;
    }
thead {
    display: table-row-group;
}

@media only print{

    .hideDueReport{
        display: none;
        visibility: hidden;
    }
    

    
}


    </style>
    
    <script>
        
        var siteUrlForMemo = "<?= $this->config->item('SITE')['website'] ?>";
        
 

        if(siteUrlForMemo=='http://thejamunapub.com/'){
                        $('.due_payment_section').addClass('hideDueReport');
                        //$('.due_memo_part').removeAttr('style');
                    }


                    
 

      
        
   </script>