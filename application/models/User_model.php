<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($user_name, $user_email, $user_password) {
		
		$data = array(
			'user_name'   => $user_name,
			'user_email'      => $user_email,
			'user_password'   => $this->hash_password($user_password),
			'created_at' => date('Y-m-j H:i:s'),
		);
		
		return $this->db->insert('user_login', $data);
		
	}
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($user_name, $user_password) {
		
		$this->db->select('user_password');
		$this->db->from('user_login');
		$this->db->where('user_name', $user_name);
		$hash = $this->db->get()->row('user_password');
		
		return $this->verify_password_hash($user_password, $hash);
		
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($user_name) {
		
		$this->db->select('id');
		$this->db->from('user_login');
		$this->db->where('user_name', $user_name);

		return $this->db->get()->row('id');
		
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('user_login');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($user_password) {
		
		return password_hash($user_password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($user_password, $hash) {
		
		return password_verify($user_password, $hash);
		
	}
	
}