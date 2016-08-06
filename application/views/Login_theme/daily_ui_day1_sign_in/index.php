<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$form_attribute = array('class' => 'login');
$submit_attr = 'class="login-submit"';

$login = array(
    'name' => 'login',
    'id' => 'login',
    'class' => 'login-input',
    'placeholder' => "Email Address",
    'value' => set_value('login'),
    'maxlength' => 80,
    'size' => 30,
    'autofocus' => ''
);
if ($login_by_username AND $login_by_email) {
    $login_label = 'Email or login';
} else if ($login_by_username) {
    $login_label = 'Login';
} else {
    $login_label = 'Email';
}

$password = array(
    'name' => 'password',
    'id' => 'password',
    'class' => 'login-input',
    'placeholder' => "Password",
    'size' => 30,
);
$remember = array(
    'name' => 'remember',
    'id' => 'remember',
    'value' => 1,
    'checked' => set_value('remember'),
    'style' => 'margin:0;padding:0',
);
$captcha = array(
    'name' => 'captcha',
    'id' => 'captcha',
    'maxlength' => 8,
);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>

        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?= $login_theme_asset_url ?>css/animate.css">
        <!-- Custom Stylesheet -->
        <link rel="stylesheet" href="<?= $login_theme_asset_url ?>css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="top">
                <h1 id="title" class="hidden" style="text-align: center"><span id="logo"><?= $SITE['name'] ?><span></span></span></h1>
            </div>
            <div class="login-box animated fadeInUp">
                <div class="box-header">
                    <h2>Log In</h2>
                </div>
                <?php echo form_open($this->uri->uri_string(), $form_attribute); ?>
                <?php echo form_input($login); ?>
                <?php echo form_password($password); ?>
                <table>
                    <?php
                    if ($show_captcha) {
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
                                <td colspan="2"><?php echo form_label('Confirmation Code', $captcha['id']); ?></td>
                                <td><?php echo form_input($captcha); ?></td>

                            </tr>
                            <tr>
                                <td colspan="3" style="color: red;"><?php echo form_error($captcha['name']); ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>

                    <tr>
                        <td colspan="3">
                            <?php // echo form_checkbox($remember); ?>
                            <?php // echo form_label('Remember me', $remember['id']); ?>
                        </td>
                    </tr>
                </table>
                <?php echo form_submit('submit', 'Let me in',$submit_attr); ?> <br />
                
                <?php echo form_checkbox($remember); ?>
                            <?php echo form_label('Remember me', $remember['id']); ?>
                <p class="login-help"><?php echo anchor('/auth/forgot_password/', 'Forgot password'); ?></p>
                <?php echo form_close(); ?>
            </div>

            <section class="about">
                <p class="about-links">
                    <?= anchor($SITE['website'], "Main Site", 'target="_blank"') ?>
                    <?php if ($this->config->item('allow_registration', 'tank_auth')) echo anchor('#', 'Register'); ?>       
                </p>
                <p class="about-author">
                    &copy; <?= date("Y") ?> <?= anchor($SITE['website'], $SITE['name'], 'target="_blank"') ?>
                    Developed by <?= anchor($DEVELOPER['website'], $DEVELOPER['name'], 'target="_blank"') ?>  
                </p>
            </section>
        </div>
    </body>

    <script>
        $(document).ready(function () {
            $('#logo').addClass('animated fadeInDown');
            $("input:text:visible:first").focus();
        });
        $('#username').focus(function () {
            $('label[for="username"]').addClass('selected');
        });
        $('#username').blur(function () {
            $('label[for="username"]').removeClass('selected');
        });
        $('#password').focus(function () {
            $('label[for="password"]').addClass('selected');
        });
        $('#password').blur(function () {
            $('label[for="password"]').removeClass('selected');
        });
    </script>

</html>