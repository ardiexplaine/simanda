<div class="row">
    <div class="col-sm-12 col-md-12">
    <h3 class="heading">KEGIATAN PINJAMAN DAERAH YANG SESUAI DALAM RKPD</h3>
        <div class="flex-container">
        <div style="width: 25%; background-color:DodgerBlue;text-align: justify;">TATACARA:</div>
            <div style="width: 25%; background-color:#3cb371;text-align: justify;">1. Unduh file KAK.exl pada dokumen persyaratan </div>
            <div style="width: 35%; background-color:#3cb371;text-align: justify;">2. Klik tombol import dokumen, untuk memasukkan data ke database</div>
            <div style="width: 15%; background-color:#3cb371;text-align: justify;">3. Klik tombol Cetak</div>
        </div><br>
        <p>
        <!--    <button id="tab9-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> -->
                <button onclick="initFile(2);" data-toggle="modal" data-backdrop="static" href="#uploadExcel" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-document_letter_upload""></i>  Import Dokumen</button>  
                <button onclick="loadDocument(2);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>

        <!-- Form Input Kegiatan diSembunyikan, karena menggunakan tombol import dari excel
        <form class="form-horizontal" id="tab9-form" role="form">

            <div class="form-group">
                <label for="tab9_urusan" class="col-lg-2 control-label">Urusan *</label>
                <div class="col-lg-7">
                    <select class="urusan_select2" style="width: 55%" name="tab9_urusan_id" id="tab9_urusan_id">
                        <?php 
                         //   $query = $this->db->get('m_urusan');
                         //   foreach($query->result() as $row) :
                        ?>
                        <option value="<?php // echo $row->urusan_id;?>"><?php // echo $row->urusan;?></option>
                        <?php // endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="tab9_title" class="col-lg-2 control-label">Kegiatan Pinjaman Daerah Yang Diusulkan RKPD*</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" name="tab9_title" id="tab9_title" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab9_amount" class="col-lg-2 control-label">Jumlah *</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align" name="tab9_amount" id="tab9_amount" >
                </div>
            </div>
            <div class="formSep"></div>
        </form>
            
        -->
        <div id="tab9_tblItemData"></div>
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        $("#tab9_amount").addClass("text-input-align");
        tab9_loadtable(wfnum);
        var tab9_amount = document.getElementById('tab9_amount');
		tab9_amount.addEventListener('keyup', function(e){
			tab9_amount.value = formatRupiah(this.value, '');
        });

        function tab9_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab9/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab9_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        function tab9delitem(id){
            $.ajax({
                url     : baseurl+"doc/tab9/deletdata",
                type    : "POST",
                dataType: "json",
                data    : { "item_id" : id },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    tab9_loadtable(wfnum);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab9-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab9/savedata",
                type    : "POST",
                data    : $('#form-header, #tab9-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab9-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab9-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab9_loadtable($('#txtWfnum').val());
                    $('#tab9-form input').val('');
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });



  
</script>

