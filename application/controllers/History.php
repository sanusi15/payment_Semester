<?php 


class History extends CI_Controller{
    public function index(){
        $data['page'] = 'History';
        $data['profile'] = $this->session->userdata('profile');
        $data['sukses'] = $this->Mmahasiswa->getTransaksiSukses();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('history/index', $data);
        $this->load->view('templates/footer');
    }
}

?>