<div class="case-prog">
    <div class="row">
        <div class="col-md-8">
            <p><strong>Case started: <?php echo $phase1->customer_note;?></strong></p>
            <p><strong>Contract Signed: </strong><span class="case_status"><?php echo $phase2->customer_note??"Inprogress";?></span></p>
        </div>
        <div class="col-md-4">
            <?php echo $this->load->view("log");?>
        </div>
    </div>
   
</div>

<div class="modal fade" id="caseStartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content case-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Contract Signed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_case" action="javascript:prcesscase();">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label case-label">Contract Signed</label>
                        <div class="col-md-6">
                            <input type="text" name="case_started" id="case_started" class="form-control" placeholder="Remark" value=""
                                required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-md-4 control-label case-label"></label>
                        <div class="col-md-6">
                           <input type="checkbox" name="send_email" id="send_email" value="1"> Send Email
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">YES</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#form_case").validate();
          <?php if($this->session->userdata("clms_front_user_group") != 14) {?>
            $('#caseStartModal').modal('show');
        <?php } ?>
    });
    function prcesscase(){
        var remark = $("#case_started").val();
        var enroll_id = $("#enroll_id").val();
        var student_id = $("#student_id").val();
        var phase = $("#phase_id").val();
        var send_email = $("#send_email").prop("checked") ? 1 : 0;
         
        

        $.ajax({
            url: '<?php echo base_url() ?>project/add_phase',
            type: "POST",
            data: {remark:remark,enroll_id:enroll_id,phase:2,send_email:send_email},
            success: function(data) { 
                var link = '<?php echo base_url("project/case")?>/'+student_id+'/'+enroll_id+'/'+3;
                window.location.href  =  link;
            }        
        });
    }
</script>