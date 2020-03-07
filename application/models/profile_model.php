<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Profile_model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	function getloadAllUsers($mode){

		if($mode == 'KAB'){
			$SQL = "SELECT a.*,b.namakab FROM users a JOIN m_daerah b ON a.group_user=b.id WHERE user_type!='KEM'";
		}

		if($mode == 'PUSAT'){
			$SQL = "SELECT *,'' as namakab FROM users WHERE user_type='KEM' AND usrcd!='USB1636UCP'";
		}
		
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"usrcd" => $row->usrcd,
				"nama_lengkap" => $row->nama_lengkap,
				"username" => $row->username,
				"jabatan" => $row->jabatan,
				"email" => $row->email,
				"telepon" => $row->telepon,
				"status" => $row->aktif,
				"daerah" => $row->namakab,
				"group_user" => $row->group_user
			);
		}
		return $data;
	}

	function getDataUsersByID(){

		$usrcd = $this->input->post('txtusrcd');

		$SQL = "SELECT a.*,b.namakab FROM users a LEFT JOIN m_daerah b ON a.group_user=b.id WHERE a.usrcd='$usrcd'";
		$query = $this->db->query($SQL);
		$row = $query->row();
		$data = array(
			"usrcd" => $row->usrcd,
			"nama_lengkap" => $row->nama_lengkap,
			"username" => $row->username,
			"jabatan" => $row->jabatan,
			"email" => $row->email,
			"telepon" => $row->telepon,
			"fax" => $row->fax,
			"status" => $row->aktif,
			"superadmin" => $row->superadmin,
			"daerah" => $row->namakab
		);
		return $data;
	}

	function savedataRegis(){
		$data = array(
			"nama_lengkap" => $this->input->post('nama_lengkap'),
			"jabatan" => $this->input->post('jabatan'),
			"email" => $this->input->post('email'),
			"telepon" => $this->input->post('telepon'),
			"fax" => $this->input->post('fax'),
			"aktif" => 'Y'
		);
		$this->db->update('users',$data, array('usrcd'=>$this->input->post('usrcd')));

		$zuser = $this->db->get_where('users',array('usrcd'=>$this->input->post('usrcd')));
		$row = $zuser->row();
		$sess_data['usrcd'] 	   = $row->usrcd;
		$sess_data['nama_lengkap'] = $row->nama_lengkap;
		$sess_data['username'] 	   = $row->username;
		$sess_data['group_user']   = $row->group_user;
		$sess_data['user_type']    = $row->user_type;
		$sess_data['level']    	   = $row->superadmin;
		$sess_data['login']        = TRUE;
		$this->session->set_userdata($sess_data);
	}

	function savedata(){
		if($this->input->post('password') == ''){
			$data = array(
				"nama_lengkap" => $this->input->post('nama_lengkap'),
				"username" => $this->input->post('username'),
				"jabatan" => $this->input->post('jabatan'),
				"email" => $this->input->post('email'),
				"telepon" => $this->input->post('telepon'),
				"fax" => $this->input->post('fax'),
				"aktif" => $this->input->post('aktif')
			);
		}else{
			$data = array(
				"nama_lengkap" => $this->input->post('nama_lengkap'),
				"username" => $this->input->post('username'),
				"jabatan" => $this->input->post('jabatan'),
				"email" => $this->input->post('email'),
				"telepon" => $this->input->post('telepon'),
				"fax" => $this->input->post('fax'),
				"aktif" => $this->input->post('aktif'),
				"password" => md5($this->input->post('password').$this->config->item("key_login"))
			);
		}
		$this->db->update('users',$data,array('usrcd'=>$this->input->post('usrcd')));
	}

	function savedataPusat(){

		if($this->input->post('usrcd')!=''){
			$usrcd = $this->input->post('usrcd');
			if($this->input->post('password') == ''){
				$data = array(
					"nama_lengkap" => $this->input->post('nama_lengkap'),
					"username" => $this->input->post('username'),
					"jabatan" => $this->input->post('jabatan'),
					"email" => $this->input->post('email'),
					"telepon" => $this->input->post('telepon'),
					"fax" => $this->input->post('fax'),
					"aktif" => $this->input->post('aktif'),
					"superadmin" => $this->input->post('superadmin')
				);
			}else{
				$data = array(
					"nama_lengkap" => $this->input->post('nama_lengkap'),
					"username" => $this->input->post('username'),
					"jabatan" => $this->input->post('jabatan'),
					"email" => $this->input->post('email'),
					"telepon" => $this->input->post('telepon'),
					"fax" => $this->input->post('fax'),
					"aktif" => $this->input->post('aktif'),
					"password" => md5($this->input->post('password').$this->config->item("key_login")),
					"superadmin" => $this->input->post('superadmin')
				);
			}
			$this->db->update('users',$data,array('usrcd'=>$usrcd));
		}else{
			$usrcd = 'USR'.strtoupper(substr(str_shuffle(MD5(microtime())), 0, 7));
			$data = array(
				"usrcd" => $usrcd,
				"nama_lengkap" => $this->input->post('nama_lengkap'),
				"username" => $this->input->post('username'),
				"jabatan" => $this->input->post('jabatan'),
				"email" => $this->input->post('email'),
				"telepon" => $this->input->post('telepon'),
				"fax" => $this->input->post('fax'),
				"aktif" => $this->input->post('aktif'),
				"password" => md5($this->input->post('password').$this->config->item("key_login")),
				"superadmin" => $this->input->post('superadmin'),
				"user_type" => 'KEM'
			);
			$this->db->insert('users',$data);
			// print_r($data);
			// exit();
		}

		$load = $this->db->get_where('users',array("usrcd"=>$usrcd));
		return $load->row();		
		
	}

	function getdesc($table,$cols,$where){
		if(is_array($where)){
			$data = $this->db->get_where($table, $where);
			$row = $data->row();
			return $row->$cols;
		}
		return '';
	}

	function slcJenisStatus() {
		$html = '<option value="">- Semua Data</option>';
		$query = $this->db->get('wf_status');	
		foreach ($query->result() as $row) {
			$html .= '<option value="'.$row->stscd.'">'.$row->stscd.' - '.$row->stsnm.'</option>';
		}
		return $html;
	}

}