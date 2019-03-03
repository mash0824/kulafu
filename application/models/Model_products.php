<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_users');
	}

	/* get the product data */
	public function getProductData($id = null)
	{
	    
		if($id) {
			$sql = "SELECT * FROM products where is_deleted = '0'  AND id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}	

		$sql = "SELECT * FROM products WHERE is_deleted = '0' ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array(); 
	}
	
	public function getExpiryDetails($id=null){
	   if($id) {
	       $sql = "SELECT
                	product_id,SUM(quantity) as total_quantity
                FROM
                	stock_details
                WHERE
                	expiry_date <= DATE_ADD(CURDATE() , INTERVAL 7 DAY)
                AND product_id = '".intval($id)."' AND expiry_date != '1970-01-01'";
	       $query = $this->db->query($sql);
	       return $query->result_array();
	   }
	}
	
	public function getProductListByWarehouse($warehouse_id){
	    if($warehouse_id) {
// 	        $sql = "
// 	            SELECT 
//                 	product_id, store_id, products.`name`, products.sku, (SELECT brands.`name` FROM brands WHERE brands.id = products.brand_id) as brand_name,
//                 	(SELECT units.`name` FROM units WHERE units.id = products.id) as unit_name, products.sale_price, products.cost,
//                 	(
//                 		SELECT
//                 			sum(skd.quantity) 
//                 		FROM
//                 			stock_details skd, stocks stk
//                 		WHERE
// 	                        stk.store_id = '".intval($warehouse_id)."' AND stk.id = skd.stock_id AND 
//                 			skd.expiry_date > DATE(NOW())
//                 		AND product_id = products.id
//                 		AND skd.is_deleted = '0' AND  skd.stock_id = stocks.id 
//                 		GROUP BY
//                 			product_id
//                 	) as stock_count,
//                 	(
//                 		SELECT
//                 			sum(tds.quantity) as less_count
//                 		FROM
//                 			transaction_details tds ,
//                 			transactions trs
//                 		WHERE
//                 			trs.transaction_type NOT IN('transfer')
//                 		AND trs.id = tds.transaction_id AND tds.product_id = products.id AND trs.store_id = '".intval($warehouse_id)."'
//                 	) as less_stock
                	
                	
//                 FROM
//                 	stocks, 
//                 	stock_details,
//                 	products
                	
//                 WHERE 
//                 	stocks.id = stock_details.stock_id AND products.id = stock_details.product_id 
//                 	AND stocks.store_id = '".intval($warehouse_id)."' AND stock_details.is_deleted = 0
// 	            ";
            $sql= "
                SELECT
                	product_id ,
                	store_id ,
                	products.`name` ,
                	products.sku ,
                	(
                		SELECT
                			brands.`name`
                		FROM
                			brands
                		WHERE
                			brands.id = products.brand_id
                	) as brand_name ,
                	(
                		SELECT
                			units.`name`
                		FROM
                			units
                		WHERE
                			units.id = products.id
                	) as unit_name ,
                	products.sale_price ,
                	products.cost ,
                	IFNULL((
                		SELECT
                			sum(skd.quantity)
                		FROM
                			stock_details skd ,
                			stocks stk
                		WHERE
                			stk.store_id = '".intval($warehouse_id)."'
                		AND stk.id = skd.stock_id
                		AND product_id = products.id
                		AND skd.is_deleted = '0'
                		AND skd.stock_id = stocks.id
                		GROUP BY
                			product_id
                	),0)-(
                	IFNULL((
                		SELECT
                			sum(tds.quantity) as less_count
                		FROM
                			transaction_details tds ,
                			transactions trs
                		WHERE
                			trs.transaction_type NOT IN('transfer')
                		AND trs.id = tds.transaction_id
                		AND tds.product_id = products.id
                		AND trs.store_id = '".intval($warehouse_id)."'
                	),0)+
                	IFNULL((
                		SELECT
                			sum(tds.quantity) as less_count
                		FROM
                			transaction_details tds ,
                			transactions trs
                		WHERE
                			trs.transaction_type = 'transfer'
                		AND trs.id = tds.transaction_id AND tds.product_id = products.id AND trs.from_store_id = '".intval($warehouse_id)."'
                	),0)) as stock_count,
                    (0) as less_stock
                FROM
                	stocks ,
                	stock_details ,
                	products
                WHERE
                	stocks.id = stock_details.stock_id
                AND products.id = stock_details.product_id
                AND stocks.store_id = 1
                AND stock_details.is_deleted = 0 Having stock_count > 0
                ";
	        $query = $this->db->query($sql);
	        return $query->result_array();
	    }
	}
	
	public function getProductListByWarehouseNonGroup($warehouse_id,$withdraw=""){
	    
	    $d = " sum(skd.quantity) ";
// 	    if($withdraw) {
// 	        $d  = "IFNULL(
// 				(
// 					SELECT
// 						sum(sss.quantity)
// 					FROM
// 						stock_details sss
// 					WHERE
// 					sss.product_id = skd.product_id
// 					GROUP BY
// 						sss.product_id
// 				) ,
// 				0
// 			) ";
// 	    }
// 	    else {
// 	        $d  = "IFNULL(
// 				(
// 					SELECT
// 						sum(sss.quantity)
// 					FROM
// 						stock_details sss
// 					WHERE
// 						sss.expiry_date > DATE(NOW())
// 					AND sss.product_id = skd.product_id
// 					GROUP BY
// 						sss.product_id
// 				) ,
// 				0
// 			) + IFNULL(
// 				(
// 					SELECT
// 						sum(sse.quantity)
// 					FROM
// 						stock_details sse
// 					WHERE
// 						sse.expiry_date = '1970-01-01'
// 					AND sse.product_id = skd.product_id
// 					GROUP BY
// 						sse.product_id
// 				) ,
// 				0
// 			)";
// 	    }
	    
	    if($warehouse_id) {
	        $sql = "
	            SELECT
                	product_id, store_id, products.`name`, products.sku, (SELECT brands.`name` FROM brands WHERE brands.id = products.brand_id) as brand_name,
                	(SELECT units.`name` FROM units WHERE units.id = products.id) as unit_name, products.sale_price, products.cost, unit_id,
                	(
                		SELECT
                			$d 
                		FROM
                			stock_details skd, stocks stk
                		WHERE
                		stk.store_id = '".intval($warehouse_id)."' AND stk.id = skd.stock_id 
                		AND product_id = products.id
                		AND skd.is_deleted = '0' 
                		GROUP BY
                			product_id
                	) as stock_count,
                	IFNULL((
                		SELECT
                			sum(tds.quantity) as less_count
                		FROM
                			transaction_details tds ,
                			transactions trs
                		WHERE
                			trs.transaction_type NOT IN('transfer')
                		AND trs.id = tds.transaction_id AND tds.product_id = products.id AND trs.store_id = '".intval($warehouse_id)."'
                	),0) +
                	IFNULL((
                		SELECT
                			sum(tds.quantity) as less_count
                		FROM
                			transaction_details tds ,
                			transactions trs
                		WHERE
                			trs.transaction_type = 'transfer'
                		AND trs.id = tds.transaction_id AND tds.product_id = products.id AND trs.from_store_id = '".intval($warehouse_id)."'
                	),0) as less_stock
                FROM
                	stocks,
                	stock_details,
                	products
                
                WHERE
                	stocks.id = stock_details.stock_id AND products.id = stock_details.product_id
                	AND stocks.store_id = 1 AND stock_details.is_deleted = 0 AND products.is_deleted = 0 
                	GROUP BY products.id HAVING stock_count >0
	            ";
	        $query = $this->db->query($sql);
	        return $query->result_array();
	    }
	}
// 	public function getProductListByWarehouseNonGroup($warehouse_id){
// 	    if($warehouse_id) {
// 	        $sql = "
// 	            SELECT
//                 	product_id, store_id, products.`name`, products.sku, (SELECT brands.`name` FROM brands WHERE brands.id = products.brand_id) as brand_name,
//                 	(SELECT units.`name` FROM units WHERE units.id = products.id) as unit_name, products.sale_price, products.cost, unit_id,
//                 	(
//                 		SELECT
//                 			sum(skd.quantity)
//                 		FROM
//                 			stock_details skd, stocks stk
//                 		WHERE
// 	                        stk.store_id = '".intval($warehouse_id)."' AND stk.id = skd.stock_id AND
//                 			skd.expiry_date > DATE(NOW())
//                 		AND product_id = products.id
//                 		AND skd.is_deleted = '0' 
//                 		GROUP BY
//                 			product_id
//                 	) as stock_count,
//                 	(
//                 		SELECT
//                 			sum(tds.quantity) as less_count
//                 		FROM
//                 			transaction_details tds ,
//                 			transactions trs
//                 		WHERE
//                 			trs.transaction_type NOT IN('transfer')
//                 		AND trs.id = tds.transaction_id AND tds.product_id = products.id AND trs.store_id = '".intval($warehouse_id)."'
//                 	) as less_stock
         
         
//                 FROM
//                 	stocks,
//                 	stock_details,
//                 	products
         
//                 WHERE
//                 	stocks.id = stock_details.stock_id AND products.id = stock_details.product_id
//                 	AND stocks.store_id = '".intval($warehouse_id)."' AND stock_details.is_deleted = 0
//                 	GROUP BY products.id 
// 	            ";
// 	        $query = $this->db->query($sql);
// 	        return $query->result_array();
// 	    }
// 	}
	

	/* get the product data */
	public function getProductDataByCat($cat_id = null)
	{
		if($cat_id) {
			$user_id = $this->session->userdata('id');
			if($user_id == 1) {
				$sql = "SELECT * FROM products ORDER BY id DESC";
				$query = $this->db->query($sql);
				$result = array();
				foreach($query->result_array() as $key => $value) {
					$category_ids = json_decode($value['category_id']);
					if(in_array($cat_id, $category_ids)) {
						$result[] = $value;
					}
				} 
				return $result;
			}
			else {
				// for store users 
				$user_data = $this->model_users->getUserData($user_id);

				$sql = "SELECT * FROM products ORDER BY id DESC";
				$query = $this->db->query($sql);

				$data = array();
				foreach ($query->result_array() as $k => $v) {
					$store_ids = json_decode($v['store_id']);
					$category_ids = json_decode($v['category_id']);
					if(in_array($cat_id, $category_ids) && in_array($user_data['store_id'], $store_ids)) {
						$data[] = $v;
					}
				}

				return $data;		
			}
		}	
	}
	
	public function getStockHistory($id,$store_id=null){
	    $and = "";
	    if($store_id) {
	        $and = " AND sts.store_id = '$store_id' ";
	    }
	    $sql = <<<xxx
            SELECT
                sds.id,
	           strs.id as store_id,
            	strs.`name` as store_name ,
            	quantity ,
            	unt.`name` as unit_name,
            	sts.transaction_id,
            	expiry_date,
            	(CASE
            	     WHEN DATE(CURDATE()) >=  expiry_date AND expiry_date <> "1970-01-01" THEN "<span class='expiring'>Expired</span>"
            	    WHEN DATE_ADD(CURDATE(), INTERVAL 7 DAY) >=  expiry_date AND expiry_date <> "1970-01-01" THEN "<span class='expiring'>Expiring</span>"
            	    ELSE "<span class='normal'>Normal</span>"
            	END) as stock_status,
            	(CASE
            	    WHEN DATE_ADD(CURDATE(), INTERVAL 7 DAY) >=  expiry_date AND expiry_date <> "1970-01-01"  THEN 1
            	    ELSE 0
            	END) as stock_status_flag
            FROM 
            	stocks sts,
            	stock_details sds,
            	products pd,
            	stores strs,
            	units unt 
            WHERE 
            	pd.id = sds.product_id AND
            	sds.stock_id = sts.id AND 
            	strs.id = sts.store_id AND 
            	unt.id = pd.unit_id  AND 
            	sds.product_id = '$id' $and
            	ORDER BY sds.id ASC, sds.expiry_date DESC
xxx;
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	
	public function getExpiryDetailNew($pid,$sid=""){
	    if($pid) {
	        $ex = "";
	        if($sid) {
	            $ex = " AND trs.store_id = '".intval($sid)."' ";
	        }
	       $sql = "SELECT
	        sum(trd.quantity) as expiry_total, product_id
	        FROM
	        transactions trs, transaction_details trd
	        WHERE
	        trs.transaction_type = 'withdrawal' AND trd.product_id = '".intval($pid)."' AND 
	        trs.id = trd.transaction_id $ex ";
	       $query = $this->db->query($sql);
	       return $query->result_array();
	    }
	}
	
	public function getStockSummary($id){
	    $sql = <<<xxx
SELECT
	(SELECT `name` FROM products WHERE id = sds.product_id) AS product_name ,
	(SELECT `id` FROM products WHERE id = sds.product_id) AS product_id ,
    sds.id as stock_detail_id,
	sds.quantity ,
    sts.supplier_name,
    sts.store_id,
    sts.sales_invoice_id as sales_invoice,
	(SELECT unt.name FROM units unt, products pd WHERE pd.unit_id = unt.id AND  pd.id = sds.product_id ) AS unit_name ,
	sds.expiry_date
FROM
	stocks sts ,
	stock_details sds 
		
WHERE
	sds.stock_id = sts.id AND sts.id = '$id'
xxx;
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	
	public function getInStockCount($id=null){
	    if($id) {
    	    $sql = "SELECT
	product_id ,
	stock_count ,
	less_count
FROM
	(
		SELECT
			skd.product_id ,
			IFNULL(
				(
					SELECT
						sum(sss.quantity)
					FROM
						stock_details sss
					WHERE
						sss.product_id = skd.product_id
					GROUP BY
						sss.product_id
				) ,
				0
			) as stock_count
		FROM
			stock_details skd
		WHERE
			product_id = '$id'
		AND skd.is_deleted = '0'
		GROUP BY
			product_id
	) as D
LEFT JOIN(
	SELECT
		tds.product_id as pdid ,
		sum(tds.quantity) as less_count
	FROM
		transaction_details tds ,
		transactions trs
	WHERE
	trs.id = tds.transaction_id
	group by
		tds.product_id
) as C ON C.pdid = D.product_id
AND D.product_id = '$id'
AND C.pdid = '$id'";
	    } else {
    	    $sql = "SELECT
	product_id ,
	stock_count ,
	less_count
FROM
	(
		SELECT
			skd.product_id ,
			IFNULL(
				(
					SELECT
						sum(sss.quantity)
					FROM
						stock_details sss
					WHERE
						sss.product_id = skd.product_id
					GROUP BY
						sss.product_id
				) ,
				0
			) as stock_count
		FROM
			stock_details skd
		WHERE
			skd.expiry_date > DATE(NOW())
		AND skd.is_deleted = '0'
		AND skd.expiry_date <> '1970-01-01'
		GROUP BY
			product_id
	) as D
LEFT JOIN(
	SELECT
		tds.product_id as pdid ,
		sum(tds.quantity) as less_count
	FROM
		transaction_details tds ,
		transactions trs
	WHERE
		trs.id = tds.transaction_id
	GROUP BY
		tds.product_id
) as C ON C.pdid = D.product_id";
	    }
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	
	public function getNextIncrementID(){
	    $sql = "SELECT AUTO_INCREMENT as nextId FROM information_schema.tables WHERE table_name = 'products' AND table_schema = DATABASE();";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}

	public function getActiveProductData()
	{
		$user_id = $this->session->userdata('id');

		if($user_id == 1) {
			$sql = "SELECT * FROM products  WHERE is_deleted = 0 ORDER BY id DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		else {
			$this->load->model('model_users');
			$user_data = $this->model_users->getUserData($user_id);
			$sql = "SELECT * FROM products   WHERE is_deleted = 0 ORDER BY id DESC";
			$query = $this->db->query($sql);

			$data = array();
			foreach ($query->result_array() as $k => $v) {
				$store_ids = json_decode($v['store_id']);
				if(in_array($user_data['store_id'], $store_ids)) {
					$data[] = $v;
				}
			}

			return $data;			
		}
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function createStock($data){
	    if($data) {
	       $this->db->insert('stocks', $data);
	       $id = $this->db->insert_id();
	       return $id;
	    }
	}
	
	public function createStockDetails($data){
    	if($data) {
			$insert = $this->db->insert('stock_details', $data);
			return ($insert == true) ? true : false;
		}
	}
	
	public function updateStocks($data, $id)
	{
	    if($data && $id) {
	        $this->db->where('id', $id);
	        $update = $this->db->update('stocks', $data);
	        return ($update == true) ? true : false;
	    }
	}
	
	public function updateStockDetails($data, $id)
	{
	    if($data && $id) {
	        $this->db->where('id', $id);
	        $update = $this->db->update('stock_details', $data);
	        return ($update == true) ? true : false;
	    }
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}
	
	public function removeStocksFromWarehouse($id, $store_id){
	    if($id && $store_id) {
    	    $sql = "SELECT
    			sds.id
    		FROM
    			stocks ,
    			stock_details sds
    		WHERE
    			stocks.id = sds.stock_id
    		AND stocks.store_id = '".intval($store_id)."'
    		AND sds.product_id = '".intval($id)."'";
    	    $query = $this->db->query($sql);
    	    return $query->result_array();
	    }
	}
	
	public function removeStocks($id){
	    if($id) {
	        $this->db->where('stock_id', $id);
	        $delete = $this->db->delete('stock_details');
	        return ($delete == true) ? true : false;
	    }
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}