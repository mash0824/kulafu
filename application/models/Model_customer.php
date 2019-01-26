<?php 
class Model_customer extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the company data */
	public function getCustomerData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM customers WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT * FROM customers WHERE is_status = 1 ORDER BY id ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('customers', $data);
			return ($update == true) ? true : false;
		}
	}
	
	public function delete($id)
	{
	    $this->db->where('id', $id);
	    $delete = $this->db->delete('customers');
	    return ($delete == true) ? true : false;
	}

	public function getNextIncrementID(){
	    $sql = "SELECT AUTO_INCREMENT as nextId FROM information_schema.tables WHERE table_name = 'customers'AND table_schema = DATABASE();";
	    $query = $this->db->query($sql);
	    return $query->result_array();
	}
	
	public function create($data = '')
	{
	    if($data) {
	        $create = $this->db->insert('customers', $data);
	        return ($create == true) ? true : false;
	    }
	}

}
