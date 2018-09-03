<?php 

class Model_expenses extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getExpensesData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM expenses WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM expenses ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data = array())
	{
		if($data) {
			$create = $this->db->insert('expenses', $data);
			return ($create == true) ? true : false;
		}
	}

	public function update($id = null, $data = array())
	{
		if($id && $data) {
			$this->db->where('id', $id);
			$update = $this->db->update('expenses', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id = null)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('expenses');
			return ($delete == true) ? true : false;
		}
	}
}