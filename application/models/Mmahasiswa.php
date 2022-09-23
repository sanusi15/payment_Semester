<?php 

Class Mmahasiswa extends CI_Model{
    public function getDetailMahasiswa($nim)
    {
        $this->db->select('*');
        $this->db->from('tbl_mhs'); 
        $this->db->join('tbl_jurusan', 'tbl_mhs.idJurusan = tbl_jurusan.idJurusan');
        $this->db->join('tbl_semester', 'tbl_mhs.idSemester = tbl_semester.idSemester');
        $this->db->where(['tbl_mhs.nim' => $nim]);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getDetailBayar(){       

        $this->db->select('*');
        $this->db->from('tbl_tagihan');
        $this->db->where('nim', $this->session->userdata('profile')['nim']);
        $tagihan = $this->db->get()->row_array();

        $where = [
            'nim' => $this->session->userdata('profile')['nim'],
            'idSemester' => $this->input->post('semester')
        ];

        $this->db->select('*');
        $this->db->from('tbl_detailBayaran');
        $this->db->where($where);
        $query = $this->db->get()->row_array();
        
        if($query){
            $data = [   
                'nama' => $this->session->userdata('profile')['nama'],
                'nim' => $this->session->userdata('profile')['nim'],
                'semester' => $this->input->post('semester'),
                'jurusan' => $this->session->userdata('profile')['jurusan'],
                'jml_tagihan' => $tagihan['jml_tagihan'],
                'cicilan1' => $query['cicilan1'],
                'cicilan2' => $query['cicilan2'],
                'total_bayar' => $query['total_bayar'],
                'keterangan' => $query['keterangan'],
            ];
            echo json_encode($data);
        }else{
            $data = [
                'nama' => $this->session->userdata('profile')['nama'],
                'nim' => $this->session->userdata('profile')['nim'],
                'semester' => $this->input->post('semester'),
                'jurusan' => $this->session->userdata('profile')['jurusan'],
                'jml_tagihan' => $tagihan['jml_tagihan'],
                'cicilan1' => '',
                'cicilan2' => '',
                'total_bayar' => '',
                'keterangan' => '',
            ];
            echo json_encode($data);
        }        
    }

    public function getPendingPayment(){
        $where = [
            'nim' => $this->session->userdata('profile')['nim'],            
            // 'nim' => '2057570025',            
            // 'status' => '201'
        ];
        $this->db->select('*');
        $this->db->where($where);
        $this->db->order_by('id', 'DESC');
        $data = $this->db->get('tbl_historytransaksi')->result_array();        
        return $data;
    }

    public function getTransaksiSukses(){
        // get sukses payment from tbl_historytransaksi
        $where = [
            'status' => '200',
            'nim' => $this->session->userdata('profile')['nim']
        ];
        $this->db->where($where);
        $query = $this->db->get('tbl_historytransaksi');
        return $query->result_array();
    }
}





?>