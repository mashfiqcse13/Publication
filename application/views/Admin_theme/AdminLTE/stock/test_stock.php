<?php 


?>

<table border="1">
    <thead>
        <tr >
            <th>date</th>
        <?php 
        
        $now = date('Y-m-d');
        $start = date('2016-9-4');
        
        for($i=1;$i<60;$i++){ ?>
       
            <th width="100"><?= $date = date('Y-m-d',strtotime('+'.$i.' day' ,  strtotime ( $start )));  ?> </th>
        
              
        <?php }         ?>
            </tr>
        
    </thead>
    <!--
    <?php foreach($sales_item as $key => $value){ ?>
    <tr>
        <td><?=$value->issue_date;?></td>
         <td><?=$value->id_item;?></td>
         <td><?=$value->sale_quantity;?></td>
         <td>
            <?php  foreach($register_item as  $item) { 
                if($item->date == $value->issue_date && $item->id_item == $value->id_item){
                    echo $item->register_sales_amount;
                }               
                
            }
        ?>              
             
         </td>
    <tr>
    
    <?php } ?>
    -->
</table>


