<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form')
                   ->helper('security')// 如需使用xss_clean等驗證功能
                   ->helper('url')
                   ->library('form_validation')
                   ->model('user_model');
    }
	
	public function index()
	{
        $this->load->view('templates/header')
                   ->view('user')
                   ->view('templates/footer');
    }
    
    public function getList()
    {
        $page = $this->input->get('page');
        $perpage = $this->input->get('perpage');
        $UserList = $this->user_model->getList(($page)?? NULL, ($perpage)?? NULL);
        if ($UserList) {
            $data['data'] = $UserList;
        } else {
            $data['message'] = "參數有誤";
        }
        echo json_encode($data);   
    }

    public function create()
    {
        $this->form_validation->set_rules('username', 'UserName', 'trim|required|xss_clean');
        $this->form_validation->set_rules('usermail', 'UserMail', 'trim|required|valid_email|is_unique[user.user_email]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        $this->form_validation->set_rules('confirmPassword', 'ConfirmPassword', 'trim|required|matches[password]|xss_clean');
        $isPass = $this->form_validation->run();
        if ($isPass) {
            $data = array(
                'user_name' => $this->input->post('username'),
                'user_email' => $this->input->post('usermail'),
                'user_password' => $this->input->post('password')
            );
            $isCreate = $this->user_model->create($data);
            $result['message'] = ($isCreate)? 'Ok': 'Create Faild';
        } else {
            $result['message'] = 'Validate Faild';
        }
        echo json_encode($result);
    }

    public function delete()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        $isPass = $this->form_validation->run();
        if ($isPass) {
            $data = array(
                'id' => $this->input->post('id')
            );
            $isDel = $this->user_model->delete($data);
            $result['message'] = ($isDel)? 'Ok' : 'Delete Faild';
        } else {
            $result['message'] = 'Validated Faild';
        }
        echo json_encode($result);
    }

    public function edit()
    {
        $this->form_validation->set_rules('id', 'id', 'trim|required|integer');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $isPass = $this->form_validation->run();
        if ($isPass) {
            $data = array(
                'id' => $this->input->post('id'),
                'user_name' => $this->input->post('username')
            );
            $isUpdate = $this->user_model->edit($data);
            $result['message'] = ($isUpdate)? 'Ok' : 'Update Faild';
        } else {
            $result['message'] = 'Validated Faild';
        }
        echo json_encode($result);
    }

}