<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

    public function insert($data)
    {
        $this->db->insert('posts',$data);
        return $this->db->insert_id();
    }
    public function get_posts() 
    {
        $this->db->where('user_id',$_SESSION['id']);
        $sql = $this->db->get('posts');
        return  $sql->result_array();
    }


}
