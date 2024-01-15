<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function authenticate($username, $password) {
        // Your authentication logic goes here
        // For simplicity, this example checks against a hardcoded user
        $hashed_password = password_hash('password123', PASSWORD_DEFAULT);

        if ($username === 'demo' && password_verify($password, $hashed_password)) {
            return ['id' => 1, 'username' => 'demo']; // Simulated user data
        } else {
            return null;
        }
    }
}
