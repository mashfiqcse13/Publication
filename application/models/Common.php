<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Model {

    function int_to_bangla_int($int) {
        $bangla_int_char = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        $product = '';
        if (is_int($int)) {
//           for(i=)
            return $product;
        } else
            return 'FALSE';
    }

}
