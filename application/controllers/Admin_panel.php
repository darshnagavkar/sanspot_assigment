<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_panel extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        if(isset($_POST)) clean_xss_helper($_POST);
        if(isset($_GET)) clean_xss_helper($_GET);
        $this->load->model('admin_panel_model');
    }

    public function admin()
    {
        $data['users'] = $this->admin_panel_model->fetch_users();
        $this->load->view('admin_panel',$data);
    }

    public function edit_user()
    {
        $id=$this->input->post('id');
        $name=$this->input->post('name');
        $email=$this->input->post('email');
        $result = $this->admin_panel_model->edituser($id,$name,$email);
       // echo $this->db->last_query();
        if($result=== TRUE)
        {
            $array = array(
                'status' => 200,
                'msg' => "Record Edited Successfully",
                );
        }
        else
        {
        $array = array(
            'status' => 400,
            'msg' => "Something Went Wrong",
            );
        }

        echo json_encode($array);

    }
    public function delete_user($id)
    {
        $this->db->delete('users', array('id' => $id)); 
        $this->db->delete('posts', array('user_id' => $id)); 
        return TRUE;
    }

    public function upload_image()
    {
        $extension = pathinfo($_FILES["picfile"]['name'], PATHINFO_EXTENSION);
        $new_name = time() . uniqid();
        $uploaded_img = $new_name . "." . $extension;
    
        $config = [
        'upload_path' =>'./frontend/image/',
        'allowed_types' => 'gif|jpg|png',
        'file_name' => $uploaded_img,
        ];
        $this->load->library('upload',$config);
        if(!$this->upload->do_upload('picfile'))
        {
            echo "Please choose file";
            $this->profile();
        }
        else
        {
            $id=$this->input->post('id');
            $upload = $this->admin_panel_model->update_profile($uploaded_img,$id); 
            if($upload==TRUE)
            {
                $array = array(
                    'status' => 200,
                    'msg' => "Image Uploaded",
                    );
            }
            
            else
            {
                $array = array(
                    'status' => 400,
                    'msg' => "Image Not Uploaded",
                    );
            }
        }
        echo json_encode($array);
    }
}
?>