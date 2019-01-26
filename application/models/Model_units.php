<?php 
class Model_units extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the company data */
	public function getUnitsData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM units WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}
		$sql = "SELECT * FROM units WHERE is_status= 1 ORDER BY name ASC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('units', $data);
			return ($update == true) ? true : false;
		}
	}
	
	public function delete($id)
	{
	    $this->db->where('id', $id);
	    $delete = $this->db->delete('units');
	    return ($delete == true) ? true : false;
	}
	
	public function create($data = '')
	{
	    if($data) {
	        $create = $this->db->insert('units', $data);
	        return ($create == true) ? true : false;
	    }
	}

}
