<?php
class Authentication_model extends CI_Model
{
    function validate_login($data)
    {
        $this->db->where('name', $data['name']);
        $this->db->where('password', $data['password']);
        $sql = $this->db->get('users');
        return  $sql->row();
    }
}
?>