<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {


	public function __construct(){
		parent::__construct();
	}

    public function index(){
        $this->load->view('login');
        // var_dump($this->session->userdata());
        // die;
    }

    public function verification()
    {
        $post = $this->input->post();

        $data = array(
            "username" => $post['username'],
            "password" => $post['password'],
        );

        $response = optimus_curl('GET', api_url('login'), $data);

        if($response->status == 'success'){
            $this->set_user_session($response->data);
        }
        $data['status'] = $response->status;
        $data['message'] = $response->message;

        echo json_encode($data);
    }

    public function set_user_session($data)
    {
        $this->session->set_userdata('id', $data->id);
        $this->session->set_userdata('name', $data->name);
        $this->session->set_userdata('logged_in', true);
    }

}
?>
