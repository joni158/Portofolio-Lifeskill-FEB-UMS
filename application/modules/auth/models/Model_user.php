<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Model_user extends CI_Model {

		public function cek_user($data) {
			$query = $this->db->get_where('s_table0', $data);
			return $query;
		}

		public function get_id($table, $where) {
			$query = $this->db->get_where($table, $where);
			return $query->row();
		}

	}

?>
