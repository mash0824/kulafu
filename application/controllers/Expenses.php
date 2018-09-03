<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->not_logged_in();
        $this->data['page_title'] = 'Expenses';
        $this->load->model('model_expenses');
        $this->load->model('model_users');
    }
    
    public function index()
    {
        $this->render_template('expenses/index', $this->data);
    }
    
    
    public function fetchExpensesData(){
        $result = array('data' => array());
        $user_id = $this->session->userdata('id');
		// get store id from user id 
		
        $data = $this->model_expenses->getExpensesData();
        foreach ($data as $key => $value) {
            // button
            $buttons = '';
        
            if(in_array('updateCategory', $this->permission)) {
                $buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
            }
        
            if(in_array('deleteCategory', $this->permission)) {
                $buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
            
            $date_time = date('F d,Y h:i a', strtotime($value['timestamp']));
            $user_data = $this->model_users->getUserData($value['user_id']);
            $result['data'][$key] = array(
                $value['name'],
                $value['amount'],
                $value['description'],
                $date_time,
                $user_data['firstname']." ".$user_data['lastname'],
                $buttons
            );
        } // /foreach
        
        echo json_encode($result);
    }
    
    public function create(){
        $response = array();
        
        $this->form_validation->set_rules('expense_name', 'Expense name', 'trim|required');
        $this->form_validation->set_rules('expense_amount', 'Expense amount', 'trim|required|numeric');
        $this->form_validation->set_rules('expense_description', 'Expense description', 'trim');
        $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
        
        if ($this->form_validation->run() == TRUE) {
            $data = array(
                'name' => $this->input->post('expense_name'),
                'amount' => $this->input->post('expense_amount'),
                'description' => $this->input->post('expense_description'),
                'date_time' => strtotime(date('Y-m-d h:i:s a')),
                'timestamp' => date("Y-m-d H:i:s"),
                'user_id' => $this->session->userdata('id'),
                'store_id' => 1
            );
        
            $create = $this->model_expenses->create($data);
            if($create == true) {
                $response['success'] = true;
                $response['messages'] = 'Succesfully created';
            }
            else {
                $response['success'] = false;
                $response['messages'] = 'Error in the database while creating the brand information';
            }
        }
        else {
            $response['success'] = false;
            foreach ($_POST as $key => $value) {
                $response['messages'][$key] = form_error($key);
            }
        }
        
        echo json_encode($response);
    }
    
    public function fetchExpensesDataById($id = null)
    {
        if($id) {
            $data = $this->model_expenses->getExpensesData($id);
            echo json_encode($data);
        }
    
    }
    
    public function update($id){
        $response = array();
        
        if($id) {
            $this->form_validation->set_rules('edit_expense_name', 'Expense name', 'trim|required');
            $this->form_validation->set_rules('edit_expense_amount', 'Expense amount', 'trim|required|numeric');
            $this->form_validation->set_rules('edit_expense_description', 'Expense description', 'trim');
            $this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');
        
            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'name' => $this->input->post('edit_expense_name'),
                    'amount' => $this->input->post('edit_expense_amount'),
                    'description' => $this->input->post('edit_expense_description'),
                );
        
                $update = $this->model_expenses->update($id, $data);
                if($update == true) {
                    $response['success'] = true;
                    $response['messages'] = 'Succesfully updated';
                }
                else {
                    $response['success'] = false;
                    $response['messages'] = 'Error in the database while updated the brand information';
                }
            }
            else {
                $response['success'] = false;
                foreach ($_POST as $key => $value) {
                    $response['messages'][$key] = form_error($key);
                }
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = 'Error please refresh the page again!!';
        }
        
        echo json_encode($response);
    }
    
    public function remove()
    {
        // if(!in_array('deleteStore', $this->permission)) {
        // 	redirect('dashboard', 'refresh');
        // }
    
        $expense_id = $this->input->post('expense_id');
    
        $response = array();
        if($expense_id) {
            $delete = $this->model_expenses->remove($expense_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed";
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the brand information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }
    
        echo json_encode($response);
    }
    
}