<div class="row">
    <div class="col-sm-12 col-md-12">
        
        <p>
            <button id="tab6-save" class="btn btn-default btn-sm"><i class="splashy-document_small_download"></i>  Simpan Data</button> 
            <button onclick="loadDocument(1);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>
        <form class="form-horizontal" id="tab6-form" role="form">
            <div class="form-group">
                <label for="tab7_title" class="col-lg-3 control-label">Belanja Tambahan Penghasilan*</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control" name="tab6_title" id="tab6_title" >
                </div>
            </div>

            <div  class="form-group">
                <label for="tab7_amount" class="col-lg-3 control-label">Jumlah*</label>
                <div class="col-lg-3">
                    <input type="text" class="input-sm form-control input-align" name="tab6_amount" id="tab6_amount" >
                </div>
            </div>
            <div class="formSep"></div>
        </form>

        <div id="tab6_tblItemData"></div>
        <!-- <table id="tab6_tblItemData" class="display" style="width:100%">
            <thead>
                <tr>
                <th>No</th>
                <th>Belanja Pegawai</th>
                <th>Belanja Tambahan Penghasilan PNS</th>
                <th>Action</th>
                </tr>
            </thead>
        </table> -->
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        $("#tab6_amount").addClass("text-input-align");
        loadtable(wfnum);
        var tab6_amount = document.getElementById('tab6_amount');
		tab6_amount.addEventListener('keyup', function(e){
			tab6_amount.value = formatRupiah(this.value, '');
        });

        function loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab6/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab6_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }

        function tab6delitem(id){
            $.ajax({
                url     : baseurl+"doc/tab6/deletdata",
                type    : "POST",
                dataType: "json",
                data    : { "item_id" : id },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    loadtable(wfnum);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab6-save').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab6/savedata",
                type    : "POST",
                data    : $('#form-header, #tab6-form').serializeArray(),
                beforeSend: function(xhr){
                    $('#tab6-save').prop('disabled',true);
                }, 
                success : function(data){
                    $('#tab6-save').prop('disabled',false);
                    document.getElementById('ztxtAppsMsg').innerHTML = data.notif;	
                    loadtable($('#txtWfnum').val());
                    $('#tab6-form input').val('');
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });

        // $('#tab6-print').on("click", function(e) {
        //     location.href = baseurl;
        // });

  
</script>

