<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
		$this->load->model('Global_model');
		$this->load->model('Profile_model');
    }

    public function index(){
        $this->auth->checkAdmin();
        $data['content'] = 'profile/selection_daerah';
		$this->load->view('layout2',$data);
    }

    public function pusat(){
        $data['content'] = 'profile/selection_pusat';
		$this->load->view('layout2',$data);
    }

    function loadAllUsers(){
        $mode = $this->input->post('mode');
        $resultObj = $this->Profile_model->getloadAllUsers($mode);
        echo $this->withJson($resultObj);
    }

    function detail(){
        $role = $this->uri->segment(3);

        if($role == 'kabkot'){
            $data['usrcd'] = $this->uri->segment(4);
            $data['content'] = 'profile/usr_daerah';
		    $this->load->view('layout2',$data);
        }
        if($role == 'pusat'){
            $data['usrcd'] = $this->uri->segment(4);
            $data['content'] = 'profile/usr_pusat';
		    $this->load->view('layout2',$data);
        }
    }

    function usersadd() {
        $data['content'] = 'profile/usr_pusat';
		$this->load->view('layout2',$data);
    }

    function getDataUsers(){
        $resultObj = $this->Profile_model->getDataUsersByID();
        echo $this->withJson($resultObj);
    }

    function changepassword(){
        $data['content'] = 'cpassword';
		$this->load->view('layout2',$data);
    }

    function savedata() {

		$this->form_validation->set_rules('nama_lengkap','Name Langkap','required|xss_clean');
        $this->form_validation->set_rules('jabatan','Jabatan','required|xss_clean');
        $this->form_validation->set_rules('email','Email','required|xss_clean');
        $this->form_validation->set_rules('telepon','Telepon','required|xss_clean');

		
		if($this->form_validation->run() == TRUE)
		{
            $saved = $this->Profile_model->savedata();    
            $status = 0;
            $message = 'Profile Berhasil Diupdate';
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

    function savedatapusat() {

		$this->form_validation->set_rules('nama_lengkap','Name Langkap','required|xss_clean');
        $this->form_validation->set_rules('jabatan','Jabatan','required|xss_clean');
        $this->form_validation->set_rules('email','Email','required|xss_clean');
        $this->form_validation->set_rules('telepon','Telepon','required|xss_clean');

		
		if($this->form_validation->run() == TRUE)
		{
            $saved = $this->Profile_model->savedatapusat();    
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
		echo $this->withJson($resultObj);	
    }


    function proseschangepassword() {
		$this->form_validation->set_rules('oldpass','Password Lama','required|xss_clean');
        $this->form_validation->set_rules('newpass','Password Baru','required|xss_clean');
        $this->form_validation->set_rules('ulapass', 'Password Confirmation', 'trim|required|matches[newpass]');
		
		if($this->form_validation->run() == TRUE)
		{
            $cek['usrcd']    = $this->session->userdata('usrcd');
            $cek['password'] = md5($this->input->post('oldpass').$this->config->item("key_login"));
            $cek_login       = $this->db->get_where('users', $cek);
            
            if(count($cek_login->result())>0) {   
                $this->db->update('users',array("password"=>md5($this->input->post('newpass').$this->config->item("key_login"))), array("usrcd"=>$cek['usrcd']));
                
                $status = 0;
                $message = 'Password berhasil dirubah';
                $notif = $this->Global_model->getNotif($status,$message);
                $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
            }else{
                $status = 1;
                $message = 'Password lama salah';
                $notif = $this->Global_model->getNotif($status,$message);
                $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
            }
			
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