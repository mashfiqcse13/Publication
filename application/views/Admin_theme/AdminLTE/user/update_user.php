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
                    <div class="box-header with-border">
                        <h3 class="box-title">Update users info</h3>
                    </div><!-- /.box-header -->
                    <?php
                    foreach ($users as $user) {
                        ?>
                        <?php
                        $username = array(
                            'name' => 'username',
                            'id' => 'username',
                            'class' => 'form-control',
                            'value' => $user->username,
                            'maxlength' => $this->config->item('username_max_length', 'tank_auth'),
                            'size' => 30,
                        );
                        $email = array(
                            'name' => 'email',
                            'id' => 'email',
                            'class' => 'form-control',
                            'value' => $user->email,
                            'maxlength' => 80,
                            'size' => 30,
                        );
                        $password = array(
                            'name' => 'password',
                            'id' => 'password',
                            'class' => 'form-control',
                            'size' => 30,
                        );
                        $confirm_password = array(
                            'name' => 'confirm_password',
                            'id' => 'confirm_password',
                            'class' => 'form-control',
                            'size' => 30,
                        );
                        $activation = array(
                            'name' => 'activated',
                            'id' => 'activated',
                            'class' => 'form-control activated',
                        );
                        $options = array(
                            '1' => 'Active',
                            '0' => 'Inactive'
                        );
                        $id = array(
                            'name' => 'id',
                            'type' => 'hidden',
                            'value' => $user->id,
                            'size' => 30,
                        );
                        $captcha = array(
                            'name' => 'captcha',
                            'id' => 'captcha',
                            'maxlength' => 8,
                        );
                        ?>
                        <?php echo form_open('users_info/updata_data',"name='form'"); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <?php echo form_label('Username', $username['id']); ?>
                                <?php echo form_input($username); ?>
                                <?php echo form_input($id); ?>
                                <span style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']]) ? $errors[$username['name']] : ''; ?></span>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Email Address', $email['id']); ?>
                                <?php echo form_input($email); ?>
                                <span style="color: red;"><?php echo form_error($email['name']); ?><?php echo isset($errors[$email['name']]) ? $errors[$email['name']] : ''; ?></span>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Password', $password['id']); ?>
                                <?php echo form_password($password); ?>
                                <span style="color: red;"><?php echo form_error($password['name']); ?></span>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Confirm Password', $confirm_password['id']); ?>
                                <?php echo form_password($confirm_password); ?>
                                <span style="color: red;"><?php echo form_error($confirm_password['name']); ?></span>
                            </div>
                            <div class="form-group">
                                <?php echo form_label('Activation', $activation['id']); ?>
                                <?php echo form_dropdown($activation,$options); ?>
                                <span style="color: red;"><?php echo form_error($activation['name']); ?></span>
                            </div>

                        </div>



                         <?php echo form_submit('register', 'Update User', "class='btn btn-success'"); ?>
                        <?php echo form_close(); ?>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>




    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
      document.forms['form'].elements['activated'].value  = <?php echo $user->activated;?>;
</script>
<!-- insert book -->
<?php include_once __DIR__ . '/../footer.php'; ?>