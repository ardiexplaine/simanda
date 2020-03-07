<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daerah extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkAdmin();
		$this->load->model('Global_model');
	}

	public function index() {	
		$data['content'] = 'daerah/table';
		$this->load->view('layout2',$data);
	}

	public function create() {	
		$data['content'] = 'daerah/form';
		$this->load->view('layout2',$data);
	}

	public function change($id) {
		$data['rowdata'] = $this->db->get_where('m_daerah', array("id"=>$id))->row();	
		$data['content'] = 'daerah/form';
		$this->load->view('layout2',$data);
	}

	public function store() {
		
		$this->form_validation->set_rules('namakab','Nama Daerah','required|xss_clean');
		
		$ursrow = array(
			"id"=>$this->input->post("id"),
			"namakab"=> $this->input->post("namakab"),
			"kdprov"=> $this->input->post("kdprov"),
			"kdkabkota"=> $this->input->post("kdkabkota"),
		);
		

		if($this->form_validation->run() == TRUE)
		{
            if($this->input->post("id")==""){
				$this->db->insert('m_daerah',$ursrow);
			}else{
				$this->db->update('m_daerah',$ursrow,array("id"=>$this->input->post("id")));
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
	
	function loadAllDaerah(){

		$SQL = "SELECT * FROM m_daerah ORDER BY id ASC";
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"id" => $row->id,
				"namakab" => "<a href='#'>".$row->namakab."</a>",
				"kdprov" => $row->kdprov,
				"kdkabkota" => $row->kdkabkota
			);
		}
        echo $this->withJson($data);
    }

	function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}