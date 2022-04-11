<link rel="stylesheet" href="<?php echo base_url("assets/theme/dist/");?>assets/css/trumbowyg.min.css" >
<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/trumbowyg.js" ></script>
<script>
	$(document).ready(function(){
		$('#details123').trumbowyg();
        $("#docs1").select2();

        $("#email_new").click(function(){  
				var detail = $("#txt_detail").html();
				var txt_subject = $("#txt_subject").val();
				$('#details123').trumbowyg('html', detail);
				$("#subject").val(txt_subject);
				 $("#intern-email").val("");
				 $("#intern-email").trigger("change");
				$(".div_existing").hide(); 
			  });
			$("#email_existing").click(function(){
			$(".div_existing").show(); 
			$("#lead-email").trigger("change");
			});

			$("#lead-email").change(function(){
				var email = $(this).val();
				var leadid = $("#lead_id").val();
				$.ajax({
					method: "POST",
			
					url: '<?php echo base_url();?>lms/getemailContent',
					data: { email: email,leadid: leadid}
				  })
					.done(function( msg ) { 
						var response = JSON.parse(msg)
					$('#subject').val(response.subject);
					$('#details123').trumbowyg('html', response.msg);
					});
			});

			$(document).on("change", "#profile_image", function () {
				var file_data = $(this).prop('files')[0];
				var form_data = new FormData();
				form_data.append('file', file_data);
		  
				$.ajax({
				  url: base_url + 'company/upload_file_project',
				  dataType: 'text',
				  cache: false,
				  contentType: false,
				  processData: false,
				  data: form_data,
				  type: 'post',
				  success: function (response) {
					$("#div_document").append('<tr style="margin-top:10px;" >' +
					  '<td> <a href="'+base_url+'uploads/document/' + response +
					  '" target="_blank">' + response + '</a></td>' +
					  '<td><input type="hidden" name="txt_file[]" id="txt_file" class="txt_files" value="' + response +
					  '"><a href="javascript:void(0);" class="link_remove" > Remove</a></td></tr>');
					$("#profile_image").val("");
				  },
				  error: function (response) {
					$('#div_document').append(response);
				  }
				});
			  });
		  
			  $(document).on("click", ".link_remove", function () {
				if (!confirm("Are you sure to remove this image?"))
				  return false;
				$(this).parent().parent().remove();
			  });
		  

	});
	   
</script>
 <!--begin::Modal content-->
  <div class="modal-content">
  	<!--begin::Modal header-->
  	<div class="modal-header" id="kt_modal_add_user_header">
  		<!--begin::Modal title-->
  		<h2 class="fw-bolder">Preview Mail</h2>
  		<!--end::Modal title-->
  		<!--begin::Close-->
  		<div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
  			<!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
  			<span class="svg-icon svg-icon-1">
  				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
  					<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
  						transform="rotate(-45 6 17.3137)" fill="black" />
  					<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
  						fill="black" />
  				</svg>
  			</span>
  			<!--end::Svg Icon-->
  		</div>
  		<!--end::Close-->
  	</div>


  	<!--end::Modal header-->
  	<!--begin::Modal body-->
  	<div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
  		<!--begin::Form-->
  		<form id="kt_lead_mail_preview" class="form"
  			action="<?php echo base_url("lms/mail_preview");?>"
  			enctype='multipart/form-data' method="post">
  			<!--begin::Scroll-->
  			<div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true"
  				data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
  				data-kt-scroll-dependencies="#kt_modal_add_user_header"
  				data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

  			
                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2 required">Type</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="radio" name="email_type" id="email_new" value="new"> New &nbsp;&nbsp;&nbsp;
                      <input type="radio" name="email_type" id="email_existing" value="new" checked> Existing
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7 div_existing">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2 required">Emails</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select name="email" id="lead-email" class="form-select form-select-solid fw-bolder">
                          <option value="Default">Default</option>
                          <?php
                    foreach($emails->result() as $email){
                        ?>
                          <option value="<?php echo $email->id;?>"
                              <?php echo @$defualt_email->id == $email->id ? 'selected' : '';?>>
                              <?php echo $email->email_subject;?></option>
                          <?php
                    }
                 ?>
                      </select>
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2 required">Subject</label>
                      <!--end::Label-->
                      <!--begin::Input-->

                      <input type="text" name="subject" id="subject" class="form-control form-control-solid mb-3 mb-lg-0" value="<?php echo $subject;?>">
                        <input type="hidden"  id="txt_subject" style="display: none;" value=""> 
                      <!--end::Input-->
                  </div>


                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Content</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="details123" id="details123" class="form-control" rows="6"><?php echo $message;?></textarea>
                      <div   id="txt_detail" style="display: none;"> <?php echo $new_message;?></div>
                      <!--end::Input-->
                  </div>


                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2">Attach new file</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="file" name="profile_image"  id="profile_image"  class="form-control">
           <table style="width: 100%;" id="div_document">
                  </table>
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7">
                    <!--begin::Label-->
                    <label class=" fw-bold fs-6 mb-2">Contact Emails</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                     
                      <span style="float: left;">  <input type="checkbox" name="useremails[]" value="<?php echo $customer_arr['email']; ?>" checked=""> <?php echo $customer_arr['name']; ?> </span>
                      <!--end::Input-->
                  </div>



                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2 required">Other Emails</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="other_email" id="other_email" class="form-control"></textarea>
            Add the valid email address seperated by comma.
                      <!--end::Input-->
                  </div>

                  <div class="fv-row mb-7">
                      <!--begin::Label-->
                      <label class=" fw-bold fs-6 mb-2 required">Attached Documents</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select name="docs[]" id="docs1" multiple data-plugin-selectTwo
                                class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                data-placeholder="Select option" data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="true">
                            <?php 
                    foreach ($docs as $row){
                        ?>
                        <option value="<?php echo $row->content_id;?>"  <?php if(in_array($row->content_id, $lead_docs)) echo 'selected="selected"';?>><?php echo $row->name;?></option>
                        <?php
                    }
                    ?>
			</select>
                      <!--end::Input-->
                  </div>

  			</div>
  			<!--end::Scroll-->
  			<!--begin::Actions-->
  			<div class="text-center pt-15">
  				<input type="hidden" name="txt_submit" value="1">
  				<input type="hidden" value="<?php echo $leadid;?>" name="leadid" id="lead_id">
  				<button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
  				<button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
  					<span class="indicator-label">Submit</span>
  					<span class="indicator-progress">Please wait...
  						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
  				</button>
  			</div>
  			<!--end::Actions-->
  		</form>
  		<!--end::Form-->
  	</div>
  	<!--end::Modal body-->
  </div>
  <!--end::Modal content-->
  <script
  	src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/add_lead.js">
  </script>
  <script
  	src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/apps/user-management/users/list/lead_mail.js">
  </script>