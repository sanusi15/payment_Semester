<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{  
    public function index()
    {
        $this->load->view('login/index');
    }
    

    public function cek_login()
    {
        $nim = $this->input->post('nim');
        $password = $this->input->post('password');

        $getData = $this->db->get_where('tbl_mhs', ['nim' => $nim])->row_array();
        // var_dump($getData);die;

        //  password_verify($password, $getData['password'])  -> jika password menggunakan hash
        if($nim == $getData['nim'] && $password == $getData['nama_mahasiswa']) {
            $data = array(
                'nim' => $nim,
                'nama' => $getData['nama_mahasiswa'],
                'jurusan' =>  $getData['idJurusan'],
                'semester' =>  $getData['idSemester'],
                'status' => 'login'
            );
            $this->session->set_userdata('profile',$data);
            redirect('');
        }else{
            $this->session->set_flashdata('message', `<div class="alert alert-danger" role="alert">
            Username atau Password Salah!
            </div>`);
            redirect('login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
