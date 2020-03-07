<div class="row">
    <div class="col-sm-12 col-md-12">
        
        <p>
            <button id="tab7-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> 
            <button onclick="loadDocument(7);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>
        <form class="form-horizontal" id="tab7-form" role="form">
            <div class="form-group">
                <label for="tab7_title" class="col-lg-2 control-label">Uraian Honorarium PNS *</label>
                <div class="col-lg-4">
                    <input type="text" class="input-sm form-control" name="tab7_title" id="tab7_title" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab7_amount" class="col-lg-2 control-label">Jumlah *</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align" name="tab7_amount" id="tab7_amount" >
                </div>
            </div>
            <div class="formSep"></div>
        </form>

        <div id="tab7_tblItemData"></div>
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        $("#tab7_amount").addClass("text-input-align");
        tab7_loadtable(wfnum);
        var tab7_amount = document.getElementById('tab7_amount');
		tab7_amount.addEventListener('keyup', function(e){
			tab7_amount.value = formatRupiah(this.value, '');
        });

        function tab7_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab7/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab7_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        function tab7delitem(id){
            $.ajax({
                url     : baseurl+"doc/tab7/deletdata",
                type    : "POST",
                dataType: "json",
                data    : { "item_id" : id },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    tab7_loadtable(wfnum);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab7-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab7/savedata",
                type    : "POST",
                data    : $('#form-header, #tab7-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab7-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab7-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    tab7_loadtable($('#txtWfnum').val());
                    $('#tab7-form input').val('');
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });
  
</script>

