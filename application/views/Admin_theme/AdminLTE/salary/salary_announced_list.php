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
            <li class="active">Salary section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">


                    <div class="box-header" >
                        <h2>Salary Announcement of <?php echo date('F', now());
            echo ' ';
            echo date('Y', now());
            ; ?></h2>
                        <?php
                        $message = $this->session->userdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        $this->session->unset_userdata('message');
                        ?>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form target="_new" action="<?php echo base_url(); ?>index.php/Salary/save_announced" method="post" id="salary">
                            <table id="example1" class="table table-bordered table-hover">

                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>Basic</th>
                                        <th>Bonus</th>
                                        <th>Salary Announced or Not</th>
                                    </tr>
                                </thead>
                                <tbody>

<?php
foreach ($employees as $employee) {
    ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="id_employee[]" value="<?php echo $employee->id_employee; ?>">
    <?php echo $employee->name_employee; ?>
                                            </td>

                                            <td id="click"><?php echo $employee->lmid_name; ?></td>
                                            <td>
                                                <input type="hidden" name="amount_salary_payment[]" value="<?php echo $employee->basic + $employee->medical + $employee->house_rent + $employee->transport_allowance + $employee->lunch; ?>">
    <?php echo $employee->basic + $employee->medical + $employee->house_rent + $employee->transport_allowance + $employee->lunch; ?>
                                            </td>

                                            <td>
                                                <select class="form-control select2"style="width:100%;" name="bonus_type[]">
                                                    <option value="0">Select Bonus Type</option>
                                                    <?php
                                                    foreach ($bonus_type as $bonus) {
                                                        ?>
                                                    <option value="<?php echo $bonus->id_salary_bonus_type?>"><?php echo $bonus->name_salary_bonus_type; ?>(1000)</option>
    <?php }
    ?>
                                                    <option value="0">No Bonus</option>
                                                </select>
                                            </td>
                                            <td >
                                                <?php
//                                                        echo '<pre>';print_r($announced_test);exit();
                                                        
//                                                foreach ($announced_test as $value) {
                                                $value =$this->Salary_model->announce($employee->id_employee);
//                                                    echo '<pre>';print_r($value);exit();
                                                if($value!=null){
                                                    if ($employee->id_employee == $value[0]->id_employee) {
//                                                        ?>
                                                        <label>Announced</label>
            <?php
        }} else {
//            ?>
                                                        <label >
                                                            <input type="checkbox" name="status_salary_payment[]" value="<?php echo $employee->id_employee; ?>" id="check" > Announced
                                                        </label>
            <?php
        }
//    }
    ?>
                                            </td>

    <!--                                            <td>
                     <a href="<?php echo base_url() ?>index.php/users_info/update_user/<?php echo $user->id; ?>" class="primary"><span class="glyphicon glyphicon-edit"></span></a>
                 <a href="<?php echo base_url() ?>index.php/users_info/delete_user/<?php echo $user->id; ?>" class="danger" onclick="return check();"><span class="glyphicon glyphicon-trash"></span></a>
                                                    <button type="submit" class="btn btn-sm btn-success">Announced</button>
                                                </td>-->

                                        </tr>
    <?php
}
?>



                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>Basic</th>
                                        <th>Bonus</th>
                                        <th>Salary Announced or Not</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <button type="submit" class="btn btn-sm btn-success pull-right" id="submit"> Save</button> 
                        </form>
                    </div>



                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>