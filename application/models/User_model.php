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
    public function create_user($user_mail, $user_password) {

        $data = array(
            'mail'   => $user_mail,
            'pwd'   => $this->hash_password($user_password),
            'created_at' => date('Y-m-j H:i:s'),
        );

        return $this->db->insert('cvp_c_profile', $data);

    }

    /**
     * resolve_user_login function.
     *
     * @access public
     * @param mixed $username
     * @param mixed $password
     * @return bool true on success, false on failure
     */
    public function resolve_user_login($user_mail, $user_password) {

        $this->db->select('pwd');
        $this->db->from('cvp_c_profile');
        $this->db->where('mail', $user_mail);
        $hash = $this->db->get()->row('pwd');

        return $this->verify_password_hash($user_password, $hash);

    }

    /**
     * get_user_id_from_username function.
     *
     * @access public
     * @param mixed $username
     * @return int the user id
     */
    public function get_user_id_from_user_mail($user_mail) {

        $this->db->select('id');
        $this->db->from('cvp_c_profile');
        $this->db->where('mail', $user_mail);
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

        $this->db->from('cvp_c_profile');
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