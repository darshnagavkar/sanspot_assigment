<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_panel_model extends CI_Model {

    public function fetch_users() 
    {
        $sql = $this->db->get('users');
        return  $sql->result_array();
    }

    public function edituser($id,$name,$email)
    {
        $this->db->set('name', $name);
        $this->db->set('email', $email);
        $this->db->where('id',$id);
        $result = $this->db->update('users');
        return $result;
    }

    function update_profile($uploaded_img,$id)
    {  
        $this->db->set('image', $uploaded_img);
        $this->db->where('id', $id);
        $result = $this->db->update('users'); 
        return $result;
    }

}
