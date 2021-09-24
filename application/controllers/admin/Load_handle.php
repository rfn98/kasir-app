<?php defined("BASEPATH") or exit(); 

class Load_handle extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("admin/load_handle_model", "l");
		$this->load->database();
	}

	private function load_menu($post) {
		if(count($post) > 0) {
			$post  = $this->security->xss_clean($post);
			$post = $this->corelib->escape_string($post);
			return $this->l->load_menu($post);
		}
		else {
			return $this->l->load_menu(["tipe" => "datatable"]);
		}
	}

	private function load_part_menu($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);

		return $this->l->load_part_menu($post);
	}

	private function pesanan($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);

		return $this->l->load_pesanan($post);
	}

	private function filter_pesanan($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);
		$list_pesanan = json_decode($this->l->load_pesanan($post)); // string JSON
		$decode = $list_pesanan->data;
		$filter = [];
		if (isset($_GET['date']))
			foreach ($decode as $k => $v) 
				if ($v[6] == $_GET['date']) 
					array_push($filter, $v);
		
		$list_pesanan->data = $filter;
		$list_pesanan->recordsTotal = count($filter);
		$list_pesanan->recordsFiltered = count($filter);
		// 21-02-2019

		/*echo "<pre>";
		var_dump($list_pesanan);
		// var_dump(json_decode($this->l->load_pesanan($post)));
		echo "</pre>";*/
		// return $this->l->load_pesanan($post);
		// return $_GET['date'];
		return json_encode($list_pesanan);
	}

	private function pelanggan($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);

		return $this->l->pelanggan($post);
	}

	private function part_pelanggan($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);

		return $this->l->part_pelanggan($post);
	}

	private function transaksi($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);
		return $this->l->transaksi($post);

	}

	private function part_pesanan($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);

		return $this->l->part_pesanan($post);
	}

	private function get_pesanan_by_transaksi($post) {
		$post = $this->security->xss_clean($post);
		$post = $this->corelib->escape_string($post);
		return $this->l->get_pesanan_by_transaksi($post);
	}

	public function touch($func) {
		switch($func) {
			case "load_menu" :
				echo self::load_menu($_POST);
				break;
			case "load_part_menu" :
				echo self::load_part_menu($_POST);
				break;
			case "pesanan" :
				echo self::pesanan($_POST);
				break;
			case "part_pesanan" :
				echo self::part_pesanan($_POST);
				break;
			case "pelanggan" :
				echo self::pelanggan($_POST);
				break;
			case "part_pelanggan" : 
				echo self::part_pelanggan($_POST);
				break;
			case "transaksi" :
				echo self::transaksi($_POST);
				break;
			case "filter_pesanan" :
				echo self::filter_pesanan($_POST);
				break;
			case "get_pesanan_by_transaksi" :
				echo self::get_pesanan_by_transaksi($_POST);
				break;
		}
	}
}

?>