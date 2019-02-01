<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();


		$this->data['page_title'] = 'Dashboard';
		
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_stores');
		$this->load->model('model_reports');
	}

	public function index_old()
	{

		$this->data['total_products'] = $this->model_products->countTotalProducts();
		$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_stores'] = $this->model_stores->countTotalStores();

		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->render_template('dashboard', $this->data);
	}
	
	public function index()
	{
	    $today_year = date('Y');
	
	
	    $store_data = $this->model_stores->getStoresData();
	    
	
	
	    $store_id = $store_data[0]['id'];
	
	    if($this->input->post('select_store')) {
	        $store_id = $this->input->post('select_store');
	    }
	
	    if($this->input->post('select_year')) {
	        $today_year = $this->input->post('select_year');
	    }
	
	    $order_data = $this->model_reports->getStoreWiseOrderData($today_year, $store_id);
	    $this->data['report_years'] = $this->model_reports->getOrderYear();
	    $selected_store = $this->model_stores->getStoresData($store_id);
	
	    $final_parking_data = array();
	    foreach ($order_data as $k => $v) {
	        	
	        if(count($v) > 1) {
	            $total_amount_earned = array();
	            foreach ($v as $k2 => $v2) {
	                if($v2) {
	                    $total_amount_earned[] = $v2['net_amount'];
	                }
	            }
	            $final_parking_data[$k] = array_sum($total_amount_earned);
	        }
	        else {
	            $final_parking_data[$k] = 0;
	        }
	        	
	    }
	    
	    $top = $this->model_reports->getTopProducts($store_id);
	    
	
	    $this->data['selected_store'] = $store_id;
	    $this->data['store_data'] = $store_data;
	    $this->data['store'] = $selected_store;
	    $this->data['selected_year'] = $today_year;
	    $this->data['top'] = $top;
	    $this->data['company_currency'] = $this->company_currency();
	    $this->data['results'] = $final_parking_data;
	
	    $this->render_template('reports/storewise', $this->data);
	}
	
	
	
}