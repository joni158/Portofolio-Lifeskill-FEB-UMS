<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel {

	private $excel;

	public function __construct() {
		$CI = &get_instance();
		$CI->load->library('PHPExcel');
		$this->excel = new PHPExcel();
	}

	public function export($title, $data = null) {
		$filename = date('Y-m-d') . "-" . $title . ".xlsx";
		if ($data != null) {
			$col = 'A';
			foreach ($data[0] as $key => $val) {
				$objRichText = new PHPExcel_RichText();
				$objPayable = $objRichText->createTextRun(ucwords(str_replace("_", " ", $key)));
				$objPayable->getFont()->setBold(true);
				$this->excel->getActiveSheet()->getCell($col . '1')->setValue($objRichText);
				$col++;
			}
			$rowNumber = 2;
			foreach ($data as $row) {
				$col = 'A';
				foreach ($row as $cell) {
					$this->excel->getActiveSheet()->setCellValue($col . $rowNumber, $cell);
					$col++;
				}
				$rowNumber++;
			}
		}
		$this->excel->getActiveSheet()->setTitle($filename);

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');

		//Header
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		header('Content-Disposition: attachment;filename="' . $filename . '"');

		//Download
		$objWriter->save("php://output");
	}

	public function import($table, $field, $pk, $file, $level) {
		$CI = &get_instance();
		$CI->load->database();
		$CI->load->library('PHPExcel');
		$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$highestRow = $objWorksheet->getHighestRow();
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		$rows = array();
		for ($row = 2; $row <= $highestRow; ++$row) {
			$fields = $CI->db->list_fields($table);
			$explode = explode(",", $field);
			$my_nim = '';
			for ($col = 0; $col < $highestColumnIndex; ++$col) {
				$datacol[] = $explode[$col];
				$getval = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				if ($explode[$col] == 'nim' || $explode[$col] == 'nidn') {
					$my_nim = $getval;
				}

				if ($explode[$col] == 'id_jurusan') {
					$get_idjurusan = $CI->db->query("SELECT uid_jurusan FROM s_table2 WHERE nama_jurusan = '$getval'")->row();
					$dataxl[] = $get_idjurusan->uid_jurusan;
				} elseif ($explode[$col] == 'level') {
					if ($level == 'dosen') {
						if ($getval == 'Kaprodi' || $getval == 'Ketua Progdi' || $getval == 'Ketua Program Studi' || $getval == 'kaprodi') {
							$dataxl[] = 'kaprodi';
						} elseif ($getval == 'Pembimbing' || $getval == 'Dosen Pembimbing') {
							$dataxl[] = 'pembimbing';
						}
					} else {
						$dataxl[] = $getval;
					}
				} elseif ($explode[$col] == 'uid_fakultas') {
					$get_idfakultas = $CI->db->query("SELECT id_fakultas FROM s_table1 WHERE nama_fakultas = '$getval'")->row();
					$dataxl[] = $get_idfakultas->id_fakultas;
				} else {
					$dataxl[] = $getval;
				}
			}

			$data = array_combine($datacol, $dataxl);

			if ($pk != "") {
				$query = $CI->db->get_where($table, array($pk => $data[$pk]));
				if ($query->num_rows()) {
					if ($level == 'mahasiswa' || $level == 'dosen') {
						$data['username'] = $my_nim;
					}
					if ($level == 'mahasiswa') {
						$data['level'] = $level;	
					}

					$CI->db->where($pk, $data[$pk]);
					$CI->db->update($table, $data);
				} else {
					if ($data[$pk] != "") {
						if ($level == 'mahasiswa' || $level == 'dosen') {
							$data['password'] = $CI->encrypt($my_nim);
							$data['username'] = $my_nim;
						}

						if ($level == 'mahasiswa') {
							$data['level'] = $level;	
						}
						
						$CI->db->insert($table, $data);
					}
				}
			} else {
				$CI->db->update($table, $data);
			}
		}
	}

}

/* End of file Excel.php */
/* Location: ./application/libraries/Excel.php */
