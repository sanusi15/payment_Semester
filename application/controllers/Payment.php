<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $session = $this->session->userdata('profile');
        if (!$session) {
            redirect('login');
        }
    }
    public function index()
    {
        $this->db->select('*');
        $this->db->from('tbl_detailBayaran');
        $data['data'] = $this->db->get()->result_array();
        $data['profile'] = $this->session->userdata('profile');
        $data['pending'] = $this->Mmahasiswa->getPendingPayment();
        $data['page'] = 'Payment';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar');
        $this->load->view('templates/sidebar');
        $this->load->view('payment/index');
        $this->load->view('templates/footer');
    }

    public function lihatData()
    {
    	$smstr = $this->input->post('semester');	
    	$this->Mmahasiswa->getDetailBayar($smstr);
    }
}
