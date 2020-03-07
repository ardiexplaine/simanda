<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkAdmin();
		$this->load->model('Global_model');
	}

	public function index() {	
		$data['content'] = 'status/table';
		$this->load->view('layout2',$data);
	}

	public function create() {	
		$data['content'] = 'status/form';
		$this->load->view('layout2',$data);
	}

	public function change($id) {
		$data['rowdata'] = $this->db->get_where('wf_status', array("stssq"=>$id))->row();	
		$data['content'] = 'status/form';
		$this->load->view('layout2',$data);
	}

	public function store() {
		
		$this->form_validation->set_rules('stsnm','Nama Status','required|xss_clean');
		
		$stsrow = array(
			"stssq"=>$this->input->post("stssq"),
			"stsnm"=> $this->input->post("stsnm"),
		);
		

		if($this->form_validation->run() == TRUE)
		{
            if($this->input->post("stssq")==""){
				$this->db->insert('wf_status',$stsrow);
			}else{
				$this->db->update('wf_status',$stsrow,array("stssq"=>$this->input->post("stssq")));
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
	
	function loadAllStatus(){

		$SQL = "SELECT * FROM wf_status ORDER BY stssq ASC";
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"stssq" => $row->stssq,
				"stsnm" => "<a href='#'>".$row->stsnm."</a>"
			);
		}
        echo $this->withJson($data);
    }

	function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}