<!--add header -->

<?php include_once 'header.php'; ?>



      <!-- Left side column. contains the logo and sidebar -->

<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->

      <!-- Content Wrapper. Contains page content -->

<div class="content-wrapper" style="min-height: 600px">

        <!-- Content Header (Page header) -->

        <section class="content-header">

          <h1>

             <?=$Title ?>

            <small><?=$Title ?></small>

          </h1>

          <ol class="breadcrumb">

            <li><a href="<?=$base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>

            <li class="active">Stock Management</li>

          </ol>

        </section>

        

        <!-- Main content -->

        <section class="content">



            <div class="row">

                <div class="col-md-12">

                    

                    <div class="box">

                

                    <div class="box-header with-border">

                        <h3 class="box-title">Manage Stock</h3>

                    </div><!-- /.box-header -->

                    <div class="box-body">

                    <div class="row">

                      <div class="col-md-4">

                        <table class="table table-bordered">

                          <tr>

                            

                            <th colspan="5" class="text-center info">Printing press</th>

                          </tr>



                          <tr>

                            <th>#</th>

                            <th>book Name</th>

                            <th>Press</th>

                            <th>Amount</th>

                            <th>Action</th>

                          </tr>



                          <tr>

                            <td>1</td>

                            <td>Book 1</td>

                            <td></td>

                            <td>500</td>

                            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button></td>

                          </tr>



                           <tr>

                            <td>1</td>

                            <td>Book 1</td>

                            <td></td>

                            <td>500</td>

                            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button></td>

                          </tr>

                        </table>

                      </div>

                      <div class="col-md-4">

                           <table class="table table-bordered">

                          <tr>

                            

                            <th colspan="5" class="text-center warning">Binding Store</th>

                          </tr>



                          <tr>

                            <th>#</th>

                            <th>book Name</th>

                            <th>Store Name</th>

                            <th>Amount</th>

                            <th>Action</th>

                          </tr>



                          <tr>

                            <td>1</td>

                            <td>Book 1</td>

                            <td></td>

                            <td>500</td>

                            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button></td>

                          </tr>



                           <tr>

                            <td>1</td>

                            <td>Book 1</td>

                            <td></td>

                            <td>500</td>

                            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button></td>

                          </tr>

                        </table>

                      </div>

                      <div class="col-md-4">

                           <table class="table table-bordered">

                          <tr>

                            

                            <th colspan="5" class="text-center success">Sales Store</th>

                          </tr>



                          <tr>

                            <th>#</th>

                            <th>book Name</th>

                            <th>Sales Name</th>

                            <th>Amount</th>

                            <th>Action</th>

                          </tr>



                          <tr>

                            <td>1</td>

                            <td>Book 1</td>

                            <td></td>

                            <td>500</td>

                            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button></td>

                          </tr>



                           <tr>

                            <td>1</td>

                            <td>Book 1</td>

                            <td></td>

                            <td>500</td>

                            <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-transfer"></span></button></td>

                          </tr>

                        </table>

                      </div>

                    </div>

                

                    </div>

                    

                    </div>

                </div>

            </div>

<!-- /.row -->



          



          <!-- modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Transfer Book Amount</h4>

      </div>

      <div class="modal-body">

         <form role="form-inline">

                  <div class="box-body">

                      <div class="row">

                       

                          <div class="col-xs-6">

                                <div class="form-group">

                                <label>To:</label>

                                <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">

                                  <option selected="selected">Select</option>

                                  <option>Printing Press</option>

                                  <option>Binding</option>

                                  <option>Sales</option>

                                  

                                </select>

                                </div>



                              <div class="form-group">

                                <label for="amount">Amount:</label>

                                <input type="text" id="amount" class="form-control">



                              </div>

                              

                          

                          </div>

                          <div class="col-xs-6">

                             <div class="form-group">

                                <label for="address">Comment</label>

                                <textarea name="" id="address" cols="30" rows="4" class="form-control"></textarea>

                               



                              </div>

       

                          </div>

                      </div>

                    

                      

                    

                    

                     

              

                  </div><!-- /.box-body -->



                  <div class="box-footer">

                    <button class="btn btn-primary pull-right" type="submit">Transfer</button>

                  </div>

                </form>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        

      </div>

    </div>

  </div>

</div>


        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
<?php include_once 'footer.php'; ?>
