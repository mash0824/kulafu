<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'All-Products-'.date("Y-m-d");

		$this->load->model('model_products');
		$this->load->model('model_category');
		$this->load->model('model_stores');
		$this->load->model('model_brands');
		$this->load->model('model_units');
		$this->load->model('model_customer');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        ob_start();
        $this->fetchProductData();
        $fetch = ob_get_clean();
		$this->render_template('products/index', $this->data);	
	}
	
	public function checkExpiry($id){
	    
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchProductData()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
		$result = array('data' => array());

		$data = $this->model_products->getProductData();
		$brand_data = $this->model_brands->getBrandsData();
		$unit_data = $this->model_units->getUnitsData();
		$brands = array();
		$units = array();
		
		foreach ($brand_data as $key => $val) {
		    $brands[$val["id"]] = $val['name']; 
		}
		foreach ($unit_data as $key => $val) {
		    $units[$val["id"]] = $val['name']; 
		}

		foreach ($data as $key => $value) {
			// button
            $buttons = '';
            $stock = $this->model_products->getInStockCount($value['id']);
            $expiry = $this->model_products->getExpiryDetails($value['id']);
            $expiryDetails = $this->model_products->getExpiryDetailNew($value['id']);
            
//             echo "<pre>";
//             print_r($expiry);
//             print_r($$expiryDetails);
            
            if(in_array('viewProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/view/'.$value['id']).'" class="">View</a>';
            }
//             if(in_array('deleteProduct', $this->permission) && isset($expiry[0]['store_id']) && $expiry[0]['store_id'] > 0) { 
//     			$buttons .= '&nbsp;<a href="'.base_url('withdrawals-create/manage/'.$expiry[0]['store_id']).'" class="redlink">Withdraw</a>';
//             }
            $my_stock_count = (isset($stock[0]['stock_count']) ? (($stock[0]['stock_count'] - $stock[0]['less_count']) > 0 ? ($stock[0]['stock_count'] - $stock[0]['less_count']) : 0) : 0);
            
            if($my_stock_count <= 0) {
                $status = "<span class='expiring'>Out of Stock</span>";
                //$this->session->set_flashdata('errorc', 'Out of Stock');
            }
            elseif($my_stock_count <= 10){
                $status = "<span class='expiring'>Low Stock</span>";
                //$this->session->set_flashdata('errorc', 'Low Stock');
            }
            elseif(isset($expiry[0]['total_quantity'])  && isset($expiryDetails[0]['expiry_total'])) {
                if(intval($expiry[0]['total_quantity']) > 0 && $expiryDetails[0]['expiry_total'] > 0) {
                    if($expiryDetails[0]['expiry_total'] >= $expiry[0]['total_quantity']) {
                        $status = "<span class='normal'>Normal</span>";
                    }
                    else {
                        $status = "<span class='expiring'>Expiring</span>";
                        $buttons .= '&nbsp;<a href="'.base_url('withdrawals-create/manage/'.$expiry[0]['store_id']).'" class="redlink">Withdraw</a>';
                    }
                }
                else {
                    $status = "<span class='normal'>Normal</span>";
                }
            }
            else {
                $status = "<span class='normal'>Normal</span>";
            }
            
			$result['data'][$key] = array(
				$value['sku'],
				$value['name'],
                (($value['brand_id'] > 0) ? $brands[$value['brand_id']] : "") ,
				$my_stock_count,
		        (($value['unit_id'] > 0) ? $units[$value['unit_id']] : "") ,  
                $value['sale_price'],
                $value['cost'],
			    $status,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}	
	
	
    
    /*
    * view the product based on the store 
    * the admin can view all the product information
    */
    public function viewproduct()
    {
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $company_currency = $this->company_currency();
        // get all the category 
        $category_data = $this->model_category->getCategoryData();

        $result = array();
        
        foreach ($category_data as $k => $v) {
            $result[$k]['category'] = $v;
            $result[$k]['products'] = $this->model_products->getProductDataByCat($v['id']);
        }

        // based on the category get all the products 

        $html = '<!-- Main content -->
                    <!DOCTYPE html>
                    <html>
                    <head>
                      <meta charset="utf-8">
                      <meta http-equiv="X-UA-Compatible" content="IE=edge">
                      <title>Invoice</title>
                      <!-- Tell the browser to be responsive to screen width -->
                      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                      <!-- Bootstrap 3.3.7 -->
                      <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
                      <!-- Font Awesome -->
                      <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
                      <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
                    </head>
                    <body>
                    
                    <div class="wrapper">
                      <section class="invoice">

                        <div class="row">
                        ';
                            foreach ($result as $k => $v) {
                                $html .= '<div class="col-md-6">
                                    <div class="product-info">
                                        <div class="category-title">
                                            <h1>'.$v['category']['name'].'</h1>
                                        </div>';

                                        if(count($v['products']) > 0) {
                                            foreach ($v['products'] as $p_key => $p_value) {
                                                $html .= '<div class="product-detail">
                                                            <div class="product-name" style="display:inline-block;">
                                                                <h5>'.$p_value['name'].'</h5>
                                                            </div>
                                                            <div class="product-price" style="display:inline-block;float:right;">
                                                                <h5>'.$company_currency . ' ' . $p_value['price'].'</h5>
                                                            </div>
                                                        </div>';
                                            }
                                        }
                                        else {
                                            $html .= 'N/A';
                                        }        
                                    $html .='</div>
                                        
                                </div>';
                            }
                        

                        $html .='
                        </div>
                      </section>
                      <!-- /.content -->
                    </div>
                </body>
            </html>';

                      echo $html;
    }

    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function create()
	{
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->form_validation->set_rules('name', 'Product name', 'trim|required');
		$this->form_validation->set_rules('sku', 'Supplier SKU', 'trim|required');
		$this->form_validation->set_rules('cost', 'Price', 'trim|required|decimal');
		$this->form_validation->set_rules('sale_price', 'Price', 'trim|required|decimal');
		
		$nextID = $this->model_products->getNextIncrementID();
		$pd_disp_id = "PD-".sprintf("%011s",$nextID[0]['nextId']);
	
        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'name' => $this->input->post('name'),
        		'cost' => $this->input->post('cost'),
        		'sku' => $this->input->post('sku'),
        		'max_quantity' => $this->input->post('max_quantity'),
        		'quantity_in_box' => $this->input->post('quantity_in_box'),
        		'unit_id' => $this->input->post('unit_id'),
        		'brand_id' => $this->input->post('brand_id'),
        		'sale_price' => $this->input->post('sale_price'),
        		'pd_disp_id' => $pd_disp_id,
        	);

        	$create = $this->model_products->create($data);
        	if($create == true) {
        		$this->session->set_flashdata('success', 'Successfully created');
        		redirect('products/', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('products/create', 'refresh');
        	}
        }
        else {
            // false case

        	// attributes 
        	// $attribute_data = $this->model_attributes->getActiveAttributeData();
        	// $this->data['attributes'] = $attributes_final_data;
			// $this->data['brands'] = $this->model_brands->getActiveBrands();        	
			$this->data['stores'] = $this->model_stores->getActiveStore();  
			$this->data['brands'] = $this->model_brands->getBrandsData();
			$this->data['units'] = $this->model_units->getUnitsData();
			 // false case
            $data = array(
                'pd_disp_id' => $pd_disp_id
            );
            $this->data['products_data'] = $data;

            $this->render_template('products/create', $this->data);
        }	
	}
	
	public function view($id){
	    if(!in_array('viewProduct', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    if($id) {
	        $customer_data = $this->model_products->getProductData($id);
	        $stock_data = $this->model_products->getStockHistory($id);
	        
	        //fix transfer value
	        $tmpQty = 0;
	        foreach ($stock_data as $k => $val) {
	            if(!empty($val['transaction_id'])) {
	                $tmpQty = $val['quantity'];
	            }
	            else {
	                $t = ($val['quantity'] - $tmpQty);
	                $stock_data[$k]['quantity'] = ( $t > 0 ? $t  : 0);
	                $tmpQty = 0;
	            }
	        }
	        //fix sort of data;
	        usort($stock_data, function($a, $b) {
	            return $a['id'] - $b['id'];
	        });
// 	        echo "<prE>";
// 	        print_r($stock_data);
	        $expiry_total = array();
	        foreach ($stock_data as $k => $val) {
	            if($val['stock_status_flag'] == 1) {
	                if(!isset($expiry_total[$val['store_id']]['total'])) {
	                   $expiryDetails = $this->model_products->getExpiryDetailNew($id,$val['store_id']);
	                   $expiry_total[$val['store_id']]['total'] = $expiryDetails[0]['expiry_total'];
	                }
	                if($expiry_total[$val['store_id']]['total'] >= $val['quantity']) {
	                    $stock_data[$k]['stock_status_flag'] = 0;
	                    $stock_data[$k]['stock_status'] = "<span class='expiring'>Withdrawn</span>";
	                    $expiry_total[$val['store_id']]['total'] = $expiry_total[$val['store_id']]['total'] - $val['quantity'];
	                }
	            }
	        }
// 	        print_r($stock_data);
	        $this->data['product_data'] = $customer_data;
	        $this->data['stock_data'] = $stock_data;
	        $this->render_template('products/view', $this->data);
	    }     
	}
	
	public function viewstoreproduct($name,$product_id,$store_id){
	    if(!in_array('viewProduct', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    if($product_id) {
	        $warehouseNameLink = $name;
	        $customer_data = $this->model_products->getProductData($product_id);
	        $stock_data = $this->model_products->getStockHistory($product_id,$store_id);
	        $this->data['product_data'] = $customer_data;
	        $this->data['stock_data'] = $stock_data;
	        $this->data['warehouseNameLink'] = $warehouseNameLink;
	        $this->data['store_id'] = $store_id;
	        $this->render_template('products/view-store-products', $this->data);
	    }
	}

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('name', 'Product name', 'trim|required');
		$this->form_validation->set_rules('sku', 'Supplier SKU', 'trim|required');
		$this->form_validation->set_rules('cost', 'Price', 'trim|required|decimal');
		$this->form_validation->set_rules('sale_price', 'Price', 'trim|required|decimal');

        if ($this->form_validation->run() == TRUE) {
            // true case
            $data = array(
                'name' => $this->input->post('name'),
        		'cost' => $this->input->post('cost'),
        		'sku' => $this->input->post('sku'),
        		'max_quantity' => $this->input->post('max_quantity'),
        		'quantity_in_box' => $this->input->post('quantity_in_box'),
        		'unit_id' => $this->input->post('unit_id'),
        		'brand_id' => $this->input->post('brand_id'),
        		'sale_price' => $this->input->post('sale_price'),
            );
            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }
        else {
            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            $this->data['stores'] = $this->model_stores->getActiveStore();
            $this->data['brands'] = $this->model_brands->getBrandsData();
            $this->data['units'] = $this->model_units->getUnitsData();
            $this->render_template('products/edit', $this->data); 
        }   
	}
	
	public function stocks_edit($stock_id) {
	    if(!in_array('updateProduct', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $this->form_validation->set_rules('sales_invoice_id', 'Sales Invoice', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Destination', 'trim|required');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric');
	    $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim');
	    //$this->form_validation->set_rules('expiry_date[]', 'Expiry Date', 'trim|required');
	    
	    if ($this->form_validation->run() == TRUE) {
	        $stock_data = array(
	            'sales_invoice_id' => $this->input->post('sales_invoice_id'),
	            'store_id' => $this->input->post('store_id'),
	            'supplier_name' => $this->input->post('supplier_name'),
	        );
	        //update stocks
	        $this->model_products->updateStocks($stock_data,$stock_id);
	        $count_product = count($this->input->post('product_id'));
	        if($count_product > 0) {
	            //remove all stock and enter new one
	            $this->model_products->removeStocks($stock_id);
    	        for($x = 0; $x < $count_product; $x++) {
    	            $product_data = $this->model_products->getProductData($this->input->post('product_id')[$x]);
    	            $items = array(
    	                'stock_id'     => $stock_id,
    	                'product_id'   => $this->input->post('product_id')[$x],
    	                'quantity'     => $this->input->post('quantity')[$x],
    	                'expiry_date'  => date("Y-m-d",strtotime($this->input->post('expiry_date')[$x])),
    	                'cost'         => $product_data['cost'],
    	                'sale_price'   => $product_data['sale_price']
    	            );
    	            $this->model_products->createStockDetails($items);
    	        }
    	        redirect('stocks-summary/'.$stock_id, 'refresh');
	        }
	        else {
	           $stock_data = $this->model_products->getStockSummary($stock_id);
	           $this->data['products'] = $this->model_products->getActiveProductData();
	           $this->data['stock_data'] = $stock_data;
	           $this->data['stock_id'] = $stock_id;
	           $this->data['store'] = $this->model_stores->getStoresData($stock_data[0]['store_id']);
	           $this->data['stores'] = $this->model_stores->getStoresData();
	           $this->render_template('products/stock-edit', $this->data);
	        }
	        
	    }
	    else {
	        $stock_data = $this->model_products->getStockSummary($stock_id);
	        $this->data['products'] = $this->model_products->getActiveProductData();
	        $this->data['stock_data'] = $stock_data;
	        $this->data['stock_id'] = $stock_id;
	        $this->data['store'] = $this->model_stores->getStoresData($stock_data[0]['store_id']);
	        $this->data['stores'] = $this->model_stores->getStoresData();
	        $this->render_template('products/stock-edit', $this->data);
	    }
	     
	    
	}
	
	public function stocks_create(){
	    if(!in_array('updateProduct', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    $this->form_validation->set_rules('sales_invoice_id', 'Sales Invoice', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Destination', 'trim|required');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric');
	    $this->form_validation->set_rules('expiry_date[]', 'Expiry Date', 'trim|required');
	    
	    if ($this->form_validation->run() == TRUE) {
	        
	        $user_id = $this->session->userdata('id');
	        $create_date = date("Y-m-d H:i:s");
	        $stock_data = array(
	            'sales_invoice_id' => $this->input->post('sales_invoice_id'),
	            'store_id' => $this->input->post('store_id'),
	            'create_date' => $create_date,
	            'user_id' => $user_id
	        );
	        
	        $stock_id = $this->model_products->createStock($stock_data);
	        $count_product = count($this->input->post('product_id'));
	        for($x = 0; $x < $count_product; $x++) {
	            $product_data = $this->model_products->getProductData($this->input->post('product_id')[$x]);
	            $items = array(
	                'stock_id'     => $stock_id,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'expiry_date'  => date("Y-m-d",strtotime($this->input->post('expiry_date')[$x])),
	                'cost'         => $product_data['cost'],
	                'sale_price'   => $product_data['sale_price'],
	            );
	            $this->model_products->createStockDetails($items);
	        }
	        redirect('stocks-summary/'.$stock_id, 'refresh');
	    }
	    else {
    	    $this->data['stores'] = $this->model_stores->getActiveStore();
    	    $this->data['products'] = $this->model_products->getActiveProductData();  
    	    $this->render_template('products/stock-create', $this->data);
	    }
	}
	
	public function warehouse_stocks_create($store_id){
	    if(!in_array('updateProduct', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	     
	    $this->form_validation->set_rules('sales_invoice_id', 'Sales Invoice', 'trim|required');
	    $this->form_validation->set_rules('store_id', 'Destination', 'trim|required');
	    $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim');
	    $this->form_validation->set_rules('product_id[]', 'Product name', 'trim|required');
	    $this->form_validation->set_rules('quantity[]', 'Quantity', 'trim|required|numeric');
	    //$this->form_validation->set_rules('expiry_date[]', 'Expiry Date', 'trim|required');
	     
	    if ($this->form_validation->run() == TRUE) {
	         
	        $user_id = $this->session->userdata('id');
	        $create_date = date("Y-m-d H:i:s");
	        $stock_data = array(
	            'sales_invoice_id' => $this->input->post('sales_invoice_id'),
	            'store_id' => $this->input->post('store_id'),
	            'supplier_name' => $this->input->post('supplier_name'),
	            'create_date' => $create_date,
	            'user_id' => $user_id
	        );
	         
	        $stock_id = $this->model_products->createStock($stock_data);
	        $count_product = count($this->input->post('product_id'));
	        for($x = 0; $x < $count_product; $x++) {
	            $product_data = $this->model_products->getProductData($this->input->post('product_id')[$x]);
	            $items = array(
	                'stock_id'     => $stock_id,
	                'product_id'   => $this->input->post('product_id')[$x],
	                'quantity'     => $this->input->post('quantity')[$x],
	                'expiry_date'  => date("Y-m-d",strtotime($this->input->post('expiry_date')[$x])),
	                'cost'         => $product_data['cost'],
	                'sale_price'   => $product_data['sale_price'],
	            );
	            $this->model_products->createStockDetails($items);
	        }
	        redirect('stocks-summary/'.$stock_id, 'refresh');
	    }
	    else {
	        $warehouse_data = $this->model_stores->getStoresData($store_id);
	        $warehouseName = str_replace(" ", "-", $warehouse_data['name']);
	        $warehouseName = strtolower($warehouseName);
	        $this->data['stores'] = $this->model_stores->getActiveStore();
	        $this->data['store_id'] = $store_id;
	        $this->data['store_name'] = $warehouseName;
	        $this->data['products'] = $this->model_products->getActiveProductData();
	        $this->render_template('products/stock-create-warehouse', $this->data);
	    }
	}
	
	
	public function stock_summary($stock_id){
	    if(!in_array('viewProduct', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    
	    if($stock_id) {
	        $stock_data = $this->model_products->getStockSummary($stock_id);
	        $this->data['stock_data'] = $stock_data;
	        $this->data['stock_id'] = $stock_id;
	        $this->data['stores'] = $this->model_stores->getStoresData($stock_data[0]['store_id']);
            $this->render_template('products/stock-summary', $this->data);
	    }
	}
	

    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            //$delete = $this->model_products->remove($product_id);
            $data = array(
                'is_deleted' => 1,
            );
            $delete = $this->model_products->update($data, $product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
	}

	public function removeProductStore($product_id,$store_id)
	{
	    if(!in_array('deleteProduct', $this->permission)) {
	        redirect('dashboard', 'refresh');
	    }
	    $response = array();
	    if($product_id && $store_id) {
	        //$delete = $this->model_products->updateStockDetails($product_id);
	        $ids = $this->model_products->removeStocksFromWarehouse($product_id, $store_id);
	        if(!empty($ids)) {
    	        $data = array(
    	            'is_deleted' => 1,
    	        );
    	        foreach ($ids as $key => $val) {
    	            $delete = $this->model_products->updateStockDetails($data, $val['id']);
    	        }
    	        //
    	        if($delete == true) {
    	            $response['success'] = true;
    	            $response['messages'] = "Successfully removed";
    	        }
    	        else {
    	            $response['success'] = false;
    	            $response['messages'] = "Error in the database while removing the product information";
    	        }
	        }
	        else {
	            $response['success'] = false;
	            $response['messages'] = "Error in the database while removing the product information";
	        }
	    }
	    else {
	        $response['success'] = false;
	        $response['messages'] = "Refresh the page again!!";
	    }
	
	    echo json_encode($response);
	}
	
}