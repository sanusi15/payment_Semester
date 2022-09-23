<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Controll-Allow-Origin: *');
header("Access-Controll-Allow-Methods: GET, OPTIONS ");
class Coba extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-uw12eOHH7Kz68dLi4ZVBr1-R', 'production' => false);
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
		
		// getdata
		// $nim = $this->input->get('nim');


		// $this->db->select('*');
		// $this->db->from('tbl_mhs'); 
		// $this->db->join('tbl_bayaran', 'tbl_mhs.nim = tbl_bayaran.nim');
		// $this->db->join('tbl_jurusan', 'tbl_mhs.idJurusan = tbl_jurusan.idJurusan');
		// $this->db->join('tbl_semester', 'tbl_mhs.idSemester = tbl_semester.idSemester');
		// $this->db->where(['tbl_mhs.nim' => $nim]);
		// $query = $this->db->get();
		// $data = $query->row_array();
	
		

		// Required
		$transaction_details = array(
		  'order_id' => rand(),
		  'gross_amount' =>1000, // no decimal allowed for creditcard
		);

		// Optional
		$item1_details = array(
		  'id' => 'a1',
		  'price' =>  1000,
		  'quantity' => 1,
		  'name' => 'Pembayaran Semester ' 
		);

		// Optional
		$item_details = array ($item1_details);

		// Optional
		$billing_address = array(
		  'first_name'    => 'Sabin',
		  'last_name'     => "Litani",
		  'address'       => "Mangga 20",
		  'city'          => "Jakarta",
		  'postal_code'   => "16602",
		  'phone'         => "081122334455",
		  'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
		  'first_name'    => "Obet",
		  'last_name'     => "Supriadi",
		  'address'       => "Manggis 90",
		  'city'          => "Jakarta",
		  'postal_code'   => "16601",
		  'phone'         => "08113366345",
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => 'Sabin',		  
		  'email'         => "andri@litani.com",
		  'phone'         => "081122334455",
		//   'billing_address'  => $billing_address,
		//   'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'day', 
            'duration'  => 1
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
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
		$nim = $this->input->post('nim');		
    	echo 'RESULT <br><pre>';
		$data = [
			'nim' => $nim,
			'orderId' => $result['order_id'],
			'waktu' => $result['transaction_time'],
			'bank' => $result['va_numbers'][0]['bank'],
			'status' => $result['transaction_status'],
			'jumlah_bayar' => $result['gross_amount'],
			'url' => $result['pdf_url']
		];
    	$this->db->insert('tbl_detailbayaran', $data);
		redirect('welcome');
		
    	echo '</pre>' ;

    }
}
