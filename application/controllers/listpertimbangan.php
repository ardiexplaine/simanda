<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listpertimbangan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkAdmin();
		$this->load->model('Global_model');
	}

	public function index() {	
		$data['content'] = 'listpertimbangan/table';
		$this->load->view('layout2',$data);
	}
  
	function json(){
		$tahun = $this->input->post('tahun');

		$kondisi ='';
		if($tahun != ''){
			$kondisi .= ' AND YEAR(pinjaman.tgl_surat)='.$tahun;
		}


		$SQL = "Select m_daerah.namakab, pinjaman.* from pinjaman join m_daerah on pinjaman.group_user = m_daerah.id 
		WHERE surat_mendagri NOT IN ('','undefined') $kondisi";
		//echo $SQL; exit;
		$query = $this->db->query($SQL);
		
		$data= array();
		foreach($query->result() as $row){
			$data[] = array(
				"namakab"=> $row->namakab,
				"wfnum"=> $row->wfnum,
				"docnumber"=>$row->docnumber,
				"doctgl"=> date('d M Y', strtotime($row->doctgl)),
				"surat_mendagri"=>$row->surat_mendagri,
				"tgl_surat"=>date('d M Y', strtotime($row->tgl_surat))
			);
		}

        echo $this->withJson($data);
    }

    public function cetak($tahun='') {

		$tahun = isset($tahun) ? $tahun : '';
		$kondisi ='';
		if($tahun != ''){
			$kondisi .= ' AND YEAR(pinjaman.tgl_surat)='.$tahun;
		}


		$SQL = "Select m_daerah.namakab, pinjaman.* from pinjaman join m_daerah on pinjaman.group_user = m_daerah.id 
		WHERE surat_mendagri NOT IN ('','undefined') $kondisi";
    
        $query = $this->db->query($SQL);

		 $data['content'] = $query->result();
		 $data['tahun'] = $tahun;
         
		 $this->load->view('listpertimbangan/print',$data);
	}

	function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}