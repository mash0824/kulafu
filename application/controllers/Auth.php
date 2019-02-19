<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Admin_Controller 
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('model_auth');
		$this->load->model('model_users');
	}

	/* 
		Check if the login form is submitted, and validates the user credential
		If not submitted it redirects to the login page
	*/
	public function login()
	{

		$this->logged_in();

		$this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            // true case
           	$email_exists = $this->model_auth->check_username($this->input->post('username'));

           	if($email_exists == TRUE) {
           		$login = $this->model_auth->loginUsername($this->input->post('username'), $this->input->post('password'));

           		if($login) {

           			$logged_in_sess = array(
           				'id' => $login['id'],
				        'username'  => $login['username'],
				        'email'     => $login['email'],
				        'logged_in' => TRUE
					);

					$this->session->set_userdata($logged_in_sess);
           			redirect('dashboard', 'refresh');
           		}
           		else {
           			$this->data['errors'] = 'Incorrect username/password combination';
           			$this->load->view('login_switch', $this->data);
           		}
           	}
           	else {
           		$this->data['errors'] = 'Username does not exist';

           		$this->load->view('login_switch', $this->data);
           	}	
        }
        else {
            // false case
            $this->load->view('login_switch');
        }	
	}

	/*
		clears the session and redirects to login page
	*/
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth/login', 'refresh');
	}
	
	public function forgot()
	{
	
	    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	
	    if($this->form_validation->run() == FALSE) {
	        $this->load->view('forgot');
	    }else{
	        $email = $this->input->post('email');
	        $clean = $this->security->xss_clean($email);
	        $checkemail = $this->model_auth->check_email($clean);
	        $userInfo = $this->model_users->getUserDataByEmail($clean);
	        if(!$checkemail){
	            $this->data['errors'] = 'We cant find your email address';
	            $this->load->view('forgot', $this->data);
	        }
	        else {
    	        //build token
    	        $token = $this->model_auth->insertToken($userInfo['id']);
    	        $qstring = $this->base64url_encode($token);
    	        $url = site_url() . 'auth/reset_password/token/' . $qstring;
    	        $link = '<a href="' . $url . '">' . $url . '</a>';
    	
    	        $message = '';
    	        $message .= '<strong>A password reset has been requested for this email account</strong><br>';
    	        $message .= '<strong>Please click:</strong> ' . $link;
    	        //echo $message; //send this through mail
    	        //exit;
    	        $config = array(
    	            'protocol' => 'smtp',
    	            'smtp_host' => 'email-smtp.us-west-2.amazonaws.com',
    	            'smtp_port' => 587,
    	            'smtp_user' => 'AKIAIXTKUBO5XODPUUBQ',
    	            'smtp_pass' => 'BI7DStPYnNBIvjS1/6+KuLOYdtKPyrsnYUlv0j6K6k3w',
    	            'mailtype'  => 'html',
    	            'charset'   => 'utf-8',
    	            'wordwrap'  => true,
    	            'wrapchars' => 50
    	        );
    	        $config['smtp_crypto'] = 'tls';
    	        $config['crlf'] = "\r\n";      //should be "\r\n"
    	        $config['newline'] = "\r\n";   //should be "\r\n"
    	        $this->load->library('email');
    	        $this->email->initialize($config);
    	        $this->email->from('admin@switch.local', 'Switch Admin');
    	        $this->email->to($userInfo['email']);
    	        
    	        $this->email->subject('Switch Inventory System | Password Recovery');
    	        $this->email->message($message);
    	        
    	        
    	        //Send mail
    	        if($this->email->send()) {
                    $this->data['errors'] = 'A password reset has been requested for this email account';
    	        }
	            else {
	                echo "<pre>";
	                print_r($this->email);
	                $this->data['errors'] = 'Error in sending Email.';
	            }
    	        $this->load->view('forgot', $this->data);
	        }
	
	    }
	
	}
    
    public function reset_password()
    {
        $token = $this->base64url_decode($this->uri->segment(4));
        $this->data['token'] = $this->uri->segment(4);
        $cleanToken = $this->security->xss_clean($token);
    
        $token_info = $this->model_auth->isTokenValid($cleanToken); //either false or array();
        if(!$token_info){
            $this->data['errors'] = 'Token is invalid or expired.';
            $this->load->view('reset_password', $this->data);
        }
        else {
            $user_info = $this->model_users->getUserData($token_info->user_id);
            $data = array(
                'username'=> $user_info['username'],
                'email'=> $user_info['email'],
                'token'=> $this->base64url_encode($token)
            );
             
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('passconf', 'Confirm password', 'trim|required|matches[password]');
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('reset_password', $data);
            }else{
                $post = $this->input->post(NULL, TRUE);
                $cleanPost = $this->security->xss_clean($post);
                $hashed = password_hash($cleanPost['password'], PASSWORD_DEFAULT);
                $cleanPost['password'] = $hashed;
                unset($cleanPost['passconf']);
                if(!$this->model_users->edit($cleanPost,$user_info['id'])){
                    $this->data['errors'] = 'There was a problem updating your password.';
                }else{
                    $this->data['errors'] = 'Your password has been updated. You may now login.';
                }
                $this->load->view('reset_password', $this->data);
            
            }
        }
    }
    
    public function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    public function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
	
    protected function _islocal(){
        return strpos($_SERVER['HTTP_HOST'], 'local');
    }
	

}
