<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller Extends CI_Controller
{

   protected $default_sitename = 'Tirtacode';

   public function __construct()
   {
      parent::__construct();
   }

   public function site_name()
   {
      $sitename_from_db = ucwords($this->db->query("SELECT option_value FROM options WHERE option_name = 'sitename'")->row()->option_value);

      return $sitename_from_db == NULL ? $this->default_sitename : $sitename_from_db;
   }

   public function format_rupiah($angka){
      $rupiah=number_format($angka,0,'.','.');
      return "Rp. ".$rupiah. ",-";
   }

   public function get_option($opname){
      $result = $this->admin->get_id('options', array('option_name'=>$opname))->option_value;
      return $result;
   }

   public function get_lat_long($address){
       $address = str_replace(" ", "+", $address);

       $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address='$address'&sensor=false");
       $json = json_decode($json);

       $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
       $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

       if ($lat == '' || $lat == null) {
          $mapLat = $this->get_option('lat');
       } else {
          $mapLat = $lat;
       }

       if ($long == '' || $long == null) {
          $mapLng = $this->get_option('lng');
       } else {
          $mapLng = $long;
       }
       
       return $mapLat.','.$mapLng;
   }

   public function import($table, $pk, $field, $level) {
      $config['upload_path'] = './';
      $config['allowed_types'] = 'xls|xlsx';
      $config['encrypt_name'] = TRUE;

      $this->upload->initialize($config);

      if ($this->upload->do_upload('file')) {
         $data = $this->upload->data();
         $nama = $data['file_name'];
         if (file_exists("./" . $nama)) {
            $file = "./" . $nama;
            $import = $this->excel->import($table, $field, $pk, $file, $level);
            unlink($file);
            header("location:" . base_url('admin') . "/" . $this->uri->segment(2) . "");
         } else {
            unlink($file);
            header("location:" . base_url('admin') . "/" . $this->uri->segment(2) . "/?error=1");
         }
      } else {
         header("location:" . base_url('admin') . "/" . $this->uri->segment(2) . "/?error=2");
      }
   }

   public function encrypt($data) {
        if (!empty($data)) {
            $keydata = md5(md5($data.'lifeskill@ums12345'));
            return md5($keydata);
        } else {
            return $data;
        }
    }

}