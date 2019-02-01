<?php 

class Model_stores extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getStoresData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM stores WHERE active = 1 AND id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM stores WHERE active = 1 ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = array())
	{
		if($data) {
			$create = $this->db->insert('stores', $data);
			return ($create == true) ? true : false;
		}
	}
	
	public function createT($data = array())
	{
	    if($data) {
	        $this->db->insert('transactions', $data);
	        $id = $this->db->insert_id();
	        return $id;
	    }
	}
	
	public function createST($data = array())
	{
	    if($data) {
	        $this->db->insert('stocks', $data);
	        $id = $this->db->insert_id();
	        return $id;
	    }
	}

	public function createTDetails($data){
	    if($data) {
	        $insert = $this->db->insert('transaction_details', $data);
	        return ($insert == true) ? true : false;
	    }
	}
	public function createSTDetails($data){
	    if($data) {
	        $insert = $this->db->insert('stock_details', $data);
	        return ($insert == true) ? true : false;
	    }
	}
	
	public function updateTransactions($id = null, $data = array())
	{
	    if($id && $data) {
	        $this->db->where('id', $id);
	        $update = $this->db->update('transactions', $data);
	        return ($update == true) ? true : false;
	    }
	}
	
	public function removeTdetails($id){
	    if($id) {
	        $this->db->where('transaction_id', $id);
	        $delete = $this->db->delete('transaction_details');
	        return ($delete == true) ? true : false;
	    }
	}
	
	public function update($id = null, $data = array())
	{
		if($id && $data) {
			$this->db->where('id', $id);
			$update = $this->db->update('stores', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('stores');
			return ($delete == true) ? true : false;
		}

		return false;
	}

	public function getActiveStore()
	{
		$sql = "SELECT * FROM stores WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	public function countTotalStores()
	{
		$sql = "SELECT * FROM stores WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
	
	public function getNextIncrementID(){
	    $sql = "SELECT AUTO_INCREMENT as nextId FROM information_schema.tables WHERE table_name = 'stores' AND table_schema = DATABASE();";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	public function getNextIncrementIDT(){
	    $sql = "SELECT AUTO_INCREMENT as nextId FROM information_schema.tables WHERE table_name = 'transactions' AND table_schema = DATABASE();";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	
	
	
	
	public function getAllTransactionDetails($type="delivery",$store_id,$tid=null) {
	    $and = "";
	    if($tid) {
	        $and = " AND transactions.id = '".intval($tid)."' ";
	    }
	    if($type && $store_id) {
	        $sql = "SELECT
                	*,(
                		SELECT
                			customer_name
                		FROM
                			customers
                		WHERE
                			customers.id = transactions.customer_id
                	) as customer_name ,
                	(
                		SELECT
                			SUM(
                				transaction_details.quantity * transaction_details.sale_price
                			)
                		FROM
                			transaction_details
                		WHERE
                			transactions.id = transaction_details.transaction_id
                	) as sales_total,
                	(SELECT stores.`name` FROM stores WHERE stores.id = transactions.store_id) as destination_location,
                	(SELECT stores.`name` FROM stores WHERE stores.id = transactions.from_store_id) as source_location
                FROM
                	transactions
                WHERE
                	
                	(transactions.store_id = '".intval($store_id)."' OR transactions.from_store_id = '".intval($store_id)."')
                AND transactions.transaction_type = '$type' $and";
	        //transactions.store_id = '".intval($store_id)."'
	        $query = $this->db->query($sql);
	        return $query->result_array();
	    }
	}
	
	public function getViewTransactions($tid,$store_id,$type="delivery"){
	    if($tid && $store_id) {
	        $sql = "
	            SELECT
                	DATE_FORMAT(create_date,'%m-%d-%Y') as order_date,
                	transactions.display_id as delivery_id,
	                transactions.store_id,
                	transactions.po_number,
                	(
                		SELECT
                			customer_name
                		FROM
                			customers
                		WHERE
                			customers.id = transactions.customer_id
                	) as customer_name,
	                transactions.address,
                	transactions.notes,
                	transactions.transaction_status,
                	transaction_details.quantity,
                	transaction_details.product_id,
                	transactions.customer_id,
                	transaction_details.sale_price,
                	(transaction_details.quantity * transaction_details.sale_price) as sale_amount,
                	(SELECT products.`name` FROM products WHERE products.id = transaction_details.product_id) as product_name,
                	(SELECT units.`name` FROM units, products WHERE units.id = products.unit_id AND products.id = transaction_details.product_id LIMIT 1) as unit_name,
                	(SELECT stores.`name` FROM stores WHERE stores.id = transactions.store_id) as destination_location,
                	(SELECT stores.`name` FROM stores WHERE stores.id = transactions.from_store_id) as source_location
                FROM
                	transactions, transaction_details
                WHERE
                	transactions.store_id = '".intval($store_id)."' AND transactions.id = transaction_details.transaction_id 
                AND transactions.transaction_type = '$type' AND transactions.id = '".intval($tid)."'
                ORDER BY quantity DESC";
	        $query = $this->db->query($sql);
	        return $query->result_array();
	    }
	    
	}
	
	public function getQTYStockID($store_id,$product_id){
	    if($product_id && $store_id) {
    	    $sql = "SELECT
                    	quantity,
                    	stocks.id as stock_id,
    	                expiry_date
                    
                    FROM 
                    	stocks, stock_details, products
                    WHERE	
                    	stocks.id = stock_details.stock_id AND 
                    	products.id = stock_details.product_id AND
                    	stocks.store_id = '".intval($store_id)."' AND stock_details.product_id = '".intval($product_id)."'
    	        ";
    	    $query = $this->db->query($sql);
    	    return $query->result_array();
	    }
	}
	
	public function getStockID($tid){
	    if($tid) {
	        $sql = "SELECT * FROM stocks WHERE transaction_id = ?";
	        $query = $this->db->query($sql, array($tid));
	        return $query->row_array();
	    }
	}
	
	public function getTransactionsData($id = null)
	{
	    if($id) {
	        $sql = "SELECT * FROM transactions WHERE  id = ?";
	        $query = $this->db->query($sql, array($id));
	        return $query->row_array();
	    }
	}
	
	
	
	
	
	
	
}