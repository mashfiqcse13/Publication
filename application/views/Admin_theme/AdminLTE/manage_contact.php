<!--add header -->
<?php include_once 'header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            CONTACT MANAGEMENT
            <small>manage all Contact information</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?=$base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Contact Management</li>
          </ol>
        </section>
        
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="box">
                
                    <div class="box-header with-border">
                        <h3 class="box-title">Add new Contact</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                
                <form role="form-inline">
                  <div class="box-body">
                      <div class="row">
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="bookname">Full Name:</label>
                                <input type="text" placeholder="Enter email" id="bookname" class="form-control">
                              </div>

                              <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="" id="address" cols="30" rows="4" class="form-control"></textarea>
                               

                              </div>
                              
                           
                          </div>
                          <div class="col-md-4">
                                <div class="form-group">
                                <label>District</label>
                                <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                  <option selected="selected">Alabama</option>
                                  <option>Alaska</option>
                                  <option>California</option>
                                  <option>Delaware</option>
                                  <option>Tennessee</option>
                                  <option>Texas</option>
                                  <option>Washington</option>
                                </select>
                                </div>
                              
                                <div class="form-group">
                                <label>Storing Place</label>
                                <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                  <option selected="selected">Alabama</option>
                                  <option>Alaska</option>
                                  <option>California</option>
                                  <option>Delaware</option>
                                  <option>Tennessee</option>
                                  <option>Texas</option>
                                  <option>Washington</option>
                                </select>
                                </div>
                          </div>
                          <div class="col-md-4">
                             <div class="form-group">
                                <label for="phone">Phone Number:</label>
                                <input type="text" id="phone" class="form-control">

                              </div>
                              
                               <div class="form-group">
                                <label>Contact Type</label>
                                <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true">
                                  <option selected="selected">Alabama</option>
                                  <option>Alaska</option>
                                  <option>California</option>
                                  <option>Delaware</option>
                                  <option>Tennessee</option>
                                  <option>Texas</option>
                                  <option>Washington</option>
                                </select>
                                </div>
                          </div>
                      </div>
                    
                      
                    
                    
                     
              
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button class="btn btn-primary pull-right" type="submit">Submit</button>
                  </div>
                </form>
                    </div>
                    
                    </div>
                </div>
            </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Contact List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      
                      <th>Phone</th>
                  
                      <th class="text-center">Modify</th>
                    </tr>
                    <tr>
                      <td>1.</td>
                      <td>Hasan</td>
                     
                      <td>01912572747</td>
                 
                      <td class="text-center">
                          <a class="btn btn-primary btn-xs" href="#" >edit</a> | <a href="#" class="btn btn-danger btn-xs" >delete</a> </td>
                    </tr>
                     <tr>
                      <td>2.</td>
                      <td>khan</td>
                      
                      <td>10213646654</td>
                  
                      <td class="text-center">
                          <a class="btn btn-primary btn-xs" href="#" >edit</a> | <a href="#" class="btn btn-danger btn-xs" >delete</a> </td>
                    </tr>
                     <tr>
                      <td>3.</td>
                      <td>alam</td>
                     
                      <td>14125498379</td>
              
                      <td class="text-center">
                          <a class="btn btn-primary btn-xs" href="#" >edit</a> | <a href="#" class="btn btn-danger btn-xs" >delete</a> </td>
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