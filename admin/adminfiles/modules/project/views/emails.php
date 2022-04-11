<!-- start: page -->

<!-- start: page -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#details123').trumbowyg();
  });
</script>
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
                            <h4 class="mitgrate-tt">Emails</h4>
                            <div class="adding">
                            <!-- <a href="javascript:void();" href="javascript:void(0);" id="link_add_doc"><i class="fa fa-plus"></i>Add</a> -->
                                <!-- 
                                <a href="javascript:void();"><i class="fa fa-edit"></i>Edit</a> -->
                            </div>
                        </div>

                    </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                    </div>
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
			<thead>
				<tr>
					<th>Sn</th>
					<th>Subject</th>
					<th>Description</th>
					<th>SMS</th>
					<th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($emails??[] as $key=>$value){
                    $email_count = $this->projectmodel->countemail($value->email_id,$student_id);
					?>
					<tr class="gradeX">
						<td><?php echo $key+1;?></td>
						<td><?php echo $value->email_subject;?></td>
						<td><?php echo $value->email_desc;?></td>
						<td><?php if($value->sms == 1) echo 'Yes'; else echo 'No';?></td>
						<td class="actions">

                        <a href="<?php echo base_url("project/mail_preview/".$value->email_id."/".$student_id);?>?tab=1" class="link_email simple-ajax-popup123 btn btn-primary list-btn"><span class="glyphicon glyphicon-envelope"> (<?php echo $email_count;?>) </span></a>

						</td>
					</tr>
					<?php
				} ?>


			</tbody>
		</table>
                </div>
            </div>
        </div>
    </div>
</section>

</section>
</div>


</section>

<script>
    $(document).ready(function(){
        var num=1;
        $("#link_add_doc").click(function(){
            // var num = $(".div_row").length;
            num = num + 1;

            $.ajax({
                url: '<?php echo base_url() ?>student/get_docRow',
                type: "POST",
                data: "num=" + num,
                success: function(data) { 
                if(data != ""){
                    $("#div_document").append(data);
                }
                }        
            });
        });

        $(document).on("click",".link_remove",function(){
        if(!confirm("Are you sure to delete this record?"))
            return false;

        if($(this).attr("docid")){
            var docid = $(this).attr("docid");
            $.ajax({
            url: '<?php echo base_url() ?>student/delete_docRow',
            type: "POST",
            data: "docid=" + docid,
            success: function(data) { 
            
            }        
            });
        }
        var id = $(this).attr("rel");
        $(this).parent().parent().remove();
        });
    });
</script>