<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Tab5 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
        $this->load->model('Global_model');
        $this->load->model('Pinjaman_model');
        $this->module = "tab5";
        $this->ktgid = 6;
    }

    
    function loadtable(){
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

					$html .= '<table id="divtbltab6" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>NO</th>
								<th>URAIAN</th>
								<th>REALISASI TA '.$ryear['y1'].'</th>
								<th>REALISASI TA '.$ryear['y2'].'</th>
								<th>REALISASI TA '.$ryear['y3'].'</th>
								<th>JUMLAH</th>
								<th>RATA-RATA</th>
							</tr>
						</thead>
						<tbody>';
                    $no = 1;
					$total = 0; 
					$total2 = 0;
					$totalKasda = 0;
					foreach($query->result() as $row) {
						$total = $row->ta_1+$row->ta_2+$row->ta_3;
						$rata2 = $total/3;
						$html .='<tr class="rowlink" data-toggle="modal" data-backdrop="static" href="#templateRataDscr1" data-placement="bottom" data-container="body" onclick="tab5_modalDscr('.$row->wfnum.','.$row->dscr_id.','.$row->ktg_id.','.$row->list_id.','.$row->ta_1.','.$row->ta_2.','.$row->ta_3.');">
								<td>'.$no.'</td>
								<td>'.$row->list_name.'</td>
								<td style="text-align: right">'.number_format($row->ta_1,2,'.',',').'</td>
								<td style="text-align: right">'.number_format($row->ta_2,2,'.',',').'</td>
								<td style="text-align: right">'.number_format($row->ta_3,2,'.',',').'</td>
								<td style="text-align: right">'.number_format($total,2,'.',',').'</td>
								<td style="text-align: right">'.number_format($rata2,2,'.',',').'</td>
							</tr>';          
						$total2 += $total;
						if($no>1){
							$totalKasda += $rata2;
						}
						$no++;
                    }
                    
                    $html .='<tr class="rowlink">
								<td colspan="5" style="text-align: right"><b>TOTAL</b></td>
								<td style="text-align: right"><b>'.number_format($total2,2,'.',',').'</b></td>
								<td></td>
							</tr>';
					$html .='<tr class="rowlink">
							<td colspan="5" style="text-align: right"><b>TOTAL KASDA</b></td>
							<td style="text-align: right"><b>'.number_format($totalKasda,2,'.',',').'</b></td>
							<td></td>
						</tr>';
					$html .='</tbody></table>';

				$html .= '</div>';
			}
		}
		//echo $this->session->userdata('tab5_kasda_total'); exit;
		echo json_encode(array('status'=>1, "message"=>'ok', "html"=>$html));
		
	}


    function savedata() {

		$this->form_validation->set_rules('tab5_wfnum','wfnum kosong','required|xss_clean');
		$this->form_validation->set_rules('tab5_dscr_id','dscr kosong','required|xss_clean');
		$this->form_validation->set_rules('tab5_ktg_id','kategori id kosong','required|xss_clean');


		$total = $this->input->post("tab5_ta_1")+$this->input->post("tab5_ta_2")+$this->input->post("tab5_ta_3");
        $lk_kegiatan_honor = array(
            "ta_1"  => str_replace(",","", $this->input->post("tab5_ta_1")),
            "ta_2"  => str_replace(",","", $this->input->post("tab5_ta_2")),
            "ta_3"  => str_replace(",","", $this->input->post("tab5_ta_3")),
            "total" => str_replace(",","", $total)
        );
		//echo '<pre/>'; print_r($_POST); exit;
		
		if($this->form_validation->run() == TRUE){
            $this->db->update('lk_dscr', $lk_kegiatan_honor, array("dscr_id"=> $this->input->post("tab5_dscr_id")));
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