<?php 

class Warehouses extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();
		
		$this->data['page_title'] = 'Warehouses';
		$this->load->model('model_stores');
		$this->load->model('model_products');
		$this->load->model('model_customer');
		$this->load->model('model_brands');
		$this->load->model('model_units');
		$this->load->model('model_customer');
	}
	
	public function index()
	{
	    if(!in_array('viewWarehouse', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $warehouse_data = $this->model_stores->getStoresData();
	      $this->data['warehouse_data'] = $warehouse_data;
	    $this->render_template('stores/index', $this->data);
	}
	
	
	
	public function create()
	{
	    if(!in_array('createWarehouse', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $nextID = $this->model_stores->getNextIncrementID();
	    $cs_id = "WH-".sprintf("%011s",$nextID[0]['nextId']);
	    $this->form_validation->set_rules('name', 'Warehouse', 'required');
	    $this->form_validation->set_rules('address', 'Address', 'trim|required');
	
	    if ($this->form_validation->run() == TRUE) {
	        // true case
	        $data = array(
	            'name' => $this->input->post('name'),
	            'warehouse_disp_id' => $cs_id,
	            'address' => $this->input->post('address')
	        );
	
	        $create = $this->model_stores->create($data);
	        if($create == true) {
	            $this->session->set_flashdata('success', 'Successfully created');
	            redirect('warehouses/', 'refresh');
	        }
	        else {
	            $this->session->set_flashdata('errors', 'Error occurred!!');
	            redirect('warehouse/create', 'refresh');
	        }
	    }
	    else {
	        // false case
	        $data = array(
	            'warehouse_disp_id' => $cs_id
	        );
	        $this->data['warehouses_data'] = $data;
	        $this->render_template('stores/create', $this->data);
	    }
	}
	
	public function edit($id = null)
	{
	    if(!in_array('updateWarehouse', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    if($id) {
	
	        $this->form_validation->set_rules('name', 'Warehouse', 'required');
	        $this->form_validation->set_rules('address', 'Address', 'trim|required');
	        	
	        if ($this->form_validation->run() == TRUE) {
	            // true case
	            $data = array(
	                'name' => $this->input->post('name'),
	                'address' => $this->input->post('address'),
	            );
	
	            $update = $this->model_stores->update($id,$data);
	            if($update == true) {
	                $this->session->set_flashdata('success', 'Successfully updated');
	                redirect('warehouses/', 'refresh');
	            }
	            else {
	                $this->session->set_flashdata('errors', 'Error occurred!!');
	                redirect('warehouses/edit/'.$id, 'refresh');
	            }
	        }
	        else {
	            // false case
	            $customer_data = $this->model_stores->getStoresData($id);
	            $this->data['warehouses_data'] = $customer_data;
	            $this->render_template('stores/edit', $this->data);
	        }
	    }
	
	
	}
	
	
	/*
	 * It removes the data from the database
	 * and it returns the response into the json format
	 */
	public function remove($product_id)
	{
	    if(!in_array('deleteWarehouse', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $response = array();
	    if($product_id) {
	        //$delete = $this->model_products->remove($product_id);
	        $data = array(
	            'active' => 0,
	        );
	        $delete = $this->model_stores->update($product_id,$data);
	        if($delete == true) {
	            $response['success'] = true;
	            $response['messages'] = "Successfully removed";
	        }
	        else {
	            $response['success'] = false;
	            $response['messages'] = "Error in the database while removing the warehouse";
	        }
	    }
	    else {
	        $response['success'] = false;
	        $response['messages'] = "Refresh the page again!!";
	    }
	
	    echo json_encode($response);
	}
	
	public function viewWarehouseProductsByStores($warehouseName,$warehouseId){
	    if(!in_array('viewWarehouse', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    
	    $this->data['page_title'] = $warehouseNameLink.'-list-of-products-'.date("Y-m-d");
	     
	    //get all products by stores which is not deleted and removed
	    //$warehouse_products = $this->model_products->getProductListByWarehouse($warehouseId);
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    $this->data['products'] = $warehouse_products;
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->render_template('stores/list_products', $this->data);
	}
	
	
	public function deliveries($warehouseName,$warehouseId){
	    if(!in_array('viewDelivery', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $this->data['page_title'] = $warehouseNameLink.'-deliveries-'.date("Y-m-d");
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_stores->getAllTransactionDetails("delivery",$warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    $this->data['delivery_data'] = $warehouse_products;
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->render_template('stores/delivery', $this->data);
	}
	
	public function deliveries_view($warehouseName,$tid,$warehouseId){
	    if(!in_array('viewDelivery', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    
	    //$warehouse_products = getAllTransactionDetails
	    $warehouse_products = $this->model_stores->getViewTransactions($tid,$warehouseId,"delivery");
	    if(!empty($warehouse_products)) {
	        if($warehouse_products[0]['transaction_status'] != "delivered") {$this->session->set_flashdata('confirm', 'Order has been created and is now pending');}
	        $tdata = array(
	            'order_date' => $warehouse_products[0]['order_date'],
	            'display_id' => $warehouse_products[0]['delivery_id'],
	            'po_number' => $warehouse_products[0]['po_number'],
	            'customer_name' => $warehouse_products[0]['customer_name'],
	            'address' => $warehouse_products[0]['address'],
	            'notes' => $warehouse_products[0]['notes'],
	            'transaction_status' => $warehouse_products[0]['transaction_status'],
	        );
	    }
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->data['tid'] = $tid;
	    $this->data['products'] = $warehouse_products;
	    $this->data['warehouse_data'] = $tdata;
	    $this->render_template('stores/delivery-view', $this->data);
	    
	}
	
	public function deliveries_edit($warehouseName,$warehouseId,$tid){
	    if(!in_array('updateDelivery', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId);
	    $customers = $this->model_customer->getCustomerData();
	    $units = $this->model_units->getUnitsData();
	    $transactions = $this->model_stores->getViewTransactions($tid,$warehouseId,"delivery");
	    
	    if(!empty($transactions)) {
	        $tdata = array(
	            'display_id' => $transactions[0]['delivery_id'],
	            'po_number' => $transactions[0]['po_number'],
	            'customer_id' => $transactions[0]['customer_id'],
	            'address' => $transactions[0]['address'],
	            'notes' => $transactions[0]['notes'],
	            'transaction_status' => $transactions[0]['transaction_status'],
	            'mapped_count' => count($transactions)
	        );
	        $display_id = $transactions[0]['delivery_id'];
	    }
	    
	    $this->form_validation->set_rules('po_number', 'Destination', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Source Location', 'trim|required');
	    $this->form_validation->set_rules('customer_id', 'Customer or Company Name', 'trim|required');
	    $this->form_validation->set_rules('address', 'Address', 'trim|required');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric');
	    $this->form_validation->set_rules('notes', 'Additional notes', 'trim');
	    
	    if ($this->form_validation->run() == TRUE) {
	        $transaction_data = array(
	            'display_id' => $display_id,
	            'po_number' => $this->input->post('po_number'),
	            'customer_id' => $this->input->post('customer_id'),
	            'address' => $this->input->post('address'),
	            'notes' => $this->input->post('notes'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "delivered":"pending"),
	        );
	         
	        $this->model_stores->updateTransactions($tid,$transaction_data);
	        $count_product = count($this->input->post('product_id'));
	        $this->model_stores->removeTdetails($tid);
	        for($x = 0; $x < $count_product; $x++) {
	            $items = array(
	                'transaction_id'     => $tid,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $this->model_stores->createTDetails($items);
	        }
	        redirect('deliveries-view/'.$warehouseNameLink.'/'.$tid.'/'.$warehouseId, 'refresh');
	    }
	    else {
	        $this->data['transactions'] = $transactions;
	        $this->data['tdata'] = $tdata;
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['units'] = $units;
	        $this->render_template('stores/delivery-edit', $this->data);
	    }
	    
	}
	
	public function deliveries_confirm($store_id,$tid) {
	    if(!in_array('updateDelivery', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $response = array();
	    if($store_id && $tid) {
	        //$delete = $this->model_products->remove($product_id);
	        $data = array(
	            'transaction_status' => 'delivered',
	        );
	        if($this->input->get('tvalue') == "pending") {
    	        $data = array(
    	            'transaction_status' => 'pending',
    	        );
	        }
	        $update = $this->model_stores->updateTransactions($tid,$data);
	        if($update == true) {
	            $response['success'] = true;
	            $response['messages'] = "Successfully confirmed";
	            if($this->input->get('tvalue') == "pending") {
	               $response['messages'] = "Order has been created and is now pending";
	            }
	        }
	        else {
	            $response['success'] = false;
	            $response['messages'] = "Error in the database while confirming the order";
	        }
	    }
	    else {
	        $response['success'] = false;
	        $response['messages'] = "Refresh the page again!!";
	    }
	    
	    echo json_encode($response);
	}
	
	public function deliveries_create($warehouseName,$warehouseId){
	    if(!in_array('createDelivery', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    
	    $nextID = $this->model_stores->getNextIncrementIDT();
	    $display_id = "DL-MO-".sprintf("%011s",$nextID[0]['nextId']);
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId);
	    $customers = $this->model_customer->getCustomerData();
	    $units = $this->model_units->getUnitsData();
	    
	    
	    $this->form_validation->set_rules('po_number', 'Destination', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Source Location', 'trim|required');
	    $this->form_validation->set_rules('customer_id', 'Customer or Company Name', 'trim|required');
	    $this->form_validation->set_rules('address', 'Address', 'trim|required');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric|greater_than[0]');
	    $this->form_validation->set_rules('notes', 'Additional notes', 'trim');
	    
	    if ($this->form_validation->run() == TRUE) {
	        $transaction_data = array(
	            'display_id' => $display_id,
	            'po_number' => $this->input->post('po_number'),
	            'customer_id' => $this->input->post('customer_id'),
	            'store_id' => $this->input->post('store_id'),
	            'address' => $this->input->post('address'),
	            'notes' => $this->input->post('notes'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "delivered":"pending"),
	            'transaction_type' => "delivery",
	            'create_date' => date("Y-m-d H:i:s"),
	        );
	        
	        $t_id = $this->model_stores->createT($transaction_data);
	        $count_product = count($this->input->post('product_id'));
	        for($x = 0; $x < $count_product; $x++) {
	            $items = array(
	                'transaction_id'     => $t_id,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $this->model_stores->createTDetails($items);
	        }
	        redirect('deliveries-view/'.$warehouseNameLink.'/'.$t_id.'/'.$warehouseId, 'refresh');
	    }
	    else {
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['units'] = $units;
	        $this->render_template('stores/delivery-create', $this->data);
	    }
	}
	
	public function pickups($warehouseName,$warehouseId){
	    if(!in_array('viewPickup', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $this->data['page_title'] = $warehouseNameLink.'-pickups-'.date("Y-m-d");
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_stores->getAllTransactionDetails("pickup",$warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    $this->data['delivery_data'] = $warehouse_products;
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->render_template('stores/pickup', $this->data);
	}
	
	public function pickups_create($warehouseName,$warehouseId){
	    if(!in_array('createPickup', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	     
	    $nextID = $this->model_stores->getNextIncrementIDT();
	    $display_id = "PK-MO-".sprintf("%011s",$nextID[0]['nextId']);
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId);
	    $customers = $this->model_customer->getCustomerData();
	    $units = $this->model_units->getUnitsData();
	     
	     
	    $this->form_validation->set_rules('po_number', 'Destination', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Source Location', 'trim|required');
	    $this->form_validation->set_rules('customer_id', 'Customer or Company Name', 'trim|required');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric|greater_than[0]');
	    $this->form_validation->set_rules('notes', 'Additional notes', 'trim');
	     
	    if ($this->form_validation->run() == TRUE) {
	        $transaction_data = array(
	            'display_id' => $display_id,
	            'po_number' => $this->input->post('po_number'),
	            'customer_id' => $this->input->post('customer_id'),
	            'store_id' => $this->input->post('store_id'),
	            'notes' => $this->input->post('notes'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "delivered":"pending"),
	            'transaction_type' => "pickup",
	            'create_date' => date("Y-m-d H:i:s"),
	        );
	         
	        $t_id = $this->model_stores->createT($transaction_data);
	        $count_product = count($this->input->post('product_id'));
	        for($x = 0; $x < $count_product; $x++) {
	            $items = array(
	                'transaction_id'     => $t_id,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $this->model_stores->createTDetails($items);
	        }
	        redirect('pickups-view/'.$warehouseNameLink.'/'.$t_id.'/'.$warehouseId, 'refresh');
	    }
	    else {
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['units'] = $units;
	        $this->render_template('stores/pickups-create', $this->data);
	    }
	}
	
	public function pickups_view($warehouseName,$tid,$warehouseId){
	    if(!in_array('viewPickup', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	     
	    //$warehouse_products = getAllTransactionDetails
	    $warehouse_products = $this->model_stores->getViewTransactions($tid,$warehouseId,"pickup");
	    if(!empty($warehouse_products)) {
	        if($warehouse_products[0]['transaction_status'] != "delivered") {$this->session->set_flashdata('confirm', 'Order has been created and is now pending');}
	        $tdata = array(
	            'order_date' => $warehouse_products[0]['order_date'],
	            'display_id' => $warehouse_products[0]['delivery_id'],
	            'po_number' => $warehouse_products[0]['po_number'],
	            'customer_name' => $warehouse_products[0]['customer_name'],
	            'notes' => $warehouse_products[0]['notes'],
	            'transaction_status' => $warehouse_products[0]['transaction_status'],
	        );
	    }
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->data['tid'] = $tid;
	    $this->data['products'] = $warehouse_products;
	    $this->data['warehouse_data'] = $tdata;
	    $this->render_template('stores/pickup-view', $this->data);
	}
	
	public function pickups_confirm($store_id,$tid) {
	    if(!in_array('updatePickup', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    $response = array();
	    if($store_id && $tid) {
	        //$delete = $this->model_products->remove($product_id);
	        $data = array(
	            'transaction_status' => 'delivered',
	        );
	        if($this->input->get('tvalue') == "pending") {
	            $data = array(
	                'transaction_status' => 'pending',
	            );
	        }
	        $update = $this->model_stores->updateTransactions($tid,$data);
	        if($update == true) {
	            $response['success'] = true;
	            $response['messages'] = "Successfully confirmed";
	            if($this->input->get('tvalue') == "pending") {
	                $response['messages'] = "Order has been created and is now pending";
	            }
	        }
	        else {
	            $response['success'] = false;
	            $response['messages'] = "Error in the database while confirming the order";
	        }
	    }
	    else {
	        $response['success'] = false;
	        $response['messages'] = "Refresh the page again!!";
	    }
	     
	    echo json_encode($response);
	}
	
	public function pickups_edit($warehouseName,$warehouseId,$tid){
	    if(!in_array('updatePickup', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId);
	    $customers = $this->model_customer->getCustomerData();
	    $units = $this->model_units->getUnitsData();
	    $transactions = $this->model_stores->getViewTransactions($tid,$warehouseId,"pickup");
	     
	    if(!empty($transactions)) {
	        $tdata = array(
	            'display_id' => $transactions[0]['delivery_id'],
	            'po_number' => $transactions[0]['po_number'],
	            'customer_id' => $transactions[0]['customer_id'],
	            'notes' => $transactions[0]['notes'],
	            'transaction_status' => $transactions[0]['transaction_status'],
	            'mapped_count' => count($transactions)
	        );
	        $display_id = $transactions[0]['delivery_id'];
	    }
	     
	    $this->form_validation->set_rules('po_number', 'Destination', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Source Location', 'trim|required');
	    $this->form_validation->set_rules('customer_id', 'Customer or Company Name', 'trim|required');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric|greater_than[0]');
	    $this->form_validation->set_rules('notes', 'Additional notes', 'trim');
	     
	    if ($this->form_validation->run() == TRUE) {
	        $transaction_data = array(
	            'display_id' => $display_id,
	            'po_number' => $this->input->post('po_number'),
	            'customer_id' => $this->input->post('customer_id'),
	            'address' => $this->input->post('address'),
	            'notes' => $this->input->post('notes'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "delivered":"pending"),
	        );
	
	        $this->model_stores->updateTransactions($tid,$transaction_data);
	        $count_product = count($this->input->post('product_id'));
	        $this->model_stores->removeTdetails($tid);
	        for($x = 0; $x < $count_product; $x++) {
	            $items = array(
	                'transaction_id'     => $tid,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $this->model_stores->createTDetails($items);
	        }
	        redirect('pickups-view/'.$warehouseNameLink.'/'.$tid.'/'.$warehouseId, 'refresh');
	    }
	    else {
	        $this->data['transactions'] = $transactions;
	        $this->data['tdata'] = $tdata;
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['units'] = $units;
	        $this->render_template('stores/pickup-edit', $this->data);
	    }
	     
	}
	
	public function transfers($warehouseName,$warehouseId){
	    if(!in_array('viewTransfer', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $this->data['page_title'] = $warehouseNameLink.'-transfers-'.date("Y-m-d");
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_stores->getAllTransactionDetails("transfer",$warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    
	    $this->data['warehouse_data'] = $warehouse_data;
	    $this->data['delivery_data'] = $warehouse_products;
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->render_template('stores/transfers', $this->data);
	}
	
	public function transfers_create($warehouseName,$warehouseId){
	    if(!in_array('createTransfer', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	
	    $nextID = $this->model_stores->getNextIncrementIDT();
	    $display_id = "TR-MO-".sprintf("%011s",$nextID[0]['nextId']);
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId);
	    $customers = $this->model_stores->getStoresData();
	    $units = $this->model_units->getUnitsData();
	    $customers_r = $this->model_customer->getCustomerData();
	
	
	    $this->form_validation->set_rules('from_store_id', 'Source Location', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Destination Location', 'trim|required');
	    $this->form_validation->set_rules('customer_id', 'Customer', 'trim');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric|greater_than[0]');
	    

	
	    if ($this->form_validation->run() == TRUE) {
	        $transaction_data = array(
	            'display_id' => $display_id,
	            'store_id' => $this->input->post('store_id'),
	            'customer_id' => $this->input->post('customer_id'),
	            'from_store_id' => $this->input->post('from_store_id'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "transferred":"pending"),
	            'transaction_type' => "transfer",
	            'create_date' => date("Y-m-d H:i:s"),
	        );
	
	        $t_id = $this->model_stores->createT($transaction_data);
	        $count_product = count($this->input->post('product_id'));
	        $destination_store_id = $this->input->post('store_id');
	        $sale_invoice_num = "SI-".sprintf("%011s",mt_rand(1,99999999));
	        $user_id = $this->session->userdata('id');
	        $stock_info = array(
	            'sales_invoice_id' => $sale_invoice_num,
	            'store_id' => $destination_store_id,
	            'create_date' => date("Y-m-d H:i:s"),
	            'user_id' => $user_id,
	            'transaction_id' => $t_id,
	        );
	        $stock_id = $this->model_stores->createST($stock_info);
	        for($x = 0; $x < $count_product; $x++) {
	            $expiry = $this->getExpiredDateFromTransfer($warehouseId, $this->input->post('product_id')[$x], $this->input->post('less_stock')[$x]);
	            $stock_details = array(
	                'stock_id'   => $stock_id,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	                'expiry_date'   => $expiry,
	            );
	            $items = array(
	                'transaction_id'     => $t_id,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $this->model_stores->createTDetails($items);
	            $this->model_stores->createSTDetails($stock_details);
	        }
	        redirect('transfers-view/'.$warehouseNameLink.'/'.$t_id.'/'.$destination_store_id, 'refresh');
	    }
	    else {
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['customers_r'] = $customers_r;
	        $this->data['units'] = $units;
	        $this->render_template('stores/transfers-create', $this->data);
	    }
	}
	
	public function transfers_view($warehouseName,$tid,$warehouseId){
	    if(!in_array('viewTransfer', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	
	    //$warehouse_products = getAllTransactionDetails
	    $warehouse_products = $this->model_stores->getViewTransactions($tid,$warehouseId,"transfer");
	    if(!empty($warehouse_products)) {
	        if($warehouse_products[0]['transaction_status'] != "transferred") {$this->session->set_flashdata('confirm', 'Transfer has been created and is now pending');}
	        $tdata = array(
	            'order_date' => $warehouse_products[0]['order_date'],
	            'display_id' => $warehouse_products[0]['delivery_id'],
	            'destination_location' => $warehouse_products[0]['destination_location'],
	            'source_location' => $warehouse_products[0]['source_location'],
	            'transaction_status' => $warehouse_products[0]['transaction_status'],
	            'from_store_id' => $warehouse_products[0]['from_store_id'],
	        );
	    }
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->data['tid'] = $tid;
	    $this->data['products'] = $warehouse_products;
	    $this->data['warehouse_data'] = $tdata;
	    $this->render_template('stores/transfers-view', $this->data);
	}
	
	public function transfers_confirm($store_id,$tid) {
	    if(!in_array('updateTransfer', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $response = array();
	    if($store_id && $tid) {
	        //$delete = $this->model_products->remove($product_id);
	        $data = array(
	            'transaction_status' => 'transferred',
	        );
	        if($this->input->get('tvalue') == "pending") {
	            $data = array(
	                'transaction_status' => 'pending',
	            );
	        }
	        $update = $this->model_stores->updateTransactions($tid,$data);
	        if($update == true) {
	            $response['success'] = true;
	            $response['messages'] = "Successfully confirmed";
	            if($this->input->get('tvalue') == "pending") {
	                $response['messages'] = "Transfer has been created and is now pending";
	            }
	        }
	        else {
	            $response['success'] = false;
	            $response['messages'] = "Error in the database while confirming the order";
	        }
	    }
	    else {
	        $response['success'] = false;
	        $response['messages'] = "Refresh the page again!!";
	    }
	
	    echo json_encode($response);
	}
	
	public function transfers_edit($warehouseName,$warehouseId,$tid){
	    if(!in_array('updateTransfer', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	   
	    //get store_id from transactions
	    $transData = $this->model_stores->getTransactionsData($tid);
	    if($transData) {
	       $to_store_id = $transData['store_id'];
	       $warehouseId = $transData['from_store_id'];
	    }
	    
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId);
	    $customers = $this->model_stores->getStoresData();
	    $units = $this->model_units->getUnitsData();
	    $transactions = $this->model_stores->getViewTransactions($tid,$to_store_id,"transfer");
	    $customers_r = $this->model_customer->getCustomerData();
	    if(!empty($transactions)) {
	        $tdata = array(
	            'display_id' => $transactions[0]['delivery_id'],
	            'store_id' => $transactions[0]['store_id'],
	            'destination_location' => $transactions[0]['destination_location'],
	            'source_location' => $transactions[0]['source_location'],
	            'customer_id' => $transactions[0]['customer_id'],
	            'transaction_status' => $transactions[0]['transaction_status'],
	            'mapped_count' => count($transactions)
	        );
	        $display_id = $transactions[0]['delivery_id'];
	    }
	    
	    
	    $this->form_validation->set_rules('from_store_id', 'Source Location', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Destination Location', 'trim|required');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric|greater_than[0]');
	    $this->form_validation->set_rules('customer_id', 'Customer', 'trim');
	
	    if ($this->form_validation->run() == TRUE) {
	        $transaction_data = array(
	            'store_id' => $this->input->post('store_id'),
	            'customer_id' => $this->input->post('customer_id'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "transferred":"pending"),
	        );
	        $to_store_id = $transaction_data['store_id'];
	        $stocks = $this->model_stores->getStockID($tid);
	        $this->model_stores->updateTransactions($tid,$transaction_data);
	        
	        $count_product = count($this->input->post('product_id'));
	        $this->model_stores->removeTdetails($tid);
	        $this->model_products->removeStocks($stocks['id']);
	        for($x = 0; $x < $count_product; $x++) {
	            $items = array(
	                'transaction_id'     => $tid,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $expiry = $this->getExpiredDateFromTransfer($warehouseId, $this->input->post('product_id')[$x], $this->input->post('less_stock')[$x]);
	            $stock_details = array(
	                'stock_id'   => $stocks['id'],
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	                'expiry_date'   => $expiry,
	            );
	            $this->model_stores->createTDetails($items);
	            $this->model_stores->createSTDetails($stock_details);
	        }
	        redirect('transfers-view/'.$warehouseNameLink.'/'.$tid.'/'.$to_store_id, 'refresh');
	    }
	    else {
	        $this->data['transactions'] = $transactions;
	        $this->data['customers_r'] = $customers_r;
	        $this->data['tdata'] = $tdata;
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['units'] = $units;
	        $this->render_template('stores/transfers-edit', $this->data);
	    }
	
	}
	
	
	private function getExpiredDateFromTransfer($warehouseID,$productId,$less_count) {
	    $stock_qty = $this->model_stores->getQTYStockID($warehouseID,$productId);
	    $expired_date = "";
	    $total = 0;
	    foreach ($stock_qty as $k => $val) {
	        $total = $total + $val['quantity'];
	        if($total > $less_count) {
	            $expired_date = $val['expiry_date'];
	            break;
	        }
	    }
	    return $expired_date;
	}
	
	
	
	
	public function withdrawals($warehouseName,$warehouseId){
	    if(!in_array('viewWithdrawal', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    
	    $this->data['page_title'] = $warehouseNameLink.'-withdrawals-'.date("Y-m-d");
	    
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_stores->getAllTransactionDetails("withdrawal",$warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    $this->data['delivery_data'] = $warehouse_products;
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->render_template('stores/withdrawals', $this->data);
	}
	
	
	public function withdrawals_confirm($store_id,$tid) {
	    if(!in_array('updateWithdrawal', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $response = array();
	    if($store_id && $tid) {
	        //$delete = $this->model_products->remove($product_id);
	        $data = array(
	            'transaction_status' => 'withdrew',
	        );
	        if($this->input->get('tvalue') == "pending") {
	            $data = array(
	                'transaction_status' => 'pending',
	            );
	        }
	        $update = $this->model_stores->updateTransactions($tid,$data);
	        if($update == true) {
	            $response['success'] = true;
	            $response['messages'] = "Successfully confirmed";
	            if($this->input->get('tvalue') == "pending") {
	                $response['messages'] = "Withdrawal has been created and is now pending";
	            }
	        }
	        else {
	            $response['success'] = false;
	            $response['messages'] = "Error in the database while confirming the order";
	        }
	    }
	    else {
	        $response['success'] = false;
	        $response['messages'] = "Refresh the page again!!";
	    }
	
	    echo json_encode($response);
	}
	
	public function withdrawals_create($warehouseName,$warehouseId){
	    if(!in_array('createWithdrawal', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	
	    $nextID = $this->model_stores->getNextIncrementIDT();
	    $display_id = "WD-MO-".sprintf("%011s",$nextID[0]['nextId']);
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId,1);
	    $customers = $this->model_stores->getStoresData();
	    $units = $this->model_units->getUnitsData();
	
	
	    $this->form_validation->set_rules('store_id', 'Destination Location', 'trim|required');
	    $this->form_validation->set_rules('notes', 'Reason for Withdrawal', 'trim');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric|greater_than[0]');
	     
	    if ($this->form_validation->run() == TRUE) {
	        $transaction_data = array(
	            'display_id' => $display_id,
	            'store_id' => $this->input->post('store_id'),
	            'notes' => $this->input->post('notes'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "withdrew":"pending"),
	            'transaction_type' => "withdrawal",
	            'create_date' => date("Y-m-d H:i:s"),
	        );
	        $t_id = $this->model_stores->createT($transaction_data);
	        $count_product = count($this->input->post('product_id'));
	        for($x = 0; $x < $count_product; $x++) {
	            $items = array(
	                'transaction_id'     => $t_id,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $this->model_stores->createTDetails($items);
	        }
	        redirect('withdrawals-view/'.$warehouseNameLink.'/'.$t_id.'/'.$warehouseId, 'refresh');
	    }
	    else {
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['units'] = $units;
	        $this->render_template('stores/withdrawals-create', $this->data);
	    }
	}
	

	public function withdrawals_view($warehouseName,$tid,$warehouseId){
	    if(!in_array('viewWithdrawal', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	
	    //$warehouse_products = getAllTransactionDetails
	    $warehouse_products = $this->model_stores->getViewTransactions($tid,$warehouseId,"withdrawal");
	    if(!empty($warehouse_products)) {
	        if($warehouse_products[0]['transaction_status'] != "withdrew") {$this->session->set_flashdata('confirm', 'Withdrawal has been created and is now pending');}
	        $tdata = array(
	            'order_date' => $warehouse_products[0]['order_date'],
	            'display_id' => $warehouse_products[0]['delivery_id'],
	            'notes' => $warehouse_products[0]['notes'],
	            'destination_location' => $warehouse_products[0]['destination_location'],
	            'source_location' => $warehouse_products[0]['source_location'],
	            'transaction_status' => $warehouse_products[0]['transaction_status'],
	        );
	    }
	    $this->data['warehouseNameLink'] = $warehouseNameLink;
	    $this->data['warehouseId'] = $warehouseId;
	    $this->data['tid'] = $tid;
	    $this->data['products'] = $warehouse_products;
	    $this->data['warehouse_data'] = $tdata;
	    $this->render_template('stores/withdrawals-view', $this->data);
	}
	
	public function withdrawals_edit($warehouseName,$warehouseId,$tid){
	    if(!in_array('updateWithdrawal', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    $warehouseNameLink = $warehouseName;
	    $warehouseName = str_replace("-", " ", $warehouseName);
	    $warehouseName = ucwords($warehouseName);
	    $warehouseId = intval($warehouseId);
	    $warehouse_data = $this->model_stores->getStoresData($warehouseId);
	    $this->data['warehouse_data'] = $warehouse_data;
	    //get all products by stores which is not deleted and removed
	    $warehouse_products = $this->model_products->getProductListByWarehouseNonGroup($warehouseId,1);
	    $customers = $this->model_stores->getStoresData();
	    $units = $this->model_units->getUnitsData();
	    $transactions = $this->model_stores->getViewTransactions($tid,$warehouseId,"withdrawal");
	    if(!empty($transactions)) {
	        $tdata = array(
	            'display_id' => $transactions[0]['delivery_id'],
	            'store_id' => $transactions[0]['store_id'],
	            'destination_location' => $transactions[0]['destination_location'],
	            'source_location' => $transactions[0]['source_location'],
	            'transaction_status' => $transactions[0]['transaction_status'],
	            'notes' => $transactions[0]['notes'],
	            'mapped_count' => count($transactions)
	        );
	        $display_id = $transactions[0]['delivery_id'];
	    }
	     
	    $this->form_validation->set_rules('store_id', 'Source Location', 'trim|required');
	    $this->form_validation->set_rules('notes', 'Reason for Withdrawal', 'trim');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric|greater_than[0]');
	
	
	    if ($this->form_validation->run() == TRUE) {
	         
	         
	        $transaction_data = array(
	            'notes' => $this->input->post('notes'),
	            'transaction_status' => ($this->input->post('checkme') == 1 ? "withdrew":"pending"),
	        );
	        
	        $this->model_stores->updateTransactions($tid,$transaction_data);
	        $count_product = count($this->input->post('product_id'));
	        $this->model_stores->removeTdetails($tid);
	        for($x = 0; $x < $count_product; $x++) {
	            $items = array(
	                'transaction_id'     => $tid,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'cost'         => $this->input->post('cost')[$x],
	                'sale_price'   => $this->input->post('price')[$x],
	            );
	            $this->model_stores->createTDetails($items);
	        }
	        redirect('withdrawals-view/'.$warehouseNameLink.'/'.$tid.'/'.$warehouseId, 'refresh');
	    }
	    else {
	        $this->data['transactions'] = $transactions;
	        $this->data['tdata'] = $tdata;
	        $this->data['display_id'] = $display_id;
	        $this->data['products'] = $warehouse_products;
	        $this->data['warehouse_data'] = $warehouse_data;
	        $this->data['customers'] = $customers;
	        $this->data['units'] = $units;
	        $this->render_template('stores/withdrawals-edit', $this->data);
	    }
	
	}
		
}