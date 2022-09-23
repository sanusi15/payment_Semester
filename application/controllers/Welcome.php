<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$session = $this->session->userdata('profile');
		if(!$session){
			redirect('login');
		}
		
	}
	public function index()
	{
		// $this->db->select('*');
		// $this->db->from('tbl_detailBayaran');
		// $data['data'] = $this->db->get()->result_array();
		// $data['profile'] = $this->session->userdata('profile');
		// $data['pending'] = $this->Mmahasiswa->getPendingPayment();
		$data['page'] = 'Dashboard';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/navbar');		
		$this->load->view('templates/sidebar');
		$this->load->view('welcome_message');	
		$this->load->view('templates/footer');
	}

	// public function lihatData()
	// {
	// 	$smstr = $this->input->post('semester');	
	// 	$this->Mmahasiswa->getDetailBayar($smstr);
	// }
}
