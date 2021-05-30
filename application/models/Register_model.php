<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Register_model extends CI_Model
{
	public function user_reg_save($data)
	{
		$result=$this->db->insert('users',$data);
		return $result;
	}
}