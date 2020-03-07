<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Urusan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkAdmin();
		$this->load->model('Global_model');
	}

	public function index() {	
		$data['content'] = 'urusan/table';
		$this->load->view('layout2',$data);
	}

	public function create() {	
		$data['content'] = 'urusan/form';
		$this->load->view('layout2',$data);
	}

	public function change($id) {
		$data['rowdata'] = $this->db->get_where('m_urusan', array("urusan_id"=>$id))->row();	
		$data['content'] = 'urusan/form';
		$this->load->view('layout2',$data);
	}

	public function store() {
		
		$this->form_validation->set_rules('urusan','Nama Urusan','required|xss_clean');
		
		$ursrow = array(
			"urusan_id"=>$this->input->post("urusan_id"),
			"urusan"=> $this->input->post("urusan"),
		);
		

		if($this->form_validation->run() == TRUE)
		{
            if($this->input->post("urusan_id")==""){
				$this->db->insert('m_urusan',$ursrow);
			}else{
				$this->db->update('m_urusan',$ursrow,array("urusan_id"=>$this->input->post("urusan_id")));
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
	
	function loadAllUrusan(){

		$SQL = "SELECT * FROM m_urusan ORDER BY urusan_id ASC";
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"urusan_id" => $row->urusan_id,
				"urusan" => "<a href='#'>".$row->urusan."</a>"
			);
		}
        echo $this->withJson($data);
    }

	function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}