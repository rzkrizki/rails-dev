<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Todolist extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function _remap($method, $param = array())
    {
        $session = $this->session->userdata('logged_in');
        if (method_exists($this, $method)) {
            if (!empty($session)) {
                return call_user_func_array(array($this, $method), $param);
            } else {
                redirect('login', 'refresh');
            }
        } else {
            redirect(base_url('welcome'));
        }
    }

    public function index()
    {
        init_view('todolist');
    }

    public function get_todolist()
    {

        $data = array('user_id' => $this->session->userdata('id'));

        $response = optimus_curl('GET', api_url('tasks'), $data);
        $data['results'] = $response->data;

        $view = $this->load->view('table', $data);

        echo json_encode($view);
    }

    public function get_detail_data()
    {
        $post = $this->input->post();

        $response = optimus_curl('GET', api_url('tasks/' . trim($post["id"])), $data = '');

        $data['results'] = $response->data;
        $data['message'] = $response->message;
        $data['status'] = $response->status;

        echo json_encode($data);
    }

    public function save()
    {
        $post = $this->input->post();

        if ($post['task_id'] == 0) {
            $data = array(
                "last_date" => date("Y-m-d", strtotime($post['date'])),
                "mytask" => $post['mytask'],
                "priority" => $post['priority'],
                "is_done" => 0,
                "user_id" => $this->session->userdata('id')
            );

            $response = optimus_curl('POST', api_url('tasks'), $data);
        } else {
            $data = array(
                "last_date" => date("Y-m-d", strtotime($post['date'])),
                "mytask" => $post['mytask'],
                "priority" => $post['priority'],
            );

            $response = optimus_curl('PUT', api_url('tasks/' . trim($post["task_id"])), $data);
        }

        $data['message'] = $response->message;
        $data['status'] = $response->status;

        echo json_encode($data);
    }

    public function delete()
    {
        $post = $this->input->post();

        $response = optimus_curl('PUT', api_url('tasks/' . trim($post["id"])), $data = '');

        $data['message'] = $response->message;
        $data['status'] = $response->status;
        echo json_encode($response);
    }

    public function update()
    {
        $post = $this->input->post();

        $data = array(
            'is_done' => $post['type']
        );

        $response = optimus_curl('PUT', api_url('tasks/' . trim($post["id"])), $data);

        $data['message'] = $response->message;
        $data['status'] = $response->status;

        echo json_encode($data);
    }
}
