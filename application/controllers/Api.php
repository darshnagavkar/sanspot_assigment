<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Post_model');
    }

    public function index()
	{
       $this->load->view('user_login');
	}
    public function login() {
        // Your authentication logic goes here
        // For simplicity, this example just checks if a username and password are provided
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($username && $password) {
            $user = $this->User_model->authenticate($username, $password);

            if ($user) {
                // Successful authentication
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['message' => 'Login successful', 'user_id' => $user['id']]));
            } else {
                $this->output
                    ->set_status_header(401)
                    ->set_content_type('application/json')
                    ->set_output(json_encode(['message' => 'Authentication failed']));
            }
        } else {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['message' => 'Invalid request']));
        }
    }

    public function get_posts() {
        // Your code to retrieve posts goes here
        $posts = $this->Post_model->get_posts();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($posts));
    }

    // Other CRUD operations for posts can be added similarly
}
?>