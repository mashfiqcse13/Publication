<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height:600px">
        <!-- Content Header (Page header) -->
        <section class="content-header">
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
        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php 
                                $attributes = array(
                                                'clase' => 'form-inline',
                                                'method' => 'post');
                                echo form_open('', $attributes)
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
                                    
                                <?php form_close() ?>
                                
                                <?php if(isset($return_price)){
                                    echo "Cash Back: ".$return_price;
                                }
                                ?>
                            </div>
                        </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                
                                     <?php
                                        if(isset($search_memo)){
                                            $attributes1 = array(
                                                'clase' => 'form-inline',
                                                'method' => 'post');
                                            echo form_open('', $attributes1)
                                      ?>      
                                            <div class="page-header">
                                                <h2>Sales Return</h2>
                                            </div>
                                       <?php             
                                            foreach($search_memo as $row){                     
                                        ?>
                            


                                        <div class="panel-body" >

                               

                                    <table class="table table-striped table_custom" style="font-size:13px;">

                                        <tr>

                                            <td><strong>Name:</strong></td>

                                            <td><?= $Book_selection_table['party_name'] ?></td>



                                            <td><strong>Code No:</strong></td>

                                            <td><?= $Book_selection_table['code'] ?></td>



                                            <td><strong>Memo No:</strong></td>

                                            <td><?= $Book_selection_table['memoid'] ?></td>

                                        </tr>

                                        <tr>

                                            <td><strong>Mobile:</strong></td>

                                            <td> <?= $Book_selection_table['phone'] ?></td>



                                            <td><strong>District:</strong></td>

                                            <td><?= $Book_selection_table['district'] ?></td>



                                            <td><strong>Date:</strong></td>

                                            <td><?php echo " " .$Book_selection_table['issue_date'] ?></td>

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
                                            <td><?=$row['book_name']?><input type="hidden" name="book_ID[]" class="form-control"  value="<?=$row['book_ID']?>"></td>
                                            <td><?=$row['book_price']?></td>
                                            <td><?=$row['price']?><input type="hidden" name="price[]" class="form-control"  value="<?=$row['price']?>"></td>
                                            <td>
                                                <input type="number" class="form-control" name="quantity[]" min="0" max="<?=$row['quantity']?>"  placeholder="<?=$row['quantity']?>">
                                                <input type="hidden" name="memo_ID[]" class="form-control"  value="<?=$row['memo_ID']?>">                                                
                                                <input type="hidden" name="stock_ID[]" class="form-control"  value="<?=$row['stock_ID']?>">
                                                <input type="hidden" name="pre_quantity[]" class="form-control"  value="<?=$row['quantity']?>">
                                                <input type="hidden" name="contact_ID" class="form-control"  value="<?=$row['contact_ID']?>">
                                                
                                                
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                
                            </div>

                                    <input type="submit" class="btn btn-primary pull-right" value="Update Sales Return" name="sales_return">
                                        
                                        <?php   }   echo form_close(); }   ?>
                               
                               
                            </div>
                            </div>
                            
                        </div>
                     
                                   
                    </div>
                    
                </div>
            </div>
         


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>