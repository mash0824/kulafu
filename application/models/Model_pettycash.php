<?php 

class Model_pettycash extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getPettyCashData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM petty_cash WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM petty_cash ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = array())
	{
		if($data) {
			$create = $this->db->insert('petty_cash', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if($id && $data) {
			$this->db->where('id', $id);
			$update = $this->db->update('petty_cash', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('petty_cash');
			return ($delete == true) ? true : false;
		}
	}
}