<div class="case-prog">
    <div class="row">
        <div class="col-md-8">
            <p><strong>Case started: <?php echo $phase1->customer_note;?></strong></p>
            <p><strong>Contract Signed: <?php echo $phase2->customer_note;?></strong></p>

            <div class="doc-list">
                <div>
                    <strong>Doc List: </strong>
                </div>
                <div style="width: 90%;">
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th>Check list</th>
                                <th>File</th>
                                <th>Status</th>
                                <th>Received Date</th>
                                <th>Received and Verified By</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions"
                                    style="width: 99px;">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
   $checklists = $this->appointmentmodel->listChecklist($enroll->fee_id,'ceo-processing');
   
   foreach ($checklists->result() as $row) {
    $enroll_check = $this->projectmodel->checkChecklist($row->type_id,$enroll->order_id)->row();
    $user = $this->projectmodel->getUserDetailNew(@$enroll_check->added_by);
    $enroll_checklistid = $enroll_check->id??null;
    $checklist_files = $this->projectmodel->getchecklistfiles($enroll_checklistid);
    ?>
                            <tr class="gradeX"
                                <?php  if(@$enroll_check->checklist_status == 'Cancel') echo 'style="background:#fbdbe4"';?>>
                                <td>
                                    <?php echo $row->type_name;?>
                                </td>

                                <td>
                                <?php 
                  foreach($checklist_files as $key => $file){
                ?>
                  <a href="<?php echo SITE_URL."uploads/student_documents/".@$file->checklist_file; ?>"
                    target="_blank"> <?php echo @$file->checklist_file;?></a> 
                    <?php  }?>
                                </td>

                                <td>
                                    <?php 
      if(@$enroll_check->checklist_status == 'Received and Verified')
        $color = '#47a447';
      elseif(@$enroll_check->checklist_status == 'Pending / Not verified')
        $color = '#ef6a0a';
      elseif(@$enroll_check->checklist_status == 'In Progress')
        $color = '#390bef';
      else
       $color = '#ff003d';
     if(@$enroll_check->checklist_status != "")
      echo '<span class="label" style="background:'.$color.'">'.@$enroll_check->checklist_status.'</span>';?>
                                </td>


                                <td>
                                    <?php echo @$enroll_check->received_date;?>
                                </td>

                                <td>
                                    <?php 
      if(@$enroll_check->checklist_status == 'Received and Verified')
        echo @$user->first_name.' '.@$user->last_name;
      ?>
                                </td>

                                <td>
                                    <a class="simple-ajax-popup-reminder btn btn-primary"
                                        href="<?php echo base_url("project/edit_checklist/".$row->checklist_id.'/'.$enroll->order_id);?>">Update</a>
                                </td>

                            </tr>
                            <?php
}
?>

                        </tbody>
                    </table>

                </div>
            </div>
          
            <p><strong>Document Received: </strong> <span class="case_status">In Progress</span></p>
        </div>
        <div class="col-md-4">
            <?php echo $this->load->view("log");?>
        </div>
    </div>
</div>

<script>
     $(document).ready(function(){
        $(document).on("change","#profile_pic",function(){ 
			var file_data = $(this).prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);

			$.ajax({
				url: '<?php echo base_url("");?>project/upload_file_project', 
				dataType: 'text', 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (response) {
          $("#profile_pic").val('');
					$('#post_img_profile').append('<tr><td><input type="hidden" name="file_name[]" value="'+response+'"><a href="<?php echo SITE_URL."uploads/student_documents/";?>'+response+'" style="width:100%"><i class="fa fa-paperclip" aria-hidden="true"></i></a></td><td><a href="javascript:void(0);" id="link_remove_image" class="list-btn btn btn-primary">Remove</a></td></tr>');
				},
				error: function (response) {
					$('#post_img_profile').html("Ops! something goes wrong."); 
				}
			});
		});

    $(document).on("click","#link_remove_image",function(){
			if(!confirm("Are you sure to remove this image?"))
				return false;
      $(this).parent().parent().remove();
		});
    });
    function addNote() {
        var remark = $("#customer_note").val();
        var admin_note = $("#admin_note").val();
        var enroll_id = $("#enroll_id").val();
        var student_id = $("#student_id").val();
        var phase = $("#phase_id").val();
        var send_email = $("#send_email").prop("checked") ? 1 : 0;



        $.ajax({
            url: '<?php echo base_url() ?>project/add_phase',
            type: "POST",
            data: {
                remark: remark,
                enroll_id: enroll_id,
                phase: 5,
                admin_note: admin_note,
                send_email: send_email
            },
            success: function (data) {
                var link = '<?php echo base_url("project/case")?>/' + student_id + '/' + enroll_id + '/' +
                6;
                window.location.href = link;
            }
        });
    }
</script>