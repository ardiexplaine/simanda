<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Tab8 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
        $this->load->model('Global_model');
        $this->load->model('Pinjaman_model');
        $this->module = "tab8";
        $this->ktgid = 8;
    }

    
    function loadtable(){
		error_reporting(0);
		$wfnum = $this->input->post('wfnum');

		$html = '';

		$SQL = "SELECT a.*,b.list_name FROM lk_dscr a JOIN m_list b ON a.list_id=b.list_id WHERE a.wfnum = '$wfnum' AND a.ktg_id = $this->ktgid ORDER BY a.dscr_id ASC";
		$query = $this->db->query($SQL);
		if($query->num_rows() > 0){
			$ctg = $this->Pinjaman_model->getdesc('pinjaman','wfcat',array("wfnum"=>$wfnum));

			$ryear = $this->Global_model->getYear($wfnum);
			if($ctg == 'WF01') {
				$html .= '<div class="col-lg-12">';

				
					
					// $btn = $this->Pinjaman_model->getdesc('pinjaman','curst',array("wfnum"=>$wfnum));
					// if(($btn == "RNA1" || $btn == "RNB1" || $btn == "RNBX")){
						$disabled = '';
					// }else{
					// 	$disabled = 'disabled="disabled"';
					// }

					$html .= '<table id="divtbltab6" class="table table-striped table-bordered table-condensed" data-provides="rowlink">
						<thead>
							<tr>
								<th>NO</th>
								<th>Belanja</th>
								<th>TA '.date('Y').'</th>
								<th>% DARI TOTAL BELANJA</th>
							</tr>
						</thead>
						<tbody>';
                    $no = 1;
					$total = 0; 
					$total2 = 0;
					$percent = '';
					$totalB = $this->db->get_where('lk_dscr',array('wfnum'=>$wfnum,"ktg_id"=>$this->ktgid, "list_id"=>21))->row();
					foreach($query->result() as $row) {
					$total1 = $row->ta_1;
					if($row->list_id != 21){
						$percent = number_format( $row->ta_1/$totalB->ta_1 * 100, 0 ).'%';
					}else{
						$percent = '';
					}
					$html .='<tr class="rowlink" data-toggle="modal" data-backdrop="static" href="#templateRataDscr3" data-placement="bottom" data-container="body" onclick="tab8_modalDscr('.$row->wfnum.','.$row->dscr_id.','.$row->ktg_id.','.$row->list_id.','.$row->ta_1.');">
								<td>'.$no.'</td>
								<td>'.$row->list_name.'</td>
								<td style="text-align: right">'.number_format($row->ta_1,2,'.',',').'</td>
								<td style="text-align: center">'.$percent.'</td>
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

		$this->form_validation->set_rules('tab8_wfnum','wfnum kosong','required|xss_clean');
		$this->form_validation->set_rules('tab8_dscr_id','dscr kosong','required|xss_clean');
		$this->form_validation->set_rules('tab8_ktg_id','kategori id kosong','required|xss_clean');

        $lk_kegiatan_honor = array(
            "ta_1"  => str_replace(",","", $this->input->post("tab8_ta_1")),
            "total" => 0
        );
		//echo '<pre/>'; print_r($_POST); exit;
		
		if($this->form_validation->run() == TRUE){
            $this->db->update('lk_dscr', $lk_kegiatan_honor, array("dscr_id"=> $this->input->post("tab8_dscr_id")));
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



    function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}