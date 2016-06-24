<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper only_print" style="min-height:600px">
        <!-- Content Header (Page header) -->
        <section class="content-header ">
          <h1>
            <?=$Title ?>
            <small> <?=$Title ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $Title ?></li>
          </ol>
        </section>
        
        
        <!-- Main content -->
        <section class="content only_print">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="secondform1" class="form" action="<?php echo site_url('sales_return/sales_current_sales_return'); ?>" method="post">
                                 
                                <?php 
//                                $attributes = array(
//                                                'clase' => 'form-inline',
//                                                'method' => 'post');
//                                echo form_open('', $attributes)
                                ?>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Memo Id:</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="memo_id" class="form-control">
                                            </div>
                                        </div>
                                   
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="submit" value="Search Memo" name="search_memo">
                                    </div>
                                </form>
                                
                                <?php //form_close() ?>
                                
                                
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-12">

                                <?php if(isset($list_item)){
                                    echo $list_item['table1'];
                                    echo $list_item['table2'];
                                    
                                ?>
                                    <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  value="Print Report"/>

                                <?php }  ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                   
                                     <?php   if(isset($search_memo)){ ?>
                                    <form id="secondform" class="form" action="<?php echo site_url('sales_return/sales_current_sales_return'); ?>" method="post">
<!--                                            $attributes1 = array(
                                                'clase' => 'form-inline',
                                                'method' => 'post');
                                            echo form_open('', $attributes1);
                                      ?>      -->
                                            <div class="page-header">
                                                <h2>Sales Return</h2>
                                            </div>
                                       <?php             
                                            foreach($search_memo as $row){                     
                                        ?>
                            


                                        <div class="panel-body" >

                               

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

                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Book Name</th>
                                            <th>Book Price</th>
                                            <th>Sale Price</th>
                                            <th>Quantity</th>
                                        </tr>
                                        <?php foreach($get_book_list as $row) {?>
                                        <tr>
                                            <td><?=$row['item_name']?><input type="hidden" name="id_item[]" class="form-control"  value="<?=$row['id_item']?>"></td>
                                            <td><?=$row['regular_price']?></td>
                                            <td><?=$row['sale_price']?><input type="hidden" name="price[]" class="form-control"  value="<?=$row['sale_price']?>"></td>
                                            <td>
                                                <input type="number" class="form-control" name="quantity[]" min="0" max="<?=$row['quantity']?>"  placeholder="<?=$row['quantity']?>" required>
                                                <input type="hidden" name="id_total_sales[]" class="form-control"  value="<?=$row['id_total_sales']?>">                                                
                                                
                                                <input type="hidden" name="pre_quantity[]" class="form-control"  value="<?=$row['quantity']?>">
                                                <input type="hidden" name="id_customer" class="form-control"  value="<?=$row['id_customer']?>">
                                                
                                               
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                
                            </div>

                                    <input type="submit" class="btn btn-primary pull-right" value="Update Sales Return" name="sales_return">
                                       </form>  
                                     <?php   }}  // echo form_close(); }    ?>
                               
                               
                            </div>
                            </div>
                            
                        </div>
                     
                                   
                    </div>
                    
                </div>
            </div>
         


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->

      <div class="report-logo-for-print" >
          <h3 class="text-center"><?=$this->config->item('SITE')['name'] ?></h3>
          <p class="text-center"> <?=$Title ?> Report</p>
          <p>Report Generated by: <?php echo $_SESSION['username'] ?></p>
            <?php if(isset($list_item)){
                echo $list_item['table1'];
                echo $list_item['table2'];

            }   ?> 
      </div>

<?php include_once __DIR__ . '/../footer.php'; ?>