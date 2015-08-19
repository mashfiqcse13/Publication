<?php
	/* 
	 * To change this license header, choose License Headers in Project Properties.
	 * To change this template file, choose Tools | Templates
	 * and open the template in the editor.
	 */


$form_attribute = array('class' => 'login');
$submit_attr = 'class="login-submit"';

$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'class'	=> 'login-input',
        'placeholder' => "Email Address",
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
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
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
	?>
<!DOCTYPE html>
<!--[if lt IE 7]> 
<html class="lt-ie9 lt-ie8 lt-ie7" lang="en">
	<![endif]-->
	<!--[if IE 7]> 
	<html class="lt-ie9 lt-ie8" lang="en">
		<![endif]-->
		<!--[if IE 8]> 
		<html class="lt-ie9" lang="en">
			<![endif]-->
			<!--[if gt IE 8]><!--> 
<html lang="en">
        <!--<![endif]-->
        <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <title><?= $title ?></title>
                <link rel="stylesheet" href="<?= $login_theme_asset_url ?>css/style.css">
                <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        </head>
        <body>
                <?php echo form_open($this->uri->uri_string(),$form_attribute);?>
                        <h1><?= $this->config->item('SITE_NAME') ?></h1>
                        <!--<input type="email" name="email" class="login-input" placeholder="Email Address" autofocus>-->
                        <?php echo form_input($login); ?>
                        <input type="password" name="password" class="login-input" placeholder="Password">
                        <!--<input type="submit" value="Login" class="login-submit">-->
                        <?php echo form_submit('submit', 'Let me in',$submit_attr); ?>
                        <p class="login-help"><a href="index.html">Forgot password?</a></p>
                <?php echo form_close(); ?>
                <section class="about">
                        <p class="about-links">
                                <a href="#" target="_parent">Main Site</a>
                                <a href="#" target="_parent">Register</a>
                        </p>
                        <p class="about-author">
                                &copy; <?=  date("Y")?> <a href="<?= base_url() ?>" target="_blank"><?= $site_name ?></a><br>
                                Developed by <a href="#" target="_blank"><?= $DEVELOPED_BY ?></a>
                        </p>
                </section>
        </body>
</html>