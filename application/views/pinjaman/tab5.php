<div class="row">
    <div class="col-sm-12 col-md-12">
        
        <p>
            <button onclick="loadDocument(6);" data-toggle="modal" data-backdrop="static" href="#templatePrint" data-placement="bottom" data-container="body" class="btn btn-default btn-sm"><i class="splashy-printer"></i>  Cetak Dokumen</button>  
        </p>

        <div id="tab5_tblItemData"></div>
    </div>
</div>


<div class="modal fade" id="templateRataDscr1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">Cetak Dokumen</h3>
            </div>
            <div class="modal-body">

                <form id="frmModaltab5_dscr">
                    <input type="hidden" id="tab5_wfnum" name="tab5_wfnum">
                    <input type="hidden" id="tab5_dscr_id" name="tab5_dscr_id">
                    <input type="hidden" id="tab5_ktg_id" name="tab5_ktg_id">
                    <div class="formSep">
                        <div class="form-group">
                            <label>Realisasi TA <?php echo $ryear['y1'];?></label>
                            <input name="tab5_ta_1" id="tab5_ta_1" class="form-control input-align text-input-align" type="text">
                        </div>
                    </div>
                    <div class="formSep">
                        <div class="form-group">
                            <label>Realisasi TA <?php echo $ryear['y2'];?></label>
                            <input name="tab5_ta_2" id="tab5_ta_2" class="form-control input-align text-input-align" type="text">
                        </div>
                    </div>
                    <div class="formSep">
                        <div class="form-group">
                            <label>Realisasi TA <?php echo $ryear['y3'];?></label>
                            <input name="tab5_ta_3" id="tab5_ta_3" class="form-control input-align text-input-align" type="text">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="tab5_btnSaveModal" class="btn btn-default"><i class="splashy-document_letter_okay"></i> Simpan</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

        var wfnum = $('#txtWfnum').val();
        tab5_loadtable(wfnum);


        var tab5_ta_1 = document.getElementById('tab5_ta_1');
		tab5_ta_1.addEventListener('keyup', function(e){
			tab5_ta_1.value = formatRupiah(this.value, '');
        });

        var tab5_ta_2 = document.getElementById('tab5_ta_2');
		tab5_ta_2.addEventListener('keyup', function(e){
			tab5_ta_2.value = formatRupiah(this.value, '');
        });

        var tab5_ta_3 = document.getElementById('tab5_ta_3');
		tab5_ta_3.addEventListener('keyup', function(e){
			tab5_ta_3.value = formatRupiah(this.value, '');
        });

        function tab5_loadtable(wfnum){
            $.ajax({
                url     : baseurl+"doc/tab5/loadtable",
                type    : "POST",
                dataType: "json",
                data    : { "wfnum" : wfnum },
                beforeSend: function(xhr){
                }, 
                success : function(data){
                    $('#tab5_tblItemData').html(data.html);
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
        }
        

        $('#tab5_btnSaveModal').on("click", function(e) {
            $.ajax({
                url     : baseurl+"doc/tab5/savedata",
                type    : "POST",
                data    : $('#frmModaltab5_dscr').serializeArray(),
                success : function(data){
                    $('#templateRataDscr1').modal('hide');
                    tab5_loadtable($('#txtWfnum').val());
                },
                error   : function(){
                    alert('Opps: Something Error!');
                }
            });
            return false;
        });

        function tab5_modalDscr(wfnum,dscr_id,ktg_id,list_id,ta_1,ta_2,ta_3){
            $('#tab5_wfnum').val(wfnum);
            $('#tab5_dscr_id').val(dscr_id);
            $('#tab5_ktg_id').val(ktg_id);
            $('#tab5_ta_1').val(ta_1);
            $('#tab5_ta_2').val(ta_2);
            $('#tab5_ta_3').val(ta_3);
        }

  
</script>

