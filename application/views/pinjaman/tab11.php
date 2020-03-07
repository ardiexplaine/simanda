<div class="row">
    <div class="col-sm-12 col-md-12">
    <h3 class="heading">KEGIATAN PINJAMAN DAERAH YANG DIUSULKAN DALAM KAK</h3>
        <div class="flex-container">
            <div style="width: 25%; background-color:DodgerBlue;text-align: justify;">TATACARA:</div>
            <div style="width: 25%; background-color:#3cb371;text-align: justify;">1. Unduh file KAK.exl pada dokumen persyaratan </div>
            <div style="width: 35%; background-color:#3cb371;text-align: justify;">2. Klik tombol import dokumen, untuk memasukkan data ke database</div>
            <div style="width: 15%; background-color:#3cb371;text-align: justify;">3. Klik tombol Cetak</div>
        </div><br>
        <p>
        <!--    <button id="tab11-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> -->
            
            <button onclick="initFile(4);" data-toggle="modal" data-backdrop="static" href="#uploadExcel" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-document_letter_upload""></i>  Import Dokumen</button>    
            <button onclick="loadDocument(4);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>
        </p>

        <!-- Form Input Kegiatan diSembunyikan, karena menggunakan tombol import dari excel
        <form class="form-horizontal" id="tab11-form" role="form">

            <div class="form-group">
                <label for="tab11_urusan" class="col-lg-2 control-label">Urusan *</label>
                <div class="col-lg-7">
                    <select class="urusan_select2" style="width: 55%" name="tab11_urusan_id" id="tab11_urusan_id">
                        <?php 
                        //    $query = $this->db->get('m_urusan');
                        //    foreach($query->result() as $row) :
                        ?>
                        <option value="<?php // echo $row->urusan_id;?>"><?php // echo $row->urusan;?></option>
                        <?php // endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="tab11_title" class="col-lg-2 control-label">Kegiatan Pinjaman Daerah Yang Diusulkan KAK*</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" name="tab11_title" id="tab11_title" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab11_amount" class="col-lg-2 control-label">Jumlah *</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align" name="tab11_amount" id="tab11_amount" >
                </div>
            </div>
            <div class="formSep"></div>
        </form>
         -->                       
        <div id="tab11_tblItemData"></div>
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        $("#tab11_amount").addClass("text-input-align");
        tab11_loadtable(wfnum);
        var tab11_amount = document.getElementById('tab11_amount');
		tab11_amount.addEventListener('keyup', function(e){
			tab11_amount.value = formatRupiah(this.value, '');
        });

        function tab11_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab11/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab11_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        function tab11delitem(id){
            $.ajax({
                url     : baseurl+"doc/tab11/deletdata",
                type    : "POST",
                dataType: "json",
                data    : { "item_id" : id },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    tab11_loadtable(wfnum);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab11-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab11/savedata",
                type    : "POST",
                data    : $('#form-header, #tab11-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab11-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab11-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab11_loadtable($('#txtWfnum').val());
                    $('#tab11-form input').val('');
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });

  
</script>

