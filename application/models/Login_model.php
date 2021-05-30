<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model
{
	public function user_model_info($name, $password)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('name', $name);
		$this->db->where('password', $password);
		$query_result=$this->db->get();
		$result=$query_result->row();
		return $result;
	}

    public function login($email, $password){
			$query = $this->db->get_where('users', array(
				'email'=>$email, 
				'password'=>$password
				)
			);
			return $query->row_array();
	}

	public function inserter($table, $data) {

        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function get_data($table = NULL, $orderby = NULL, $where = NULL) {
        $this->db->select('*');
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($orderby != '') {
            $this->db->order_by($orderby, "DESC");
        }

        $result = $this->db->get()->result_array();
        return $result;
    }
}
