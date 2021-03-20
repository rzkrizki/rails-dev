<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Todolist extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

    public function index(){
        init_view('todolist');
    }

    public function get_todolist(){

        $data = array('user_id' => 3);

        $response = optimus_curl('GET', api_url('tasks'), $data);
        $data['results'] = $response->data;

        $view = $this->load->view('table', $data);

        echo json_encode($view);
    }

    public function get_todolists()
    {
        $okee = 'kksksks';
        echo json_encode($okee);
    }

    public function save()
    {
        $post = $this->input->post();

        $data = array(
            "last_date" => date("Y-m-d", strtotime($post['date'])),
            "mytask" => $post['mytask'],
            "priority" => $post['priority'],
            "is_done" => 0,
            "user_id" => 3
        );

        $response = optimus_curl('POST', api_url('tasks/'), $data);

        $data['message'] = $response->message;

         echo json_encode($data);
    }

    public function delete()
    {
        $post = $this->input->post();

        $response = optimus_curl('DELETE', api_url('tasks/'.$post['id']), $data = '');

        // $data['message'] = $response->message;
         echo json_encode($response);
    }

    public function update()
    {
        $post = $this->input->post();

        $data = array(
            'is_done' => 1
        );

        $response = optimus_curl('PUT', api_url('tasks/'.$post['id']), $data);

        $data['message'] = $response->message;

        var_dump($response);
        die;

        // echo json_encode($response);
    }

}
?>
