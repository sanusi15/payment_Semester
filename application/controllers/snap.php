<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Controll-Allow-Origin: *');
header("Access-Controll-Allow-Methods: GET, OPTIONS ");
class Snap extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$params = array('server_key' => 'SB-Mid-server-uw12eOHH7Kz68dLi4ZVBr1-R', 'production' => false);
		// $params = array('server_key' => 'Mid-server-BPuFkPX9yHxLv-cwTKEPXfuV', 'production' => true);
		$this->load->library('midtrans');
		$this->midtrans->config($params);
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('checkout_snap');
	}

	public function token()
	{
		$nim = $this->input->post('nim');
		$semester = $this->input->post('semester');
		$jmlBayar = $this->input->post('jmlBayar');
	
		$mhs = $this->Mmahasiswa->getDetailMahasiswa($nim);

		// Required
		$transaction_details = array(
			'order_id' => rand(),
			'gross_amount' => $jmlBayar, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
			'id' => 'a1',
			'quantity' => 1,
			'price' => $jmlBayar,
			'name' => "Pembayaran Semester ".$semester,
		);

		// Optional
		$item_details = array($item1_details);

		// Optional
		$billing_address = array(
			'first_name'    => $mhs['nama_mahasiswa'],
			'last_name'     => "",
			'address'       => $mhs['jurusan'],
			'city'          => $mhs['nim'],			
			'phone'         => "085813673382",
			'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
			'first_name'    => "Politeknik ",
			'last_name'     => "PGRI Banten",
			'address'       => "Kramatwatu",
			'city'          => "Serang",
			'postal_code'   => "42161",
			'phone'         => "(0254) 8493568",
			'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
			'first_name'    =>$mhs['nama_mahasiswa'],
			'jurusan' => $mhs['jurusan'],
			'last_name'     => "",
			'email'         => "andri@litani.com",
			'phone'         => "085813673382",
			'billing_address'  => $billing_address,
		);

		// Data yang akan dikirim untuk request redirect_url.
		$credit_card['secure'] = true;
		//ser save_card true to enable oneclick or 2click
		//$credit_card['save_card'] = true;

		$time = time();
		$custom_expiry = array(
			'start_time' => date("Y-m-d H:i:s O", $time),
			'unit' => 'day',
			'duration'  => 1
		);

		$transaction_data = array(
			'transaction_details' => $transaction_details,
			'item_details'       => $item_details,
			'customer_details'   => $customer_details,
			'credit_card'        => $credit_card,
			'expiry'             => $custom_expiry
		);

		
		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);		
		error_log($snapToken);
		echo $snapToken;

	}
	
	public function finish()
	{
		
		$result = json_decode($this->input->post('result_data'), true);		
		$rp = number_format($result['gross_amount'], 0, ',', '.');		
		$url = "https://api.midtrans.com/v2/qris/".$result['transaction_id']."/qr-code";
		// var_dump($url);die;
	
		if($result['payment_type'] == "echannel"){
			// mandiri
			$bank = 'mandiri';
			$kodeBayar = "(".$result['biller_code'].")" ." ". $result['bill_key'];
			$aksi = $result['pdf_url'];
		}else if($result['payment_type'] == "bank_transfer"){
			// bni dan bri
			$bank = $result['va_numbers'][0]['bank'];
			$kodeBayar = $result['va_numbers'][0]['va_number'];
			$aksi = $result['pdf_url'];
		}else{			
			$bank = 'gopay';
			$kodeBayar = '-';
			$aksi = '-';
		}

		// bni dan bri
		$data = [
			'waktu' => $result['transaction_time'],
			'nim' => $this->session->userdata('profile')['nim'],
			'semester' => $this->input->post('semester'),
			'order_id' => $result['order_id'],
			'kode_pembayaran' => $kodeBayar,
			'total_bayar' => $rp,
			'method' => $bank,
			'status' => $result['status_code'],
			'aksi' => $aksi
		];
		
		$this->db->insert('tbl_historytransaksi', $data);
		redirect('pay');

		// echo 'RESULT <br><pre>';
		// echo($result);
		// echo '</pre>';
	}
}