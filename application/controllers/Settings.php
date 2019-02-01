<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Settings extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Settings';
		$this->load->model('model_brands');
		$this->load->model('model_units');
	}
	
	public function brands(){
	    if(!in_array('viewSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $groups_data = $this->model_brands->getBrandsData();
	    $this->data['brands_data'] = $groups_data;
	    
	    $this->render_template('settings/brands', $this->data);
	}
	
	public function brandEdit($id=null){
	    if(!in_array('updateSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    if($id) {
	    
	        $this->form_validation->set_rules('name', 'Brand name', 'required');
	        	
	        if ($this->form_validation->run() == TRUE) {
	            // true case
	            $data = array(
	                'name' => $this->input->post('name')
	            );
	    
	            $update = $this->model_brands->update($data, $id);
	            if($update == true) {
	                $this->session->set_flashdata('success', 'Successfully updated');
	                redirect('settings/brands', 'refresh');
	            }
	            else {
	                $this->session->set_flashdata('errors', 'Error occurred!!');
	                redirect('settings/brandEdit/'.$id, 'refresh');
	            }
	        }
	        else {
	            // false case
	            $customer_data = $this->model_brands->getBrandsData($id);
	            $this->data['brands_data'] = $customer_data;
	            $this->render_template('settings/brandEdit', $this->data);
	        }
	    }
	}
	
	public function brandCreate(){
	    if(!in_array('createSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $this->form_validation->set_rules('name', 'Brand name', 'required');
	    
	    if ($this->form_validation->run() == TRUE) {
	        // true case
	        $data = array(
	            'name' => $this->input->post('name')
	        );
	    
	        $create = $this->model_brands->create($data);
	        if($create == true) {
	            $this->session->set_flashdata('success', 'Successfully created');
	            redirect('settings/brands', 'refresh');
	        }
	        else {
	            $this->session->set_flashdata('errors', 'Error occurred!!');
	            redirect('settings/brandCreate', 'refresh');
	        }
	    }
	    else {
	        $this->render_template('settings/brandCreate',$this->data);
	    }
	}
	
	public function brandView($id=null){
	    if(!in_array('viewSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    if($id) {
	        $customer_data = $this->model_brands->getBrandsData($id);
	        $this->data['brands_data'] = $customer_data;
	        $this->render_template('settings/brandView', $this->data);
	    }
	}
	
	public function brandDelete($id=null){
	    if(!in_array('deleteSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    if($id) {
	        if($this->input->post('confirm')) {
	            //
	            $check = false;
	            if($check == true) {
	                $this->session->set_flashdata('error', 'Brand exists in the warehouse');
	                redirect('settings/brands', 'refresh');
	            }
	            else {
	                $data = array(
	                    "is_active" => 0
	                );
	                $delete = $this->model_brands->update($data, $id);
	                if($delete == true) {
	                    $this->session->set_flashdata('success', 'Successfully removed');
	                    redirect('settings/brands', 'refresh');
	                }
	                else {
	                    $this->session->set_flashdata('error', 'Error occurred!!');
	                    redirect('settings/brandDelete/'.$id, 'refresh');
	                }
	            }
	        }
	        else {
	            $this->data['id'] = $id;
	            $this->render_template('settings/brandDelete', $this->data);
	        }
	    }
	}
	
    public function units(){
	    if(!in_array('viewSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $groups_data = $this->model_units->getUnitsData();
	    $this->data['units_data'] = $groups_data;
	    
	    $this->render_template('settings/units', $this->data);
	}
	
	public function unitEdit($id=null){
	    if(!in_array('updateSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    if($id) {
	    
	        $this->form_validation->set_rules('name', 'Unit name', 'required');
	        	
	        if ($this->form_validation->run() == TRUE) {
	            // true case
	            $data = array(
	                'name' => $this->input->post('name')
	            );
	    
	            $update = $this->model_units->update($data, $id);
	            if($update == true) {
	                $this->session->set_flashdata('success', 'Successfully updated');
	                redirect('settings/units', 'refresh');
	            }
	            else {
	                $this->session->set_flashdata('errors', 'Error occurred!!');
	                redirect('settings/unitEdit/'.$id, 'refresh');
	            }
	        }
	        else {
	            // false case
	            $customer_data = $this->model_units->getUnitsData($id);
	            $this->data['units_data'] = $customer_data;
	            $this->render_template('settings/unitEdit', $this->data);
	        }
	    }
	}
	
	public function unitCreate(){
	    if(!in_array('createSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $this->form_validation->set_rules('name', 'Unit name', 'required');
	    
	    if ($this->form_validation->run() == TRUE) {
	        // true case
	        $data = array(
	            'name' => $this->input->post('name')
	        );
	    
	        $create = $this->model_units->create($data);
	        if($create == true) {
	            $this->session->set_flashdata('success', 'Successfully created');
	            redirect('settings/units', 'refresh');
	        }
	        else {
	            $this->session->set_flashdata('errors', 'Error occurred!!');
	            redirect('settings/unitCreate', 'refresh');
	        }
	    }
	    else {
	        $this->render_template('settings/unitCreate',$this->data);
	    }
	}
	
	public function unitView($id=null){
	    if(!in_array('viewSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    if($id) {
	        $customer_data = $this->model_units->getUnitsData($id);
	        $this->data['units_data'] = $customer_data;
	        $this->render_template('settings/unitView', $this->data);
	    }
	}
	
	public function unitDelete($id=null){
	    if(!in_array('deleteSetting', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    if($id) {
	        if($this->input->post('confirm')) {
	            //
	            $check = false;
	            if($check == true) {
	                $this->session->set_flashdata('error', 'Unit exists in the warehouse');
	                redirect('settings/units', 'refresh');
	            }
	            else {
	                $data = array(
	                    "is_status" => 0
	                );
	                $delete = $this->model_units->update($data, $id);
	                if($delete == true) {
	                    $this->session->set_flashdata('success', 'Successfully removed');
	                    redirect('settings/units', 'refresh');
	                }
	                else {
	                    $this->session->set_flashdata('error', 'Error occurred!!');
	                    redirect('settings/unitDelete/'.$id, 'refresh');
	                }
	            }
	        }
	        else {
	            $this->data['id'] = $id;
	            $this->render_template('settings/unitDelete', $this->data);
	        }
	    }
	}
}