<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Customers extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Customers';
		

		$this->load->model('model_customer');
	}

	public function index()
	{
		if(!in_array('viewCustomer', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$groups_data = $this->model_customer->getCustomerData();
		$this->data['customers_data'] = $groups_data;

		$this->render_template('customers/index', $this->data);
	}

	public function create()
	{
		if(!in_array('createCustomer', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $nextID = $this->model_customer->getNextIncrementID();
        $cs_id = "CS-".sprintf("%011s",$nextID[0]['nextId']);
		$this->form_validation->set_rules('customer_name', 'Customer name', 'required|is_unique[customers.customer_name]');
		$this->form_validation->set_rules('address', 'Delivery Address', 'trim|required');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
        	$data = array(
        		'customer_name' => $this->input->post('customer_name'),
        		'cs_id' => $cs_id,
        		'address' => $this->input->post('address'),
        		'contact_person' => $this->input->post('contact_person'),
        		'customer_name' => $this->input->post('customer_name'),
        		'email' => $this->input->post('email')
        	);

        	$create = $this->model_customer->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('customers/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('customers/create', 'refresh');
        	}
        }
        else {
            // false case
            $data = array(
                'cs_id' => $cs_id
            );
            $this->data['customers_data'] = $data;
            $this->render_template('customers/create', $this->data);
        }	

		
	}
	
	public function view($id = null){
	    if(!in_array('viewCustomer', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    if($id) {
	        $customer_data = $this->model_customer->getCustomerData($id);
	        $this->data['customers_data'] = $customer_data;
	        $this->render_template('customers/view', $this->data);
	    }
	}

	public function edit($id = null)
	{
		if(!in_array('updateCustomer', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if($id) {

			$this->form_validation->set_rules('customer_name', 'Customer name', 'required|is_unique[customers.customer_name]');
			$this->form_validation->set_rules('address', 'Delivery Address', 'trim|required');
			$this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			
			if ($this->form_validation->run() == TRUE) {
	            // true case
	        	$data = array(
	        		'customer_name' => $this->input->post('customer_name'),
	        		'address' => $this->input->post('address'),
	        		'contact_person' => $this->input->post('contact_person'),
	        		'customer_name' => $this->input->post('customer_name'),
	        		'email' => $this->input->post('email')
	        	);

	        	$update = $this->model_customer->update($data, $id);
	        	if($update == true) {
	        		$this->session->set_flashdata('success', 'Successfully updated');
	        		redirect('customers/', 'refresh');
	        	}
	        	else {
	        		$this->session->set_flashdata('errors', 'Error occurred!!');
	        		redirect('customers/edit/'.$id, 'refresh');
	        	}
	        }
	        else {
	            // false case
	            $customer_data = $this->model_customer->getCustomerData($id);
                $this->data['customers_data'] = $customer_data;
				$this->render_template('customers/edit', $this->data);	
	        }	
		}

		
	}

	public function delete($id)
	{
		if(!in_array('deleteCustomer', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		if($id) {
		    $data = array(
		        "is_status" => 0
		    );
		    $delete = $this->model_customer->update($data, $id);
		    if($delete == true) {
		        $response['success'] = true;
	            $response['messages'] = "Successfully removed";
		    }
		    else {
		        $response['success'] = false;
	            $response['messages'] = "Refresh the page again!!";
		    }
		}
		echo json_encode($response);
	}


}