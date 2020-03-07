<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
		$this->load->model('Pinjaman_model');
	}

	public function index() {	
		$data['content'] = 'dashboard/index';
		$this->load->view('layout2',$data);
	}

	public function detail() {	
		$data['wfnum'] = $this->uri->segment(3);
		$data['content'] = 'dashboard/detail';
		$this->load->view('layout2',$data);
	}

	public function timeline(){
		$wfnum = $this->uri->segment(3);

		$this->db->select('time_name');
		$this->db->order_by('time_id','ASC');
		$query = $this->db->get('time_status');

		$curid = $this->db->query("SELECT b.no_urut FROM pinjaman a 
		JOIN wf_status b ON a.curst=b.stscd
		WHERE a.wfnum='$wfnum'")->row();

		foreach($query->result() as $r){
			$da[] = $r->time_name;
		}

		$data = array(
			"curid" => $curid->no_urut,
			"tline" => $da
		);

		echo json_encode($data);

	}
	
	
	public function loadDashboard() {
		$conds = '';
		$usrcd = $this->session->userdata('usrcd');
		$usrty = $this->session->userdata('user_type');
		$group = $this->session->userdata('group_user');
		

		if($usrty == 'KAB' || $usrty == 'PRO'){ // 
			$conds .= "AND pinjaman.group_user='$group' ";
		}

		// autoclose 3 hari jika tidak diproses
		$this->autoReject3days();

		$SQL = "SELECT pinjaman.wfnum, pinjaman.group_user, pinjaman.docnumber, pinjaman.doctgl, wf_status.stsnm, pinjaman.tgl_surat, pinjaman.hari_booking, pinjaman.zdate, pinjaman.hari_kerja,
		(SELECT jangka_waktu_pinjam FROM dscr_pp WHERE wfnum=pinjaman.wfnum ORDER BY ktg_id DESC LIMIT 1) as tenor,
		(SELECT rencana_usulan_pinjaman FROM dscr_pp WHERE wfnum=pinjaman.wfnum ORDER BY ktg_id DESC LIMIT 1) as jumlah
		FROM pinjaman 
		JOIN wf_status ON pinjaman.curst=wf_status.stscd
		WHERE 1=1 AND pinjaman.curst NOT IN ('RNA1') $conds 
		ORDER BY pinjaman.doctgl DESC";
		$query = $this->db->query($SQL);

		$data = array();
		$no = 1;
		$peringatan='';
		
		foreach($query->result() as $row)
		{

			/*
			Peringatan Dini adalah indikator bagi petugas, 
			agar segera menyelesaikan surat pertimbangan Mendagri
			2 hari sebelum hari ke 11 diajukan ke Mendagri

			 Masa Ideal penyampaian surat pertimbangan final ke Mendagri yaitu hari ke 11
			 Peringatan dini Aktif, 2 hari sebelum ke Menteri yaitu hari ke 9		  		 
			 */	
			$sisabooking=$this->Pinjaman_model->number_of_booking_days($row->tgl_surat,$row->hari_booking); 
			$sisahari=$this->Pinjaman_model->number_of_working_days($row->tgl_surat,$row->hari_kerja);
			if(in_array($sisahari,array(1,2,3,4,5,6,7)))
			{ //boolean = true
				$peringatan='<span style="color:red;"><i class="splashy-warning_triangle"></i> Deadline</span>';
			}


			//deteksi nilai hari booking
			if($sisabooking != '0')
			{
				$sisabooking=$sisabooking.' Hari Lagi';
			}
			else
			{
				$sisabooking='';
			}

			//deteksi nilai hari kerja
			if($sisahari != '0')
			{
				$sisahari=$sisahari.' Hari Lagi';
			}
			else
			{
				$sisahari='';
			}

			//cari nama daerah
			$nmdaerah=$row->group_user;
			$SQL_daerah = "SELECT m_daerah.id, m_daerah.namakab 
					FROM m_daerah 
					WHERE m_daerah.id = $nmdaerah";
			$q_daerah = $this->db->query($SQL_daerah);

			foreach($q_daerah->result() as $r_daerah)
			{

				$data[] = array(
					"no" => $no++,
					"wfnum" => $row->wfnum,
					"group_user" => $r_daerah->namakab,
					"docnumber" => $row->docnumber,
					"doctgl" => date('d/M/Y', strtotime($row->doctgl)),
					"stsnm" => $row->stsnm,
					"tenor" => (int) $row->tenor,
					"jumlah" => number_format($row->jumlah,0),
					"zdate" => $sisabooking,
					'workdays' => $sisahari,
					"deadline" => $peringatan
				);
			}
			$peringatan='';
		}

		$resultObj = $data;

		header("Content-type:application/json");
		echo json_encode($resultObj);
	}

	public function loadDashboardDetail() {
		$wfnum = $this->input->post('wfnum');
		$resultObj = $this->Pinjaman_model->getHistory($wfnum);

		header("Content-type:application/json");
		echo json_encode($resultObj);
	}

	public function autoReject3days() {
		$SQL = "SELECT wfnum,(zdate + INTERVAL 3 DAY) as habis, zdate,
		CASE WHEN CURRENT_DATE > (zdate + INTERVAL 3 DAY) THEN 'EXPIRE'
		ELSE 'OK' END as status
		FROM pinjaman where curst='RNB1'";
		$query = $this->db->query($SQL);
		
		foreach($query->result() as $row){
			if($row->status == 'EXPIRE'){
				$this->db->update('pinjaman',array('curst'=>'RNXX'),array("wfnum"=>$row->wfnum ) );
			}
		}
	}
}