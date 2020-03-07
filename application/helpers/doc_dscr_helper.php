<?php  
    
    require_once("fpdf17/fpdf.php");
    
    class doc_static extends FPDF {

        private $data = array();
        private $options = array(
            'filename' => '',
            'destinationfile' => '',
            'paper_size'=>'F4',
            'orientation'=>'P'
        );
        
        function __construct($data = array(), $options = array()) {
          parent::__construct();
          $this->data = $data;
          $this->options = $options;
      }
      
      public function rptDetailData () {
          //
          $header = $this->data["header"];
          $year  = $this->data["realisasi"];
          $cols1 = ""; 
          $cols2 = "";
          if($header->ktg_id == 5){
              $cols1 = "URAIAN";
              $cols2 = "REALISASI TA ".$year['y1'];
              $cols3 = "REALISASI TA ".$year['y2'];
              $cols4 = "REALISASI TA ".$year['y3'];
              $cols5 = "TOTAL";
              $cols6 = "RATA-RATA";

              $header_title = "PERHITUNGAN RATA-RATA REALISASI TA ".$year['y1'].", REALISASI TA ".$year['y2']." DAN REALISASI TA ".$year['y3'];
          }

          if($header->ktg_id == 6){
              $cols1 = "URAIAN";
              $cols2 = "REALISASI TA ".$year['y1'];
              $cols3 = "REALISASI TA ".$year['y2'];
              $cols4 = "REALISASI TA ".$year['y3'];
              $cols5 = "TOTAL";
              $cols6 = "RATA-RATA";
              $header_title = "SILPA TA ".$year['y1'].", TA ".$year['y2']." DAN TA ".$year['y3'];
          }

          if($header->ktg_id == 7){
              $cols1 = "Belanja Pegawai";
              $cols2 = "Honorarium Panitia Pelaksana Kegiatan";
              $cols3 = "Honorarium Tenaga Ahli/Instruktur/Narasumber";
              $cols4 = "Honorarium PNS Lainnya";
              $cols5 = "TOTAL";
              $cols6 = "RATA-RATA";
              $header_title = "";
          }

          if($header->ktg_id == 4){
            $cols1 = "Kegiatan Pinjaman Daerah Yang Diusulkan Dalam KAK";
            $cols2 = "Jumlah";
          }
          //echo '<pre/>'; print_r($this->data->detail); exit;
          
          $border = 0;
          $this->AddPage();
          $this->SetAutoPageBreak(true,60);
          $this->AliasNbPages();
          $left = 25;
          $left2 = 25;
          
          //header
		  $this->Ln(50);
          $this->SetFont("", "B", 10);
          $this->SetFillColor(255, 255, 255);
		  $this->SetX($left); $this->MultiCell(400, 12,  $header->doc_title, 0, 1,'L');
          $this->Ln(10);

          								

          $this->SetX($left); $this->MultiCell(500, 12, $header_title , 0, 1,'L');
          $this->Ln(10);
          
          
          
          $h = 25;
          $left = 40;
          $top = 80;	
          #tableheader
          $this->SetFont('Arial','',9);
		  $this->SetFillColor(200,200,200);
		  $left = $this->GetX();
		  $this->Cell(20,$h,'NO',1,0,'L',true);
          $this->SetX($left += 20); $this->Cell(170, $h, $cols1, 1, 0, 'C',true);
          $this->SetX($left += 170); $this->Cell(120, $h, $cols2, 1, 0, 'C',true);
          $this->SetX($left += 120); $this->Cell(120, $h, $cols3, 1, 0, 'C',true);
          $this->SetX($left += 120); $this->Cell(120, $h, $cols4, 1, 0, 'C',true);
          $this->SetX($left += 120); $this->Cell(120, $h, $cols5, 1, 0, 'C',true);
		  $this->SetX($left += 120); $this->Cell(120, $h, $cols6, 1, 1, 'C',true);
          //$this->Ln(20);

        //   [dscr_id] => 21
        //   [ktg_id] => 5
        //   [list_id] => 1
        //   [wfnum] => 1112191006123737
        //   [ta_1] => 87801546391.21
        //   [ta_2] => 104829402222.16
        //   [ta_3] => 104592348670.09
        //   [total] => 295.00
        //   [list_name] => PAD
          
          $this->SetFont('Arial','',9);
		  $this->SetWidths(array(20,170,120,120,120,120,120));
		  $this->SetAligns(array('C','L','R','R','R','R','R'));
          $no = 1; $this->SetFillColor(255);
          $total = 0;
          $rata2 = 0;
          $totalAmount = 0;
          foreach ($this->data["detail"] as $baris) {
            $total = $baris->ta_1+$baris->ta_2+$baris->ta_3;
            $rata2 = $total/3;
              $this->Row(
                  array($no, 
                  $baris->list_name,
                  number_format($baris->ta_1,2,'.',','),
                  number_format($baris->ta_2,2,'.',','),
                  number_format($baris->ta_3,2,'.',','),
                  number_format($total,2,'.',','),
                  number_format($rata2,2,'.',',') 
              ));
              if($no >1){
                $totalAmount += $rata2;
              }
              $no++;    
          }
        

        if($header->ktg_id == 6){
          $this->SetFont('Arial','B',9);
		  $this->Row(
			  array(
                  '',
                  '',
                  '',
                  '',
                  '',
				  'TOTAL KASDA',
                  number_format(abs($totalAmount),2,'.',',')
			  )
          );
        }


		  $this->Ln(35);
		  $this->SetFont("", "", 9);
		  $this->SetX($left2); $this->Cell(0, 7, 'NOTES :', 0, 1,'L');
		  $this->Ln(5);
		  $this->SetX($left2); $this->MultiCell(400, 12, $header->doc_footer, 0, 1,'L');
		  $this->Ln(20);

		  $this->SetFont("", "", 9);
		  $this->SetX($left-50); $this->Cell(0, 10, 'Jakarta, '.date('d F Y') , 0, 1,'L');
		  $this->Ln(6);
          $this->SetX($left-50); $this->MultiCell(180, 10, "Direktur Fasilitasi Dana Perimbangan\ndan Pinjaman Daerah,", 0, 1,'L');
		  $this->Ln(60);
		  $this->SetX($left-50); $this->Cell(0, 10, $header->doc_ttd, 0, 1,'L');
              
  
      }
  
      public function printPDF () {
                  
          if ($this->options['paper_size'] == "F4") {
              $a = 8.3 * 72; //1 inch = 72 pt
              $b = 13.0 * 72;
              $this->FPDF($this->options['orientation'], "pt", array($a,$b));
          } else {
              $this->FPDF($this->options['orientation'], "pt", $this->options['paper_size']);
          }
          
          $this->SetAutoPageBreak(false);
          $this->AliasNbPages();
          $this->SetFont("helvetica", "B", 10);
          //$this->AddPage();
      
          $this->rptDetailData();
                  
          $this->Output($this->options['filename'],$this->options['destinationfile']);
        }
        
        
        
      private $widths;
      private $aligns;
  
      function SetWidths($w)
      {
          //Set the array of column widths
          $this->widths=$w;
      }
  
      function SetAligns($a)
      {
          //Set the array of column alignments
          $this->aligns=$a;
      }
  
      function Row($data)
      {
          //Calculate the height of the row
          $nb=0;
          for($i=0;$i<count($data);$i++)
              $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
          $h=15*$nb;
          //Issue a page break first if needed
          $this->CheckPageBreak($h);
          //Draw the cells of the row
          for($i=0;$i<count($data);$i++)
          {
              $w=$this->widths[$i];
              $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
              //Save the current position
              $x=$this->GetX();
              $y=$this->GetY();
              //Draw the border
              $this->Rect($x,$y,$w,$h);
              //Print the text
              $this->MultiCell($w,15,$data[$i],0,$a);
              //Put the position to the right of the cell
              $this->SetXY($x+$w,$y);
          }
          //Go to the next line
          $this->Ln($h);
      }
  
      function CheckPageBreak($h)
      {
          //If the height h would cause an overflow, add a new page immediately
          if($this->GetY()+$h>$this->PageBreakTrigger)
              $this->AddPage($this->CurOrientation);
      }
  
      function NbLines($w,$txt)
      {
          //Computes the number of lines a MultiCell of width w will take
          $cw=&$this->CurrentFont['cw'];
          if($w==0)
              $w=$this->w-$this->rMargin-$this->x;
          $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
          $s=str_replace("\r",'',$txt);
          $nb=strlen($s);
          if($nb>0 and $s[$nb-1]=="\n")
              $nb--;
          $sep=-1;
          $i=0;
          $j=0;
          $l=0;
          $nl=1;
          while($i<$nb)
          {
              $c=$s[$i];
              if($c=="\n")
              {
                  $i++;
                  $sep=-1;
                  $j=$i;
                  $l=0;
                  $nl++;
                  continue;
              }
              if($c==' ')
                  $sep=$i;
              $l+=$cw[$c];
              if($l>$wmax)
              {
                  if($sep==-1)
                  {
                      if($i==$j)
                          $i++;
                  }
                  else
                      $i=$sep+1;
                  $sep=-1;
                  $j=$i;
                  $l=0;
                  $nl++;
              }
              else
                  $i++;
          }
          return $nl;
      }
    }
    

