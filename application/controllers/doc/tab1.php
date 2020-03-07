<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Tab1 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
        $this->load->model('Global_model');
        $this->load->model('Pinjaman_model');
        $this->module = "tab1";
        $this->ktgid = 11;
	}

	function calculate() {
		error_reporting(0);
		$wfnum = $this->input->post('txtWfnum');
		$sisa_pinjaman = str_replace(",","", $this->input->post("tab1_sisa_pinjaman"));
		$pendapatan_daerah = str_replace(",","", $this->input->post("tab1_pendapatan_daerah"));
		$dak = str_replace(",","", $this->input->post("tab1_dak"));
		$dana_darurat = str_replace(",","", $this->input->post("tab1_dana_darurat"));
		$dana_penyesuaian = str_replace(",","", $this->input->post("tab1_dana_penyesuaian"));
		$data = array();

		$SQL3 = "SELECT rencana_usulan_pinjaman FROM dscr_pp WHERE wfnum='$wfnum' ORDER BY ktg_id DESC LIMIT 1";
		$Q3 = $this->db->query($SQL3);
		$rencana_pinjaman = 0;
		if($Q3->num_rows()>0){
			$row = $Q3->row();
			$rencana_pinjaman = $row->rencana_usulan_pinjaman;
		}

		$data = array(
			"rencana_pinjaman" => number_format($rencana_pinjaman,2,'.',','),
			"sisa_pinjaman" => number_format($sisa_pinjaman,2,'.',','),
			"pendapatan_daerah" => number_format($pendapatan_daerah,2,'.',','),
			"dak" => number_format($dak,2,'.',','),
			"dana_darurat" => number_format($dana_darurat,2,'.',','),
			"dana_penyesuaian" => number_format($dana_penyesuaian,2,'.',',')
		);
		

		echo $this->withJson($data);
	}

	
	function loaddata() {
		$wfnum = $this->input->post('wfnum');
		$query = $this->db->get_where("lk_perhitungan_75", array("wfnum"=>$wfnum,"ktg_id"=>$this->ktgid));
		$row = $query->row();

		$data = array();
		if($query->num_rows()>0){
			$data = array(
				"wfnum"  => $row->wfnum,
				"ktg_id" => $row->ktg_id,
				"rencana_pinjaman" => number_format($row->rencana_pinjaman,2,'.',','),
				"sisa_pinjaman" => number_format($row->sisa_pinjaman,2,'.',','),
				"pendapatan_daerah" => number_format($row->pendapatan_daerah,2,'.',','),
				"dak" => number_format($row->dak,2,'.',','),
				"dana_darurat" => number_format($row->dana_darurat,2,'.',','),
				"dana_penyesuaian" => number_format($row->dana_penyesuaian,2,'.',',')
			);
		}
		
		echo $this->withJson($data);
	}

    function savedata() {


		$this->form_validation->set_rules('tab1_rencana_pinjaman','Rencana Pinjaman','required|xss_clean');

        $item_dscr_pp = array(

			"wfnum"  => $this->input->post("txtWfnum"),
			"ktg_id" => $this->ktgid,
			"rencana_pinjaman" => str_replace(",","", $this->input->post("tab1_rencana_pinjaman")),
			"sisa_pinjaman" => str_replace(",","", $this->input->post("tab1_sisa_pinjaman")),
			"pendapatan_daerah" => str_replace(",","", $this->input->post("tab1_pendapatan_daerah")),
			"dak" => str_replace(",","", $this->input->post("tab1_dak")),
			"dana_darurat" => str_replace(",","", $this->input->post("tab1_dana_darurat")),
			"dana_penyesuaian" => str_replace(",","", $this->input->post("tab1_dana_penyesuaian"))
        );

		
		if($this->form_validation->run() == TRUE)
		{
			$query = $this->db->get_where("lk_perhitungan_75", array("wfnum"=>$this->input->post("txtWfnum")));
			if($query->num_rows()>0){
				$this->db->update('lk_perhitungan_75', $item_dscr_pp, array("wfnum"=>$this->input->post("txtWfnum")) );
			}else{
				$this->db->insert('lk_perhitungan_75', $item_dscr_pp);
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