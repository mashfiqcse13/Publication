<!--add header -->
<?php include_once __DIR__ . '/../header.php'; ?>

<!-- Left side column. contains the logo and sidebar -->
<?php include_once 'main_sidebar.php'; ?> <!-- main sidebar area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $Title ?>
            <small> <?= $Title ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= $base_url ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?php echo $Title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12" id="block">

                <div id="employee_table" style="margin-top: 50px;">
                    <div class="box">
                        <div class="box-header" >
                            <h1 class="text-center">Current Month Salary</h1>
                        </div>
                        <div class="box-body">
                            <input style="margin-bottom: 10px;" class="only_print pull-right btn btn-primary" type="button" id="print"  onClick="printDiv('block')"  value="Print Report"/>
                                        <div class="pull-right" id="test">Report Date: <?php echo date('d/m/Y',now());?></div>
                            <table  class="table table-bordered table-hover">
                                <thead style="background: #DFF0D8;">
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Amount of Bonus</th>
                                        <th>Amount of Salary</th>
                                        <th>Date of Salary</th>
                                        <th>Salary Status</th>
                                    </tr>
                                </thead>
                                <tbody id="current_salary_info">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div id="loan_info">
                </div>
                </form>
            </div>
        </div>
</div>
</div>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>