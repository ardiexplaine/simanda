<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class tab13 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
        $this->load->model('Global_model');
        $this->load->model('Pinjaman_model');
        $this->module = "tab13";
        $this->ktgid = 13;
	}
	
	function loaddata() {
		$wfnum = $this->input->post('wfnum');
		$query = $this->db->get_where("defisit", array("wfnum"=>$wfnum,"ktg_id"=>$this->ktgid));
		$row = $query->row();

		$data = array();
		if($query->num_rows()>0){
			$data = array(
				"wfnum"  => $row->wfnum,
				"ktg_id" => $row->ktg_id,
				"tahun_anggaran" =>  $row->tahun_anggaran,
				"rencana_pinjaman" => number_format($row->rencana_pinjaman,2,'.',','),
				"belanja" => number_format($row->belanja,2,'.',','),
				"pendapatan_daerah" => number_format($row->pendapatan_daerah,2,'.',','),
				"defisit_yang_dibiayai_dari_pinjaman" => number_format($row->defisit_yang_dibiayai_dari_pinjaman,2,'.',',')
			);
		}

		echo $this->withJson($data);
	}

    function savedata() {


		$this->form_validation->set_rules('tab13_tahun_anggaran','Tahun Anggaran','required|xss_clean');
		$this->form_validation->set_rules('tab13_rencana_pinjaman','Rencana Pinjaman','required|xss_clean');
		$this->form_validation->set_rules('tab13_pendapatan_daerah','Pendapatan Daerah','required|xss_clean');

        $defisit = array(
			"wfnum"  => $this->input->post("txtWfnum"),
			"ktg_id" => $this->ktgid,
			"tahun_anggaran" =>$this->input->post("tab13_tahun_anggaran"),
			"rencana_pinjaman" => str_replace(",","", $this->input->post("tab13_rencana_pinjaman")),
			"pendapatan_daerah" => str_replace(",","", $this->input->post("tab13_pendapatan_daerah")),
			"belanja" => str_replace(",","", $this->input->post("tab13_belanja")),
			"defisit_yang_dibiayai_dari_pinjaman" => str_replace(",","", $this->input->post("tab13_defisit_yang_dibiayai_dari_pinjaman"))
        );

		
		if($this->form_validation->run() == TRUE)
		{
			$query = $this->db->get_where("defisit", array("wfnum"=>$this->input->post("txtWfnum")));
			if($query->num_rows()>0){
				$this->db->update('defisit', $defisit, array("wfnum"=>$this->input->post("txtWfnum")) );
			}else{
				$this->db->insert('defisit', $defisit);
			}
            
            $status = 0;
            $message = 'Data Berhasil Disave';
            $notif = $this->Global_model->getNotif($status,$message);
            $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
			
		}else{
			$status = 1;
			$message = strip_tags(validation_errors());
			$notif = $this->Global_model->getNotif($status,$message);
            $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
		}
		echo $this->withJson($resultObj);	
    }




    function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}