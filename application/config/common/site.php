<?php

/* 
 * To change this license header]=choose License Headers in Project Properties.
 * To change this template file]=choose Tools | Templates
 * and open the template in the editor.
 */

$config['SITE_NAME']        = "Jomuna Publication";
$config['DEVELOPED_BY']     = "Friends IT";

$config['ASSET_FOLDER']     ="asset/";

$config['ADMIN_THEME']      ='Admin_theme/AdminLTE/'; //Theme location on view folder
$config['THEME_ASSET']      =$config['ASSET_FOLDER'].$config['ADMIN_THEME'];

$config['book_categories']  =array('Bangla','English','Math','ICT');
$config['LOGIN_THEME']      ='Login_theme/facebook-login/'; //Theme location on view folder


$config['book_categories']  = array(
                                'Bangla'=>'Bangla',
                                'English'=>'English',
                                'Math'=>'Math',
                                'ICT'=>'ICT');
$config['storing_place']  = array(
                                'Printing Press'=>'Printing Press',
                                'Binding Store'=>'Binding Store',
                                'Sales Store'=>'Sales Store');
$config['contact_type']  = array(
                                'Printing Press'=>'Printing Press',
                                'Binding Store'=>'Binding Store',
                                'Sales Store'=>'Sales Store',
                                'Buyer'=>'Buyer');