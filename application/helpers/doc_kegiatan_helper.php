<?php  
    
    require_once("fpdf17/fpdf.php");
    
    class doc_kegiatan extends FPDF {

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
          $footer = $this->data["footer"];

            $cols1 = "Kegiatan Pinjaman Daerah Yang Diusulkan Dalam KAK dan Sesuai Dalam RKPD";
            $cols2 = "Jumlah";

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
          $this->Ln(20);
          
          
          
          $h = 25;
          $left = 40;
          $top = 80;	
          #tableheader
          $this->SetFont('Arial','',9);
		  $this->SetFillColor(200,200,200);
		  $left = $this->GetX();
		  $this->Cell(20,$h,'NO',1,0,'L',true);
		  $this->SetX($left += 20); $this->Cell(400, $h, $cols1, 1, 0, 'C',true);
		  $this->SetX($left += 400); $this->Cell(120, $h, $cols2, 1, 1, 'C',true);
          //$this->Ln(20);
          
          $this->SetFont('Arial','',9);
		  $this->SetWidths(array(20,400,120));
		  $this->SetAligns(array('C','L','R'));
          $no = 1; $this->SetFillColor(255);
          $totalAmount = 0;
          foreach ($this->data["detail"] as $baris) {
              $this->Row(
                  array($no++, 
                  $baris->title,
                  number_format($baris->amount,2,'.',',') 
              ));
              $totalAmount += $baris->amount;
          }


          $this->SetFont('Arial','B',9);
		  $this->Row(
			  array(
				  '',
				  'TOTAL KEGIATAN',
				  number_format(abs($totalAmount),2,'.',',')
			  )
          );

          $footer2 = "JUMLAH\nBESARAN MAKSIMAL PINJAMAN DAERAH\nBESARAN PINJAMAN YANG DISETUJUI";
          $tt_setuju=0;
          if($footer['tt_setuju'] == 0){
                $tt_setuju = $totalAmount-$footer['tt_jumlah'];
          }else{
                $tt_setuju = $footer['tt_setuju'];
          }


		  $this->Ln(5);
		  $this->SetFont("Arial", "", 9);
          $this->SetX($left2); $this->MultiCell(400, 12, $header->doc_footer, 0, 1,'L');;
          $this->SetFont("Arial", "B", 9);
          $this->SetX($left2); $this->MultiCell(400, 15, $footer2, 0, 1,'J');
          $this->Ln(-75);
          $this->SetX($left2+120); $this->Cell(0, 10, number_format($footer['tt_rata2_pns_pengurang'],2,'.',',') , 0, 1,'R');
          $this->Ln(4);
          $this->SetX($left2+120); $this->Cell(0, 10,  number_format($footer['tt_kasda'],2,'.',',') , 0, 1,'R');
          $this->Ln(1);
          $this->SetX($left2+120); $this->Cell(0, 10, '------------------------------- +' , 0, 1,'R');
          
          $this->SetFont("Arial", "B", 9);
          $this->Ln(3);
          $this->SetX($left2+120); $this->Cell(0, 10, number_format($footer['tt_jumlah'],2,'.',',') , 0, 1,'R');
          $this->Ln(3);
          $this->SetX($left2+120); $this->Cell(0, 10, number_format($totalAmount-$footer['tt_jumlah'],2,'.',',') , 0, 1,'R');
          $this->Ln(3);
          $this->SetX($left2+120); $this->Cell(0, 10, number_format($tt_setuju,2,'.',','), 0, 1,'R');
        //   $this->SetFont("Arial", "B", 9);
        //   $this->SetX($left2); $this->MultiCell(300, 4, 'JUMLAH', 0, 1,'L');
         
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
    

