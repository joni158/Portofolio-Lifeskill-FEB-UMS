<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends MY_Controller {

	public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
		$this->load->model('admin_model', 'admin');
        $this->load->library(array('form_validation'));
		$this->load->library('excel');

		if (($this->session->userdata('username')=="") && ($this->session->userdata('level')=="")) {
			redirect('auth');
		} 
        if ($this->session->userdata('level') == 'mahasiswa') {
            redirect('auth');
        }
    }

    public function index() {
        $level = $this->session->userdata('level');
        $id_user = $this->session->userdata('id_user');
        $semester = $this->get_current_semester();

        if ($level == 'superadmin') {
            $mahasiswa = $this->db->query("SELECT COUNT(uid_kelasajar) AS num_mhs FROM s_table7 WHERE semester = '$semester'")->row();
            $dosen = $this->db->query("SELECT COUNT(DISTINCT id_dosen) AS num_dosen FROM 
                s_table7 WHERE semester = '$semester'")->row();
            $count_dosen = $dosen->num_dosen;
            $bimbingan = $this->db->query("SELECT COUNT(DISTINCT id_kelas) AS num_bimbingan FROM s_table7 WHERE semester = '$semester' GROUP BY id_jurusan")->result();
            $count_bimbingan = 0;
            foreach ($bimbingan as $key => $value) {
                $count_bimbingan += $value->num_bimbingan;
            }
        } elseif ($level == 'kaprodi') {
            $id_jurusan = $this->get_id_jurusan($id_user);
            $mahasiswa = $this->db->query("
                SELECT COUNT(uid_kelasajar) AS num_mhs FROM s_table7 
                WHERE semester = '$semester' AND id_jurusan = '$id_jurusan'")->row();
            $dosen = $this->db->query("SELECT COUNT(DISTINCT id_dosen) AS num_dosen FROM 
                s_table7 WHERE semester = '$semester' AND id_jurusan = '$id_jurusan'")->row();
            $count_dosen = $dosen->num_dosen;
            $bimbingan = $this->db->query("SELECT COUNT(DISTINCT(id_kelas)) AS num_bimbingan FROM s_table7 WHERE id_jurusan = '$id_jurusan'")->row();
            $count_bimbingan = $bimbingan->num_bimbingan;
        } else {
            $mahasiswa = $this->db->query("SELECT COUNT(uid_kelasajar) AS num_mhs FROM s_table7 WHERE semester = '$semester' AND id_dosen = " .$id_user. "")->row();
            $count_bimbingan = 0;
            $count_dosen = 0;
        }

        $rubrik = $this->db->query("SELECT COUNT(uid_rubrik) AS num_rubrik FROM s_table6 WHERE child = 0")->row();

		$data = array('main_content' => 'dashboard',
					  'username' => $this->session->userdata('username'),
                      'mahasiswa' => $mahasiswa->num_mhs,
                      'dosen' => $count_dosen,
                      'bimbingan' => $count_bimbingan,
                      'rubrik' => $rubrik->num_rubrik,
					  );
		$this->load->view('index', $data, FALSE);
	}

    private function _superadmin_area(){
        if ($this->session->userdata('level')!="superadmin") {
            redirect('auth');
        }
    }
    private function _kaprodi_area(){
        if ($this->session->userdata('level')!="kaprodi") {
            redirect('auth');
        }
    }
    private function _pembimbing_area(){
        if ($this->session->userdata('level')!="pembimbing") {
            redirect('auth');
        }
    }

    public function get_id_jurusan($uid_dosen) {
        $this->_kaprodi_area();
        $query = $this->admin->get_id('s_table3', array('uid_dosen'=>$uid_dosen));
        return $query->id_jurusan;
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

    public function data_nilai() {
        $level = $this->session->userdata('level');
        $id_user = $this->session->userdata('id_user');
        switch ($this->uri->segment(3)) {
        case 'get':
            $pembimbing_filter = ''; $jurusan_filter = '';
            if ($level == 'pembimbing') {
                $semester = $this->get_current_semester();
                $pembimbing_filter = " AND kelasajar.id_dosen = " .$id_user. "";
            } elseif ($level == 'kaprodi') {
                $semester = $this->input->post("st_semester", true);
                $jurusan = $this->get_id_jurusan($id_user);
                $jurusan_filter = " AND jurusan.uid_jurusan LIKE '%$jurusan%'";
            } else {
                $semester = $this->input->post("st_semester", true);
                $jurusan = $this->input->post("st_jurusan", true);
                $jurusan_filter = " AND jurusan.uid_jurusan LIKE '%$jurusan%'";
            }

            $st_angkatan = $this->input->post("st_angkatan", true);
            $st_nim = $this->input->post("st_nim", true);

            $query = $this->db->query("
                SELECT mahasiswa.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, jurusan.nama_jurusan, SUM(IF(nilai.status = 1, rubrik.poin, 0)) AS poin, nilai.id_kelasajar
                FROM s_table8 AS nilai LEFT JOIN s_table7 AS kelasajar ON nilai.id_kelasajar = kelasajar.uid_kelasajar
                LEFT JOIN s_table4 AS mahasiswa ON kelasajar.id_mhs = mahasiswa.uid_mhs
                LEFT JOIN s_table6 AS rubrik ON nilai.id_rubrik = rubrik.uid_rubrik
                LEFT JOIN s_table2 AS jurusan ON mahasiswa.id_jurusan = jurusan.uid_jurusan
                WHERE kelasajar.semester = '$semester' AND mahasiswa.nim LIKE '%$st_nim%' AND mahasiswa.angkatan LIKE '%$st_angkatan%' " .$pembimbing_filter. "" .$jurusan_filter. "
                GROUP BY nilai.id_kelasajar
            ");

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $respon['data'][] = array(
                        $no,
                        $value->nim,
                        $value->nama_mhs,
                        $value->angkatan,
                        $value->nama_jurusan,
                        $value->poin,
                        '<center>
                            <a href="' . base_url('admin/data-nilai/detail?id=') . $value->id_kelasajar . '" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Lihat Detail" data-placement="left"><i class="fa fa-plus-circle"></i></a>
                        </center>'
                    );
                    $no++;
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            
            echo json_encode($respon);
            break;
        case 'detail':
            $id = $this->input->get('id');
            $data = array(
                'main_content' => 'datanilai-detail',
                'getdata' => $this->db->query('SELECT mahasiswa.*, jurusan.nama_jurusan, kelasajar.uid_kelasajar FROM s_table7 AS kelasajar LEFT JOIN s_table4 AS mahasiswa ON kelasajar.id_mhs = mahasiswa.uid_mhs LEFT JOIN s_table2 AS jurusan ON mahasiswa.id_jurusan = jurusan.uid_jurusan WHERE kelasajar.uid_kelasajar = ' .$id. '')->row(),
            );
            $this->load->view('index', $data, FALSE);
            break;
        case 'verification':
            $num = $this->input->get('num');
            $action = $this->input->get('action');
            $id = $this->input->get('id');

            if ($num == 'one') {
                if ($action == 'verify') {
                    $data['status'] = 1;
                    $this->admin->update('s_table8', $data, array('uid_nilai'=>$id));
                } else {
                    $data['status'] = 0;
                    $this->admin->update('s_table8', $data, array('uid_nilai'=>$id));
                }

                echo json_encode(array('action'=>$action));
            }

            break;
        case 'get-kegiatan':
            $uid_kelasajar = $this->input->post("uid_kelasajar", true);

            $query = $this->db->query("
                SELECT nilai.uid_nilai, nilai.keterangan, rubrik.poin, rubrik.bukti, rubrik.softskill, nilai.status
                FROM s_table8 AS nilai LEFT JOIN s_table6 AS rubrik ON nilai.id_rubrik = rubrik.uid_rubrik
                WHERE nilai.id_kelasajar = " .$uid_kelasajar. "
            ");

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $check_disabled = ''; $times_disabled = '';
                    if ($value->status == 1) {
                        $status = 'Verified';
                        $check_disabled = 'disabled';
                    } else {
                        $status = 'Unverified';
                        $times_disabled = 'disabled';
                    }

                    if ($level == 'pembimbing') {
                        $respon['data'][] = array(
                            $no,
                            $value->keterangan,
                            $value->poin,
                            $value->bukti,
                            $value->softskill,
                            $status,
                            '<center>
                                <a onclick="verification(' . "'" . base_url('admin/data-nilai/verification?num=one&action=verify&id=') . $value->uid_nilai . "'" . ')" class="btn btn-xs btn-success ' .$check_disabled. '" data-toggle="tooltip" title="Verify" data-placement="left"><i class="fa fa-check"></i></a>

                                <a onclick="verification(' . "'" . base_url('admin/data-nilai/verification?num=one&action=unverify&id=') . $value->uid_nilai . "'" . ')" class="btn btn-xs btn-danger ' .$times_disabled. '" data-toggle="tooltip" title="Unverify" data-placement="left"><i class="fa fa-times"></i></a>
                            </center>'
                        );
                        $no++;
                    } else {
                        $respon['data'][] = array(
                            $no,
                            $value->keterangan,
                            $value->poin,
                            $value->bukti,
                            $value->softskill,
                            $status,
                        );
                        $no++;
                    }
                }
            } else {
                if ($level == 'pembimbing') {
                    $respon['data'][] = array(
                        "<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>",
                    );
                } else {
                    $respon['data'][] = array(
                        "<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>",
                    );
                }
            }
            
            echo json_encode($respon);
            break;
        case 'export':
            $title = "daftarnilai";
            
            $pembimbing_filter = ''; $jurusan_filter = '';
            if ($level == 'pembimbing') {
                $semester = $this->get_current_semester();
                $pembimbing_filter = " AND kelasajar.id_dosen = " .$id_user. "";
            } elseif ($level == 'kaprodi') {
                $semester = $this->input->post("st_semester", true);
                $jurusan = $this->get_id_jurusan($id_user);
                $jurusan_filter = " AND jurusan.uid_jurusan LIKE '%$jurusan%'";
            } else {
                $semester = $this->input->post("st_semester", true);
                $jurusan = $this->input->post("st_jurusan", true);
                $jurusan_filter = " AND jurusan.uid_jurusan LIKE '%$jurusan%'";
            }

            $st_angkatan = $this->input->post("st_angkatan", true);
            $st_nim = $this->input->post("st_nim", true);

            $query = $this->db->query("
                SELECT mahasiswa.nim, mahasiswa.nama_mhs, mahasiswa.angkatan, jurusan.nama_jurusan, SUM(rubrik.poin) AS poin
                FROM s_table8 AS nilai LEFT JOIN s_table7 AS kelasajar ON nilai.id_kelasajar = kelasajar.uid_kelasajar
                LEFT JOIN s_table4 AS mahasiswa ON kelasajar.id_mhs = mahasiswa.uid_mhs
                LEFT JOIN s_table6 AS rubrik ON nilai.id_rubrik = rubrik.uid_rubrik
                LEFT JOIN s_table2 AS jurusan ON mahasiswa.id_jurusan = jurusan.uid_jurusan
                WHERE kelasajar.semester = '$semester' AND mahasiswa.nim LIKE '%$st_nim%' AND mahasiswa.angkatan LIKE '%$st_angkatan%' " .$pembimbing_filter. "" .$jurusan_filter. "
                GROUP BY nilai.id_kelasajar
            ");
            $data = $query->result();

            $this->excel->export($title, $data);
            break;
        case 'pdf':
            $uid_kelasajar = $this->input->get('id');

            $getdata = $this->db->query("SELECT * FROM s_table7 AS kelasajar LEFT JOIN s_table4 AS mahasiswa ON kelasajar.id_mhs = mahasiswa.uid_mhs LEFT JOIN s_table2 AS jurusan ON kelasajar.id_jurusan = jurusan.uid_jurusan LEFT JOIN s_table3 AS dosen ON kelasajar.id_dosen = dosen.uid_dosen WHERE kelasajar.uid_kelasajar = " .$uid_kelasajar. "")->row();

            $getkaprodi = $this->db->query("SELECT nidn, nama_dosen FROM s_table3 AS dosen WHERE level = 'kaprodi' AND id_jurusan = '$getdata->id_jurusan'")->row();

            $getsum = $this->db->query("
                SELECT SUM(IF(nilai.status = 1, rubrik.poin, 0)) AS numpoin
                FROM s_table8 AS nilai LEFT JOIN s_table6 AS rubrik ON nilai.id_rubrik = rubrik.uid_rubrik
                WHERE nilai.id_kelasajar = " .$uid_kelasajar. "
                GROUP BY nilai.id_kelasajar
            ")->row();

            $total = $getsum->numpoin;
            $angkatan = $getdata->angkatan;

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

            $query = $this->db->query("
                SELECT nilai.uid_nilai, nilai.keterangan, rubrik.poin, rubrik.bukti, rubrik.softskill, nilai.status
                FROM s_table8 AS nilai LEFT JOIN s_table6 AS rubrik ON nilai.id_rubrik = rubrik.uid_rubrik
                WHERE nilai.status = 1 AND nilai.id_kelasajar = " .$uid_kelasajar. "
            ")->result();

            
            $data = array(
                'getdata' => $getdata,
                'getkaprodi' => $getkaprodi,
                'kegiatan' => $query,
                'total' => $total,
                'nilaikonversi' => $nilaikonversi
            );
            $this->load->view('datanilai-pdf', $data);
            
            $html = $this->output->get_output();
            $this->load->library('dompdf_gen');

            $this->dompdf->load_html($html);
            $this->dompdf->render();

            $this->dompdf->stream("report-" .$getdata->nim. "-" .date('Ymd'). ".pdf",array('Attachment'=>0));

            break;
        default:
            $data = array(
                'main_content' => 'datanilai',
                'daftarjurusan' => $this->admin->read('s_table2'),
                'current_semester' => $this->get_current_semester(),
                'semester_lists' => $this->db->query("SELECT semester FROM s_table7 GROUP BY semester")->result(),
            );
            $this->load->view('index', $data, FALSE);
            break;
        }
    }

    public function kaprodi() {
        switch ($this->uri->segment(3)) {
        case 'get':
            $query = $this->db->query("SELECT * FROM s_table3 LEFT JOIN s_table2 ON s_table3.id_jurusan = s_table2.uid_jurusan WHERE level = 'kaprodi' ORDER BY s_table2.nama_jurusan ASC");

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $respon['data'][] = array(
                        $no,
                        $value->nidn,
                        $value->nama_dosen,
                        $value->nama_jurusan,
                        '<center>
                            <a href="' . base_url('admin/data-dosen/edit?id=') . $value->uid_dosen . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                        </center>'
                    );
                    $no++;
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            
            echo json_encode($respon);
            break;
        default:
            $data = array(
                'main_content' => 'kaprodi',
            );
            $this->load->view('index', $data, FALSE);
            break;
        }
    }

    public function data_bimbingan() {
        $level = $this->session->userdata('level');
        $id_user = $this->session->userdata('id_user');
        switch ($this->uri->segment(3)) {
        case 'get':
            $st_semester = $this->input->post("st_semester", true);

            if ($level == 'kaprodi') {
                $st_jurusan = $this->get_id_jurusan($id_user);
            } else {
                $st_jurusan = $this->input->post("st_jurusan", true);
            }

            $query = $this->db->query("
                SELECT bimbingan.uid_kelasajar, kelas.nama_kelas, pembimbing.nama_dosen, COUNT(bimbingan.id_mhs) AS jumlah_mahasiswa, bimbingan.semester, jurusan.nama_jurusan, bimbingan.id_dosen
                FROM s_table7 AS bimbingan LEFT JOIN s_table5 AS kelas ON bimbingan.id_kelas = kelas.uid_kelas
                LEFT JOIN s_table3 AS pembimbing ON bimbingan.id_dosen = pembimbing.uid_dosen
                LEFT JOIN s_table4 AS mahasiswa ON bimbingan.id_mhs = mahasiswa.uid_mhs
                LEFT JOIN s_table2 AS jurusan ON bimbingan.id_jurusan = jurusan.uid_jurusan
                WHERE bimbingan.semester = '$st_semester' AND bimbingan.id_jurusan LIKE '%$st_jurusan%'
                GROUP BY bimbingan.id_dosen
            ");

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $smt = substr($value->semester, 4, strlen($value->semester));
                    $smt_val = ($smt == '1') ? 'Gasal' : 'Genap';
                    $respon['data'][] = array(
                        $no,
                        $value->nama_kelas,
                        $value->nama_dosen,
                        '<a href="' . base_url('admin/data-bimbingan/edit?id=') . $value->id_dosen . '">' .$value->jumlah_mahasiswa. '</a>',
                        $value->nama_jurusan,
                        substr($value->semester, 0, 4),
                        $smt_val,
                        '<center>
                            <a href="' . base_url('admin/data-bimbingan/edit?id=') . $value->id_dosen . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus" data-placement="left" onclick="hapus(' . "'" . base_url('admin/data-bimbingan/delete?id=') . $value->id_dosen . "'" . ')"><i class="fa fa-trash"></i></a>
                        </center>'
                    );
                    $no++;
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            
            echo json_encode($respon);
            break;
        case 'get-dosen':
            $uid_jurusan = $this->input->post('uid_jurusan');
            $query = $this->admin->read_where('s_table3', array('id_jurusan'=>$uid_jurusan, 'level'=>'pembimbing'));
                echo "<option disabled=''>-- Pilih Pembimbing --</option>";
            foreach ($query as $key => $value) {
                echo "<option value='" .$value->uid_dosen. "'>" .$value->nama_dosen. "</option>";
            }
            break;
        case 'get-mahasiswa':
            $page = $this->input->post('page');
            if ($page == 'addmahasiswa') {
                $st_jurusan = $this->input->post("st_jurusan", true);
                $query = $this->db->query("SELECT s_table4.*, s_table2.nama_jurusan FROM s_table4 LEFT JOIN s_table2 ON s_table4.id_jurusan = s_table2.uid_jurusan WHERE s_table4.id_jurusan LIKE '%$st_jurusan%' AND aktif = 'Aktif' ORDER BY s_table4.angkatan DESC, s_table4.nim ASC");
            } else {
                $st_dosen = $this->input->post("st_dosen", true);
                $semester = $this->get_current_semester();
                $query = $this->db->query("
                    SELECT mahasiswa.*, jurusan.nama_jurusan
                    FROM s_table7 AS bimbingan LEFT JOIN s_table4 AS mahasiswa ON bimbingan.id_mhs = mahasiswa.uid_mhs
                    LEFT JOIN s_table2 AS jurusan ON bimbingan.id_jurusan = jurusan.uid_jurusan
                    WHERE bimbingan.id_dosen = " .$st_dosen. " AND bimbingan.semester = '$semester' ORDER BY mahasiswa.angkatan DESC, mahasiswa.nim ASC
                ");
            }

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    if ($page == 'addmahasiswa') {
                        $respon['data'][] = array(
                            '<input type="checkbox" name="id_mahasiswa[]" value="'.$value->uid_mhs.'">',
                            $no,
                            $value->nim,
                            $value->username,
                            $value->nama_mhs,
                            $value->angkatan,
                            $value->nama_jurusan,
                            $value->aktif,
                        );
                        $no++;
                    } else {
                        $respon['data'][] = array(
                            '<input type="checkbox" name="id_mahasiswa[]" value="'.$value->uid_mhs.'" checked>',
                            $no,
                            $value->nim,
                            $value->username,
                            $value->nama_mhs,
                            $value->angkatan,
                            $value->nama_jurusan,
                            $value->aktif,
                        );
                        $no++;
                    }
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            echo json_encode($respon);
            break;
        case 'add':
            $step = $this->input->get('st');
            if ($step == 'bimbingan') {
                $data = array(
                    'main_content' => 'daftarbimbingan-addbimbingan',
                    'daftarkelas' => $this->admin->read('s_table5'),
                    'current_semester' => $this->get_current_semester(),
                );
                if ($level == 'superadmin') {
                    $data['daftarjurusan'] = $this->admin->read('s_table2');
                } else {
                    $jurusan = $this->get_id_jurusan($id_user);
                    $data['daftarjurusan'] = $this->admin->read_where('s_table2', array('uid_jurusan'=>$jurusan));
                }
            } elseif ($step == 'mahasiswa') {
                $data = array(
                    'main_content' => 'daftarbimbingan-addmahasiswa',
                );
            } elseif ($step == 'tambahkan') {
                $data = array(
                    'main_content' => 'daftarbimbingan-addtambahkan',
                );
            } else {
                $data = array(
                    'main_content' => 'daftarbimbingan-addselesai',
                );
            }
            
            $this->load->view('index', $data, FALSE);
            break;
        case 'delete':
            $id = $this->input->get('id');
            $this->admin->delete('s_table7', array('id_dosen' => $id));
            echo json_encode(array("status" => TRUE));
            break;
        case 'edit':
            $id = $this->input->get('id');
            $query = $this->admin->get_id('s_table7', array('id_dosen'=>$id, 'semester'=>$this->get_current_semester()));
            
            $data = array(
                'main_content' => 'daftarbimbingan-editmahasiswa',
                'uid_dosen' => $id,
                'bimbingan_id_kelas' => $query->id_kelas,
                'bimbingan_id_jurusan' => $query->id_jurusan,
                'bimbingan_id_dosen' => $id,
                'bimbingan_semester' => $query->semester
            );
            $this->load->view('index', $data, FALSE);
            break;
        case 'save':
            $act = $this->input->get('act');

            if ($act == "save") {
                $step = $this->input->get('st');
                if ($step == 'bimbingan') {
                    $second_bimbingan['bimbingan_id_kelas'] = $this->input->post('st_kelas');
                    $second_bimbingan['bimbingan_id_jurusan'] = $this->input->post('st_jurusan');
                    $second_bimbingan['bimbingan_id_dosen'] = $this->input->post('st_pembimbing');
                    $second_bimbingan['bimbingan_semester'] = $this->input->post('st_semester');
                    $this->session->set_userdata($second_bimbingan);
                    redirect('admin/data-bimbingan/add?st=mahasiswa');
                } elseif ($step == 'mahasiswa') {                    
                    $data['id_kelas'] = $this->input->post('id_kelas');
                    $data['id_jurusan'] = $this->input->post('id_jurusan');
                    $data['id_dosen'] = $this->input->post('id_dosen');
                    $data['semester'] = $this->input->post('semester');

                    $id_mahasiswa = $this->input->post('id_mahasiswa');

                    for ($i = 0; $i < count($id_mahasiswa); $i++) {
                        $data['id_mhs'] = $id_mahasiswa[$i];
                        $this->admin->create('s_table7', $data);
                    }
                    $this->session->unset_userdata('bimbingan_id_kelas');
                    $this->session->unset_userdata('bimbingan_id_jurusan');
                    $this->session->unset_userdata('bimbingan_id_dosen');
                    $this->session->unset_userdata('bimbingan_semester');
                    redirect('admin/data-bimbingan/add?st=selesai');
                } elseif ($step == 'tambahkan') {
                    $data['id_kelas'] = $this->input->post('id_kelas');
                    $data['id_jurusan'] = $this->input->post('id_jurusan');
                    $data['id_dosen'] = $this->input->post('id_dosen');
                    $data['semester'] = $this->input->post('semester');

                    $id_mahasiswa = $this->input->post('id_mahasiswa');

                    for ($i = 0; $i < count($id_mahasiswa); $i++) {
                        $data['id_mhs'] = $id_mahasiswa[$i];
                        $this->admin->create('s_table7', $data);
                    }
                    echo "<script>window.close();</script>";
                }
                
            } else {
                $step = $this->input->get('st');
                if ($step == 'mahasiswa') {
                    $id_dosen = $this->input->post('id_dosen');
                    $semester = $this->input->post('semester');

                    $data['id_kelas'] = $this->input->post('id_kelas');
                    $data['id_jurusan'] = $this->input->post('id_jurusan');
                    $data['id_dosen'] = $id_dosen;
                    $data['semester'] = $semester;

                    $id_mahasiswa = $this->input->post('id_mahasiswa');

                    $getOldBimbingan = $this->admin->read_where('s_table7', array('id_dosen'=>$id_dosen, 'semester'=>$semester));
                    foreach ($getOldBimbingan as $key => $value) {
                        if (!in_array($value->id_mhs, $id_mahasiswa)) {
                            $this->admin->delete('s_table7', array('id_mhs' => $value->id_mhs, 'semester'=>$semester));
                        }
                    }
                    redirect('admin/data-bimbingan/add?st=selesai');

                }

            }
            echo json_encode(array("status" => TRUE));
            break;
        case 'export':
            $title = "daftarbimbingan";
            
            $st_semester = $this->input->post("st_semester", true);

            if ($level == 'kaprodi') {
                $st_jurusan = $this->get_id_jurusan($id_user);
            } else {
                $st_jurusan = $this->input->post("st_jurusan", true);
            }

            $query = $this->db->query("
                SELECT kelas.nama_kelas, pembimbing.nama_dosen, COUNT(bimbingan.id_mhs) AS jumlah_mahasiswa, bimbingan.semester, jurusan.nama_jurusan
                FROM s_table7 AS bimbingan LEFT JOIN s_table5 AS kelas ON bimbingan.id_kelas = kelas.uid_kelas
                LEFT JOIN s_table3 AS pembimbing ON bimbingan.id_dosen = pembimbing.uid_dosen
                LEFT JOIN s_table4 AS mahasiswa ON bimbingan.id_mhs = mahasiswa.uid_mhs
                LEFT JOIN s_table2 AS jurusan ON bimbingan.id_jurusan = jurusan.uid_jurusan
                WHERE bimbingan.semester = '$st_semester' AND bimbingan.id_jurusan LIKE '%$st_jurusan%'
                GROUP BY bimbingan.id_dosen
            ");
            $data = $query->result();

            $this->excel->export($title, $data);
            break;
        default:
            $data = array(
                'main_content' => 'daftarbimbingan',
                'current_semester' => $this->get_current_semester(),
                'semester_lists' => $this->db->query("SELECT semester FROM s_table7 GROUP BY semester")->result(),
                'daftarjurusan' => $this->admin->read('s_table2'),
            );
            $this->load->view('index', $data, FALSE);
            break;
        }
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
        switch ($this->uri->segment(3)) {
            case 'get':
                $st_level = $this->input->post("st_level", true);
                $st_username = $this->input->post("st_username", true);

                $query = $this->db->query("SELECT * FROM s_table0 WHERE level LIKE '%$st_level%' AND username LIKE '%$st_username%' ORDER BY level ASC, username ASC");

                $count_query = $query->num_rows();
                $getdata = $query->result();
                
                if ($count_query > 0) {
                    $no = 1;
                    foreach ($getdata as $key => $value) {
                        $respon['data'][] = array(
                            $no,
                            $value->username,
                            $value->password,
                            $value->level,
                        );
                        $no++;
                    }
                } else {
                    $respon['data'][] = array(
                        "<span style='color:#ccc;'>Tidak ada Data</span>",
                        "<span style='color:#ccc;'>Tidak ada Data</span>",
                        "<span style='color:#ccc;'>Tidak ada Data</span>",
                        "<span style='color:#ccc;'>Tidak ada Data</span>",
                    );
                }
                
                echo json_encode($respon);
                break;
            case 'all':
                $this->_superadmin_area();
                $data['main_content'] = 'profil-all';
                $this->load->view('index', $data, FALSE);
                break;
            case 'delete':
                $this->_superadmin_area();
                $id = $this->input->get('id');
                $this->admin->delete('s_table0', array('uid' => $id));
                echo json_encode(array("status" => TRUE));
                break;
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
                                    $this->admin->update('s_table3', $data, array('uid_dosen' => $id_user ));
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
                        'nidn' => $this->input->post('nidn'),
                        'nama_dosen' => $this->input->post('nama_dosen'),
                        'email' => $this->input->post('email'),
                        'no_hp' => $this->input->post('no_hp'),
                    );
                    $this->admin->update('s_table3', $data, array('uid_dosen' => $kode));
                    $msg = "<div class='alert alert-success'>Selamat profil anda berhasil di update !</div>";
                }
                
                echo json_encode(array("status" => TRUE, 'msg'=>$msg));
                break;
            case 'me':
                $id_user = $this->session->userdata('id_user');
                $data['getdata'] = $this->admin->get_id('s_table3', array('uid_dosen'=>$id_user));
                $data['main_content'] = 'profil';
                $this->load->view('index', $data, FALSE);
                break;
            default:
                $level = $this->session->userdata('level');
                if ($level == 'superadmin') {
                    $data['getdata'] = $this->admin->get_id('s_table0', array('uid' => 1));
                } else {
                    $id_user = $this->session->userdata('id_user');
                    $data['getdata'] = $this->admin->get_id('s_table3', array('uid_dosen'=>$id_user));
                }
                $data['main_content'] = 'profil';
                $this->load->view('index', $data, FALSE);
                break;
        }
    }

    public function data_mahasiswa() {
        $level = $this->session->userdata('level');
        $id_user = $this->session->userdata('id_user');
        switch ($this->uri->segment(3)) {
        case 'get':
            if ($level == 'superadmin') {
                $st_jurusan = $this->input->post("st_jurusan", true);
            } else {
                $st_jurusan = $this->get_id_jurusan($id_user);
            }

            $st_angkatan = $this->input->post("st_angkatan", true);
            $st_nim = $this->input->post("st_nim", true);

            $query = $this->db->query("SELECT s_table4.*, s_table2.nama_jurusan FROM s_table4 LEFT JOIN s_table2 ON s_table4.id_jurusan = s_table2.uid_jurusan WHERE s_table4.id_jurusan LIKE '%$st_jurusan%' AND s_table4.angkatan LIKE '%$st_angkatan%' AND s_table4.nim LIKE '%$st_nim%' ORDER BY s_table4.angkatan DESC, s_table4.nim ASC");

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $respon['data'][] = array(
                        $no,
                        $value->nim,
                        $value->username,
                        $value->nama_mhs,
                        $value->angkatan,
                        $value->nama_jurusan,
                        $value->aktif,
                        '<center>
                            <a href="' . base_url('admin/data-mahasiswa/detail?id=') . $value->uid_mhs . '" class="btn btn-xs btn-success" data-toggle="tooltip" title="Detail" data-placement="left"><i class="fa fa-eye"></i></a>
                            <a href="' . base_url('admin/data-mahasiswa/edit?id=') . $value->uid_mhs . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void()" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus" data-placement="left" onclick="hapus(' . "'" . base_url('admin/data-mahasiswa/delete?id=') . $value->uid_mhs . "'" . ')"><i class="fa fa-trash"></i></a>
                        </center>'
                    );
                    $no++;
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            
            echo json_encode($respon);
            break;
        case 'add':
            $data['main_content'] = 'daftarmahasiswa-add';
            if ($level == 'superadmin') {
                $data['daftarjurusan'] = $this->admin->read('s_table2');
            } else {
                $jurusan = $this->get_id_jurusan($id_user);
                $data['daftarjurusan'] = $this->admin->read_where('s_table2', array('uid_jurusan'=>$jurusan));
            }
            $this->load->view('index', $data, FALSE);
            break;
        case 'delete':
            $id = $this->input->get('id');

            $image = $this->db->query("SELECT img FROM s_table4 WHERE uid_mhs = " .$id. "")->row();
            if ($image) {
                if ($image->img != '' || $image->img != null) {
                    if (file_exists('uploads/' . $image->img)) {
                        unlink('uploads/' . $image->img);
                    }
                }
            }

            $this->admin->delete('s_table4', array('uid_mhs' => $id));
            echo json_encode(array("status" => TRUE));
            break;
        case 'edit':
            $id = $this->input->get('id');
            $data = array(
                'main_content' => 'daftarmahasiswa-edit',
                'mahasiswa' => $this->admin->get_id('s_table4', array('uid_mhs' => $id)),
            );
            if ($level == 'superadmin') {
                $data['daftarjurusan'] = $this->admin->read('s_table2');
            } else {
                $jurusan = $this->get_id_jurusan($id_user);
                $data['daftarjurusan'] = $this->admin->read_where('s_table2', array('uid_jurusan'=>$jurusan));
            }
            $this->load->view('index', $data, FALSE);
            break;
        case 'detail':
            $id = $this->input->get('id');
            $data = array(
                'main_content' => 'daftarmahasiswa-detail',
                'mahasiswa' => $this->admin->join_where('s_table4', 's_table2', 's_table4.id_jurusan = s_table2.uid_jurusan', array('uid_mhs' => $id)),
            );
            $this->load->view('index', $data, FALSE);
            break;
        case 'save':
            $act = $this->input->get('act');

            $kode = $this->input->post('kode');

            $file_max_weight = 5000000; //limit the maximum size of file allowed (2Mb)
            $ok_ext = array('jpg','png','gif','jpeg'); // allow only these types of files
            $destination = 'uploads/'; // where our files will be stored
            $file = $_FILES['userfile'];
            $filename = explode(".", $file["name"]);
            $file_name = $file['name']; // file original name
            $file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
            $file_extension = $filename[count($filename)-1];
            $file_weight = $file['size'];
            $file_type = $file['type'];

            if ($file_name != '' || $file_name != null) {
                $image = $this->db->query("SELECT img FROM s_table4 WHERE uid_mhs = " .$kode. "")->row();
                if ($image) {
                    if ($image->img != '' || $image->img != null) {
                        if (file_exists('uploads/' . $image->img)) {
                            unlink('uploads/' . $image->img);
                        }
                    }
                }

                $fileNewName = md5( $file_name_no_ext[0].microtime() ).'.'.$file_extension ;
                move_uploaded_file($file['tmp_name'], $destination.$fileNewName);
            }else {
                $fileNewName = '';
            }

            $data = array(
                'nim' => strtoupper($this->input->post('st_input1')),
                'nama_mhs' => ucwords($this->input->post('st_input2')),
                'username' => $this->input->post('st_input8'),
                'email' => $this->input->post('st_input3'),
                'no_hp' => $this->input->post('st_input4'),
                'alamat' => $this->input->post('st_alamat'),
                'tempat_lahir' => $this->input->post('st_input5'),
                'tgl_lahir' => $this->input->post('st_input6'),
                'angkatan' => $this->input->post('st_input7'),
                'id_jurusan' => $this->input->post('st_input10'),
                'level' => 'mahasiswa'
            );

            if ($act == "save") {
                $data['password'] = $this->encrypt($this->input->post('st_input9'));
                $data['img'] = $fileNewName;
                $this->admin->create('s_table4', $data);
            } else {
                if ($fileNewName != '' || $fileNewName != null) {
                    $data['img'] = $fileNewName;
                }
                $this->admin->update('s_table4', $data, array('uid_mhs' => $kode ));
            }
            echo json_encode(array("status" => TRUE));
            break;
        case 'import':
            $this->import('s_table4', 'nim', 'nim,nama_mhs,email,no_hp,alamat,tempat_lahir,tgl_lahir,angkatan,id_jurusan,aktif', 'mahasiswa');
            break;
        case 'export':
            $title = "daftarmahasiswa";
            
            if ($level == 'superadmin') {
                $st_jurusan = $this->input->post("st_jurusan", true);
            } else {
                $st_jurusan = $this->get_id_jurusan($id_user);
            }

            $st_angkatan = $this->input->post("st_angkatan", true);
            $st_nim = $this->input->post("st_nim", true);

            $query = $this->db->query("SELECT s_table4.nim, s_table4.nama_mhs AS 'Nama Mahasiswa', s_table4.email, s_table4.no_hp, s_table4.alamat, s_table4.tempat_lahir, s_table4.tgl_lahir AS 'Tanggal Lahir (YYYY-mm-dd)', s_table4.angkatan, s_table2.nama_jurusan, s_table4.aktif AS 'Status' FROM s_table4 LEFT JOIN s_table2 ON s_table4.id_jurusan = s_table2.uid_jurusan WHERE s_table4.id_jurusan LIKE '%$st_jurusan%' AND s_table4.angkatan LIKE '%$st_angkatan%' AND s_table4.nim LIKE '%$st_nim%' ORDER BY s_table4.angkatan DESC, s_table4.nim ASC");
            $data = $query->result();

            $this->excel->export($title, $data);
            break;
        default:
            $data = array(
                'main_content' => 'daftarmahasiswa',
                'daftarjurusan' => $this->admin->read('s_table2'),
            );
            $this->load->view('index', $data, FALSE);
            break;
        }
    }

    public function data_dosen() {
        $id_user = $this->session->userdata('id_user');
        switch ($this->uri->segment(3)) {
        case 'get':
            $level = $this->session->userdata('level');
            $st_jurusan = $this->input->post("st_jurusan", true);
            $st_nama = $this->input->post("st_nama", true);

            if ($level == 'superadmin') {
                $st_level = $this->input->post("st_level", true);
                $query = $this->db->query("SELECT * FROM s_table3 LEFT JOIN s_table2 ON s_table3.id_jurusan = s_table2.uid_jurusan WHERE s_table3.level LIKE '%$st_level%' AND s_table3.id_jurusan LIKE '%$st_jurusan%' AND (s_table3.nidn LIKE '%$st_nama%' OR s_table3.nama_dosen LIKE '%$st_nama%') ORDER BY s_table3.level ASC, s_table3.nidn ASC");
            } else {
                $jurusan = $this->get_id_jurusan($id_user);
                $query = $this->db->query("SELECT * FROM s_table3 LEFT JOIN s_table2 ON s_table3.id_jurusan = s_table2.uid_jurusan WHERE s_table3.level <> 'kaprodi' AND s_table3.id_jurusan = '$jurusan' AND s_table3.id_jurusan LIKE '%$st_jurusan%' AND (s_table3.nidn LIKE '%$st_nama%' OR s_table3.nama_dosen LIKE '%$st_nama%') ORDER BY s_table3.level ASC, s_table3.nidn ASC");
            }

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $respon['data'][] = array(
                        $no,
                        $value->nidn,
                        $value->nama_dosen,
                        $value->username,
                        ucwords($value->level),
                        $value->nama_jurusan,
                        '<center>
                            <a href="' . base_url('admin/data-dosen/edit?id=') . $value->uid_dosen . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void()" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus" data-placement="left" onclick="hapus(' . "'" . base_url('admin/data-dosen/delete?id=') . $value->uid_dosen . "'" . ')"><i class="fa fa-trash"></i></a>
                        </center>'
                    );
                    $no++;
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            
            echo json_encode($respon);
            break;
        case 'add':
            $level = $this->session->userdata('level');
            $data['main_content'] = 'daftardosen-add';
            if ($level == 'superadmin') {
                $data['daftarjurusan'] = $this->admin->read('s_table2');
            } else {
                $jurusan = $this->get_id_jurusan($id_user);
                $data['daftarjurusan'] = $this->admin->read_where('s_table2', array('uid_jurusan'=>$jurusan));
            }
            $this->load->view('index', $data, FALSE);
            break;
        case 'delete':
            $id = $this->input->get('id');
            $this->admin->delete('s_table3', array('uid_dosen' => $id));
            echo json_encode(array("status" => TRUE));
            break;
        case 'edit':
            $level = $this->session->userdata('level');
            $id = $this->input->get('id');
            $data = array(
                'main_content' => 'daftardosen-edit',
                'getdata' => $this->admin->get_id('s_table3', array('uid_dosen' => $id)),
            );
            if ($level == 'superadmin') {
                $data['daftarjurusan'] = $this->admin->read('s_table2');
            } else {
                $jurusan = $this->get_id_jurusan($id_user);
                $data['daftarjurusan'] = $this->admin->read_where('s_table2', array('uid_jurusan'=>$jurusan));
            }
            $this->load->view('index', $data, FALSE);
            break;
        case 'save':
            $act = $this->input->get('act');

            $level = $this->input->post('st_level');
            $data = array(
                'nidn' => strtoupper($this->input->post('st_input1')),
                'nama_dosen' => ucwords($this->input->post('st_input2')),
                'email' => $this->input->post('st_input3'),
                'no_hp' => $this->input->post('st_input4'),
                'username' => $this->input->post('st_input5'),
                'level' => $level,
                'id_jurusan' => $this->input->post('st_jurusan'),
            );

            if ($act == "save") {
                $data['password'] = $this->encrypt($this->input->post('st_input6'));
                if ($level == 'kaprodi') {
                    $cek = $this->admin->count_where('s_table3', array('level'=>'kaprodi'));
                    if ($cek >= 3) {
                        $msg = 0;
                    } else {
                        $this->admin->create('s_table3', $data);
                        $msg = 1;
                    }
                } else {
                    $this->admin->create('s_table3', $data);
                    $msg = 1;
                }
            } else {
                $kode = $this->input->post('kode');
                if ($level == 'kaprodi') {
                    $cek = $this->db->query("SELECT uid_dosen FROM s_table3 WHERE level = 'kaprodi' AND uid_dosen <> " .$kode. "")->num_rows();
                    if ($cek >= 3) {
                        $msg = 0;
                    } else {
                        $this->admin->update('s_table3', $data, array('uid_dosen' => $kode ));
                        $msg = 1;
                    }
                } else {
                    $this->admin->update('s_table3', $data, array('uid_dosen' => $kode ));
                    $msg = 1;
                }
            }
            echo json_encode(array("status" => TRUE, 'msg'=>$msg));
            break;
        case 'import':
            $this->import('s_table3', 'nidn', 'nidn,nama_dosen,email,no_hp,level,id_jurusan', 'dosen');
            break;
        case 'export':
            $title = "daftardosen";
            
            $level = $this->session->userdata('level');
            $st_nama = $this->input->post("st_nama", true);

            if ($level == 'superadmin') {
                $st_jurusan = $this->input->post("st_jurusan", true);
                $st_level = $this->input->post("st_level", true);
                $query = $this->db->query("SELECT s_table3.nidn, s_table3.nama_dosen, s_table3.email, s_table3.no_hp, s_table3.level, s_table2.nama_jurusan FROM s_table3 LEFT JOIN s_table2 ON s_table3.id_jurusan = s_table2.uid_jurusan WHERE s_table3.level LIKE '%$st_level%' AND s_table3.id_jurusan LIKE '%$st_jurusan%' AND (s_table3.nidn LIKE '%$st_nama%' OR s_table3.nama_dosen LIKE '%$st_nama%') ORDER BY s_table3.level ASC, s_table3.nidn ASC");
            } else {
                $jurusan = $this->get_id_jurusan($id_user);
                $query = $this->db->query("SELECT s_table3.nidn, s_table3.nama_dosen, s_table3.email, s_table3.no_hp, s_table3.level, s_table2.nama_jurusan FROM s_table3 LEFT JOIN s_table2 ON s_table3.id_jurusan = s_table2.uid_jurusan WHERE s_table3.level <> 'kaprodi' AND s_table3.id_jurusan LIKE '%$jurusan$' AND (s_table3.nidn LIKE '%$st_nama%' OR s_table3.nama_dosen LIKE '%$st_nama%') ORDER BY s_table3.level ASC, s_table3.nidn ASC");
            }

            $data = $query->result();

            $this->excel->export($title, $data);
            break;
        default:
            $data = array(
                'main_content' => 'daftardosen',
                'daftarjurusan' => $this->admin->read('s_table2'),
            );
            $this->load->view('index', $data, FALSE);
            break;
        }
    }

    public function data_jurusan() {
        $this->_superadmin_area();
        switch ($this->uri->segment(3)) {
        case 'get':
            $st_fakultas = $this->input->post("st_fakultas", true);
            $st_kode = $this->input->post("st_kode", true);
            $st_nama = $this->input->post("st_nama", true);

            $query = $this->db->query("SELECT s_table2.*, s_table1.nama_fakultas FROM s_table2 LEFT JOIN s_table1 ON s_table2.uid_fakultas = s_table1.id_fakultas WHERE s_table2.uid_jurusan LIKE '%$st_kode%' AND s_table2.nama_jurusan LIKE '%$st_nama%'  ORDER BY s_table2.uid_jurusan ASC, s_table2.nama_jurusan ASC");

            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $respon['data'][] = array(
                        $no,
                        $value->uid_jurusan,
                        $value->nama_jurusan,
                        $value->nama_fakultas,
                        '<center>
                            <a href="' . base_url('admin/data-jurusan/edit?id=') . $value->uid_jurusan . '" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void()" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus" data-placement="left" onclick="hapus(' . "'" . base_url('admin/data-jurusan/delete?id=') . $value->uid_jurusan . "'" . ')"><i class="fa fa-trash"></i></a>
                        </center>'
                    );
                    $no++;
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            
            echo json_encode($respon);
            break;
        case 'add':
            $data = array(
                'main_content' => 'daftarjurusan-add',
                'daftarfakultas' => $this->admin->read('s_table1')
            );
            $this->load->view('index', $data, FALSE);
            break;
        case 'delete':
            $id = $this->input->get('id');
            $this->admin->delete('s_table2', array('uid_jurusan' => $id));
            echo json_encode(array("status" => TRUE));
            break;
        case 'edit':
            $id = $this->input->get('id');
            $data = array(
                'main_content' => 'daftarjurusan-edit',
                'getdata' => $this->admin->get_id('s_table2', array('uid_jurusan' => $id)),
                'daftarfakultas' => $this->admin->read('s_table1')
            );
            $this->load->view('index', $data, FALSE);
            break;
        case 'save':
            $act = $this->input->get('act');

            $data = array(
                'uid_jurusan' => strtoupper($this->input->post('st_input1')),
                'nama_jurusan' => ucwords($this->input->post('st_input2')),
                'uid_fakultas' => $this->input->post('st_input3'),
            );

            if ($act == "save") {
                $this->admin->create('s_table2', $data);
            } else {
                $kode = $this->input->post('st_input1');
                $this->admin->update('s_table2', $data, array('uid_jurusan' => $kode ));
            }
            echo json_encode(array("status" => TRUE));
            break;
        default:
            $data = array(
                'main_content' => 'daftarjurusan',
                'daftarfakultas' => $this->admin->read('s_table1')
            );
            $this->load->view('index', $data, FALSE);
            break;
        }
    }

    public function data_kelas() {
        $this->_superadmin_area();
        switch ($this->uri->segment(3)) {
        case 'get':
            $st_nama = $this->input->post("st_nama", true);
            $st_display = $this->input->post("st_display", true);

            if ($st_display == 'filter') {
                $query = $this->db->query("SELECT * FROM s_table5 WHERE nama_kelas LIKE '%$st_nama%' ORDER BY nama_kelas ASC");
            } else {
                $query = $this->db->query("SELECT * FROM s_table5 ORDER BY nama_kelas ASC LIMIT 1000");
            }

            $count_data = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_data > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $respon['data'][] = array(
                        $no,
                        $value->nama_kelas,
                        '<center>
                            <a class="btn btn-xs btn-info" onclick="getdata(' . "'" .  $value->uid_kelas . "'" .')"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-xs btn-danger" onclick="hapus(' . "'" . base_url('admin/data-kelas/delete?id=') . $value->uid_kelas . "'" . ')"><i class="fa fa-trash"></i></a>
                        </center>'
                    );
                    $no++;
                }
            } else {
                $respon['data'][] = array(
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                    "<span style='color:#ccc;'>Tidak ada Data</span>",
                );
            }
            
            echo json_encode($respon);
            break;
        case 'getdata':
            $uid_kelas = $this->input->post('uid_kelas');
            $query = $this->admin->get_id('s_table5', array('uid_kelas' => $uid_kelas));
            $dataarr = array(
                'uid_kelas' => $query->uid_kelas,
                'nama_kelas' => $query->nama_kelas
            );
            echo json_encode($dataarr);
            break;
        case 'delete':
            $id = $this->input->get('id');          
            $this->admin->delete('s_table5', array('uid_kelas' => $id));
            echo json_encode(array("status" => TRUE));
            break;
        case 'save':
            $act = $this->input->get('act');

            $data = array(
                'nama_kelas' => $this->input->post('kelas')
            );

            if ($act == 'save') {
                $this->admin->create('s_table5', $data);
                echo json_encode(array("status" => TRUE));
            } else {
                $kode = $this->input->post('uid_kelas');
                if ($kode == '') {
                    echo json_encode(array("status" => FLASE));
                } else {
                    $this->admin->update('s_table5', $data, array('uid_kelas' => $kode ));
                    echo json_encode(array("status" => TRUE));
                }
            }
            break;
        default:
            $data = array('main_content' => 'daftarkelas');
            $this->load->view('index', $data, FALSE);
            break;
            }
        }

    public function data_rubrik() {
        switch ($this->uri->segment(3)) {
        case 'get':
            $st_level = $this->input->post("st_level", true);

            $st_softskill = $this->input->post("st_softskill", true);
            $st_satuan = $this->input->post("st_satuan", true);
            $st_nama = $this->input->post("st_nama", true);

            if ($st_softskill == 'empty') {
                $softskill = "AND softskill = ''";
            } elseif ($st_softskill == "") {
                $softskill = "";
            } else {
                $softskill = "AND softskill = '". $st_softskill. "'";
            }

            if ($st_satuan == 'empty') {
                $satuan = "AND satuan = ''";
            } elseif ($st_satuan == "") {
                $satuan = "";
            } else {
                $satuan = "AND satuan = '". $st_satuan. "'";
            }

            if ($st_level == 'kategori') {
                $query = $this->db->query("SELECT * FROM s_table6 WHERE level = 1 " .$softskill. " " .$satuan. " AND kegiatan LIKE '%$st_nama%' ORDER BY kegiatan ASC");
            } elseif ($st_level == 'tingkatan') {
                $st_kategori = $this->input->post("st_kategori", true);
                $kategori = ($st_kategori == "") ? "" : "AND parent = " . $st_kategori;
                $query = $this->db->query("SELECT * FROM s_table6 WHERE level = 2 " .$softskill. " " .$satuan. " AND kegiatan LIKE '%$st_nama%' " .$kategori. "");
            } elseif ($st_level == 'posisi') {
                $st_tingkatan = $this->input->post("st_tingkatan", true);
                $tingkatan = ($st_tingkatan == "") ? "" : "AND parent = " . $st_tingkatan;
                $query = $this->db->query("SELECT * FROM s_table6 WHERE level = 3 " .$softskill. " " .$satuan. " AND kegiatan LIKE '%$st_nama%' " .$tingkatan. "");
            }


            $count_query = $query->num_rows();
            $getdata = $query->result();
            
            if ($count_query > 0) {
                $no = 1;
                foreach ($getdata as $key => $value) {
                    $button = '<center>
                                <a href="' . base_url('admin/data-rubrik/edit?id=') . $value->uid_rubrik . '&p='. $st_level .'" class="btn btn-xs btn-info" data-toggle="tooltip" title="Edit" data-placement="left"><i class="fa fa-pencil"></i></a>
                                <a class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus" data-placement="left" onclick="hapus(' . "'" . base_url('admin/data-rubrik/delete?id=') . $value->uid_rubrik . "'" . ')"><i class="fa fa-trash"></i></a>
                            </center>';

                    if ($st_level == 'kategori') {
                        $respon['data'][] = array(
                            $no,
                            $value->kegiatan,
                            $value->poin,
                            $value->satuan,
                            $value->bukti,
                            $value->softskill,
                            $button
                        );
                        $no++;
                    } elseif ($st_level == 'tingkatan') {
                        $parent = $this->admin->get_id('s_table6', array('uid_rubrik' => $value->parent));
                        $respon['data'][] = array(
                            $no,
                            $parent->kegiatan,
                            $value->kegiatan,
                            $value->poin,
                            $value->satuan,
                            $value->bukti,
                            $value->softskill,
                            $button
                        );
                        $no++;
                    } elseif ($st_level == 'posisi') {
                        $st_kategori = $this->input->post("st_kategori", true);
                        $st_tingkatan = $this->input->post("st_tingkatan", true);

                        if ($st_kategori != '' && $st_tingkatan == '') {

                            $rubrik_tingkatan = $this->admin->read_where('s_table6', array('parent'=>$st_kategori));

                            foreach ($rubrik_tingkatan as $tingkatan) {
                                if ($value->parent == $tingkatan->uid_rubrik) {
                                    $parent_tingkatan = $this->admin->get_id('s_table6', array('uid_rubrik' => $value->parent));
                                    $parent_kategori = $this->admin->get_id('s_table6', array('uid_rubrik' => $parent_tingkatan->parent));
                                    $respon['data'][] = array(
                                        $no,
                                        $parent_kategori->kegiatan,
                                        $parent_tingkatan->kegiatan,
                                        $value->kegiatan,
                                        $value->poin,
                                        $value->satuan,
                                        $value->bukti,
                                        $value->softskill,
                                        $button
                                    );
                                    $no++;
                                }   
                            }

                        } else {
                            $parent_tingkatan = $this->admin->get_id('s_table6', array('uid_rubrik' => $value->parent));
                            $parent_kategori = $this->admin->get_id('s_table6', array('uid_rubrik' => $parent_tingkatan->parent));
                            $respon['data'][] = array(
                                $no,
                                $parent_kategori->kegiatan,
                                $parent_tingkatan->kegiatan,
                                $value->kegiatan,
                                $value->poin,
                                $value->satuan,
                                $value->bukti,
                                $value->softskill,
                                $button
                            );
                            $no++;
                        }
                    }
                }
            } else {
                if ($st_level == 'kategori') {
                    $respon['data'][] = array(
                        "<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>",
                    );
                } elseif ($st_level == 'tingkatan') {
                    $respon['data'][] = array(
                        "<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>",
                    );
                } elseif ($st_level == 'posisi') {
                    $respon['data'][] = array(
                        "<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>","<span style='color:#ccc;'>Tidak ada Data</span>",
                    );
                }
            }
            
            echo json_encode($respon);
            break;
        case 'all':
            $data = array('main_content' => 'daftarrubrik-all');
            $this->load->view('index', $data, FALSE);
            break;
        case 'view':
            $data = array(
                'main_content' => 'daftarrubrik-view',
                'daftarsatuan' => $this->db->query("SELECT satuan FROM s_table6 GROUP BY satuan")->result(),
                'daftarsoftskill' => $this->db->query("SELECT softskill FROM s_table6 GROUP BY softskill")->result(),
                'daftarkategori' => $this->db->query("SELECT uid_rubrik, kegiatan, parent, child FROM s_table6 WHERE level = 1 AND child = 1")->result(),
            );
            $this->load->view('index', $data, FALSE);
            break;
        case 'get-tingkatan':
            $kode_kategori = $this->input->post('kode_kategori');
            $page = $this->input->post('page');
            if ($page == 'add') {
                $query = $this->admin->read_where('s_table6', array('parent'=>$kode_kategori, 'child'=>1));
                echo "<option disabled=''>-- Pilih Tingkatan --</option>";
            } elseif ($page == 'edit') {
                $query = $this->admin->read_where('s_table6', array('parent'=>$kode_kategori, 'child'=>1));
                echo "<option disabled=''>-- Pilih Tingkatan --</option>";
            } else {
                $query = $this->admin->read_where('s_table6', array('parent'=>$kode_kategori, 'child'=>1));
                echo "<option value=''>Semua Tingkatan</option>";
            }
            foreach ($query as $key => $value) {
                echo "<option value='" .$value->uid_rubrik. "'>" .$value->kegiatan. "</option>";
            }
            break;
        case 'get-data-auto':
            $data = $this->input->get('q');
            $column = $this->input->get('column');
            $query = $this->db->query("SELECT " .$column. " FROM s_table6 WHERE " .$column. " LIKE '%$data%' GROUP BY " .$column. "")->result();

            $row[] = array();
            foreach ($query as $q){
                $row[] = array(
                        'label' => $q->$column,
                    );
            }
            echo json_encode($row);
            break;
        case 'is-child':
            $uid_rubrik = $this->input->post('id');
            $cek = $this->admin->count_where('s_table6', array('parent'=>$uid_rubrik));
            if ($cek > 0) {
                $child = 1;
            }else{
                $child = 0;
            }
            echo json_encode(array('child'=>$child));
            break;
        case 'add':
        $this->_superadmin_area();
            $level = $this->input->get('p');
            if ($level != 'kategori') {
                $data['levelkategori'] = $this->db->get_where('s_table6', array('level' => 1, 'child' => 1))->result();
            }
            $data['main_content'] = 'daftarrubrik-add';
            $this->load->view('index', $data, FALSE);
            break;
        case 'edit':
        $this->_superadmin_area();
            $id = $this->input->get('id');
            $level = $this->input->get('p');
            if ($level != 'kategori') {
                $data['levelkategori'] = $this->db->get_where('s_table6', array('level' => 1, 'child' => 1))->result();
            }
            if ($level == 'posisi') {
                $get_parent = $this->admin->get_id('s_table6', array('uid_rubrik'=>$id))->parent;
                $get_parent_parent = $this->admin->get_id('s_table6', array('uid_rubrik'=>$get_parent))->parent;
                $data['uid_rubrik_kategori'] = $get_parent_parent;
            }
            $data['main_content'] = 'daftarrubrik-edit';
            $data['getdata'] = $this->admin->get_id('s_table6', array('uid_rubrik' => $id));
            $this->load->view('index', $data, FALSE);
            break;
        case 'delete':
            $this->_superadmin_area();
            $id = $this->input->get('id');
            $this->admin->delete('s_table6', array('uid_rubrik' => $id));

            $cek_child = $this->admin->count_where('s_table6', array('parent'=>$id));
            if ($cek_child > 0) {
                $uid_child = $this->admin->get_id('s_table6', array('parent' => $id))->uid_rubrik;
                $this->admin->delete('s_table6', array('parent' => $id));
                $cek_child_child = $this->admin->count_where('s_table6', array('parent'=>$uid_child));
                if ($cek_child_child > 0) {
                    $this->admin->delete('s_table6', array('parent' => $uid_child));
                }
            }

            echo json_encode(array("status" => TRUE));
            break;
        case 'save':
            $act = $this->input->get('act');

            $st_child = $this->input->post('st_child');

            $data = array(
                'parent' => $this->input->post('st_parent'),
                'level' => $this->input->post('st_level'),
                'child' => $st_child,

                'kegiatan' => $this->input->post('st_input1'),
                'poin' => $this->input->post('st_input2'),
                'satuan' => $this->input->post('st_input3'),
                'bukti' => $this->input->post('st_input4'),
                'softskill' => $this->input->post('st_input5'),
            );

            if ($act == "save") {
                $this->admin->create('s_table6', $data);
            } else {
                $kode = $this->input->post('kode');
                $this->admin->update('s_table6', $data, array('uid_rubrik' => $kode ));
            }
            echo json_encode(array("status" => TRUE));
            break;
        default:
            $data = array(
                'main_content' => 'daftarrubrik-view',
                'daftarfakultas' => $this->admin->read('s_table1')
            );
            $this->load->view('index', $data, FALSE);
            break;
        }
    }

}
