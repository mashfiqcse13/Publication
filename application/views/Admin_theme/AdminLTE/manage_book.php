<!--add header -->
<?php include_once 'header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            BOOK MANAGEMENT
            <small>manage all book information</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Book Management</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Bordered Table</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Book Name</th>
                      <th>Category</th>
                      <th style="width: 40px">Quantity</th>
                      <th>Price</th>
                      <th class="text-center">Modify</th>
                    </tr>
                    <tr>
                      <td>1.</td>
                      <td>English for today</td>
                      <td>Science</td>
                      <td><span class="badge bg-red">55</span></td>
                      <td>500tk</td>
                      <td class="text-center">
                          <a class="btn btn-primary btn-xs" href="#" >edit</a> | <a href="#" class="btn btn-danger btn-xs" >delete</a> | <a href="#" class="btn btn-info btn-xs" >view</a></td>
                    </tr>
                     <tr>
                      <td>2.</td>
                      <td>English for today</td>
                      <td>Science</td>
                      <td><span class="badge bg-red">55</span></td>
                      <td>500tk</td>
                      <td class="text-center">
                          <a class="btn btn-primary btn-xs" href="#" >edit</a> | <a href="#" class="btn btn-danger btn-xs" >delete</a> | <a href="#" class="btn btn-info btn-xs" >view</a></td>
                    </tr>
                     <tr>
                      <td>3.</td>
                      <td>English for today</td>
                      <td>Science</td>
                      <td><span class="badge bg-red">55</span></td>
                      <td>500tk</td>
                      <td class="text-center">
                          <a class="btn btn-primary btn-xs" href="#" >edit</a> | <a href="#" class="btn btn-danger btn-xs" >delete</a> | <a href="#" class="btn btn-info btn-xs" >view</a></td>
                    </tr>
                     <tr>
                      <td>4.</td>
                      <td>English for today</td>
                      <td>Science</td>
                      <td><span class="badge bg-red">55</span></td>
                      <td>500tk</td>
                      <td class="text-center">
                          <a class="btn btn-primary btn-xs" href="#" >edit</a> | <a href="#" class="btn btn-danger btn-xs" >delete</a> | <a href="#" class="btn btn-info btn-xs" >view</a></td>
                    </tr>
                      
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </div>
              </div><!-- /.box -->

              
            </div><!-- /.col -->
            
          </div><!-- /.row -->
          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php include_once 'footer.php'; ?>