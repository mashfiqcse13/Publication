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
                        <?php
                            $message = $this->session->userdata('message');
                            if(isset($message)){
                                echo $message;
                            }
                            $this->session->unset_userdata('message');
                        ?>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Basic</th>
                                    <th>Bonus</th>
                                    <th>Salary Announced or Not</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                            <form target="_new" action="<?php echo base_url(); ?>index.php/Salary/save_announced" method="post">
                                <td>
                                    <select class="form-control select2"style="width:100%;" name="id_employee" id="announced">
                                        <option>Select Employee Name</option>
                                        <?php
                                        foreach ($employees as $employee) {
                                            ?>
                                            <option value="<?php echo $employee->id_employee; ?>"><?php echo $employee->name_employee; ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </td>

                                <td>
                                    <?php
                                    foreach ($employees as $employee) {
                                        ?>
                                        <?php echo $employee->lmid_name; ?>
                                    <?php }
                                    ?>
                                </td>
                                <td>
                                    <select class="form-control select2"style="width:100%;" name="amount_salary_payment" >
                                        <option value="1">Select Basic</option>
                                        <option id="amount"></option>
                                    </select>
                                <td>
                                    <select class="form-control select2"style="width:100%;" name="bonus_amount" id="select">
                                        <option>Select Bonus Type</option>
                                        <?php
                                        foreach ($bonus_type as $bonus) {
                                            ?>
                                            <option value="1000"><?php echo $bonus->name_salary_bonus_type; ?>(1000)</option>
                                        <?php }
                                        ?>
                                            <option value="0">No Bonus</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2"style="width:100%;" name="status_salary_payment">
                                        <option value="1">Announced</option>
                                        <option>Not Announced</option>
                                    </select>
                                </td>
                                <td>
<!--                                        <a href="<?php echo base_url() ?>index.php/users_info/update_user/<?php echo $user->id; ?>" class="primary"><span class="glyphicon glyphicon-edit"></span></a>
                                    <a href="<?php echo base_url() ?>index.php/users_info/delete_user/<?php echo $user->id; ?>" class="danger" onclick="return check();"><span class="glyphicon glyphicon-trash"></span></a>-->
                                    <button type="submit" class="btn btn-sm btn-success">Announced</button>
                                </td>
                            </form>
                            </tr>


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Basic</th>
                                    <th>Bonus</th>
                                    <th>Salary Announced or Not</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        
<!--                        <h3>Announced</h3>
                        
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Amount of Total Salary</th>
                                    <th>Salary Announced or Not</th>
                                </tr>
                            </thead>
                            <?php 
                            foreach($edit_salary as $salary){?>
                            <tr>
                                <td><?php echo $salary->id_employee;?></td>
                                <td><?php echo $salary->amount_salary_payment;?></td>
                                <td><?php echo ($salary->status_salary_payment==1)?'Announced':'Not Announced';?></td>
                            </tr>
                            <?php
                            }?>
                        </table>-->
                    </div>



                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>