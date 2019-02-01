<?php 

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months*/
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getOrderYearOld()
	{
		$sql = "SELECT * FROM orders WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		
		$return_data = array();
		foreach ($result as $k => $v) {
			$date = date('Y', $v['date_time']);
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}
    
	public function getOrderYear()
	{
	    $sql = "SELECT 
                SUM(td.quantity * td.sale_price) as net_amount,
                DATE_FORMAT(tr.create_date,'%Y-%m-%d') as order_date  
                FROM
                transactions tr,
                transaction_details td 
                WHERE 
                tr.id = td.transaction_id
                AND
                tr.transaction_type IN ('delivery','pickup')
                AND 
                tr.transaction_status = 'delivered'";
	    $query = $this->db->query($sql);
	    $result = $query->result_array();
	
	    $return_data = array();
	    foreach ($result as $k => $v) {
	        $date = date('Y', strtotime($v['order_date'])); 
	        $return_data[] = $date;
	    }
	    $return_data = array_unique($return_data);
	    return $return_data;
	}
	
	// getting the order reports based on the year and moths
	public function getOrderDataOld($year)
	{	
		if($year) {
			$months = $this->months();
			
			$sql = "SELECT * FROM orders WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['date_time']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	

			return $final_data;
		}
	}
	
	// getting the order reports based on the year and moths
	public function getOrderData($year)
	{
	    if($year) {
	        $months = $this->months();
	        	
	        $sql = "SELECT 
                SUM(td.quantity * td.sale_price) as net_amount,
                DATE_FORMAT(tr.create_date,'%Y-%m-%d') as order_date  
                FROM
                transactions tr,
                transaction_details td 
                WHERE 
                tr.id = td.transaction_id
                AND
                tr.transaction_type IN ('delivery','pickup')
                AND 
                tr.transaction_status = 'delivered'";
	        $query = $this->db->query($sql);
	        $result = $query->result_array();
	
	        $final_data = array();
	        foreach ($months as $month_k => $month_y) {
	            $get_mon_year = $year.'-'.$month_y;
	
	            $final_data[$get_mon_year][] = '';
	            foreach ($result as $k => $v) {
	                $month_year = date('Y-m', strtotime($v['order_date'])); 
	
	                if($get_mon_year == $month_year) {
	                    $final_data[$get_mon_year][] = $v;
	                }
	            }
	        }
	
	        return $final_data;
	    }
	}

	public function getStoreWiseOrderData($year, $store)
	{
		if($year && $store) {
			$months = $this->months();
			
			$sql = "SELECT 
                        SUM(td.quantity * td.sale_price) as net_amount,
                        DATE_FORMAT(tr.create_date,'%Y-%m-%d') as order_date  
                        FROM
                        transactions tr,
                        transaction_details td 
                        WHERE 
                        tr.id = td.transaction_id
                        AND
                        tr.transaction_type IN ('delivery','pickup')
                        AND 
                        tr.transaction_status = 'delivered'
                        AND
                        tr.store_id = '".$store."' ";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', strtotime($v['order_date'])); 

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	
			
			return $final_data;
		}
	}
	
	public function getTopProducts($storeid){
	    if($storeid) {
	        $sql = "
	            SELECT 
                SUM(td.quantity) as item_sold,
                (SELECT products.`name` FROM products WHERE products.id = td.product_id) as product_name,
                (SELECT products.`sku` FROM products WHERE products.id = td.product_id) as sku,
                (SELECT units.`name` FROM units, products WHERE products.unit_id = units.id AND products.id = td.product_id) as unit_name
                FROM
                transactions tr,
                transaction_details td 
                WHERE 
                tr.id = td.transaction_id
                AND
                tr.transaction_type IN ('delivery','pickup')
                AND 
                tr.transaction_status = 'delivered'
                AND
                tr.store_id = '".intval($storeid)."' 
                GROUP BY td.product_id 
                ORDER BY item_sold DESC LIMIT 10 
	            ";
	        $query = $this->db->query($sql);
	        return  $query->result_array();
	    }
	}
	
}