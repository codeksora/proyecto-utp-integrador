<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    // public function __construct() {
    //     $this->CI =& get_instance();
    // }   

    // function valid_url($str){

    //         $pattern = "/^([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
    //         if (!preg_match($pattern, $str)) {
    //             return FALSE;
    //         }

    //         return TRUE;
    // }

    public function edit_unique($str, $field) {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'id !=' => $id, 'status_id !=' => 3))->num_rows() === 0)
            : FALSE;
    }

    public function is_unique($str, $field) {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'status_id !=' => 3))->num_rows() === 0)
            : FALSE;
    }

    public function valid_date($date) {
        // $d = DateTime::createFromFormat('Y-m-d', $date);
        // return $d && $d->format('Y-m-d') === $date;
        return date_parse($date);
    }

    // public function diff_date($str, $field){

    //     // $pattern = "/^([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
    //     // if (!preg_match($pattern, $str)) {
    //     //     return FALSE;
    //     // }

    //     diff()

    //     return FALSE;
    // }

}