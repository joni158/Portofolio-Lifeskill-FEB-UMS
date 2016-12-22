<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Router.php";

class MY_Router extends MX_Router {
	function _set_request($segment = array()) {
		if (isset($segment[2])) {
			$segment[2] = str_replace('-', '_', $segment[2]);
		}
		return parent::_set_request($segment);
	}
}