<!--add header -->
<?php include_once 'header.php'; ?>

      <!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
        <section class="content" style="background:#fff;padding:20px;">
        <div class="row">
            <form action="" class="form">
                <div class="form-group">
                <label for="" >Binder Name:</label>
                <select name="" id="" class="form-control">
                    <option value="">kamal ahamed</option>
                     <option value="">kamal ahamed</option>
                      <option value="">kamal ahamed</option>
                       <option value="">kamal ahamed</option>
                </select>
                </div>
                <div class="form">
                    <label for="">Issue Date</label>
                    <input type="" class="datetime-input form-control"/>
                </div>
                <br>
                <div class="form">
                    <table class="table table-border" >
                        <tr>
                            <th>Book Name</th>
                            <th>Quantity</th>
                        </tr>
                        <tr>
                            <td>English 1s part</td>
                            <td>
                                <input type="number" class="form-control" />
                            </td>
                        </tr>
                        <tr>
                             <td>English 2s part</td>
                            <td>
                                <input type="number" class="form-control" />
                            </td>
                        </tr>
                        <tr>
                             <td>English 3s part</td>
                            <td>
                                <input type="number" class="form-control" />
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group">
                    <input type="submit"  value="Save" class="btn btn-primary pull-right"/>
                </div>
            </form>
        </div>
    </section>
         


          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- insert book -->



<?php include_once 'footer.php'; ?>