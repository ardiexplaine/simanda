<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporan extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
		$this->load->model('Global_model');
		$this->load->model('Pinjaman_model');
	}

	function addlaporan() {
		$filetype = array();
		$wfnum = $this->input->post('wfnum');
		$title = $this->input->post("title");
		$filenm = $this->input->post("filenm");

		$filetype = array('pdf');
		$file1 = $this->do_upload($filetype,'fileid');
		if($file1["status"]==0) {

			
			$data = array(
				"wfnum"=> $wfnum,
				"title" => $title,
				"original_name"=> $file1["upload_data"]["orig_name"],
				"encrypt_name" => $file1["upload_data"]["file_name"],
				"zdate" => date('Y-m-d h:i:s'),
				"status" => 'N',
				"lokasi" => $file1["lokasi"]
			);
			$this->db->insert('t_laporan_komulatif', $data);
			
			$status = 0;
			$message = 'ok';

			$resultObj = array('status'=>$status, "message"=>$message);
		}else{
			$status = 1;
			$message = 'Data Not Found!';
			$notif = $this->Global_model->getNotif(1,"Data tidak ditemukan");
			$resultObj = array('status'=>$status, "message"=>$message, "notif"=>$notif);
		}
		echo $this->withJson($resultObj);
	}

	function loadtable(){
		$wfnum = $this->input->post('wfnum');

		$html = '';

		$SQL = "SELECT * FROM t_laporan_komulatif WHERE wfnum = '$wfnum' ORDER BY laporan_id ASC";
		$query = $this->db->query($SQL);
		if($query->num_rows() > 0){
			$ctg = $this->Pinjaman_model->getdesc('pinjaman','wfcat',array("wfnum"=>$wfnum));

			$ryear = $this->Global_model->getYear($wfnum);
			if($ctg == 'WF01') {
				$html .= '<div class="col-lg-10">';

				
					
					// $btn = $this->Pinjaman_model->getdesc('pinjaman','curst',array("wfnum"=>$wfnum));
					// if(($btn == "RNA1" || $btn == "RNB1" || $btn == "RNBX")){
						$disabled = '';
					// }else{
					// 	$disabled = 'disabled="disabled"';
					// }

					$html .= '<table class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th style="width: 60%;">Judul Laporan Semesteran</th>
								<th style="width: 30%;">Dokumen Laporan</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
                    $no = 1;
					foreach($query->result() as $row) {
					$html .='<tr class="rowlink" data-placement="bottom" data-container="body">
								<td>'.$no.'</td>
								<td>'.$row->title.'</td>
								<td><a href="'.base_url('laporan/push_file/'.$row->laporan_id).'"> '.$row->original_name.'</a></td>
								<td></td>
                            </tr>';     
                        $no++;
                    }
					
					$html .='</tbody></table>';

				$html .= '</div>';
			}
		}

		echo json_encode(array('status'=>1, "message"=>'ok', "html"=>$html));
		
	}
	
    function savedata() {

		$this->form_validation->set_rules('tab1_rencana_pinjaman','Rencana Pinjaman','required|xss_clean');

        $item_dscr_pp = array(

			"wfnum"  => $this->input->post("txtWfnum"),
			"ktg_id" => $this->ktgid,
			"rencana_pinjaman" => str_replace(",","", $this->input->post("tab1_rencana_pinjaman")),
			"sisa_pinjaman" => str_replace(",","", $this->input->post("tab1_sisa_pinjaman")),
			"pendapatan_daerah" => str_replace(",","", $this->input->post("tab1_pendapatan_daerah")),
			"dak" => str_replace(",","", $this->input->post("tab1_dak")),
			"dana_darurat" => str_replace(",","", $this->input->post("tab1_dana_darurat")),
			"dana_penyesuaian" => str_replace(",","", $this->input->post("tab1_dana_penyesuaian"))
        );

		
		if($this->form_validation->run() == TRUE)
		{
			$query = $this->db->get_where("dscr_pp", array("wfnum"=>$this->input->post("txtWfnum")));
			if($query->num_rows()>0){
				$this->db->update('dscr_pp', $item_dscr_pp, array("wfnum"=>$this->input->post("txtWfnum")) );
			}else{
				$this->db->insert('dscr_pp', $item_dscr_pp);
			}
            
            $status = 0;
            $message = 'Data Berhasil Disave';
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
	
	public function do_upload($ext_allow,$objName) {
		$dir = date('Ym');
		$tujuan_upload = './assets/uploads/'.$dir;
		if (!file_exists($tujuan_upload)) {
			mkdir("./assets/uploads/" . $dir, 0777);
		} 
		$config['upload_path']   = $tujuan_upload; 
		$config['allowed_types'] = implode("|",$ext_allow);
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($objName)) {
			if(isset($_FILES[$objName]['name'])){
				$status = 1;
				$message = strip_tags($this->upload->display_errors());
				$resultObj = array('status'=> $status, 'message' => $message, 'notif' =>  $this->Global_model->getNotif($status,$message) ); 
				echo json_encode($resultObj);
				exit();
			}else{
				$status = array('status'=>1, 'message' => 'ok');
			}
			
		}else { 
		   $status = array('status'=>0, 'message' => 'ok', 'upload_data' => $this->upload->data(), 'lokasi' => $tujuan_upload); 
		}
		return $status;
	}

	function push_file($id)
    {
		$query = $this->db->get_where("t_laporan_komulatif", array("laporan_id"=>$id));

		$row = $query->row();
		  // make sure it's a file before doing anything!
		$path = $row->lokasi.'/'.$row->encrypt_name; 
     	if(is_file($path))
      	{
			// required for IE
			if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

			// get the file mime type using the file extension
			$this->load->helper('file');

			$mime = get_mime_by_extension($path);

			// Build the headers to push out the file properly.
			header('Pragma: public');     // required
			header('Expires: 0');         // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
			header('Content-Disposition: attachment; filename="'.basename($row->original_name).'"');  // Add the file name
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($path)); // provide file size
			header('Connection: close');
			readfile($path); // push it out
			exit();
		}
	}

    function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}