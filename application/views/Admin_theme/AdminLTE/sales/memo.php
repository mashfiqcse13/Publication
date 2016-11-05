<!--add header -->

<?php include_once __DIR__ . '/../header.php'; 


$sitelink = $this->config->item('SITE')['website'];


if($sitelink == 'http://thejamunapub.com/' || $sitelink == 'http://advancedpublication.com/' ){
    $hide_due_part = 'hide';
}else{
    $hide_due_part = 'show'; 
}
if($sitelink == 'http://thejamunapub.com/' ){
    $font14 = '14px!important;';
}


?>

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
    td.noborder {
        border: 1px solid #ddd!important;
    }
     .memo table.table>tr>td.noborder {
              border: 1px solid #ddd!important;
        }
    @media only print{
          td.noborder {
            border: 1px solid #ddd!important;
        }
    }
    <?php 
   
    if($sitelink == 'http://advancedpublication.com/'){  
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

            <table class="font_12 table  table_custom text-bold" style="font-size:11px;margin-bottom: 0px;">

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

        <div class="row" style="font-size:12px;">
            <?php echo $memo_body_table['memo']; ?>
        </div>
        
        <div class="row">
        <div class="due_payment_section">
            <div class="only_print padding10"></div>
            <?php 
            
            if($hide_due_part == 'show'){  
                
            echo '<div class="">'; 
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
            }
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
    
     
    table td{
        font-size: 12px;
    }
    .font_12 tr td{
        font-size:12px!important;
    }
thead {
    display: table-row-group;
}
td.hide_advanced {
    opacity: 0;
}
@media only print{
      body td.noborder {
            border: 0px solid #ddd!important;
        }
        table,tr,td,tbody,th,p{
            font-size:<?=$font14;?>
        }
        
                #table_custom .table > tbody > tr > td.noborder, .table > tbody > tr > th, .table > tfoot > tr > td.noborder, .table > tfoot > tr > th, .table > thead > tr > td.noborder, .table > thead > tr > th {
                    border: 0px solid #222!important;
                }
                .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td.noborder, .table-bordered>tbody>tr>td.noborder, .table-bordered>tfoot>tr>td.noborder{

                    border:0px solid #222!important;
                }
                body table,body tr,body td.noborder,body th,body tbody,body thead,.table,.table-bordered td.noborder{
                    border: 0px solid #222!important;
                }
                body .table-bordered td.noborder{
                    border:0px solid #222!important;
                }
                
                .top_margin_remover{
                    margin-top: 0px!important;
                }
             

}

                

    </style>
