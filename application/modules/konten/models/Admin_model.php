<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function create($table, $data) {
		$query = $this->db->insert($table, $data);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	public function read($table) {
		$query = $this->db->get($table);
		return $query->result();
	}

	public function read_where($table, $where) {
		$query = $this->db->get_where($table, $where);
		return $query->result();
	}

	public function delete($table, $where) {
		$query = $this->db->delete($table, $where);
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	public function join($table1, $table2, $id) {
		$this->db->select('*');
		$this->db->from($table1);
		$this->db->join($table2, $id);
		$query = $this->db->get();
		return $query->result();
	}
	public function update($table, $data, $where) {
		$this->db->update($table, $data, $where);
	}
	public function get_id($table, $where) {
		$query = $this->db->get_where($table, $where);
		return $query->row();
	}
	public function validate($username, $password) {
		$query = $this->db->get_where('user', array('user_login' => $username, 'user_pass' => $password, 'user_active' => "1"));
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}
	public function count_all($table) {
		$this->db->from($table);
		return $this->db->count_all_results();
	}

	public function count_where($table, $where) {
		$query = $this->db->get_where($table, $where);
		return $query->num_rows();
	}

	// public function cek_user($data) {
	// 	$query = $this->db->get_where('s_table0', $data);
	// 	return $query;
	// }
		
}

/* End of file Admin.php */
/* Location: ./application/modules/admin/models/Admin.php */