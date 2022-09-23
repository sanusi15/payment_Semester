<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {
	public function __construct()
    {		
        parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-uw12eOHH7Kz68dLi4ZVBr1-R', 'production' => false);
		// $params = array('server_key' => 'Mid-server-BPuFkPX9yHxLv-cwTKEPXfuV', 'production' => true);
		$this->load->library('veritrans');
		$this->veritrans->config($params);
		$this->load->helper('url');
		
    }

	public function index()
	{
		echo 'test notification handler';
		
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result, true); 

		// $order_id = $result['order_id'];	
		$order_id = $this->input->get('order');

		// $data = [
		// 	'waktu' => $result['transaction_time'],
		// 	'status' => $result['status_code'],
		// ];
		$data = [
			'waktu' => 'hquheqwuigeqw',
			'status' => '200',
		];

		// update tbl_historytransaksi jadi sukses
		// if($result['status_code'] == 200) {
		// 	$this->db->where('order_id', $order_id);
		// 	$this->db->update('tbl_historytransaksi', $data);
		// }
		$this->db->where('order_id', $order_id);
		$this->db->update('tbl_historytransaksi', $data);

		// get tabel_historytransaksi 
		$getTblHistory = $this->db->get_where('tbl_historytransaksi', ['order_id' => $order_id])->row_array();

		// get total tagihan per semester mahasiswa
		$this->db->select('jml_tagihan');
		$this->db->where('nim', $getTblHistory['nim']);
		$getTotalTagihan = $this->db->get('tbl_tagihan')->row_array();


		$tblDetail = $this->db->get('tbl_detailbayaran')->num_rows();
		if($tblDetail > 0) {
			$where = [
				'nim' => $getTblHistory['nim'],
				'idSemester' => $getTblHistory['semester'],
			];

			$cekSudahBayarSemester = $this->db->get_where('tbl_detailbayaran', $where)->row_array();			
			if($cekSudahBayarSemester > 0) {
				// $data = [
					// 	'cicilan2' => $result['gross_amount'],
					// 	'total_bayar' => $result['gross_amount'] + 10,
					// ];
					$data = [
						'cicilan2' => 600000,
						'total_bayar' => 1200000,
						'keterangan' => 'LUNAS',
					];
					$this->db->where($where);
					$this->db->update('tbl_detailbayaran', $data);
			} else {
				if ($result['gross_amount'] == $getTotalTagihan['jml_tagihan']) {
					$keterangan = 'LUNAS';
				} else {
					$keterangan = 'BELUM LUNAS';
				}
				$data = [
					'nim' => $getTblHistory['nim'],
					'idSemester' => $getTblHistory['semester'],
					// 'cicilan1' => $result['gross_amount'],
					'cicilan1' => 600000,
					'cicilan2' => '',
					// 'total_bayar' => $result['gross_amount'],
					'total_bayar' => 600000,
					'keterangan' => $keterangan,
				];
				$this->db->insert('tbl_detailbayaran', $data);
			}
		} else {
			if ($result['gross_amount'] == $getTotalTagihan['jml_tagihan']) {
				$keterangan = 'LUNAS';
			} else {
				$keterangan = 'BELUM LUNAS';
			}
			$data = [
				'nim' => $getTblHistory['nim'],
				'idSemester' => $getTblHistory['semester'],
				// 'cicilan1' => $result['gross_amount'],
				'cicilan1' => 600000,
				'cicilan2' => '',
				// 'total_bayar' => $result['gross_amount'],
				'total_bayar' => 600000,
				'keterangan' => $keterangan,
			];
			$this->db->insert('tbl_detailbayaran', $data);
		}

		
	}
}
