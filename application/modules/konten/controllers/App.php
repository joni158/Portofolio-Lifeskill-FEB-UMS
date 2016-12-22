<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
				$this->load->model('admin_model', 'admin');
        $this->load->library(array('form_validation'));
    }

    private function __mahasiswa_area() {
    	if (($this->session->userdata('username')=="") && ($this->session->userdata('level')=="")) {
			redirect('auth');
		} elseif ($this->session->userdata('level') != 'mahasiswa') {
			redirect('auth');
		}
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

	public function index() {
		$this->__mahasiswa_area();
		$id = $this->session->userdata('id_user');
		$data = array('main_content' => 'dashboard',
					  'username' 	 => $this->session->userdata('username'),
					  'name' 		 => $this->admin->get_id('s_table4', array('uid_mhs' => $id))->nama_mhs,
					  );
		$this->load->view('index', $data, FALSE);
	}

	public function cek_pass_lama($pass, $level, $id_user){
        $cek_num = $this->admin->count_where('s_table0', array('id_user'=>$id_user, 'level'=>$level, 'password'=>$pass));
        if ($cek_num > 0){
            return True;
        } else {
            return False;
        }
    }

    public function profil() {
        switch ($this->uri->segment(2)) {
            case 'update':
                $page = $this->input->get('page');

                if($page == 'akun') {
                    $level = $this->session->userdata('level');
                    $id_user = $this->session->userdata('id_user');
                    $kode = $this->input->post('kode');
                    $user = $this->input->post('st_input1');
                    $pass_lama = $this->encrypt($this->input->post('st_input2'));
                    $pass_baru = $this->input->post('st_input3');
                    $ulangi_pass_baru = $this->input->post('st_input4');

                    $cek = $this->cek_pass_lama($pass_lama, $level, $id_user);
                    if ($cek == True) {
                        if (strlen($pass_baru) < 8 ){
                            $msg = "<div class='alert alert-warning'>Panjang password baru minimal 8 karakter !</div>";
                        } else { 
                            if ($pass_baru != $ulangi_pass_baru) {
                                $msg = "<div class='alert alert-warning'>Konfirmasi password tidak cocok !</div>";
                            } else {
                                $data = array(
                                    'username' => $user,
                                    'password' => $this->encrypt($pass_baru)
                                );

                                if ($level == 'superadmin') {
                                    $this->admin->update('s_table0', $data, array('uid' => $kode));
                                } else {
                                    $this->admin->update('s_table4', $data, array('uid_mhs' => $id_user ));
                                }

                                $msg = "<div class='alert alert-success'>Selamat akun anda berhasil di update !</div>";
                            }
                        }
                    } else {
                        $msg = "<div class='alert alert-danger'>Password lama salah, silahkan coba lagi !</div>";
                    }
                } else {
                    $kode = $this->input->post('kode');
                    $data = array(
                        'nim' => $this->input->post('nim'),
                        'nama_mhs' => $this->input->post('nama_mhs'),
                        'email' => $this->input->post('email'),
                        'no_hp' => $this->input->post('no_hp'),
                        'tempat_lahir' => $this->input->post('tempat_lahir'),
                        'tgl_lahir' => $this->input->post('tgl_lahir'),
                    );
                    $this->admin->update('s_table4', $data, array('uid_mhs' => $kode));
                    $msg = "<div class='alert alert-success'>Selamat profil anda berhasil di update !</div>";
                }
                
                echo json_encode(array("status" => TRUE, 'msg'=>$msg));
                break;
            case 'me':
                $id_user = $this->session->userdata('id_user');
                $data['getdata'] = $this->admin->get_id('s_table4', array('uid_mhs'=>$id_user));
                $data['main_content'] = 'profil';
                $this->load->view('index', $data, FALSE);
                break;
            default:
                $id_user = $this->session->userdata('id_user');
                $data['getdata'] = $this->admin->get_id('s_table4', array('uid_mhs'=>$id_user));
                $data['main_content'] = 'profil';
                $this->load->view('index', $data, FALSE);
                break;
        }
    }

	public function kegiatan() {
		switch ($this->uri->segment(2)) {
		case 'get':
			$id_user = $this->session->userdata('id_user');
			$semester = $this->get_current_semester();

			$query = $this->db->query("
				SELECT nilai.*, rubrik.poin, rubrik.bukti, rubrik.softskill
				FROM s_table8 AS nilai LEFT JOIN s_table7 AS kelasajar ON nilai.id_kelasajar = kelasajar.uid_kelasajar
				LEFT JOIN s_table6 AS rubrik ON nilai.id_rubrik = rubrik.uid_rubrik
				WHERE kelasajar.id_mhs = " .$id_user. " AND kelasajar.semester = '$semester'
			")->result();
			$data = array();
			$no = 1;
			foreach ($query as $key => $value) {
				$row = array();
				$row[] = $no;
				$row[] = $value->keterangan;
				$row[] = $value->poin;
				$row[] = $value->softskill;
				$row[] = $value->bukti;

				if ($value->status == 1){
					$check = "<div style='color:green; text-align:center; font-size:16px;'><i class='fa fa-check-circle'></i></div>";
				}else{
					$check = "<div style='color:#d43f3a; text-align:center; font-size:16px;'><i class='fa fa-times-circle'></i></div>	";
				}

				$row[] = $check;

				$row[] = '<center>
                    <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="hapus(' . "'" . base_url('kegiatan/delete?id=') . $value->uid_nilai . "'" . ')"><i class="fa fa-trash"></i></a>
	                </center>';
				$data[] = $row;
				$no++;
			}
			$output = array(
				"data" => $data,
			);
			echo json_encode($output);
			break;
		case 'get-tingkatan':
			$uid_kategori = $this->input->post('uid_kategori');
            $getdata = $this->admin->get_id('s_table6', array('uid_rubrik'=>$uid_kategori));
            if ($getdata->child == 1) {
            	$query = $this->admin->read_where('s_table6', array('parent'=>$uid_kategori));
	            echo "<option value=''>-- Pilih Tingkatan --</option>";
	            foreach ($query as $key => $value) {
	                echo "<option value='" .$value->uid_rubrik. "'>" .$value->kegiatan. "</option>";
	            }
            } else {
	            echo "<option value=''>-- Tingkatan Kosong --</option>";
            }
            break;
        case 'get-posisi':
			$uid_tingkatan = $this->input->post('uid_tingkatan');
            $getdata = $this->admin->get_id('s_table6', array('uid_rubrik'=>$uid_tingkatan));
            if ($getdata->child == 1) {
            	$query = $this->admin->read_where('s_table6', array('parent'=>$uid_tingkatan));
	            echo "<option value=''>-- Pilih Posisi --</option>";
	            foreach ($query as $key => $value) {
	                echo "<option value='" .$value->uid_rubrik. "'>" .$value->kegiatan. "</option>";
	            }
            } else {
	            echo "<option value=''>-- Posisi Kosong --</option>";
            }
            break;
		case 'add':
			$id = $this->session->userdata('id_user');
			$data = array(
					'main_content' => 'kegiatan-add',
					'username' 	 => $this->session->userdata('username'),
					'daftarkategori' => $this->admin->read_where('s_table6', array('level'=>1)),
			    );
			$this->load->view('index', $data, FALSE);
			break;
		case 'delete':
			$id = $this->input->get('id');
			$this->admin->delete('s_table8', array('uid_nilai' => $id));
			echo json_encode(array("status" => TRUE));
			break;
		/*case 'edit':
			$id = $this->input->get('id');
			$id_us = $this->session->userdata('id_user');
			$data = array(
				'main_content' => 'kegiatan-edit',
				'getdata' => $this->admin->get_id('s_table8', array('uid_nilai' => $id)),
			);
			$this->load->view('index', $data, FALSE);
			break;*/
		case 'save':
			$act = $this->input->get('act');

			if ($act == "save") {
				$kategori = $this->input->post('st_input1');
	        	$tingkatan = $this->input->post('st_input2');
	        	$posisi = $this->input->post('st_input3');

	        	if ($posisi == ''){
	        		if ($tingkatan == ''){
	        			$uid_rubrik = $kategori;
	        		}else{
	        			$uid_rubrik = $tingkatan;
	        		}
	        	}else{
	        		$uid_rubrik = $posisi;
	        	}

	        	$uid_kelasajar = $this->session->userdata('uid_kelasajar');
				$data = array(
					'id_kelasajar' => $uid_kelasajar,
					'id_rubrik' 	=> $uid_rubrik,
					'keterangan' => $this->input->post('st_input4'),
				);
				$this->db->set('tanggal', 'NOW()', FALSE);
				$this->admin->create('s_table8', $data);
			}
			echo json_encode(array("status" => TRUE));
			break;
		case 'pdf':
			$id_mhs = $this->session->userdata('id_user');
			$mahasiswa = $this->db->query("SELECT * FROM s_table11 LEFT JOIN s_table2 ON s_table11.id_jurusan = s_table2.uid
				WHERE s_table11.uid = " . $id_mhs . "")->row();

			if ($this->input->get('s') == 'all'){
				$kegiatan = $this->db->query("SELECT * FROM s_table7 LEFT JOIN s_table6 ON s_table7.id_kegiatan = s_table6.uid
				WHERE s_table7.id_mahasiswa = " .$id_mhs. "")->result();
			} else{
				$kegiatan = $this->db->query("SELECT * FROM s_table7 LEFT JOIN s_table6 ON s_table7.id_kegiatan = s_table6.uid
				WHERE s_table7.status = 'Verified' AND s_table7.id_mahasiswa = " .$id_mhs. "")->result();
			}
			

			$total = $this->admin->get_id('s_table11', array('uid' => $id_mhs))->nilai;
			$angkatan = $this->admin->get_id('s_table11', array('uid' => $id_mhs))->angkatan;

			if ( ($angkatan <= 2011 && $total >= 100 && $total <= 150) || ($angkatan == 2012 && $total >= 151 && $total <= 200) || ($angkatan >= 2013 && $total >= 200 && $total <= 250) ) {
				$nilaikonversi = "C";
			} elseif ( ($angkatan <= 2011 && $total >= 151 && $total <= 200) || ($angkatan == 2012 && $total >= 201 && $total <= 250) || ($angkatan >= 2013 && $total >= 251 && $total <= 300) ) {
				$nilaikonversi = "BC";
			} elseif ( ($angkatan <= 2011 && $total >= 201 && $total <= 250) || ($angkatan == 2012 && $total >= 251 && $total <= 300) || ($angkatan >= 2013 && $total >= 301 && $total <= 350) ) {
				$nilaikonversi = "B";
			} elseif ( ($angkatan <= 2011 && $total >= 251 && $total <= 300) || ($angkatan == 2012 && $total >= 301 && $total <= 350) || ($angkatan >= 2013 && $total >= 351 && $total <= 400) ) {
				$nilaikonversi = "AB";
			} elseif ( ($angkatan <= 2011 && $total > 300) || ($angkatan == 2012 && $total > 350) || ($angkatan >= 2013 && $total > 400) ) {
				$nilaikonversi = "A";
			} else {
				$nilaikonversi = "D";
			}

			$id_dosen = $this->admin->get_id('s_table11', array('uid' => $id_mhs))->id_dosen;
			$pengampu = $this->admin->get_id('s_table10', array('uid' => $id_dosen));
			$id_dekan = $pengampu->id_dekan;
			$dekan = $this->admin->get_id('s_table9', array('uid' => $id_dekan));
			$data = array(
				'jumlah' 	=> $total,
				'mahasiswa' => $mahasiswa,
				'kegiatan' => $kegiatan,
				'nilaikonversi'	=> $nilaikonversi,
				'pengampu'	=> $pengampu,
				'dekan'	=> $dekan,
			);
			$html = $this->load->view('laporan-pdf', $data, true);
			$pdfFilePath = "report-" .$mahasiswa->nim. ".pdf";
			$stylesheet = file_get_contents(base_url() . "assets/css/bootstrap.min.css");
			$style = '
					@page { margin-top: 0cm; }
					';
			// $this->m_pdf->pdf->AddPage('L');
			$this->m_pdf->pdf->WriteHTML($stylesheet, 1);
			$this->m_pdf->pdf->WriteHTML($html);
			$this->m_pdf->pdf->Output($pdfFilePath, "I");
			echo json_encode(array("status" => TRUE));
			break;
		default:
			$id_us = $this->session->userdata('id_user');
			$data = array(
					'main_content'  => 'kegiatan',
			    );
			$this->load->view('index', $data, FALSE);
			break;
		}
	}

}
