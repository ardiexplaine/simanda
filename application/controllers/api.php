<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
        $this->load->model('Global_model');
    }


    public function getmodal(){
        $html = '';
        $mode = $this->input->post('mode');

        if($mode=='NOTIF'){
            $html .= "<div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h3 class='modal-title'>Pemberitahuan Baru</h3>
                </div>
                <div class='modal-body'>
                    <table id='dataModalTable' data-provides='rowlink'>
                        <thead>
                            <tr>
                                <th>WF No.</th>
                                <th>From</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>";
                            
                        $html .= $this->dataNotifkasi();
             $html .= "</tbody>
                    </table>
                </div>";
        }
        
        $resultObj = array("status"=>0, "message"=> 'load modal, OK', "htmlmodal"=> $html);
        $this->withJson($resultObj);
    }

    function changepassword(){
        $data['content'] = 'cpassword';
		$this->load->view('layout2',$data);
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
    
    function loaddoc(){
        $ktg_id = $this->input->post('ktg_id');
        $wfnum  = $this->input->post('wfnum');
        
        $data = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktg_id, "wfnum" => $wfnum ));
        if($data->num_rows()!=0){
            $result = $data->row();
        }else{
            $data2 = $this->db->get_where('m_label_dokumen', array("doc_id" => $ktg_id ));
            $result = $data2->row();
        }
        echo $this->withJson($result); 
    }

    function savedoc(){
        $txtWfnum   = $this->input->post('txtWfnum');
        $ktg_doc    = $this->input->post('ktg_doc');

        $data = array(
            "ktg_id" => $ktg_doc,
            "wfnum" => $txtWfnum, 
            "doc_title" => $this->input->post('title_doc'),
            "doc_footer" => $this->input->post('notes_doc'),
            "doc_ttd" => $this->input->post('ttd_tangan')
        );
        
        $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktg_doc, "wfnum" => $txtWfnum ));
        if(count($doc->result()) > 0) {  
            $this->db->update('t_label_dokumen',$data, array("ktg_id" => $ktg_doc, "wfnum" => $txtWfnum ));
        }else{
            $this->db->insert('t_label_dokumen',$data);
        } 

        echo $this->withJson($data); 
    }

    function printinit(){
        echo $this->withJson($_POST); 
    }

    function printdoc(){
        $ktgcd = $this->uri->segment(3);
        $wfnum = $this->uri->segment(4);

        if($ktgcd == 1 || $ktgcd == 2  || $ktgcd == 4 || $ktgcd == 7 || $ktgcd == 12){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $item = $this->db->get_where('lk_kegiatan_honor', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ));
            $data = array(
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc, 
                "detail" => $item->result()
            );

            
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'P' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_static');
            $tabel = new doc_static($data, $options);
            $tabel->printPDF();
        }

        if($ktgcd == 3){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $item = $this->db->get_where('lk_kegiatan_honor', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ));
            
            $totalkasda = 0;
            $SQL1 = "SELECT (ta_1+ta_2+ta_3)/3 as total_kasda FROM lk_dscr WHERE wfnum='$wfnum' AND ktg_id=6 ORDER BY dscr_id DESC LIMIT 2";
            $Q1 = $this->db->query($SQL1);
            foreach($Q1->result() as $r1){
                $totalkasda += $r1->total_kasda;
            }

            $SQL2 = "SELECT SUM(amount) amount FROM lk_kegiatan_honor WHERE wfnum='$wfnum' AND ktg_id=12";
            $Q2 = $this->db->query($SQL2)->row();


            $SQL3 = "SELECT rencana_usulan_pinjaman FROM dscr_pp WHERE wfnum='$wfnum' AND ktg_id=10";
            $Q3 = $this->db->query($SQL3);
            $rencanaUsulanPinjaman = 0;
            if($Q3->num_rows()>0){
                $row = $Q3->row();
                $rencanaUsulanPinjaman = $row->rencana_usulan_pinjaman;
            }


            $data = array(
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc, 
                "footer" => array(
                    "tt_rata2_pns_pengurang" => $Q2->amount,
                    "tt_kasda" => $totalkasda,
                    "tt_jumlah" => $Q2->amount + $totalkasda,
                    "tt_setuju" => $rencanaUsulanPinjaman
                ),
                "detail" => $item->result()
            );

            //echo '<pre/>'; print_r($data);exit;
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'P' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_kegiatan');
            $tabel = new doc_kegiatan($data, $options);
            $tabel->printPDF();
        }

        if($ktgcd == 5 || $ktgcd == 6){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $SQL = "SELECT a.*,b.list_name FROM lk_dscr a JOIN m_list b ON a.list_id=b.list_id WHERE a.wfnum = '$wfnum' AND a.ktg_id = $ktgcd ORDER BY a.dscr_id ASC";
            $item = $this->db->query($SQL);
            $data = array(
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc,
                "realisasi" => $this->Global_model->getYear($wfnum),
                "detail" => $item->result()
            );

            //echo '<pre/>'; print_r($data);exit;
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'L' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_dscr');
            $tabel = new doc_static($data, $options);
            $tabel->printPDF();
        }
        
        
        if($ktgcd == 8){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $totalB = $this->db->get_where('lk_dscr',array('wfnum'=>$wfnum,"ktg_id"=>$ktgcd, "list_id"=>21))->row();
            $SQL = "SELECT a.*,b.list_name FROM lk_dscr a JOIN m_list b ON a.list_id=b.list_id WHERE a.wfnum = '$wfnum' AND a.ktg_id = $ktgcd ORDER BY a.dscr_id ASC";
            $item = $this->db->query($SQL);
            $data = array(
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc,
                "realisasi" => $this->Global_model->getYear($wfnum),
                "detail" => $item->result(),
                "totalB" => $totalB->ta_1
            );

            //echo '<pre/>'; print_r($data);exit;
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'P' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_totalbelanja');
            $tabel = new doc_belanja($data, $options);
            $tabel->printPDF();
        }

        if($ktgcd == 9){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $SQL = "SELECT a.*,b.list_name FROM lk_dscr a JOIN m_list b ON a.list_id=b.list_id WHERE a.wfnum = '$wfnum' AND a.ktg_id = $ktgcd ORDER BY a.dscr_id ASC";
            $item = $this->db->get_where("dscr_pp",array("wfnum"=>$wfnum, "ktg_id" => $ktgcd));
            $kabkot = $this->Global_model->getkabkot($wfnum);
            $data = array(
                "kabkot" => $kabkot,
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc,
                "realisasi" => $this->Global_model->getYear($wfnum),
                "detail" => $item->row()
            );

            //echo '<pre/>'; print_r($data);exit;
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'P' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_template');
            $tabel = new doc_template($data, $options);
            $tabel->gettemplate2();
        }

        if($ktgcd == 10){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $SQL = "SELECT a.*,b.list_name FROM lk_dscr a JOIN m_list b ON a.list_id=b.list_id WHERE a.wfnum = '$wfnum' AND a.ktg_id = $ktgcd ORDER BY a.dscr_id ASC";
            $item = $this->db->get_where("dscr_pp",array("wfnum"=>$wfnum, "ktg_id" => $ktgcd));
            $kabkot = $this->Global_model->getkabkot($wfnum);
            $data = array(
                "kabkot" => $kabkot,
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc,
                "realisasi" => $this->Global_model->getYear($wfnum),
                "detail" => $item->row()
            );

            //echo '<pre/>'; print_r($data);exit;
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'P' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_template');
            $tabel = new doc_template($data, $options);
            $tabel->gettemplate2();
        }

        if($ktgcd == 11){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $SQL = "SELECT a.*,b.list_name FROM lk_dscr a JOIN m_list b ON a.list_id=b.list_id WHERE a.wfnum = '$wfnum' AND a.ktg_id = $ktgcd ORDER BY a.dscr_id ASC";
            $item = $this->db->get_where("lk_perhitungan_75",array("wfnum"=>$wfnum, "ktg_id" => $ktgcd));
            $kabkot = $this->Global_model->getkabkot($wfnum);
            $data = array(
                "kabkot" => $kabkot,
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc,
                "realisasi" => $this->Global_model->getYear($wfnum),
                "detail" => $item->row()
            );

            //echo '<pre/>'; print_r($data);exit;
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'P' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_template');
            $tabel = new doc_template($data, $options);
            $tabel->gettemplate3();
        }

        if($ktgcd == 13){
            $doc = $this->db->get_where('t_label_dokumen', array("ktg_id" => $ktgcd, "wfnum" => $wfnum ))->row();
            $SQL = "SELECT a.*,b.list_name FROM lk_dscr a JOIN m_list b ON a.list_id=b.list_id WHERE a.wfnum = '$wfnum' AND a.ktg_id = $ktgcd ORDER BY a.dscr_id ASC";
            $item = $this->db->get_where("defisit",array("wfnum"=>$wfnum, "ktg_id" => $ktgcd));
            $kabkot = $this->Global_model->getkabkot($wfnum);
            $data = array(
                "kabkot" => $kabkot,
                "ktgcd" => $ktgcd,
                "wfnum" => $wfnum,
                "header" => $doc,
                "realisasi" => $this->Global_model->getYear($wfnum),
                "detail" => $item->row()
            );

            //echo '<pre/>'; print_r($data);exit;
            //pilihan
            $options = array(
                'filename' => '', //nama file penyimpanan, kosongkan jika output ke browser
                'destinationfile' => '', //I=inline browser (default), F=local file, D=download
                'paper_size'=>'A4',	//paper size: F4, A3, A4, A5, Letter, Legal
                'orientation'=>'P' //orientation: P=portrait, L=landscape
            );
            
            $this->load->helper('doc_template');
            $tabel = new doc_template($data, $options);
            $tabel->gettemplate4();
        }
    }

    function importexcel(){
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';                
        $excelreader = new PHPExcel_Reader_Excel2007();        
        $loadexcel = $excelreader->load('assets/uploads/temp_upload/kak.xlsx');        
        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);        
        echo '<pre/>'; print_r($sheet);
    }


    function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}