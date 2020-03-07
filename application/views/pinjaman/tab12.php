<div class="row">
    <div class="col-sm-12 col-md-12">
        
        <p>
            <button id="tab12-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> 
            <button onclick="loadDocument(12);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>
        <form class="form-horizontal" id="tab12-form" role="form">
            <div class="form-group">
                <label for="tab12_title" class="col-lg-2 control-label">Uraian Honorarium PNS *</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" name="tab12_title" id="tab12_title" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab12_amount" class="col-lg-2 control-label">Jumlah *</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align" name="tab12_amount" id="tab12_amount" >
                </div>
            </div>
            <div class="formSep"></div>
        </form>

        <div id="tab12_tblItemData"></div>
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        $("#tab12_amount").addClass("text-input-align");
        tab12_loadtable(wfnum);
        var tab12_amount = document.getElementById('tab12_amount');
		tab12_amount.addEventListener('keyup', function(e){
			tab12_amount.value = formatRupiah(this.value, '');
        });

        function tab12_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab12/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab12_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        function tab12delitem(id){
            $.ajax({
                url     : baseurl+"doc/tab12/deletdata",
                type    : "POST",
                dataType: "json",
                data    : { "item_id" : id },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    tab12_loadtable(wfnum);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab12-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab12/savedata",
                type    : "POST",
                data    : $('#form-header, #tab12-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab12-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab12-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab12_loadtable($('#txtWfnum').val());
                    $('#tab12-form input').val('');
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });
  
</script>

