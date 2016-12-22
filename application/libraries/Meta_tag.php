<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meta_tag {
	protected $ci;
	/**
	 * Dfault Meta
	 * @var string
	 */
	protected $viewport;
	protected $description;
	protected $keywords;
	protected $author;
	/**
	 * Fb Meta
	 * @var string
	 */
	protected $og_url;
	protected $og_title;
	protected $og_description;
	protected $og_image;
	protected $og_type;
	protected $og_author;
	protected $og_publisher;
	protected $html;

	public function __construct() {
		$this->ci = &get_instance();
		$this->ci->load->database();
	}
	public function initialize(array $params = array()) {
		$query = $this->ci->db->get('options');
		foreach ($query->result() as $row) {
			$data["$row->option_name"] = $row->option_value;
		}
		if (isset($params)) {
			$this->html .= "<!-- Meta Tags -->\n";
			$this->html .= '<meta charset="utf-8">' . "\n";
			$this->html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">' . "\n";
			$this->html .= '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
			if (isset($params['description'])) {
				$this->html .= '<meta name="description" content="' . strip_tags($params['description']) . '"/>' . "\n";
			} else {
				$this->html .= '<meta name="description" content="' . $data['about'] . '">' . "\n";
			}
			if (isset($params['keywords'])) {
				$this->html .= '<meta name="keywords" content="' . $params['keywords'] . '">' . "\n";
			}
			$this->html .= '<meta name="author" content="scripthouse.co.id">' . "\n";

			$this->html .= "<!-- s: fb meta -->\n";
			if (isset($params['og_url'])) {
				$this->html .= '<meta property="og:url" content="' . $params['og_url'] . '"/>' . "\n";
			}
			if (isset($params['og_title'])) {
				$this->html .= '<meta property="og:title" content="' . $params['og_title'] . '" />' . "\n";
			}
			if (isset($params['og_description'])) {
				$this->html .= '<meta property="og:description" content="' . strip_tags($params['og_description']) . '" />' . "\n";
			}
			if (isset($params['og_image'])) {
				$this->html .= '<meta property="og:image" content="' . $params['og_image'] . '" />' . "\n";
			}

			$this->html .= '<meta property="og:site_name" content="scripthouse.co.id" />' . "\n";

			$this->html .= '<meta property="og:type"  content="article" />' . "\n";
			if (isset($params['og_author'])) {
				$this->html .= '<meta property="article:author" content="' . $params['og_author'] . '"/>' . "\n";
			}
			if (isset($params['og_publisher'])) {
				$this->html .= '<meta property="article:publisher" content="' . $params['og_publisher'] . '" />' . "\n";
			}
		}

		return $this->html;
	}

}

/* End of file Meta_tag.php */
/* Location: ./application/libraries/Meta_tag.php */
