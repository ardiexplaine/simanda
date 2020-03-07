<?php  
    
    require_once("fpdf17/fpdf.php");
    require_once("fpdi/fpdi.php");
    
    class doc_template extends FPDI {

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

        function rupiah($val){
            return number_format($val,0,'.',',');
        }
      
        public function gettemplate() {

            $head = $this->data["header"];
            $row = $this->data["detail"];

            //echo '<pre/>'; print_r($this->data["detail"]); exit;
          
            $template = "assets/dscr.pdf";
            $fontType = 'Arial';
            $fontSmall = 9;
            $fontLarge = 10;
            $globPdfWidth = 0;

            $this->AddPage();
            $this->SetMargins(2,0,0,2);
            $this->SetAutoPageBreak(true, -120);
            $this->setSourceFile($template);
            $tplIdx = $this->importPage(1); 
            $this->useTemplate($tplIdx, 0, 0);

            $left2 = 25;

            $this->Ln(17);
            $this->SetFont($fontType,'B',8);
            $this->SetX($left2+16.5); $this->MultiCell(150, 3,strtoupper($head->doc_title), 0, 'L');
    
    

            $this->Ln(4.6);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->rencana_usulan_pinjaman), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->bunga_tahun), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->jangka_waktu_pinjam), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->tenggang_waktu), 0, 1,'R');
            
            $this->SetFont($fontType,'',7.5);
            $this->Ln(61); //Komponen A
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->pad), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->dbh), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->dau), 0, 1,'R');
            
            $this->Ln(2.5); // Jumlah Komponen A
            $jmlKomponenA = $row->pad+$row->dbh+$row->dau;
            $this->SetX($left2); $this->Cell(150, 3.7, $this->rupiah($jmlKomponenA), 0, 1,'R');

            $this->Ln(9.3); //Komponen B
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->belanja_pegawai), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->dbh_dr), 0, 1,'R');

            $this->Ln(0); // Jumlah Komponen B
            $jmlKomponenB = $row->belanja_pegawai+$row->dbh_dr;
            $this->SetX($left2); $this->Cell(150, 3.7, $this->rupiah($jmlKomponenB), 0, 1,'R');

            $this->Ln(6); //Komponen C
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->angsuran_bunga), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->angsuran_pokok), 0, 1,'R');
            $this->Ln(4.5);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->biaya_lain), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->pembayaran_pokok), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->bunga_pinjaman_lama), 0, 1,'R');
            $jmlKomponenC = $row->angsuran_bunga+$row->angsuran_pokok+$row->biaya_lain+$row->pembayaran_pokok+$row->bunga_pinjaman_lama;
            $this->Ln(0.5);
            $this->SetX($left2); $this->Cell(150, 3.7, $this->rupiah($jmlKomponenC), 0, 1,'R');

            $this->Ln(3);
            $this->SetX($left2); $this->Cell(67, 3.7, $this->rupiah($jmlKomponenA), 0, 1,'R');
            $this->Ln(-3.5);
            $this->SetX($left2); $this->Cell(98, 3.7, $this->rupiah($jmlKomponenB), 0, 1,'R');

            $this->Ln(3);
            $this->SetX($left2); $this->Cell(80, 3.7, $this->rupiah($jmlKomponenC), 0, 1,'R');
            $this->Ln(5);

            // DSCR
            $dscr = $jmlKomponenA - $jmlKomponenB;
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($dscr), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($jmlKomponenC), 0, 1,'R');

            $dscr2 = $dscr/$jmlKomponenC;
            $this->SetX($left2); $this->Cell(105, 3.7, $dscr2, 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($dscr2), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, '>2.5', 0, 1,'R');
            if($this->rupiah($dscr2)>= 2.5){
                $hasil = 'Memenuhi Persyaratan';
            }else{
                $hasil = 'Tidak Memenuhi Persyaratan';
            }

            $this->SetFont($fontType,'B',8);
            $this->SetX($left2+75); $this->Cell(105, 3.7, $hasil, 0, 1,'L');
            $this->SetFont($fontType,'',8);

            $this->Ln(3);
            $this->SetX($left2+100); $this->Cell(20, 3.6, date('d F Y'), 0, 1,'L');

            $this->Ln(25);
            $this->SetX($left2+90); $this->Cell(10, 3.7, $head->doc_ttd, 0, 1,'L');


            $filename = 'dscr-pp-30.pdf';
            $this->Output($filename,'I');
  
        }

        public function gettemplate2() {

            $head = $this->data["header"];
            $row = $this->data["detail"];
          
            $template = "assets/dscr.pdf";
            $fontType = 'Arial';
            $fontSmall = 9;
            $fontLarge = 10;
            $globPdfWidth = 0;

            $this->AddPage();
            $this->SetMargins(2,0,0,2);
            $this->SetAutoPageBreak(true, -120);
            $this->setSourceFile($template);
            $tplIdx = $this->importPage(1); 
            $this->useTemplate($tplIdx, 0, 0);

            // mulai untuk memasukan datanya
            $y = 10.5; //kebawah
            $x = 34.4; //kesamping
            $left2 = 25;

            $this->Ln(16);
            $this->SetFont($fontType,'B',8);
            $this->SetX($left2+16.5); $this->MultiCell(150, 3.5,strtoupper($head->doc_title), 0, 'L');

            $this->Ln(4);

            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->rencana_usulan_pinjaman), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->bunga_tahun), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->jangka_waktu_pinjam), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->tenggang_waktu), 0, 1,'R');

            
            $this->Ln(60);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->pad), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->dbh), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->dau), 0, 1,'R');
            
            $this->Ln(2.5);
            $jmlKomponenA = $row->pad+$row->dbh+$row->dau;
            $this->SetX($left2); $this->Cell(150, 3.7, $this->rupiah($jmlKomponenA), 0, 1,'R');

            $this->Ln(10);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->belanja_pegawai), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->dbh_dr), 0, 1,'R');

            $this->Ln(0.9);
            $jmlKomponenB = $row->belanja_pegawai+$row->dbh_dr;
            $this->SetX($left2); $this->Cell(150, 3.7, $this->rupiah($jmlKomponenB), 0, 1,'R');

            $this->Ln(5.5);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->angsuran_bunga), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->angsuran_pokok), 0, 1,'R');
            $this->Ln(3);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->biaya_lain), 0, 1,'R');
            $this->Ln(3);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->pembayaran_pokok), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->sisa_pembayaran_pokok_pinjaman), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->bunga_pinjaman_lama), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->sisa_pembayaran_bunga_pinjaman), 0, 1,'R');

            $this->Ln(0.5);
            $jmlKomponenC = $row->angsuran_bunga+$row->angsuran_pokok+$row->biaya_lain+$row->pembayaran_pokok+$row->sisa_pembayaran_pokok_pinjaman+$row->bunga_pinjaman_lama+$row->sisa_pembayaran_bunga_pinjaman;
            $this->SetX($left2); $this->Cell(150, 3.7, $this->rupiah($jmlKomponenC), 0, 1,'R');

            $this->Ln(3);
            $this->SetX($left2); $this->Cell(67, 3.7, $this->rupiah($jmlKomponenA), 0, 1,'R');
            $this->Ln(-3.5);
            $this->SetX($left2); $this->Cell(98, 3.7, $this->rupiah($jmlKomponenB), 0, 1,'R');

            $this->Ln(3);
            $this->SetX($left2); $this->Cell(80, 3.7, $this->rupiah($jmlKomponenC), 0, 1,'R');
            $this->Ln(2.3);

            $dscr = $jmlKomponenA - $jmlKomponenB;
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($dscr), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($jmlKomponenC), 0, 1,'R');

            $dscr2 = $dscr/$jmlKomponenC;
            $this->SetX($left2); $this->Cell(105, 3.7, $dscr2, 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7,  $this->rupiah($dscr2), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, '>2.5', 0, 1,'R');
            if($this->rupiah($dscr2)>= 2.5){
                $hasil = 'Memenuhi Persyaratan';
            }else{
                $hasil = 'Tidak Memenuhi Persyaratan';
            }
            $this->SetX($left2+75); $this->Cell(105, 3.7, $hasil, 0, 1,'L');

            $this->SetFont($fontType,'',8);
            $this->Ln(2.6);
            $this->SetX($left2+96); $this->Cell(20, 3.9, date('d F Y'), 0, 1,'L');

            $this->Ln(25);
            $this->SetX($left2+86); $this->Cell(10, 3.7, $head->doc_ttd, 0, 1,'L');


            $filename = 'rata2-dscr.pdf';
            $this->Output($filename,'I');
  
        }

        public function gettemplate3() {

            $head = $this->data["header"];
            $row = $this->data["detail"];
          
            $template = "assets/sisa_pinjaman.pdf";
            $fontType = 'Arial';
            $fontSmall = 9;
            $fontLarge = 10;
            $globPdfWidth = 0;

            $this->AddPage();
            $this->SetMargins(2,0,0,2);
            $this->SetAutoPageBreak(true, -120);
            $this->setSourceFile($template);
            $tplIdx = $this->importPage(1); 
            $this->useTemplate($tplIdx, 0, 0);

            // mulai untuk memasukan datanya
            $y = 10.5; //kebawah
            $x = 34.4; //kesamping
            $left2 = 25;

            $this->Ln(32);
            $this->SetFont($fontType,'B',11);
            $this->SetX($left2+16.5); $this->MultiCell(120, 3.5,strtoupper($head->doc_title), 0, 'C');

            $this->Ln(19);
            $this->SetFont($fontType,'B',8);
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($row->rencana_pinjaman), 0, 1,'R');
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($row->sisa_pinjaman), 0, 1,'R');
            $this->Ln(2);
            $sub1 = $row->rencana_pinjaman+ $row->sisa_pinjaman;
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($sub1), 0, 1,'R');


            $this->Ln(13);
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($row->pendapatan_daerah), 0, 1,'R');

            
            $this->Ln(10.5);
            $this->SetX($left2- 20); $this->Cell(105, 3.7, $this->rupiah($row->dak), 0, 1,'R');
            $this->SetX($left2- 20); $this->Cell(105, 3.7, $this->rupiah($row->dana_darurat), 0, 1,'R');
            $this->SetX($left2- 20); $this->Cell(105, 3.7, $this->rupiah($row->dana_penyesuaian), 0, 1,'R');

            $this->Ln(5.5);
            $sub2 = $row->dak+ $row->dana_darurat+$row->dana_penyesuaian;
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($sub2), 0, 1,'R');


            $this->Ln(7.5);
            $this->SetX($left2-20); $this->Cell(105, 3.7, $this->rupiah($row->pendapatan_daerah), 0, 1,'R');
            $this->Ln(-3.5);
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($sub2), 0, 1,'R');

            $this->Ln(1);
            $sub3 = $row->pendapatan_daerah-$sub2;
            $this->SetX($left2-20); $this->Cell(105, 3.7, $this->rupiah($sub3), 0, 1,'R');


            $this->Ln(3.5);
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($sub1), 0, 1,'R');
            $this->Ln(2);
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($sub3), 0, 1,'R');


            $this->Ln(3);
            $sub4 = $sub1/$sub3*100;
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $sub4, 0, 1,'R');
            $this->Ln(1);
            $this->SetX($left2+ 42); $this->Cell(105, 3.7, $this->rupiah($sub4), 0, 1,'R');

            if($sub4 < 75){
                $hasil = "MEMENUHI SYARAT";
            }else{
                $hasil = "TIDAK MEMENUHI SYARAT";
            }

            $this->Ln(7.5);
            $this->SetX($left2+ 20); $this->Cell(105, 3.7, ": ".$hasil, 0, 1,'R');


            $this->Ln(7.5);
            $this->SetFont("", "", 9);
            $this->SetX($left2+110); $this->Cell(0, 5, 'Jakarta, '.date('d F Y') , 0, 1,'L');
            $this->SetX($left2+110); $this->MultiCell(180, 4, "Direktur Fasilitasi Dana Perimbangan\ndan Pinjaman Daerah,", 0,'L');
            $this->Ln(20);
            $this->SetX($left2+110); $this->Cell(0, 10, $head->doc_ttd, 0, 1,'L');
         


            $filename = 'rata2-dscr.pdf';
            $this->Output($filename,'I');
  
        }

        public function gettemplate4() {

            $head = $this->data["header"];
            $row = $this->data["detail"];
          
            $template = "assets/pelampauan_defisit.pdf";
            $fontType = 'Arial';
            $fontSmall = 9;
            $fontLarge = 10;
            $globPdfWidth = 0;

            $this->AddPage();
            $this->SetMargins(2,0,0,2);
            $this->SetAutoPageBreak(true, -120);
            $this->setSourceFile($template);
            $tplIdx = $this->importPage(1); 
            $this->useTemplate($tplIdx, 0, 0);

            // mulai untuk memasukan datanya
            $y = 10.5; //kebawah
            $x = 34.4; //kesamping
            $left2 = 20;

            $this->Ln(22);
            $this->SetFont($fontType,'B',11);
            $this->SetX($left2); $this->MultiCell(160, 5,strtoupper($head->doc_title), 0, 'C');

            $this->Ln(10.5);
            $this->SetFont($fontType,'B',9);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->pendapatan_daerah), 0, 1,'R');
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->belanja), 0, 1,'R');
            $this->Ln(2);
            $total1 = $row->pendapatan_daerah - $row->belanja;
            if($total1 < 0){
                $total1 = '('. $this->rupiah($total1*(-1)) .')';
            }else{
                $total1 = $this->rupiah($total1);
            }
            $this->SetX($left2); $this->Cell(105, 3.7, $total1 , 0, 1,'R');

            
            $this->Ln(4);
            $this->SetFont($fontType,'B',9);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->rencana_pinjaman), 0, 1,'R');
            $this->Ln(1);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->rencana_pinjaman), 0, 1,'R');
            $this->Ln(1.5);
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($row->pendapatan_daerah), 0, 1,'R');
            $this->Ln(3);
            $total_2 = $row->rencana_pinjaman/$row->pendapatan_daerah*100;
            $this->SetX($left2); $this->Cell(105, 3.7, $this->rupiah($total_2), 0, 1,'R');

            $this->Ln(6);
            $this->SetFont($fontType,'',9);
            $this->SetX($left2+15); $this->Cell(105, 3.7, 'Persyaratan untuk TA '.$row->tahun_anggaran, 0, 1,'L');


            $this->Ln(2);
            $this->SetFont($fontType,'',9);
            $this->SetX($left2+15); $this->MultiCell(140, 5, $head->doc_footer, 0, 'J');


            $this->Ln(10);
            $this->SetFont("", "", 9);
            $this->SetX($left2+110); $this->Cell(0, 5, 'Jakarta, '.date('d F Y') , 0, 1,'L');
            $this->SetX($left2+110); $this->MultiCell(180, 4, "Direktur Fasilitasi Dana Perimbangan\ndan Pinjaman Daerah,", 0,'L');
            $this->Ln(20);
            $this->SetX($left2+110); $this->Cell(0, 10, $head->doc_ttd, 0, 1,'L');
         


            $filename = 'rata2-dscr.pdf';
            $this->Output($filename,'I');
  
        }
    }
    

