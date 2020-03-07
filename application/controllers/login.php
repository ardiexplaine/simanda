<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model','',TRUE);
		$this->load->model('Global_model');
		$this->load->model('Profile_model');
		$this->load->library('session');
	}

	public function index() {	
		$this->load->view('login');
	}

	public function reg() {	
		if($this->session->userdata('regis') == TRUE){
			$this->load->view('regis');
		}else{
			redirect(base_url(),'refresh');
		}
		
	}

	public function process() {
		$this->form_validation->set_rules('username','Username','required|xss_clean');
		$this->form_validation->set_rules('password','Password','required|xss_clean');
		
		if($this->form_validation->run() == TRUE)
		{	
			$data['username']	=	$this->input->post("username");
			$data['password']	=	$this->input->post("password");
			$this->login_model->cek_login($data);
		}else{
			$this->load->view('login');
		}
		
	}

	function savereg() {

		if($this->session->userdata('regis') == TRUE) {
			$this->form_validation->set_rules('usrcd','User ID','required|xss_clean');
			$this->form_validation->set_rules('nama_lengkap','Name Langkap','required|xss_clean');
			$this->form_validation->set_rules('jabatan','Jabatan','required|xss_clean');
			$this->form_validation->set_rules('email','Email','required|xss_clean');
			$this->form_validation->set_rules('telepon','Telepon','required|xss_clean');

			
			if($this->form_validation->run() == TRUE)
			{
				$saved = $this->Profile_model->savedataRegis();    
				$status = 0;
				$message = 'Profile Berhasil Diupdate';
				$notif = $this->Global_model->getNotif($status,$message);
				$resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif, "result"=> $saved);
				
			}else{
				$status = 1;
				$message = strip_tags(validation_errors());
				$notif = $this->Global_model->getNotif($status,$message);
				$resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
			}
			echo json_encode($resultObj);	
		}
    }

	function logout()
	{	
		$this->session->sess_destroy();
		redirect(base_url(),'refresh');
	}
}
