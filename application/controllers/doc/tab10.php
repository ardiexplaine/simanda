<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Tab10 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
        $this->load->model('Global_model');
        $this->load->model('Pinjaman_model');
        $this->module = "tab10";
        $this->ktgid = 3;
    }

    
    function loadtable(){
		$wfnum = $this->input->post('wfnum');

		$html = '';
		$this->db->order_by('item_id', 'ASC');
		$query = $this->db->get_where('lk_kegiatan_honor', array('wfnum' => $wfnum, "ktg_id" =>  $this->ktgid));

		if($query->num_rows() > 0){
			$ctg = $this->Pinjaman_model->getdesc('pinjaman','wfcat',array("wfnum"=>$wfnum));
			if($ctg == 'WF01') {
				$html .= '<div class="col-lg-12">';

				
					
					// $btn = $this->Pinjaman_model->getdesc('pinjaman','curst',array("wfnum"=>$wfnum));
					// if(($btn == "RNA1" || $btn == "RNB1" || $btn == "RNBX")){
						$disabled = '';
					// }else{
					// 	$disabled = 'disabled="disabled"';
					// }

					$html .= '<table id="divtbltab10" class="table table-striped table-condensed" data-provides="rowlink">
						<thead>
							<tr>
								<th>NO</th>
								<th>KODE URUSAN</th>
								<th>KEGIATAN PINJAMAN DAERAH YANG DIUSULKAN DALAM KAK DAN SESUAI DALAM RKPD PEMERINTAH DAERAH</th>
								<th>JUMLAH</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
                    $no = 1;
                    $total = 0;
					foreach($query->result() as $row) {
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->urusan_id.'</td>
								<td>'.$row->title.'</td>
								<td style="text-align: right">'.number_format($row->amount,0,'.',',').'</td>
								<td><button '.$disabled.' onclick="tab10delitem('."'".$row->item_id."'".');"><i class="splashy-document_letter_remove"></i> Hapus</button></td>
                            </tr>';     
                        $no++;
						$total += $row->amount;
						
                    }
                    
                    $html .='<tr class="rowlink">
								<td></td>
								<td></td>
								<td style="text-align: right"><b>TOTAL</b></td>
								<td style="text-align: right"><b>'.number_format($total,0,'.',',').'</b></td>
								<td></td>
							</tr>';
					
					$html .='</tbody></table>';

				$html .= '</div>';
			}
		}

		echo json_encode(array('status'=>1, "message"=>'ok', "html"=>$html));
		
	}


    function savedata() {

		$this->form_validation->set_rules('tab10_title','Belanja Pegawai','required|xss_clean');
        $this->form_validation->set_rules('tab10_amount','Belanja Tambahan Penghasilan PNS','required|xss_clean');


        $lk_kegiatan_honor = array(
            "wfnum"  => $this->input->post("txtWfnum"),
			"ktg_id" => $this->ktgid,
			"urusan_id"  => $this->input->post("tab10_urusan_id"),
            "title"  => $this->input->post("tab10_title"),
            "amount" => str_replace(",","", $this->input->post("tab10_amount"))
        );

		
		if($this->form_validation->run() == TRUE)
		{
            $this->db->insert('lk_kegiatan_honor', $lk_kegiatan_honor);
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

    function deletdata(){

        $this->form_validation->set_rules('item_id','Belanja Pegawai','required|xss_clean');

        if($this->form_validation->run() == TRUE)
		{
            $item_id = $this->input->post('item_id');
            $this->db->delete('lk_kegiatan_honor', array("item_id" => $item_id));

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