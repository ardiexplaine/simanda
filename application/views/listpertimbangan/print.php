<html>
<head>
<style>
.landScape
{
 width: 100%;
 height: 100%;
 margin: 0% 0% 0% 0%;
 filter: progid:DXImageTransform.Microsoft.BasicImage(Rotation=3);
}



table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 1px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
<title>Rekap Pertimbangan Pinjaman Daerah </title>
</head>

<body onload="window.print()" class="landScape">


<center><b style="font-size: 20px">Daftar Pertimbangan Menteri Dalam Negeri tentang Pinjaman Daerah</b><br><?php echo isset($tahun) ? $tahun : '';?>
	
	</center><br>


<br/>
<table id="tblListPertimbangan" class="display" border='1' style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>NDI</th>
            <th>Nama Daerah</th>
            <th>No Surat Permohonan</th>
            <th>Tgl Surat Permohonan</th>
            <th>No Surat Pertimbangan</th>
            <th>Tgl Surat Pertimbangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no='1';
        foreach($content as $row) :
        ?>
        <tr>
            <td width="2%"><?php echo $no++;?></td>
            <td width="10%"><?php echo $row->wfnum;?></td>
            <td width="20%"><?php echo $row->namakab;?></td>
            <td width="20%"><?php echo $row->docnumber;?></td>
            <td width="10%"><?php echo date('d M Y',strtotime($row->doctgl));?></td>
            <td width="10%"><?php echo $row->surat_mendagri;?></td>
            <td width="10%"><?php echo date('d M Y',strtotime($row->tgl_surat));?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>