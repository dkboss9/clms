
<div class="case-prog">
    <div class="row">
        <div class="col-md-8">
            <p><strong><?php echo $title;?>: </strong><span class="case_status">Inprogress</span></p>
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
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $title;?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_case" action="javascript:prcesscase();">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label case-label">Customer Note</label>
                        <div class="col-md-6">
                            <input type="text" name="case_started" id="case_started" class="form-control" placeholder="Customer note" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label case-label">Admin Note</label>
                        <div class="col-md-6">
                            <input type="text" name="admin_note" id="admin_note" class="form-control" placeholder="Admin note" value="">
                        </div>
                    </div>
                </div>
           
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label case-label">Attachment</label>
                        <div class="col-md-6">
                            <input type="file" name="attachment" id="attachment" class="form-control">
                            <input type="hidden" name="file_name" id="file_name" value="">
                        </div>
                        <div class="col-md-2 div_attachment">
                           
                        </div>
                    </div>
                </div>
                <?php
                if($phase == 10){
                    ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label case-label">Visa Status</label>
                            <div class="col-md-6">
                                <select name="visa_status" id="visa_status" class="form-control" required>
                                    <option value=""></option>
                                    <option value="Granted" <?php echo $enroll->visa_status == 'Granted' ? 'selected':''; ?>>Granted</option>
                                    <option value="Rejected" <?php echo $enroll->visa_status == 'Rejected' ? 'selected':''; ?>>Rejected</option>
                                </select>
                            </div>
                          
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-4 control-label case-label">Collected Points</label>
                            <div class="col-md-6">
                               <input type="number" min="0" class="form-control" name="collected_points" id="collected_points" value="<?php echo $point->points??0;?>">
                            </div>
                          
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group">
                        <label class="col-md-4 control-label case-label"></label>
                        <div class="col-md-6">
                           <input type="checkbox" name="send_email" id="send_email" value="1"> Send Email
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">YES</button>
                  <?php
                  if($phase == 5){
                      ?>
                    <button type="button" class="btn btn-danger btn-skip" >Skip</button>
                      <?php
                  }else{ 
                  ?>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                <?php } ?>
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
        $(".btn-skip").click(function(){
            var remark = $("#case_started").val();
            var enroll_id = $("#enroll_id").val();
            var student_id = $("#student_id").val();
            var phase = $("#phase_id").val();
            var admin_note = $("#admin_note").val();
            var next_phase = parseInt(phase) + 1;
            var send_email = $("#send_email").prop("checked") ? 1 : 0;
           
            $.ajax({
                url: '<?php echo base_url() ?>project/add_phase',
                type: "POST",
                data: {
                    remark:remark,enroll_id:enroll_id,phase:phase,admin_note:admin_note,is_skipped:1,send_email:send_email},
                success: function(data) { 
                    var link = '<?php echo base_url("project/case")?>/'+student_id+'/'+enroll_id+'/'+next_phase;
                    window.location.href  =  link;
                }        
            });
        });

        $(document).on("change","#attachment",function(){ 
			var file_data = $(this).prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);

			$.ajax({
				url: '<?php echo base_url("");?>company/upload_file_project/', 
				dataType: 'text', 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (response) {
				
					$('.div_attachment').html('<a href="<?php echo SITE_URL."uploads/document";?>/'+response+'" target="_blank" ><i class="fa fa-paperclip" aria-hidden="true"></i></a>');
					$('#file_name').val(response);
				},
				error: function (response) {
					$('#post_img_profile').html(response); 
				}
			});
		});
    });
    function prcesscase(){
        var remark = $("#case_started").val();
        var enroll_id = $("#enroll_id").val();
        var student_id = $("#student_id").val();
        var phase = $("#phase_id").val();
        var admin_note = $("#admin_note").val();
        var file_name = $("#file_name").val()
        var next_phase = parseInt(phase) + 1;
        var send_email = $("#send_email").prop("checked") ? 1 : 0;
        var visa_status = $("#visa_status").val();
        var collected_points = $("#collected_points").val();
        

        $.ajax({
            url: '<?php echo base_url() ?>project/add_phase',
            type: "POST",
            data: {
                remark:remark,
                enroll_id:enroll_id,
                phase:phase,
                admin_note:admin_note,
                file_name:file_name,
                send_email:send_email,
                visa_status:visa_status,
                collected_points:collected_points
                },
            success: function(data) { 
                var link = '<?php echo base_url("project/case")?>/'+student_id+'/'+enroll_id+'/'+next_phase;
                window.location.href  =  link;
            }        
        });
    }
</script>