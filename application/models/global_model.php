<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Global_model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	function konversi_number($n) {

        // first strip any formatting;
        $n = (0+str_replace(",","",$n));
        
        // is this a number?
        if(!is_numeric($n)) return false;
        
        // now filter it;
        //if($n>1000000000000) return round(($n/1000000000000),1); // Triliun
        if($n>1000000000) return round(($n/1000000000),1); // Milyar
        else if($n>1000000) return round(($n/1000000),1); // Juta
        else if($n>1000) return round(($n/1000),1); // Ribu
        
        return number_format($n);
	}
	
	function ButtonWorkflow($wfcat,$lssta) {
		$this->db->where('wfcat', $wfcat);
		$this->db->where('curst', $lssta);
		$this->db->like('usrty', $this->session->userdata('user_type')); 
		$query = $this->db->get('wf_button');
		$html = '<button class="btn btn-sm btn-default" onclick="authButton('."'".'BTN_BACK_SELECT'."'".');"><i class="splashy-arrow_medium_left"></i>&nbsp;Kembali Ke Menu</button>&nbsp;';
		foreach ($query->result() as $row) {
			$html .= '<button class="btn btn-sm btn-default" onclick="authButton('."'".$row->butmo."'".','."'".$row->curst."'".','."'".$row->nexst."'".','."'".$row->iscls."'".','."'".$row->isrea."'".');" id="'.$row->butmo.'"><i class="'.$row->btnic.'"></i>&nbsp;&nbsp;'.$row->buttx.'</button>&nbsp;';
		}
		return $html;
	}
	
	function getRegion() {
    	$query = "Select DISTINCT kode_region,nama_region from mapping ORDER BY kode_region";
		$arr = $this->db->query($query);
		return $arr;
	}

	function getDateHistoryAction($wfnum,$stscd){
		$SQL = "SELECT * FROM wf_history where wfnum='$wfnum' AND to_status='$stscd' ORDER BY zdate,ztime DESC LIMIT 1";
		$query = $this->db->query($SQL);
		$row = $query->row();
		return date('d/m/Y', strtotime($row->zdate));
	}

	function getNotif($status,$message) {
		if($status == 0){
			$type = 'success';
			$title = 'SUCESS';
		}else{
			$type = 'danger';
			$title = 'ERROR!';
		}
		$html = '';
		$html = '<div class="alert alert-'.$type.' alert-dismissable fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>'.$title.'</strong> '.$message.'
				</div>';
		return $html;
	}

	function otorisasiUserPRO($usrcd){
		$data = array();
		$SQL = "SELECT b.* FROM m_daerah a LEFT JOIN m_daerah b ON a.kodeprov=b.kodeprov WHERE a.id='$usrcd'";
		$query = $this->db->query($SQL);
		foreach($query->result() as $row){
			$data[] = $row->id;
		}
		return $data;
	}

	function otorisasiUserKEM($usrcd){
		$data = array();
		$SQL = "SELECT * FROM operator a JOIN m_daerah b ON a.prov=b.wilayah WHERE a.usrcd='$usrcd'";
		$query = $this->db->query($SQL);
		foreach($query->result() as $row){
			$data[] = $row->id;
		}
		return $data;
	}

	function loadTableItems($code){

		switch ($code) {

			case 'KP01':
				$table = 'tblRancanganPerda';
				break;

			case 'PR01':
				$table = 'tblMatrikEvaluasiRanperda';
				break;
			
			default:
				$table = '';
				break;
		}

		return $table;
		
	}

	function getYear($wfnum){
        $doc = $this->db->get_where('pinjaman', array("wfnum" => $wfnum ))->row();
        $year = $doc->realisasi_ta;
        $data = array (
            "y1" => $year-2,
            "y2" => $year-1,
            "y3" => $year,
        );
        return $data;
	}
	
	function getkabkot($wfnum){
		$SQL = "SELECT b.namakab FROM pinjaman a JOIN m_daerah b ON a.group_user=b.id where wfnum='$wfnum'";
		$query = $this->db->query($SQL);
		$row = $query->row();
		return $row->namakab;
	}

}