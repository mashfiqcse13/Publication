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
                        <h3 class="box-title">Users Registration</h3>
                    </div><!-- /.box-header -->
                    
                    <?php
                    if ($use_username) {
                        $username = array(
                            'name' => 'username',
                            'id' => 'username',
                            'class' => 'form-control',
                            'value' => set_value('username'),
                            'maxlength' => $this->config->item('username_max_length', 'tank_auth'),
                            'size' => 30,
                        );
                    }
                    $email = array(
                        'name' => 'email',
                        'id' => 'email',
                        'class' => 'form-control',
                        'value' => set_value('email'),
                        'maxlength' => 80,
                        'size' => 30,
                    );
                    $password = array(
                        'name' => 'password',
                        'id' => 'password',
                        'class' => 'form-control',
                        'value' => set_value('password'),
                        'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
                        'size' => 30,
                    );
                    $confirm_password = array(
                        'name' => 'confirm_password',
                        'id' => 'confirm_password',
                        'class' => 'form-control',
                        'value' => set_value('confirm_password'),
                        'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
                        'size' => 30,
                    );
                    $captcha = array(
                        'name' => 'captcha',
                        'id' => 'captcha',
                        'maxlength' => 8,
                    );
                    ?>
                    <?php echo form_open($this->uri->uri_string()); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php if ($use_username) { ?>
                                <?php echo form_label('Username', $username['id']); ?>
                                <?php echo form_input($username, 'form-control'); ?>
                                <span style="color: red;"><?php echo form_error($username['name']); ?><?php echo isset($errors[$username['name']]) ? $errors[$username['name']] : ''; ?></span>

                            <?php } ?>
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
                            <td><?php echo form_password($confirm_password); ?>
                                <span style="color: red;"><?php echo form_error($confirm_password['name']); ?><span>
                                        </div>
                                        </div>

                                        <?php
                                        if ($captcha_registration) {
                                            if ($use_recaptcha) {
                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <div id="recaptcha_image"></div>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
                                                        <div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
                                                        <div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="recaptcha_only_if_image">Enter the words above</div>
                                                        <div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
                                                    </td>
                                                    <td><input type="text" id="recaptcha_response_field" name="recaptcha_response_field" /></td>
                                                    <td style="color: red;"><?php echo form_error('recaptcha_response_field'); ?></td>
                                                    <?php echo $recaptcha_html; ?>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <p>Enter the code exactly as it appears:</p>
                                                        <?php echo $captcha_html; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
                                                    <td><?php echo form_input($captcha); ?></td>
                                                    <td style="color: red;"><?php echo form_error($captcha['name']); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </table>
                                        <?php echo form_submit('register', 'Register', "class='btn btn-success'"); ?>
                                        <?php echo form_close(); ?>

                                        </div>
                                        </div>
                                        </div>




                                        </section><!-- /.content -->
                                        </div><!-- /.content-wrapper -->

                                        <!-- insert book -->
                                        <?php include_once __DIR__ . '/../footer.php'; ?>