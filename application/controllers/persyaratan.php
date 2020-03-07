<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persyaratan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkAdmin();
		$this->load->model('Global_model');
	}

	public function index() {	
		$data['content'] = 'persyaratan/table';
		$this->load->view('layout2',$data);
	}

	public function create() {	
		$data['content'] = 'persyaratan/form';
		$this->load->view('layout2',$data);
	}

	public function change($id) {
		$data['rowdata'] = $this->db->get_where('m_persyaratan', array("persyaratan_id"=>$id))->row();	
		$data['content'] = 'persyaratan/form';
		$this->load->view('layout2',$data);
	}

	public function store() {
		
		$this->form_validation->set_rules('persyaratan_name','Jenis Persyaratan','required|xss_clean');
		
		$persyaratan = array(
			"persyaratan_id"=>$this->input->post("persyaratan_id"),
			"persyaratan_name"=> $this->input->post("persyaratan_name"),
			"isactive" =>$this->input->post("isactive"),
		);
		

		if($this->form_validation->run() == TRUE)
		{
            if($this->input->post("persyaratan_id")==""){
				$this->db->insert('m_persyaratan',$persyaratan);
			}else{
				$this->db->update('m_persyaratan',$persyaratan,array("persyaratan_id"=>$this->input->post("persyaratan_id")));
			}

            $status = 0;
            $message = 'Data Berhasil Disimpan';			
		}else{
			$status = 1;
			$message = strip_tags(validation_errors());
		}

		$notif = $this->Global_model->getNotif($status,$message);
        $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
		echo $this->withJson($resultObj);	
		
	}
	
	function loadAllPersyaratan(){

		$SQL = "SELECT * FROM m_persyaratan ORDER BY persyaratan_id ASC";
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"persyaratan_id" => $row->persyaratan_id,
				"persyaratan_name" => "<a href='#'>".$row->persyaratan_name."</a>",
				"isactive" => $row->isactive
			);
		}
        echo $this->withJson($data);
    }

	function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}