<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_login extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        if(isset($_POST)) clean_xss_helper($_POST);
        if(isset($_GET)) clean_xss_helper($_GET);
        $this->load->model('authentication_model');
    }

    public function user()
	{
       $this->load->view('user_login');
	}

    public function validate_user()
    {
        $this->form_validation->set_rules('username', 'Name', 'required|regex_match[/^[a-zA-Z- ]*$/]');
        $this->form_validation->set_rules('password', 'Password', 'required|regex_match[/^([a-zA-Z0-9!@#$%^&*]{6,})$/]');

        if ($this->form_validation->run())
        {   
           $password = $this->input->post('password');
           $password_hash = $this->pass_hash($password);
            $data = array(
            'name'=>$this->input->post('username'),
            'password'=>$password_hash,
            );


            $getuser = $this->authentication_model->validate_login($data);
            if($getuser == TRUE)
            {
                $_SESSION['id']= $getuser->id;
                $_SESSION['name']= $getuser->name;
                $array = array(
                    'status' => 200,
                    'msg' => "Login Successful",
                    );
            }
            else
            {
                $array = array(
                    'status' => 400,
                    'msg' => "Something Went Wrong",
                    );
            }
        } 

        echo json_encode($array);
    }

    public function pass_hash($input_password)
    {
        $hash = hash('sha256',$input_password);
        return $hash;
    } 



}

?>