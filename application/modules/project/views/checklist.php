


<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();
  });
</script>


<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>

<?php 

$this->load->view('detail');
?>


<table class="table table-bordered table-striped mb-none" id="datatable-default">
  <thead>
    <tr>
      <th>Check list</th>
      <th>File</th>
      <th>Status</th>
      <th>Received Date</th>
      <th>Received and Verified By</th>
      <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
    </tr>
  </thead>
  <tbody>
   <?php
   $checklists = $this->appointmentmodel->listChecklist($enroll->fee_id);
   
   foreach ($checklists->result() as $row) {
    $enroll_check = $this->projectmodel->checkChecklist($row->type_id,$result->project_id)->row();
    $user = $this->projectmodel->getUserDetailNew(@$enroll_check->added_by);
    $enroll_checklistid = $enroll_check->id??null;
    $checklist_files = $this->projectmodel->getchecklistfiles($enroll_checklistid);
    ?>
   <tr class="gradeX" <?php  if(@$enroll_check->checklist_status == 'Cancel') echo 'style="background:#fbdbe4"';?>>
     <td>
       <?php echo $row->type_name;?>
     </td>

     <td>
     <?php 
                  foreach($checklist_files as $key => $file){
                ?>
                  <a href="<?php echo SITE_URL."uploads/student_documents/".@$file->checklist_file; ?>"
                    target="_blank"> <?php echo @$file->checklist_file;?></a> <br>
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
      <a class="simple-ajax-popup-reminder btn btn-primary" href="<?php echo base_url("project/edit_checklist/".$row->checklist_id.'/'.$result->project_id);?>">Update</a>
    </td>

  </tr>
  <?php
}
?>

</tbody>
</table>

<!-- start: page -->

<!-- end: page -->
</section>
</div>
</section>
<script type="text/javascript">
  $(document).ready(function(){
   $("#addButton").click(function(){
    $("#div_task").toggle();
  });
   $("#form_discussion").validate();
   $(".link_delete").click(function(){
    if(!confirm('Are you sure to delete this Record?'))
      return false;
  });

  
  $(document).on("change","#profile_pic",function(){ 
			var file_data = $(this).prop('files')[0];
			var form_data = new FormData();
			form_data.append('file', file_data);

			$.ajax({
				url: '<?php echo SITE_URL;?>project/upload_file_project', 
				dataType: 'text', 
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				type: 'post',
				success: function (response) {
          $("#profile_pic").val('');
					$('#post_img_profile').append('<tr><td><input type="hidden" name="file_name[]" value="'+response+'"><a href="<?php echo base_url()."uploads/student_documents/";?>'+response+'" style="width:100%"><i class="fa fa-paperclip" aria-hidden="true"></i></a></td><td><a href="javascript:void(0);" id="link_remove_image" class="list-btn btn btn-primary">Remove</a></td></tr>');
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

</script>