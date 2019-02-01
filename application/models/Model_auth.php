<?php 

class Model_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* 
		This function checks if the email exists in the database
	*/
	public function check_email($email) 
	{
		if($email) {
			$sql = 'SELECT * FROM users WHERE email = ?';
			$query = $this->db->query($sql, array($email));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}

		return false;
	}
	
	public function check_username($username)
	{
	    if($username) {
	        $sql = 'SELECT * FROM users WHERE username = ?';
	        $query = $this->db->query($sql, array($username));
	        $result = $query->num_rows();
	        return ($result == 1) ? true : false;
	    }
	
	    return false;
	}

	/* 
		This function checks if the email and password matches with the database
	*/
	public function login($email, $password) {
		if($email && $password) {
			$sql = "SELECT * FROM users WHERE email = ?";
			$query = $this->db->query($sql, array($email));

			if($query->num_rows() == 1) {
				$result = $query->row_array();

				$hash_password = password_verify($password, $result['password']);
				if($hash_password === true) {
					return $result;	
				}
				else {
					return false;
				}

				
			}
			else {
				return false;
			}
		}
	}
	
	
	public function loginUsername($username, $password) {
	    if($username && $password) {
	        $sql = "SELECT * FROM users WHERE username = ?";
	        $query = $this->db->query($sql, array($username));
	
	        if($query->num_rows() == 1) {
	            $result = $query->row_array();
	
	            $hash_password = password_verify($password, $result['password']);
	            if($hash_password === true) {
	                return $result;
	            }
	            else {
	                return false;
	            }
	
	
	        }
	        else {
	            return false;
	        }
	    }
	}
	
	public function insertToken($user_id)
	{
	    $token = substr(sha1(rand()), 0, 30);
	    $date = date('Y-m-d');
	
	    $string = array(
	        'token'=> $token,
	        'user_id'=>$user_id,
	        'created'=>$date
	    );
	    $query = $this->db->insert_string('tokens',$string);
	    $this->db->query($query);
	    return $token . $user_id;
	}
	
	public function isTokenValid($token)
	{
	    $tkn = substr($token,0,30);
	    $uid = substr($token,30);
	     
	    $q = $this->db->get_where('tokens', array(
	        'tokens.token' => $tkn,
	        'tokens.user_id' => $uid), 1);
	     
	    if($this->db->affected_rows() > 0){
	        $row = $q->row();
	
	        $created = $row->created;
	        $createdTS = strtotime($created);
	        $today = date('Y-m-d');
	        $todayTS = strtotime($today);
	
	        if($createdTS != $todayTS){
	            return false;
	        }
	        return $row;
	
	    }else{
	        return false;
	    }
	
	}
	
	
}