<?php
class Personal_detail_model extends CI_Model
{
    function insert($data)
    {
        $this->db->insert('users',$data);
        return $this->db->insert_id();

    }
}
?>