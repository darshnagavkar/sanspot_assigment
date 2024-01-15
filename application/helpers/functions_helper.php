<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
{
function clean_xss_helper(&$post_val) {
        foreach($post_val as &$data) {
            if (is_array($data)) clean_xss_helper($data);
            else{
                $ci = get_instance();
                $data = $ci->security->xss_clean($data);
               //$data = xss_clean($data);
            }
       }
    }

}