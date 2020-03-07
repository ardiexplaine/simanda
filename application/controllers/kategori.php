<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkAdmin();
		$this->load->model('Global_model');
	}

	public function index() {	
		$data['content'] = 'kategori/table';
		$this->load->view('layout2',$data);
	}

	public function create() {	
		$data['content'] = 'kategori/form';
		$this->load->view('layout2',$data);
	}

	public function change($id) {
		$data['rowdata'] = $this->db->get_where('m_kategori', array("ktg_id"=>$id))->row();	
		$data['content'] = 'kategori/form';
		$this->load->view('layout2',$data);
	}

	public function store() {
		
		$this->form_validation->set_rules('kategori','Nama Kategori','required|xss_clean');
		
		$ursrow = array(
			"ktg_id"=>$this->input->post("ktg_id"),
			"kategori"=> $this->input->post("kategori"),
		);
		

		if($this->form_validation->run() == TRUE)
		{
            if($this->input->post("ktg_id")==""){
				$this->db->insert('m_kategori',$ursrow);
			}else{
				$this->db->update('m_kategori',$ursrow,array("ktg_id"=>$this->input->post("ktg_id")));
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
	
	function loadAllKategori(){

		$SQL = "SELECT * FROM m_kategori ORDER BY ktg_id ASC";
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"ktg_id" => $row->ktg_id,
				"kategori" => "<a href='#'>".$row->kategori."</a>"
			);
		}
        echo $this->withJson($data);
    }

	function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}