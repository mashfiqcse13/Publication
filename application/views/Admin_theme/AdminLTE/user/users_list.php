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
            <li class="active">Users section</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="box">

                    <div class="box-header">
                        <a href="<?php echo base_url();?>index.php/users_info/add_user" class="btn btn-success">Add User</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover">
                            
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Email</th>
                                    <th>Activated</th>
                                    <th>Banned</th>
                                    <th>Reason of Banned</th>
                                    <th>Last Login</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($user_info as $user) {
                                        
                                ?>
                                <tr>
                                    <td><?php echo $user->username;?></td>
                                    <td><?php echo $user->password;?></td>
                                    <td><?php echo $user->email;?></td>
                                    <td><?php echo ($user->activated)?'active':'inactive';?></td>
                                    <td><?php echo $user->banned;?></td>
                                    <td><?php echo $user->ban_reason;?></td>
                                    <td><?php echo $user->last_login;?></td>
                                    <td>
                                        <a href="<?php echo base_url()?>index.php/users_info/update_user/<?php echo $user->id;?>" class="primary"><span class="glyphicon glyphicon-edit"></span></a>
                                        <a href="<?php echo base_url()?>index.php/users_info/delete_user/<?php echo $user->id;?>" class="danger" onclick="return check();"><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>
                                <?php                                        
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Email</th>
                                    <th>Activated</th>
                                    <th>Banned</th>
                                    <th>Reason of Banned</th>
                                    <th>Last Login</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                </div>

            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<!-- insert book -->



<?php include_once __DIR__ . '/../footer.php'; ?>