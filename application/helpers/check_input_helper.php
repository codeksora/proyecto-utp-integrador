<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('check_input')){
    function check_input($data, $problem=''){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        if ($problem && strlen($data) == 0) {
            show_err($problem);
        }
        return $data;
    }

    function show_err($myError) {
        $data_resp['myError'] = $myError;
        //get main CodeIgniter object
        $ci =& get_instance();

        //load databse library
        return $ci->load->view('web/error_view', $data_resp);
        
    }
 }