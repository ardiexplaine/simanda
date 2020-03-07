<style>
.flex-container {
  border-radius: 5px;
  
  display: flex;
}

.flex-container > div {
  border-radius: 5px;
  padding: 8px;
  box-shadow: 1px 1px 2px #888888;
  margin: 4px;

  font-size: 12px;
  vertical-align: top;
}
</style>

<script type="text/javascript" class="init">
    $(document).ready(function() {
        loaddashboard();

        $('#animasiProgress').stepbar({
            items: ['Pengajuan Baru', 'Upload Dokumen Persyaratan', 'Diajukan ke Kemendagri', 'Diterima Kemendagri', 'Memenuhi Syarat', 'Surat Pertimbangan Telah Terbit', 'Melaporkan Komulatif', 'Selesai'],
            color: '#84B1FA',
            fontColor: '#000',
            selectedColor: '#223D8F',
            selectedFontColor: '#fff',
            current: 5
        });

        function loaddashboard() {
            // hapus datatable
            var table = $('#tblDashboard').DataTable();
            table.destroy();

            var formData = {
                'wfnum': $('#txtWfnum').val(),
            };

            var cols = [
                { "data": "no","width": "1%" },
                { "data": "wfnum","width": "9%" },
                { "data": "group_user","width": "20%" },
                { "data": "docnumber","width": "14%" },
                { "data": "doctgl","width": "6%" },
                { "data": "stsnm","width": "23  %" },
                { "data": "zdate","width": "9%" },
                { "data": "workdays","width": "9%" },
                { "data": "deadline","width": "9%" }
            ];   

            $('#tblDashboard').DataTable({
                "ajax": {
                    "url": baseurl+"dashboard/loadDashboard",
                    "type": "POST",
                    "data": formData,
                    "deferLoading": 57,
                    "scrollY": "200px",
                    "scrollCollapse": true,
                    "paging": false,
                    "dataSrc": ""
                },
                "columns": cols
            });

            $('#tblDashboard tbody').on('click', 'tr', function () {
                var table = $('#tblDashboard').DataTable();
                var data = table.row( this ).data();
                //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
                location.href = 'dashboard/detail/'+data["wfnum"];
            });
        }
    });
</script>

<?php
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    echo tgl_indo(date('Y-m-d'));
}

function hari_ini(){
	$hari = date ("D");

	switch($hari){
        case 'Sun':$hari_ini = "Minggu";
		break;
		case 'Mon':$hari_ini = "Senin";
		break;
		case 'Tue':$hari_ini = "Selasa";
		break;
		case 'Wed':$hari_ini = "Rabu";
		break;
		case 'Thu':$hari_ini = "Kamis";
		break;
		case 'Fri':$hari_ini = "Jumat";
		break;
		case 'Sat':$hari_ini = "Sabtu";
		break;
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}

	return "" . $hari_ini . "";

}


//Menampilkan fungsi tanggal

$tanggal= mktime(date("m"),date("d"),date("Y"));

date_default_timezone_set('Asia/Jakarta');
$jam=date("H:i:s");

$a = date ("H");


?>
<div style="display: flex; ">
    <div style="border-bottom: double; width: 85%;"><h3>BERANDA</h3></div>
    <div style="display: flex; background-color: #000080; width: 15%; height:45px; color:white;">
        <div style="width: 25%;"><i class="fa fa-calendar" style="font-size:35px; padding: 5px; "></i></div>
        <div>
            <span style="font-size:16px;"><?php echo tgl_indo(date('Y-m-d'));  ?></span>
            <span style="font-size:12px;"><?php echo "<br>". hari_ini().","; ?> <?php echo date("h:i:s"); ?></span>
        </div>
    </div>
</div>
<br>

<div class="flex-container">
<div style="width: 31%; background-color: rgb(240, 240, 240);text-align: justify;">
<h2> 
<?php    
if (($a>=6) && ($a<=11))        { echo "Selamat Pagi"; }
else if(($a>11) && ($a<=15))    { echo "Selamat Siang";}
else if (($a>15) && ($a<=18))   { echo "Selamat Sore";}
else { echo ", <b> Selamat Malam </b>";}
?>
</h2 > 
Selamat datang dilayanan Pemberian Pertimbangan 
Menteri Dalam Negeri tentang Pinjaman Daerah bagi Pemerintah Daerah</div>
  <div style="width: 69%;background-color: rgb(240, 240, 240);">
  
        <h3><u>Informasi</u></h3>
            <ul>
                <li style="color:red;">Semua dokumen yang disampaikan/dilampirkan dalam sistem aplikasi ini adalah salinan sesuai dengan dokumen aslinya.</li>
                <li>Batas penyampaian dokumen fisik ke Kemendagri paling lambat <i style="color:red;">3 Hari Kerja</i> Setelah dokumen persyaratan lengkap diupload</li>
                <li>Apabila ukuran dokumen fisik terlalu tebal, maka yang diupload adalah <i style="color:red;">Lembar Depan dan Lembar Pengesahaan</i></li>
            </ul>
</div>
</div>
<br>


<div style="border-radius: 10px; border: 1px solid grey;padding: 10px; width: 100%;height: 100%;">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="tabbable tabbable-bordered">
                <table id="tblDashboard" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NDI</th>
                            <th>Daerah</th>
                            <th>No. Surat</th>
                            <th>Tgl. Surat</th>
                            <th>Status</th>
                            <th>Sisa Booking</th>
                            <th>Sisa Hari kerja</th>
                            <th>Peringatan Dini*</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <span style="font-style: italic;">*Peringatan Dini adalah himbauan, 2 hari sebelum masa pengajuan berkas ke Mendagri di sisa waktu hari ke 5</span>
</div>