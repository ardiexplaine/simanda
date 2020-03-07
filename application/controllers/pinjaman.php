<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Pinjaman extends CI_Controller {

	public $module;

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
		$this->load->model('Global_model');
		$this->load->model('Pinjaman_model');
		$this->module = "pinjaman";
	}

	public function index() {	
		$data['content'] = $this->module.'/selection';
		$this->load->view('layout2',$data);
	}

	public function create() {	
		$data['content'] = $this->module.'/form';
		$this->load->view('layout2',$data);
	}

	public function view() {
		$data['wfnum'] = $this->uri->segment(3);
		$data['content'] = $this->module.'/form';
		$this->load->view('layout2',$data);
	}

	public function dscr() {
		$data['wfnum'] = $this->uri->segment(3);
		$data['ryear'] = $this->Global_model->getYear($data['wfnum']);
		$data['content'] = $this->module.'/form-dscr';
		$this->load->view('layout2',$data);
	}

	public function pertimbangan() {
		$data['wfnum'] = $this->uri->segment(3);
		$data['ryear'] = $this->Global_model->getYear($data['wfnum']);
		$data['content'] = $this->module.'/form-pertimbangan';
		$this->load->view('layout2',$data);
	}

	public function laporan() {
		$data['wfnum'] = $this->uri->segment(3);
		$data['ryear'] = $this->Global_model->getYear($data['wfnum']);
		$data['content'] = $this->module.'/form-laporan';
		$this->load->view('layout2',$data);
	}

	public function change($id) {
		$data['rowdata'] = $this->db->get_where('m_persyaratan', array("persyaratan_id"=>$id))->row();	
		$data['content'] = 'persyaratan/form';
		$this->load->view('layout2',$data);
	}

	public function saveData() {

		$wfnum = $this->input->post('wfnum');
		$nexst = $this->input->post('nexst');
		$butmo = $this->input->post('butmo');

		if($this->validationData($wfnum, $nexst)) { // Blok Role Vlidasi Form

			$this->form_validation->set_rules('docnumber','Nomor Dokumen','required|xss_clean');
			$this->form_validation->set_rules('doctgl','Tanggal Dokumen','required|xss_clean');
		
			if($butmo == "BTN_SAVE_DATA"){
				$hari3 = date('Y-m-d',strtotime(date('Y-m-d').' +2 Weekday'));
				$pinjaman = array(
					"wfnum"=>$this->input->post("wfnum"),
					"docnumber"=> $this->input->post("docnumber"),
					"doctgl" =>$this->input->post("doctgl"),
					"curst" =>$this->input->post("curst"),
					"zuser" =>$this->session->userdata('usrcd'),
					"group_user" =>$this->session->userdata('group_user'),
					"wfcat" => 'WF01',
					"zdate" => date("Y-m-d"),
					"hari_booking" => $hari3,
					"realisasi_ta" => $this->input->post("realisasi_ta")
				);
			} else {
				$pinjaman = array(
					"wfnum"=>$this->input->post("wfnum"),
					"docnumber"=> $this->input->post("docnumber"),
					"doctgl" =>$this->input->post("doctgl"),
					"curst" =>$this->input->post("curst"),
					"zdate" => date("Y-m-d"),
					"realisasi_ta" => $this->input->post("realisasi_ta"),
					"surat_mendagri" =>$this->input->post("surat_mendagri"),
					"tgl_surat" =>$this->input->post("tgl_surat")
				);

				// 

				if($butmo == "BTN_APPROVED"){
					$hari15 = date('Y-m-d',strtotime(date('Y-m-d').' +14 Weekday'));
					$this->db->update('pinjaman',array('hari_kerja'=>$hari15),array("wfnum"=>$wfnum));
				}
			}	

			if($this->form_validation->run() == TRUE)
			{
				$wfnum = $this->input->post("wfnum");
				$SQL = "SELECT wfnum FROM pinjaman WHERE 1=1 AND wfnum='$wfnum'";
				$query = $this->db->query($SQL);
				if($query->num_rows()>0){
					$this->db->update('pinjaman',$pinjaman,array("wfnum"=>$wfnum));
				}else{
					$this->db->insert('pinjaman',$pinjaman);
				}


				// input History
				$history = array(
					"wfnum"=> $wfnum,
					"zdate" => date('Y-m-d'),
					"ztime" => date('H:i:s'),
					"zuser" => $this->session->userdata('usrcd'),
					"from_status"=> $this->input->post("curst"),
					"to_status" => $this->input->post("nexst"),
					"reason" => ''
				);
				$cekHis = $this->db->get_where('wf_history', array('wfnum' => $wfnum, "from_status"=> $this->input->post("curst"), "to_status" => $this->input->post("nexst")));
				if($cekHis->num_rows() == 0){
					$this->db->insert('wf_history', $history);
				}else{
					$this->db->update('wf_history', $history, array('wfnum' => $wfnum, "from_status"=> $this->input->post("curst"), "to_status" => $this->input->post("nexst")));
				}
				

				if($this->input->post('nexst') != ''){
					$this->db->update('pinjaman',array("curst"=>$this->input->post('nexst')), array("wfnum"=>$wfnum));
				}

				$status = 0;
				$message = 'Data Berhasil Disimpan';			
			}else{
				$status = 1;
				$message = strip_tags(validation_errors());
			}

		}else{
			$status = 1;
			$message = "Harap melengkapi dokumen persyaratan dengan lengkap, untuk meneruskan ke proses selanjutnya!";
		}

		$notif = $this->Global_model->getNotif($status,$message);
        $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
		echo $this->withJson($resultObj);	
		
	}


	public function uploadData() {

		$filetype = array();
		$wfnum = $this->input->post('wfnum');
		$nexst = $this->input->post('nexst');

		if($this->validationData($wfnum, $nexst)) { // Blok Role Vlidasi Form

			$this->form_validation->set_rules('docnumber','Nomor Dokumen','required|xss_clean');
			$this->form_validation->set_rules('doctgl','Tanggal Dokumen','required|xss_clean');
			$this->form_validation->set_rules('surat_mendagri','Nomor Surat Mendagri','required|xss_clean');
		

			$filetype = array('pdf','doc','docx','xls','xlsx');
			$file1 = $this->do_upload($filetype,'fileSurat');
			
			if($file1["status"]==0) {

				$this->form_validation->set_rules('surat_mendagri','Surat Mendagri','required|xss_clean');

				$pinjaman = array(
					"wfnum"=>$this->input->post("wfnum"),
					"curst" =>$this->input->post("curst"),
					"surat_mendagri" =>$this->input->post("surat_mendagri"),
					"tgl_surat" =>$this->input->post("tgl_surat"),
					"file_mendagri_original" => $file1["upload_data"]["orig_name"],
					"file_mendagri_encrypt" => $file1["upload_data"]["file_name"]
				);

			}else{

				$pinjaman = array(
					"wfnum"=>$this->input->post("wfnum"),
					"curst" =>$this->input->post("curst"),
					"surat_mendagri" =>$this->input->post("surat_mendagri"),
					"tgl_surat" =>$this->input->post("tgl_surat")
				);	

			}
			if($this->form_validation->run() == TRUE)
			{
				$wfnum = $this->input->post("wfnum");
				$SQL = "SELECT wfnum FROM pinjaman WHERE 1=1 AND wfnum='$wfnum'";
				$query = $this->db->query($SQL);
				if($query->num_rows()>0){
					$this->db->update('pinjaman',$pinjaman,array("wfnum"=>$wfnum));
				}else{
					$this->db->insert('pinjaman',$pinjaman);
				}


				// input History
				$history = array(
					"wfnum"=> $wfnum,
					"zdate" => date('Y-m-d'),
					"ztime" => date('H:i:s'),
					"zuser" => $this->session->userdata('usrcd'),
					"from_status"=> $this->input->post("curst"),
					"to_status" => $this->input->post("nexst"),
					"reason" => ''
				);
				$cekHis = $this->db->get_where('wf_history', array('wfnum' => $wfnum, "from_status"=> $this->input->post("curst"), "to_status" => $this->input->post("nexst")));
				if($cekHis->num_rows() == 0){
					$this->db->insert('wf_history', $history);
				}else{
					$this->db->update('wf_history', $history, array('wfnum' => $wfnum, "from_status"=> $this->input->post("curst"), "to_status" => $this->input->post("nexst")));
				}
				

				if($this->input->post('nexst') != ''){
					$this->db->update('pinjaman',array("curst"=>$this->input->post('nexst')), array("wfnum"=>$wfnum));
				}

				$status = 0;
				$message = 'Data Berhasil Disimpan';			
			}else{
				$status = 1;
				$message = strip_tags(validation_errors());
			}

		}else{
			$status = 1;
			$message = "Harap melengkapi dokumen persyaratan dengan lengkap, untuk meneruskan ke proses selanjutnya!";
		}

		$notif = $this->Global_model->getNotif($status,$message);
        $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
		echo $this->withJson($resultObj);	
		
	}

	public function rejectData(){
		$wfnum = $this->input->post('wfnum');
		$curre = $this->input->post("curre");
		$nexst = $this->input->post("nexst");
		$reasn = $this->input->post("reasn");

		$this->db->update('pinjaman',array("curst"=>$nexst), array("wfnum"=>$wfnum));

		// input History
		$history = array(
			"wfnum"=> $wfnum,
			"zdate" => date('Y-m-d'),
			"ztime" => date('H:i:s'),
			"zuser" => $this->session->userdata('usrcd'),
			"from_status"=> $curre,
			"to_status" => $nexst,
			"reason" => $reasn
		);
		$this->db->insert('wf_history', $history);

		echo json_encode(array("wfnum"=>$wfnum));
	}

	public function loaddata(){
		$wfnum = $this->input->post("wfnum");
		$SQL = "SELECT a.*,b.namakab FROM pinjaman a JOIN m_daerah b on a.group_user=b.id WHERE wfnum='$wfnum'";
		$header = $this->db->query($SQL);

		$resultObj = array("status" =>0, "message" =>'', "header"=> $header->row());
		echo $this->withJson($resultObj);
	}
	
	function loadAllPersyaratan(){
		$wfnum = $this->input->post("wfnum");
		$SQL = "SELECT * FROM m_persyaratan ORDER BY persyaratan_id ASC";
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"persyaratan_id" => $row->persyaratan_id,
				"persyaratan_name" => $row->persyaratan_name,
				"checkList" => $this->checkList($wfnum,$row->persyaratan_id)
			);
		}
        echo $this->withJson($data);
	}

	function checkList($wfnum,$persyaratan_id){
		$html = '<i class="splashy-document_a4_remove"></i>';
		$SQL = "SELECT * FROM doc_persyaratan WHERE wfnum='$wfnum' AND persyaratan_id='$persyaratan_id' ";
		$result = $this->db->query($SQL);
		if($result->num_rows() > 0){
			$html = '<i class="splashy-check"></i>';
		}
		return $html;

	}

	
	public function workflow() {
		$wfnum = $this->input->post("wfnum");
		$cek = $this->db->get_where('pinjaman', array('wfnum' => $wfnum));
		if($cek->num_rows()>0){
			$data = $cek->row();
			$curst = $data->curst;
			$wfcat = $data->wfcat;

			//secho print_r($data); exit;
		}else{
			$type = $this->session->userdata('user_type');
			if($type == 'KAB'){
				$curst = 'RNA1';
				$wfcat = 'WF01';
			}else{
				$curst = 'RNA1';
				$wfcat = 'WF01';
			}
			
		}
		$btnwf = $this->Global_model->ButtonWorkflow($wfcat,$curst);
		$data = array("status"=>1,"button"=>$btnwf);
		echo $this->withJson($data);
	}

	public function loadDropdown() {
		$mode = $this->input->post("mode");

		if($mode=='JENISSTATUS'){
			$option = $this->Pinjaman_model->slcJenisStatus();
		}
		
		$data = array("status"=>0,"option"=>$option);
		echo $this->withJson($data);
	}

	public function loadstatus() {
		$stscd = $this->input->post("stscd");
		$cek = $this->db->get_where('wf_status', array('stscd' => $stscd));
		$row = $cek->row();

		$data = array("stscd"=>$row->stscd,"stsnm"=>$row->stsnm);
		echo $this->withJson($data);
	}

	public function loadHistory() {
		$wfnum = $this->input->post('wfnum');
		$resultObj = $this->Pinjaman_model->getHistory($wfnum);
		echo $this->withJson($resultObj);
	}

	public function searchData() {
		$conds = '';
		$usrcd = $this->session->userdata('usrcd');
		$usrty = $this->session->userdata('user_type');
		$group = $this->session->userdata('group_user');


		$wfnum = $this->input->post('wfnum');
		$srpng = $this->input->post('slcSuPeng');
		$dateFrom = $this->input->post('datetglDocFrom');
		$dateTo = $this->input->post('datetglDocTo');
		$kabkt = $this->input->post('slcDaerahProv');
		$curst = $this->input->post('slcJenisStatus');


		if($wfnum !=''){
			$conds .= "AND wfnum='$wfnum' ";
		}
		if($curst !=''){
			$conds .= "AND curst='$curst' ";
		}

		if($srpng != ''){
			$conds .= "AND docnumber='$srpng' ";
		}

		if($kabkt > 0){
			$conds .= "AND group_user='$kabkt' ";
		}

		if($dateFrom != ''){
			if($dateTo != ''){
				$dateTo = $dateFrom;
			}
			$conds .= "AND doctgl BETWEEN '$dateFrom' AND '$dateTo' ";
		}

		if($usrty != 'KEM'){ // 
			$conds .= "AND zuser='$usrcd' ";
		}


		$SQL = "SELECT * FROM pinjaman WHERE 1=1 $conds ORDER BY zdate DESC";
		//echo $SQL; exit();
		$query = $this->db->query($SQL);

		if($query->num_rows()>0){ //jika permintaan terpenuhi, maka data tampil.

			foreach($query->result() as $row){
				$data[] = array(
					"wfnum" => $row->wfnum,
					"wfcat" => $row->wfcat,
					"zuser" => $this->Pinjaman_model->getdesc('m_daerah','namakab',array("id"=>$row->group_user)) ,
					"stsnm" => $this->Pinjaman_model->getdesc('wf_status','stsnm',array("stscd"=>$row->curst)),
					"docnumber" => $row->docnumber,
					"zdate" => date('d F Y', strtotime($row->zdate)),
					"doctgl" => date('d F Y', strtotime($row->doctgl))
				);
			}
			$resultObj = array("status"=>0,"message"=>"Ok", "result"=>$data);
		}else{
			$resultObj = array("status"=>1,"message"=>"Data Notfound", "notif" => $this->Global_model->getNotif(1,"Data Not found"));
		}

		echo $this->withJson($resultObj);
	}

	function getNDI(){

		$usr = $this->session->userdata('group_user');
		$data = $this->db->get_where('m_daerah', array('id' => $this->session->userdata('group_user')));

		if($data->num_rows()>0){
			$row = $data->row();
			$tID = $row->kdprov.$row->kdkabkota.date("ymdHis");

			$status = 0;
			$message = 'ok';

			$resultObj = array('status'=>$status, "message"=>$message, "ndi" => $tID);
		}else{
			$tID = '';

			$status = 1;
			$message = 'Gagal Membuat NDI';

			$resultObj = array('status'=>$status, "message"=>$message, "ndi" => $tID);
		}
		echo $this->withJson($resultObj);
	}

	function cekKosong($data){
		$res = '-';
		if($data == 'undefined'){
			$res = '-';
		}else{
			$res = $data;
		}
		return $res;
	}

	function slckabkot(){
		$kodeprov = $this->input->post('kodeprov');
		$html = '<option value="">- Semua Data</option>';
		$query = $this->db->get_where('m_daerah', array("kodeprov" => $kodeprov));
		foreach ($query->result() as $row) {
			$html .= '<option value="'.$row->id.'">'.$row->namakab.'</option>';
		}

		echo $this->withJson(array('option'=>$html));
	}

	function additem() {
		$filetype = array();
		$wfnum = $this->input->post('wfnum');
		$title = $this->input->post("title");
		$filenm = $this->input->post("filenm");
		$fileid = $this->input->post("fileid");

		$persyaratan_id = $this->input->post("persyaratan_id");
		$filetype = array('pdf','doc','docx','xls','xlsx');
		$file1 = $this->do_upload($filetype,'fileid');
		if($file1["status"]==0) {
			
			$data = array(
				"wfnum"=> $wfnum,
				"title" => $title,
				"persyaratan_id" => $persyaratan_id,
				"original_name"=> $file1["upload_data"]["orig_name"],
				"encrypt_name" => $file1["upload_data"]["file_name"],
				"zdate" => date('Y-m-d h:i:s')
			);
			$this->db->insert('doc_persyaratan', $data);
			
			$status = 0;
			$message = 'ok';

			$resultObj = array('status'=>$status, "message"=>$message);
		}else{
			$status = 1;
			$message = 'Data Not Found!';
			$notif = $this->Global_model->getNotif(1,"Data Not found");
			$resultObj = array('status'=>$status, "message"=>$message, "notif"=>$notif);
		}
		echo $this->withJson($resultObj);
	}

	public function do_upload($ext_allow,$objName) {
		$config['upload_path']   = './assets/uploads/'; 
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
		   $status = array('status'=>0, 'message' => 'ok', 'upload_data' => $this->upload->data()); 
		}
		return $status;
	}

	function push_file($path, $name)
    {
		  // make sure it's a file before doing anything!
		$path = './assets/uploads/'.$path;  
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
			header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($path)); // provide file size
			header('Connection: close');
			readfile($path); // push it out
			exit();
		}
	}

	function loaditem(){
		$wfnum = $this->input->post('wfnum');
		$persyaratan_id = $this->input->post('persyaratan_id');

		$html = '';
		$this->db->order_by('zdate', 'ASC');
		$query = $this->db->get_where('doc_persyaratan', array('wfnum' => $wfnum, "persyaratan_id" => $persyaratan_id));

		
		if($query->num_rows() > 0){
			$ctg = $this->Pinjaman_model->getdesc('pinjaman','wfcat',array("wfnum"=>$wfnum));
			if($ctg == 'WF01') {
				$html .= '<div class="form-group">
							<div class="col-lg-2"></div>
								<div class="col-lg-9">';

				
					
					$btn = $this->Pinjaman_model->getdesc('pinjaman','curst',array("wfnum"=>$wfnum));
					if(($btn == "RNA1" || $btn == "RNB1" || $btn == "RNBX")){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>File Uploads</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="fdownload('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->item_id."'".','."'".$row->wfnum."'".','."'".$row->persyaratan_id."'".');"></i> Hapus</button></td>
							</tr>';
						$no++;
					}
					
					$html .='</tbody></table>';

				$html .= '</div>
						</div>';
			}
		}

		echo json_encode(array('status'=>1, "message"=>'ok', "html"=>$html));
		
	}

	function delitem() {

		$item_id = $this->input->post("item_id");

		$where = array("item_id"=>$item_id);
		$row = $this->db->get_where('doc_persyaratan', $where)->row();
		unlink('./assets/uploads/'.$row->encrypt_name);

		$this->db->delete('doc_persyaratan', $where);
			
		$status = 0;
		$message = '';

		$resultObj = array('status'=>$status, "message"=>$message);
		echo json_encode($resultObj);
	}

	function validationData($wfnum, $nexst){
		$res = true;
		if($nexst == 'RNC1'){
			// query menghitung yang jumlah file yang belum di uploads
			$SQL = "SELECT 
						COALESCE(
							SUM(
								CASE WHEN (
									SELECT persyaratan_id FROM doc_persyaratan where persyaratan_id=a.persyaratan_id AND wfnum='$wfnum' LIMIT 1
								)  
							IS NULL THEN 1 END), 0
						) AS total
					FROM m_persyaratan a";
			$cek = $this->db->query($SQL)->row();
			if($cek->total == 0){
				$res = true;
			}else{
				$res = false;
			}
		}		

		return $res;
	}

	public function initdscr() {

		$wfnum = $this->uri->segment(3);
		
		$init = $this->db->get_where('lk_dscr', array('wfnum' => $wfnum));
		if($init->num_rows() == 0){
			$itemDscr = $this->db->get('m_list');
			foreach($itemDscr->result() as $row){
				$data = array(
					"wfnum"   => $wfnum,
					"ktg_id"  => $row->ktg_id,
					"list_id" => $row->list_id
				);
				$this->db->insert('lk_dscr', $data);
			}
		}
		
	}

	function getYear($wfnum){
        $doc = $this->db->get_where('pinjaman', array("wfnum" => $wfnum ))->row();
        $year = date('Y',strtotime($doc->doctgl));
        $data = array (
            "y1" => $year-4,
            "y2" => $year-3,
            "y3" => $year-2,
        );
        return $data;
	}
	
	function template(){

		$data = array();
		$options = array(
			'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
			'destinationfile' => '', //I=inline browser (default), F=local file, D=download
			'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
			'orientation'=>'L' //orientation: P=portrait, L=landscape
		);

		$this->load->helper('doc_template');
		$tabel = new doc_template($data, $options);
		$tabel->gettemplate();
	}

	function template2(){

		$data = array();
		$options = array(
			'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
			'destinationfile' => '', //I=inline browser (default), F=local file, D=download
			'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
			'orientation'=>'L' //orientation: P=portrait, L=landscape
		);

		$this->load->helper('doc_template');
		$tabel = new doc_template($data, $options);
		$tabel->gettemplate2();
	}

	function template3(){

		$data = array();
		$options = array(
			'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
			'destinationfile' => '', //I=inline browser (default), F=local file, D=download
			'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
			'orientation'=>'L' //orientation: P=portrait, L=landscape
		);

		$this->load->helper('doc_template');
		$tabel = new doc_template($data, $options);
		$tabel->gettemplate3();
	}


	function importexcel(){

		$filetype = array('xls','xlsx');
		$file1 = $this->do_upload($filetype,'files');
		
		if($file1["status"]==0) {

			include APPPATH.'third_party/PHPExcel/PHPExcel.php';                
			$excelreader = new PHPExcel_Reader_Excel2007();        
			$loadexcel = $excelreader->load('assets/uploads/'.$file1["upload_data"]["file_name"]);        
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);        
			//echo '<pre/>'; print_r($sheet);
			foreach($sheet as $cell => $r){

				if($cell > 1 ){
					if($r['B']!=''){
						$lk_kegiatan_honor = array(
							"wfnum"  => $this->input->post("wfnum"),
							"ktg_id" => $this->input->post("ktg_doc"),
							"urusan_id"  => $r['A'],
							"title"  => $r['B'],
							"amount" => str_replace(",","", $r['C'])
						);
						$this->db->insert('lk_kegiatan_honor', $lk_kegiatan_honor);
					}
				}
				
			}
			echo $this->withJson($file1);
			unlink('assets/uploads/'.$file1["upload_data"]["file_name"]);
		}else{
			echo $this->withJson($file1);
		}

    }


	function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}