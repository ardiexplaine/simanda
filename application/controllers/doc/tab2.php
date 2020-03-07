<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Tab2 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
        $this->load->model('Global_model');
        $this->load->model('Pinjaman_model');
        $this->module = "tab2";
        $this->ktgid = 10;
	}
	
	function loaddata() {
		$wfnum = $this->input->post('wfnum');
		$query = $this->db->get_where("dscr_pp", array("wfnum"=>$wfnum,"ktg_id"=>$this->ktgid));
		$row = $query->row();

		$data = array();
		if($query->num_rows()>0){
			$data = array(
				"wfnum"  => $row->wfnum,
				"ktg_id" => $row->ktg_id,
				"rencana_usulan_pinjaman" => number_format($row->rencana_usulan_pinjaman,2,'.',','),
				"bunga_tahun" => number_format($row->bunga_tahun,2,'.',','),
				"jangka_waktu_pinjam" => number_format($row->jangka_waktu_pinjam,0,'.',','),
				"tenggang_waktu" => number_format($row->tenggang_waktu,0,'.',','),
				"pad" => number_format($row->pad,2,'.',','),
				"dbh" => number_format($row->dbh,2,'.',','),
				"dau" => number_format($row->dau,2,'.',','),
				"belanja_pegawai" => number_format($row->belanja_pegawai,2,'.',','),
				"dbh_dr" => number_format($row->dbh_dr,2,'.',','),
				"angsuran_bunga" => number_format($row->angsuran_bunga,2,'.',','),
				"angsuran_pokok" => number_format($row->angsuran_pokok,2,'.',','),
				"biaya_lain" => number_format($row->biaya_lain,2,'.',','),
				"pembayaran_pokok" => number_format($row->pembayaran_pokok,2,'.',','),
				"sisa_pembayaran_pokok_pinjaman" => number_format($row->sisa_pembayaran_pokok_pinjaman,2,'.',','),
				"bunga_pinjaman_lama" => number_format($row->bunga_pinjaman_lama,2,'.',','),
				"sisa_pembayaran_bunga_pinjaman" => number_format($row->sisa_pembayaran_bunga_pinjaman,2,'.',',')
			);
		}

		echo $this->withJson($data);
	}


	function calculate() {
		error_reporting(0);
		$wfnum = $this->input->post('txtWfnum');
		$rencana_usulan_pinjaman = str_replace(",","", $this->input->post("tab2_rencana_usulan_pinjaman"));
		$bunga_tahun = str_replace(",","", $this->input->post("tab2_bunga_tahun"));
		$jangka_waktu_pinjam = str_replace(",","", $this->input->post("tab2_jangka_waktu_pinjam"));
		$tenggang_waktu = str_replace(",","", $this->input->post("tab2_tenggang_waktu"));
		$data = array();


		$SQL = "SELECT *,ta_1+ta_2+ta_3 as total2, (ta_1+ta_2+ta_3)/3 as rata2 FROM lk_dscr where wfnum='$wfnum' AND ktg_id=5 ";
		$result = $this->db->query($SQL);
		foreach($result->result() as $res){
			$hasil[$res->list_id] = $res->rata2;
		}

		$angsuran_bunga = ($bunga_tahun/100)*$rencana_usulan_pinjaman;
		$angsuran_pokok = $rencana_usulan_pinjaman/($jangka_waktu_pinjam-$tenggang_waktu);
		$biaya_lain = 0.01*$rencana_usulan_pinjaman;

		$data = array(
			"rencana_usulan_pinjaman" => number_format($rencana_usulan_pinjaman,2,'.',','),
			"bunga_tahun" => number_format($bunga_tahun,2,'.',','),
			"jangka_waktu_pinjam" => number_format($jangka_waktu_pinjam,0,'.',','),
			"tenggang_waktu" => number_format($tenggang_waktu,0,'.',','),
			"pad" => number_format($hasil[1],2,'.',','),
			"dbh" => number_format($hasil[2],2,'.',','),
			"dau" => number_format($hasil[3],2,'.',','),
			"belanja_pegawai" => number_format($hasil[6],2,'.',','),
			"dbh_dr" => number_format($hasil[4],2,'.',','),
			"angsuran_bunga" => number_format($angsuran_bunga,2,'.',','),
			"angsuran_pokok" => number_format($angsuran_pokok,2,'.',','),
			"biaya_lain" => number_format($biaya_lain,2,'.',','),
			"pembayaran_pokok" => number_format($hasil[9],2,'.',','),
			"sisa_pembayaran_pokok_pinjaman" => number_format($hasil[10],2,'.',','),
			"bunga_pinjaman_lama" => number_format($hasil[7],2,'.',','),
			"sisa_pembayaran_bunga_pinjaman" => number_format($hasil[8],2,'.',',')
		);
		

		echo $this->withJson($data);
	}

    function savedata() {

		$this->form_validation->set_rules('tab2_rencana_usulan_pinjaman','Rencana Usulan','required|xss_clean');
        $this->form_validation->set_rules('tab2_bunga_tahun','Bunga Tahunan','required|xss_clean');
		$this->form_validation->set_rules('tab2_jangka_waktu_pinjam','Jangka Waktu Pinjam','required|xss_clean');

        $item_dscr_pp = array(

			"wfnum"  => $this->input->post("txtWfnum"),
			"ktg_id" => $this->ktgid,
			"rencana_usulan_pinjaman" => str_replace(",","", $this->input->post("tab2_rencana_usulan_pinjaman")),
			"bunga_tahun" => str_replace(",","", $this->input->post("tab2_bunga_tahun")),
			"jangka_waktu_pinjam" => str_replace(",","", $this->input->post("tab2_jangka_waktu_pinjam")),
			"tenggang_waktu" => str_replace(",","", $this->input->post("tab2_tenggang_waktu")),
			"pad" => str_replace(",","", $this->input->post("tab2_pad")),
			"dbh" => str_replace(",","", $this->input->post("tab2_dbh")),
			"dau" => str_replace(",","", $this->input->post("tab2_dau")),
			"belanja_pegawai" => str_replace(",","", $this->input->post("tab2_belanja_pegawai")),
			"dbh_dr" => str_replace(",","", $this->input->post("tab2_dbh_dr")),
			"angsuran_bunga" => str_replace(",","", $this->input->post("tab2_angsuran_bunga")),
			"angsuran_pokok" => str_replace(",","", $this->input->post("tab2_angsuran_pokok")),
			"biaya_lain" => str_replace(",","", $this->input->post("tab2_biaya_lain")),
			"pembayaran_pokok" => str_replace(",","", $this->input->post("tab2_pembayaran_pokok")),
			"sisa_pembayaran_pokok_pinjaman" => str_replace(",","", $this->input->post("tab2_sisa_pembayaran_pokok_pinjaman")),
			"bunga_pinjaman_lama" => str_replace(",","", $this->input->post("tab2_bunga_pinjaman_lama")),
			"sisa_pembayaran_bunga_pinjaman" => str_replace(",","", $this->input->post("tab2_sisa_pembayaran_bunga_pinjaman")),
        );

		
		if($this->form_validation->run() == TRUE)
		{
			$kondisi = array("wfnum"=>$this->input->post("txtWfnum"), "ktg_id" => $this->ktgid) ;
			$query = $this->db->get_where("dscr_pp", $kondisi );
			if($query->num_rows()>0){
				$this->db->update('dscr_pp', $item_dscr_pp, $kondisi );
			}else{
				$this->db->insert('dscr_pp', $item_dscr_pp);
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

    function deletdata(){

        $this->form_validation->set_rules('item_id','Belanja Pegawai','required|xss_clean');

        if($this->form_validation->run() == TRUE)
		{
            $item_id = $this->input->post('item_id');
            $this->db->delete('lk_kegiatan_honor', array("item_id" => $item_id));

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