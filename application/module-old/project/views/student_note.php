<!-- start: page -->
<section class="panel">
    <div class="panel-body case-body">
        <?php if($this->session->flashdata("success_message")){?>
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?>
        </div>
        <?php
    }
    ?>
        <?php $this->load->view("tab");?>
        <div class="migrate-menu">
            <div class="row">
                <div class="col-sm-12">
                    <div class="migrate-menu-list">
                        <div class="mig-top-sec">
                            <h4 class="mitgrate-tt">Notes</h4>
                            <div class="adding">
                                <a href="javascript:void();"  data-toggle="modal" data-target="#customer_note"><i
                                        class="fa fa-plus"></i>Add</a>
                                <!-- <a href="javascript:void();" class="link_edit"><i class="fa fa-edit"></i>Edit</a> -->
                            </div>
                        </div>

                    </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                    </div>

                  
                    <div class="case-prog">
                        <div class="row">
                            <div class="col-md-12">
                                <section class="card">

                                    <div class="card-body">
                                        <div class="timeline timeline-simple mt-3 mb-3">
                                            <div class="tm-body">
                                                <ol class="tm-items">
                                                    <?php 
                                                    foreach($messages as $msg){
                                                        $sender = $this->projectmodel->msgsender($msg->added_by,$msg->comment_from);
                                                        ?>
                                                        <li style="clear:both;">
                                                            <div class="tm-box <?php echo $msg->added_by == $this->session->userdata("clms_front_userid") ? "customer_note":"student_note";?>">
                                                                <p class="text-muted mb-0"><?php echo date("d F, Y",strtotime($msg->added_at));?> at <?php echo date("h:i a",strtotime($msg->added_at));?> By <?php echo $sender->first_name;?> <?php echo $sender->last_name;?></p>
                                                             <?php
                                                             if($msg->comment){
                                                             ?>
                                                                <p>
                                                                    <?php echo $msg->comment;?>
                                                                </p>
                                                                <?php } ?>
                                                                <?php if($msg->file_name){ ?>
                                                                <p><span class="text-primary">
                                                                <a href="<?php echo SITE_URL."uploads/document/$msg->file_name";?>" target="_blank" ><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                                                </span>
                                                                </p>
                                                                <?php } ?>
                                                            </div>
                                                        
                                                        </li>
                                                    <?php } ?>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

</section>
</div>


</section>

<div class="modal fade" id="customer_note" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content case-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_case" action="javascript:addNote();">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-md-4 control-label case-label">Customer Note</label>
                        <div class="col-md-6">
                            <textarea name="customer_note" id="remark" class="form-control" placeholder="Customer note"></textarea>
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
              
                <div class="form-group">
                        <label class="col-md-4 control-label case-label"></label>
                        <div class="col-md-6">
                           <input type="checkbox" name="send_email" id="send_email" value="1"> Send Email
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Send</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
 

    function addNote() {
        var remark = $("#remark").val();
        var student_id = $("#student_id").val();
        var send_email = $("#send_email").prop("checked") ? 1 : 0;
        var file_name = $("#file_name").val();

        $.ajax({
            url: '<?php echo base_url() ?>project/add_customerNote',
            type: "POST",
            data: {
                remark: remark,
                send_email: send_email,
                file_name:file_name,
                student_id:student_id
            },
            success: function (data) {
               location.reload();
            }
        });
    }
    $(document).ready(function(){
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
</script>