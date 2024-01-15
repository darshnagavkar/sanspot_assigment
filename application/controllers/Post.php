<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
    }

    public function add_post()
    {
        $this->load->view('add_new_post');
    }

    public function submit_post()
    {
        $data = array(
            'user_id' => $_SESSION['id'],
            'title'=>$this->input->post('title'),
            'content'=>$this->input->post('content')
        );
        $data = $this->post_model->insert($data);
        echo json_encode(array('status'=>200,'msg'=>'suceess'));
    }
    public function show_posts() {
      
        $data['posts'] = $this->post_model->get_posts();
      //   print_r($data);
       // echo $this->db->last_query();
        $this->load->view('posts',$data);
        // $posts = $this->post_model->get_posts();
        // echo json_encode(array('status'=>200,'data'=> $posts));
    }
}
?>