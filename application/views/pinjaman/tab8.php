<div class="row">
    <div class="col-sm-12 col-md-12">
        
        <p>
            <button onclick="loadDocument(8);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>

        <div id="tab8_tblItemData"></div>
    </div>
</div>


<div class="modal fade" id="templateRataDscr3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">TOTAL BELANJA</h3>
            </div>
            <div class="modal-body">

                <form id="frmModaltab8_dscr">
                    <input type="hidden" id="tab8_wfnum" name="tab8_wfnum">
                    <input type="hidden" id="tab8_dscr_id" name="tab8_dscr_id">
                    <input type="hidden" id="tab8_ktg_id" name="tab8_ktg_id">
                    <div class="formSep">
                        <div class="form-group">
                            <label>Belanja TA <?php echo date('Y'); ?></label>
                            <input name="tab8_ta_1" id="tab8_ta_1" class="form-control input-align text-input-align" type="text">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="tab8_btnSaveModal" class="btn btn-default"><i class="splashy-document_letter_okay"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        tab8_loadtable(wfnum);


        var tab8_ta_1 = document.getElementById('tab8_ta_1');
		tab8_ta_1.addEventListener('keyup', function(e){
			tab8_ta_1.value = formatRupiah(this.value, '');
        });

        function tab8_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab8/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab8_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab8_btnSaveModal').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab8/savedata",
                type    : "POST",
                data    : $('#frmModaltab8_dscr').serializeArray(),
                success : function(data){
                    $('#templateRataDscr3').modal('hide');
                    tab8_loadtable($('#txtWfnum').val());
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });

        function tab8_modalDscr(wfnum,dscr_id,ktg_id,list_id,ta_1){
            $('#tab8_wfnum').val(wfnum);
            $('#tab8_dscr_id').val(dscr_id);
            $('#tab8_ktg_id').val(ktg_id);
            $('#tab8_ta_1').val(ta_1);
        }

  
</script>

