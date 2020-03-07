<div class="row">
    <div class="col-sm-12 col-md-12">
        
        <p>
            <button id="tab10-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> 
            <button onclick="loadDocument(3);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
            <button onclick="initFile(3);" data-toggle="modal" data-backdrop="static" href="#uploadExcel" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-document_letter_upload""></i>  Import Dokumen</button>  
        </p>
        <form class="form-horizontal" id="tab10-form" role="form">

            <div class="form-group">
                <label for="tab10_urusan" class="col-lg-2 control-label">Urusan *</label>
                <div class="col-lg-7">
                    <select class="urusan_select2" style="width: 55%" name="tab10_urusan_id" id="tab10_urusan_id">
                        <?php 
                            $query = $this->db->get('m_urusan');
                            foreach($query->result() as $row) :
                        ?>
                        <option value="<?php echo $row->urusan_id;?>"><?php echo $row->urusan;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        
            <div class="form-group">
                <label for="tab10_title" class="col-lg-2 control-label">Kegiatan Pinjaman Daerah Yang Disetujui*</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" name="tab10_title" id="tab10_title" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab10_amount" class="col-lg-2 control-label">Jumlah *</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align" name="tab10_amount" id="tab10_amount" >
                </div>
            </div>
            <div class="formSep"></div>
        </form>

        <div id="tab10_tblItemData"></div>
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        $("#tab10_amount").addClass("text-input-align");
        tab10_loadtable(wfnum);
        var tab10_amount = document.getElementById('tab10_amount');
		tab10_amount.addEventListener('keyup', function(e){
			tab10_amount.value = formatRupiah(this.value, '');
        });

        function tab10_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab10/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab10_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        function tab10delitem(id){
            $.ajax({
                url     : baseurl+"doc/tab10/deletdata",
                type    : "POST",
                dataType: "json",
                data    : { "item_id" : id },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    tab10_loadtable(wfnum);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab10-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab10/savedata",
                type    : "POST",
                data    : $('#form-header, #tab10-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab10-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab10-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab10_loadtable($('#txtWfnum').val());
                    $('#tab10-form input').val('');
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });

  
</script>

