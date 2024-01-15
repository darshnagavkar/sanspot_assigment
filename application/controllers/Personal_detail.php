<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Personal_detail extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(isset($_POST)) clean_xss_helper($_POST);
        if(isset($_GET)) clean_xss_helper($_GET);
        $this->load->model('personal_detail_model');
    }

    public function index()
	{
       $this->load->view('personal_info');
	}

    public function submit_info()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|regex_match[/^[a-zA-Z- ]*$/]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^([a-zA-Z0-9!@#$%^&*]{6,})$/]');

        if ($this->form_validation->run())
        {
            $password = $this->input->post('password');
            $password_hash = $this->pass_hash($password);
            $data = array(
                'id'=>'',
                'name'=>$this->input->post('name'),
                'email'=>$this->input->post('email'),
                'password'=>$password_hash
            );
            // print_r($data); die();
            $data = $this->personal_detail_model->insert($data);
            echo json_encode(array('status'=>200,'msg'=>'suceess','data'=>$array));
        }
        else
        {
            $array = array(
                'error' => true,
                'name' => form_error('name'),
                'email' => form_error('email'),
                'password' => form_error('password'),
            );
            echo json_encode(array('status'=>400,'msg'=>'error','data'=>$array));
        }
    }

    public function pass_hash($input_password)
    {
        $hash = hash('sha256',$input_password);
        return $hash;
    } 

}