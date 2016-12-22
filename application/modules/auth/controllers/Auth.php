<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function index() {
	    $this->load->library('form_validation');
	    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	    $data['username'] = array('name' => 'username',
			'id'    => 'username',
			'type'  => 'text',
			'class' => 'form-control',
			'placeholder' => 'Username',
			'value' => $this->form_validation->set_value('username'),
	    );
	    $data['password'] = array('name' => 'password',
			'id'   => 'password',
			'type' => 'password',
			'class' => 'form-control',
			'placeholder' => 'Password',
	    );
		$this->load->view('login', $data);
	}

	public function get_current_semester() {
        $query = $this->db->query("SELECT semester FROM s_table7 GROUP BY semester");
        if ($query->num_rows > 0) {
            $current_semester = 0;
            foreach ($query->result() as $key => $value) {
                if ((int)$value->semester > $current_semester) {
                    $current_semester = $value->semester;
                }
            }
        } else {
            $current_semester = date('Y'). '1';
        }
        return (String)$current_semester;
    }

	public function cek_login() {
		$data = array('username' => $this->input->post('username', TRUE),
						'password' => $this->encrypt($this->input->post('password', TRUE))
			);
		$this->load->model('model_user'); // load model_user
		$hasil = $this->model_user->cek_user($data);
		if ($hasil->num_rows() > 0) {
			foreach ($hasil->result() as $sess) {
				$sess_data['logged_in'] = 'Sudah Loggin';
				$sess_data['username'] = $sess->username;
				$sess_data['password'] = $sess->password;
				$sess_data['level'] = $sess->level;
				$sess_data['id_user'] = $sess->id_user;

				if ($sess->level == 'mahasiswa') {
					$semester = $this->get_current_semester();
					$id_user = $sess->id_user;
					$getdata = $this->model_user->get_id('s_table7', array('id_mhs'=>$id_user, 'semester'=>$semester));
					$sess_data['uid_kelasajar'] = $getdata->uid_kelasajar;
				}

				$this->session->set_userdata($sess_data);
			}



			if ($this->session->userdata('level')!='' || $this->session->userdata('username')!='') {
				if ($this->session->userdata('level') == 'mahasiswa') {
					redirect('/');
				} else {
					redirect('admin');
				}
			} else{
				redirect('auth');
			}
		}
		else {
			$data['msg'] = "PASSWORD ATAU USERNAME SALAH ";
			$this->load->view('login', $data);
		}
	}

  public function logout() {
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('password');
		$this->session->unset_userdata('level');
		$this->session->unset_userdata('id_user');
		session_destroy();
		redirect('auth');
	}

}

?>
