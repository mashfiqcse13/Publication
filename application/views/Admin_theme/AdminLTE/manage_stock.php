<!--add header -->
<?php include_once 'header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            STOCK MANAGEMENT
            <small>manage all Stock information</small>
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
                            <td><a href=""><span class="glyphicon glyphicon-transfer"></span></a></i></td>
                          </tr>

                           <tr>
                            <td>1</td>
                            <td>Book 1</td>
                            <td></td>
                            <td>500</td>
                            <td><a href=""><span class="glyphicon glyphicon-transfer"></span></a></i></td>
                          
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
                            <th>Press</th>
                            <th>Amount</th>
                            <th>Action</th>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Book 1</td>
                            <td></td>
                            <td>500</td>
                            <td><a href=""><span class="glyphicon glyphicon-transfer"></span></a></i></td>
                          </tr>

                           <tr>
                            <td>1</td>
                            <td>Book 1</td>
                            <td></td>
                            <td>500</td>
                            <td><a href=""><span class="glyphicon glyphicon-transfer"></span></a></i></td>
                          
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
                            <th>Press</th>
                            <th>Amount</th>
                            <th>Action</th>
                          </tr>

                          <tr>
                            <td>1</td>
                            <td>Book 1</td>
                            <td></td>
                            <td>500</td>
                            <td><a href=""><span class="glyphicon glyphicon-transfer"></span></a></i></td>
                          </tr>

                           <tr>
                            <td>1</td>
                            <td>Book 1</td>
                            <td></td>
                            <td>500</td>
                            <td><a href=""><span class="glyphicon glyphicon-transfer"></span></a></i></td>
                          
                          </tr>
                        </table>
                      </div>
                    </div>
                
                    </div>
                    
                    </div>
                </div>
            </div>
<!-- /.row -->
          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php include_once 'footer.php'; ?>