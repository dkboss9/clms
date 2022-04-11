	<!--begin::Modal - Create Project-->
	<div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-fullscreen p-9" id="popup_edit">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header">
					<!--begin::Modal title-->
					<h2>Create Customer</h2>
					<!--end::Modal title-->
					<!--begin::Close-->
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
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
				<div class="modal-body scroll-y m-5">
					<!--begin::Stepper-->
					<div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_project_stepper">
						<!--begin::Container-->
						<div class="container">
							<!--begin::Nav-->
							<div class="stepper-nav justify-content-center py-2">
								<!--begin::Step 1-->
								<div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Persional Info</h3>
								</div>
								<!--end::Step 1-->
								<!--begin::Step 2-->
								<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Documents</h3>
								</div>
								<!--end::Step 2-->
								<!--begin::Step 3-->
								<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Classes</h3>
								</div>
								<!--end::Step 3-->
								<!--begin::Step 4-->
								<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Qualification</h3>
								</div>
								<!--end::Step 4-->
								<!--begin::Step 5-->
								<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Experience</h3>
								</div>
								<!--end::Step 5-->
								<!--begin::Step 6-->
								<!-- <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Upload Files</h3>
								</div> -->
								<!--end::Step 6-->
								<!--begin::Step 7-->
								<!-- <div class="stepper-item" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Completed</h3>
								</div> -->
								<!--end::Step 7-->
							</div>
							<!--end::Nav-->
							<!--begin::Form-->
							<form class="mx-auto w-100 mw-1000px pt-15 pb-10" action="<?php echo base_url("student/add");?>" enctype="multipart/form-data"  novalidate="novalidate"
								id="kt_modal_create_project_form" method="post">
								<!--begin::Type-->
								<div class="current" data-kt-stepper-element="content">
									<!--begin::Wrapper-->
									<div class="w-100">
										<!--begin::Heading-->
										<div class="pb-7 pb-lg-12">
											<!--begin::Title-->
											<h1 class="fw-bolder text-dark">Pertional Info</h1>
											<!--end::Title-->
											<!--begin::Description-->
											<div class="text-muted fw-bold fs-4">If you need more info, please check out
												<a href="#" class="link-primary fw-bolder">FAQ Page</a></div>
											<!--end::Description-->
										</div>
										<!--end::Heading-->

										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="required fs-6 fw-bold mb-2 required">First Name</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" name="fname"
												id="fname" placeholder="" value="" />
											<input type="hidden" name="role" id="role" value="3">
											<!--end::Input-->
										</div>

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
												<span class="required">Last Name</span>
											</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" name="lname" id="lname"
												class="form-control form-control-solid" placeholder=""
												value="<?php echo set_value("lname",@$lead->lead_lname);?>" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="required fs-6 fw-bold mb-2 required">Email</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="email" class="form-control form-control-solid" name="email"
												id="email" placeholder=""
												value="<?php echo set_value("email",@$lead->email);?>" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="required fs-6 fw-bold mb-2 required">Mobile</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" name="mobile"
												id="mobile" placeholder=""
												value="<?php echo set_value("mobile",@$lead->mobile);?>" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->


										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="required fs-6 fw-bold mb-2">DOB</label>
											<!--end::Label-->
											<!--begin::Wrapper-->
											<div class="position-relative d-flex align-items-center">
												<!--begin::Icon-->
												<!--begin::Svg Icon | path: icons/duotune/general/gen014.svg-->
												<span class="svg-icon svg-icon-2 position-absolute mx-4">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
														viewBox="0 0 24 24" fill="none">
														<path opacity="0.3"
															d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
															fill="black" />
														<path
															d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
															fill="black" />
														<path
															d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
															fill="black" />
													</svg>
												</span>
												<!--end::Svg Icon-->
												<!--end::Icon-->
												<!--begin::Input-->
												<input class="form-control form-control-solid ps-12" placeholder=""
													value="<?php echo set_value("dob");?>" name="dob" />
												<!--end::Input-->
											</div>
											<!--end::Wrapper-->
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2 ">photo</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="file" name="profile_pic" id="profile_pic" class="form-control">
											<input type="hidden" name="txt_profile_pic" id="txt_profile_pic" value="">
											<!--end::Input-->
											<div class="col-md-1" id="post_img_profile">

											</div>
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="required fs-6 fw-bold mb-2 ">Passport No</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" name="passport_no"
												id="passport_no" placeholder=""
												value="<?php echo set_value("passport_no");?>" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class=" fs-6 fw-bold mb-2 ">Phone</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" name="phone"
												id="phone_number" placeholder=""
												value="<?php echo set_value("phone",@$lead->phone_number);?>" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class=" fs-6 fw-bold mb-2 ">Referral</label>
											<!--end::Label-->
											<!--begin::Input-->

											<select name="referral" id="user" class="form-select form-select-solid"
												data-control="select2" data-hide-search="true"
												data-placeholder="Select...">
												<option value="">Select</option>
												<?php 
    foreach($users as $user){
      ?>
												<option value="<?php echo $user->id;?>"
													<?php if($user->id == set_value("referral",@$lead->user_id)) echo 'selected="selected"'; ?>>
													<?php echo $user->first_name.' '.$user->last_name;?></option>
												<?php
    }
    ?>
											</select>
											<!--end::Input-->
										</div>
										<!--end::Input group-->

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2 required">Address</label>
											<!--end::Label-->
											<!--begin::Input-->
											<input type="text" class="form-control form-control-solid" name="address"
												id="address" placeholder="" value="<?php echo set_value("address");?>" />
											<!--end::Input-->
										</div>
										<!--end::Input group-->


										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="required fs-6 fw-bold mb-2 required">Sex</label>
											<!--end::Label-->
											<!--begin::Input-->

											<select name="sex" id="sex" class="form-select form-select-solid"
												data-control="select2" data-hide-search="true"
												data-placeholder="Select...">
												<option value="">Select</option>
												<option value="Male"
													<?php if(set_value("sex") == "Male") echo 'selected="selected"';?>>Male
												</option>
												<option value="Female"
													<?php if(set_value("sex") == "Female") echo 'selected="selected"';?>>
													Female</option>
											</select>
											<!--end::Input-->
										</div>

										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class=" fs-6 fw-bold mb-2 required">Marital Status</label>
											<!--end::Label-->
											<!--begin::Input-->

											<select name="is_married" id="is_married" class="form-select form-select-solid"
												data-control="select2" data-hide-search="true"
												data-placeholder="Select...">
												<option value="">Select</option>
												<option value="Single"
													<?php if(set_value("is_married") == "Single") echo 'selected="selected"';?>>
													Single</option>
												<option value="Married"
													<?php if(set_value("is_married") == "Married") echo 'selected="selected"';?>>
													Married</option>
											</select>
											<!--end::Input-->
										</div>


										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<!--begin::Label-->
											<label class="fs-6 fw-bold mb-2 required">How do you know about
												us?</label>
											<!--end::Label-->
											<!--begin::Input-->

											<select name="about_us" id="about_us" class="form-select form-select-solid"
												data-control="select2" data-hide-search="true"
												data-placeholder="Select...">
												<option value="">Select</option>
												<?php 
      foreach($about_us as $row){
        ?>
												<option
													<?php if($row->threatre_id == set_value("about_us",@$lead->about_us)) echo 'selected="selected"';?>
													value="<?php echo $row->threatre_id;?>"><?php echo $row->name;?>
												</option>
												<?php
      }
      ?>
											</select>
											<!--end::Input-->
										</div>
										<!--end::Input group-->
										<!--begin::Actions-->
										<div class="d-flex justify-content-end">
											<button type="button" class="btn btn-lg btn-primary"
												data-kt-element="type-next">
												<span class="indicator-label">Documents</span>
												<span class="indicator-progress">Please wait...
													<span
														class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
										<!--end::Actions-->
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Type-->
								<!--begin::Settings-->
								<div data-kt-stepper-element="content">
									<!--begin::Wrapper-->
									<div class="w-100">
										<!--begin::Heading-->
										<div class="pb-12">
											<!--begin::Title-->
											<h1 class="fw-bolder text-dark">Documents</h1>
											<!--end::Title-->
											<!--begin::Description-->
											<div class="text-muted fw-bold fs-4">If you need more info, please check
												<a href="#" class="link-primary">Project Guidelines</a></div>
											<!--end::Description-->
										</div>
										<!--end::Heading-->

										<div class="fv-row mb-8">
											<div class="table-responsive">
												<table class="table table-bordered table-striped mb-none" id="">
													<thead>
														<tr>
															<th>Document Type</th>
															<th>Document </th>
															<th>Description</th>
															<th> </th>

														</tr>
													</thead>
													<tbody id="div_document">

														<tr>
															<td>
																<select name="doc_type[]" class="form-control mb-md"
																	data-plugin-selectTwo>
																	<option value="">Select</option>
																	<?php
        foreach ($doc_type as $row) {
         ?>
																	<option value="<?php echo $row->type_id;?>">
																		<?php echo $row->type_name;?></option>
																	<?php
       }
       ?>
																</select>
															</td>
															<td> <input type="file" name="document1"
																	class="form-control mb-md" /></td>
															<td> <input type="text" name="description[]"
																	class="form-control student_doc_desc mb-md"></td>
															<td>
																<a href="javascript:void(0);" class="link_remove"><i class="bi bi-trash"></i>
																	</a>
															</td>
														</tr>

													</tbody>
												</table>
											</div>


											<a href="javascript:void();" href="javascript:void(0);" id="link_add_doc"
												class="btn btn-primary">Add more</a>

										</div>

										<!--begin::Actions-->
										<div class="d-flex flex-stack">
											<button type="button" class="btn btn-lg btn-light me-3"
												data-kt-element="settings-previous">Persoinal Info</button>
											<button type="button" class="btn btn-lg btn-primary"
												data-kt-element="settings-next">
												<span class="indicator-label">Qualification</span>
												<span class="indicator-progress">Please wait...
													<span
														class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
										<!--end::Actions-->
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Settings-->
								<!--begin::Budget-->
								<div data-kt-stepper-element="content">
									<!--begin::Wrapper-->
									<div class="w-100">
										<!--begin::Heading-->
										<div class="pb-10 pb-lg-12">
											<!--begin::Title-->
											<h1 class="fw-bolder text-dark">Classes</h1>
											<!--end::Title-->
											<!--begin::Description-->
											<!-- <div class="text-muted fw-bold fs-4">If you need more info, please check
												<a href="#" class="link-primary">Project Guidelines</a></div> -->
											<!--end::Description-->
										</div>
										<!--end::Heading-->


										<!--begin::Input group-->
										<div class="fv-row mb-15">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack">
												<!--begin::Label-->
												<div class="me-5">
													<label class="fs-6 fw-bold">Have you completed an IELTS test in the
														last 2 years?</label>

												</div>
												<!--end::Label-->
												<!--begin::Switch-->
												<label class="form-check form-switch form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1"
														name="have_ielts" id="have_ielts" checked="checked" />
													<span class="form-check-label fw-bold text-muted">Allowed</span>
												</label>
												<!--end::Switch-->
											</div>
											<!--end::Wrapper-->
										</div>
										<!--end::Input group-->

										<div id="div_ielts">
											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Listening</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="listening"
													id="listening" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->


											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Writing</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="Writing"
													id="Writing" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->

											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Reading</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="reading"
													id="reading" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->

											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Speaking</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="speaking"
													id="speaking" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->
										</div>

										<!--begin::Input group-->
										<div class="fv-row mb-15">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack">
												<!--begin::Label-->
												<div class="me-5">
													<label class="fs-6 fw-bold">Have you completed a TOEFL?</label>

												</div>
												<!--end::Label-->
												<!--begin::Switch-->
												<label class="form-check form-switch form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1"
														name="have_toefl" id="have_toefl" />
													<span class="form-check-label fw-bold text-muted">Yes</span>
												</label>
												<!--end::Switch-->
											</div>
											<!--end::Wrapper-->
										</div>

										<div id="div_toefl" style="display:none;">
											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Total TOEFL iBT Score? </label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="txt_toefl"
													id="txt_toefl" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->
										</div>

										<!--begin::Input group-->
										<div class="fv-row mb-15">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack">
												<!--begin::Label-->
												<div class="me-5">
													<label class="fs-6 fw-bold">Have you completed a PTE? </label>

												</div>
												<!--end::Label-->
												<!--begin::Switch-->
												<label class="form-check form-switch form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1"
														name="have_pte" id="have_pte" />
													<span class="form-check-label fw-bold text-muted">Yes</span>
												</label>
												<!--end::Switch-->
											</div>
											<!--end::Wrapper-->
										</div>

										<div id="div_pte" style="display:none;">
											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Total PTE Score? </label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="txt_pte"
													id="txt_pte" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->
										</div>

										<!--begin::Input group-->
										<div class="fv-row mb-15">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack">
												<!--begin::Label-->
												<div class="me-5">
													<label class="fs-6 fw-bold">Have you completed a SAT? </label>

												</div>
												<!--end::Label-->
												<!--begin::Switch-->
												<label class="form-check form-switch form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1"
														name="have_sat" id="have_sat" />
													<span class="form-check-label fw-bold text-muted">Yes</span>
												</label>
												<!--end::Switch-->
											</div>
											<!--end::Wrapper-->
										</div>


										<div id="div_sat" style="display:none;">
											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Total SAT Score? </label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="txt_sat"
													id="txt_sat" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->
										</div>

										<!--begin::Input group-->
										<div class="fv-row mb-15">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack">
												<!--begin::Label-->
												<div class="me-5">
													<label class="fs-6 fw-bold">Have you completed a GRE? </label>

												</div>
												<!--end::Label-->
												<!--begin::Switch-->
												<label class="form-check form-switch form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1"
														name="have_gre" id="have_gre" />
													<span class="form-check-label fw-bold text-muted">Yes</span>
												</label>
												<!--end::Switch-->
											</div>
											<!--end::Wrapper-->
										</div>


										<div id="div_gre" style="display:none;">
											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Total GRE Score? </label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="txt_gre"
													id="txt_gre"  placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->
										</div>


										<!--begin::Input group-->
										<div class="fv-row mb-15">
											<!--begin::Wrapper-->
											<div class="d-flex flex-stack">
												<!--begin::Label-->
												<div class="me-5">
													<label class="fs-6 fw-bold">Have you completed a GMAT? </label>

												</div>
												<!--end::Label-->
												<!--begin::Switch-->
												<label class="form-check form-switch form-check-custom form-check-solid">
													<input class="form-check-input" type="checkbox" value="1"
														name="have_gmat" id="have_gmat" />
													<span class="form-check-label fw-bold text-muted">Yes</span>
												</label>
												<!--end::Switch-->
											</div>
											<!--end::Wrapper-->
										</div>


										<div id="div_gmat" style="display:none;">
											<!--begin::Input group-->
											<div class="fv-row mb-8">
												<!--begin::Label-->
												<label class="fs-6 fw-bold mb-2 required">Total GMAT Score? </label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" class="form-control form-control-solid" name="txt_gmat"
													id="txt_gmat" placeholder="" value="">
												<!--end::Input-->
											</div>
											<!--end::Input group-->
										</div>
										<!--end::Input group-->

										<!--begin::Actions-->
										<div class="d-flex flex-stack">
											<button type="button" class="btn btn-lg btn-light me-3"
												data-kt-element="budget-previous">Documents</button>
											<button type="button" class="btn btn-lg btn-primary"
												data-kt-element="budget-next">
												<span class="indicator-label">Qualifications</span>
												<span class="indicator-progress">Please wait...
													<span
														class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
										<!--end::Actions-->
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Budget-->
								<!--begin::Team-->
								<div data-kt-stepper-element="content">
									<!--begin::Wrapper-->
									<div class="w-100">
										<!--begin::Heading-->
										<div class="pb-12">
											<!--begin::Title-->
											<h1 class="fw-bolder text-dark">Qualifications</h1>
											<!--end::Title-->
											<!--begin::Description-->
											<!-- <div class="text-muted fw-bold fs-4">If you need more info, please check
												<a href="#" class="link-primary">Project Guidelines</a></div> -->
											<!--end::Description-->
										</div>
										<!--end::Heading-->

										<!--begin::Input group-->
										<div class="mb-8">
										<table class="table table-bordered table-striped mb-none" id="">
													<thead>
														<tr>
															<th>Qualification </th>
															<th>Institution </th>
															<th>Country</th>
															<th>Year of commencement</th>
															<th>Year of Completion</th>
															<th>Obtained (%)</th>
															<th>Document attachment</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<th><input type="text" name="qualification[]" 
																	class="form-control " > </th>
															<th><input type="text" name="institution[]"
																	class="form-control " > </th>
															<th> <select name="country[]" class="form-control"
																	data-plugin-selectTwo style="width:200px;">
																	<option value="">Select</option>
																	<?php
             foreach ($countries as $row) {
               ?>
																	<option value="<?php echo $row->country_name;?>">
																		<?php echo $row->country_name;?></option>
																	<?php
             }
             ?>
																</select> </th>
															<th> <select name="commence_date[]" class="form-control "
																	data-plugin-selectTwo>
																	<option value="">Select</option>
																	<?php 
            for($k = 1950; $k <= date("Y");$k++){
              ?>
																	<option value="<?php echo $k;?>">
																		<?php echo $k;?>
																	</option>
																	<?php
            }?>
																</select> </th>
															<th>
																<select name="complete_date[]" class="form-control "
																	data-plugin-selectTwo>
																	<option value="">Select</option>
																	<?php 
              for($k = 1950; $k <= date("Y");$k++){
                ?>
																	<option value="<?php echo $k;?>">
																		<?php echo $k;?>
																	</option>
																	<?php
              }?>
																</select>
															</th>
															<th><input type="text" name="percentage[]"
																	class="form-control " id="percentage"></th>
															<th><input type="checkbox" name="is_attached1"
																	id="is_attached"></th>
														</tr>
														<tr>
															<th><input type="text" name="qualification[]"
																	class="form-control " > </th>
															<th><input type="text" name="institution[]"
																	class="form-control " > </th>
															<th> <select name="country[]" class="form-control"
																	data-plugin-selectTwo style="width:200px;">
																	<option value="">Select</option>
																	<?php
           foreach ($countries as $row) {
             ?>
																	<option value="<?php echo $row->country_name;?>">
																		<?php echo $row->country_name;?></option>
																	<?php
           }
           ?>
																</select> </th>
															<th> <select name="commence_date[]" class="form-control "
																	data-plugin-selectTwo>
																	<option value="">Select</option>
																	<?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
																	<option value="<?php echo $k;?>">
																		<?php echo $k;?>
																	</option>
																	<?php
          }?>
																</select> </th>
															<th>
																<select name="complete_date[]" class="form-control "
																	data-plugin-selectTwo>
																	<option value="">Select</option>
																	<?php 
            for($k = 1950; $k <= date("Y");$k++){
              ?>
																	<option value="<?php echo $k;?>">
																		<?php echo $k;?>
																	</option>
																	<?php
            }?>
																</select>
															</th>
															<th><input type="text" name="percentage[]"
																	class="form-control " id="percentage"></th>
															<th><input type="checkbox" name="is_attached1"
																	id="is_attached"></th>
														</tr>
														<tr>
															<th><input type="text" name="qualification[]"
																	class="form-control " > </th>
															<th><input type="text" name="institution[]"
																	class="form-control "> </th>
															<th> <select name="country[]" class="form-control"
																	data-plugin-selectTwo style="width:200px;">
																	<option value="">Select</option>
																	<?php
         foreach ($countries as $row) {
           ?>
																	<option value="<?php echo $row->country_name;?>">
																		<?php echo $row->country_name;?></option>
																	<?php
         }
         ?>
																</select> </th>
															<th> <select name="commence_date[]" class="form-control "
																	data-plugin-selectTwo>
																	<option value="">Select</option>
																	<?php 
        for($k = 1950; $k <= date("Y");$k++){
          ?>
																	<option value="<?php echo $k;?>">
																		<?php echo $k;?>
																	</option>
																	<?php
        }?>
																</select> </th>
															<th>
																<select name="complete_date[]" class="form-control "
																	data-plugin-selectTwo>
																	<option value="">Select</option>
																	<?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
																	<option value="<?php echo $k;?>">
																		<?php echo $k;?>
																	</option>
																	<?php
          }?>
																</select>
															</th>
															<th><input type="text" name="percentage[]"
																	class="form-control " id="percentage"></th>
															<th><input type="checkbox" name="is_attached1"
																	id="is_attached"></th>
														</tr>
													</tbody>
												</table>
										</div>
										<!--end::Input group-->

										<!--begin::Actions-->
										<div class="d-flex flex-stack">
											<button type="button" class="btn btn-lg btn-light me-3"
												data-kt-element="team-previous">Classes</button>
											<button type="button" class="btn btn-lg btn-primary"
												data-kt-element="team-next">
												<span class="indicator-label">Experiences</span>
												<span class="indicator-progress">Please wait...
													<span
														class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
										<!--end::Actions-->
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Team-->
								<!--begin::Targets-->
								<div data-kt-stepper-element="content">
									<!--begin::Wrapper-->
									<div class="w-100">
										<!--begin::Heading-->
										<div class="pb-12">
											<!--begin::Title-->
											<h1 class="fw-bolder text-dark">Experiences</h1>
											<!--end::Title-->
											<!--begin::Title-->
											<!-- <div class="text-muted fw-bold fs-4">If you need more info, please check
												<a href="#" class="link-primary">Project Guidelines</a></div> -->
											<!--end::Title-->
										</div>
										<!--end::Heading-->
										<!--begin::Input group-->
										<div class="fv-row mb-8">
											<table class="table table-bordered table-striped mb-none" id="">
												<thead>
													<tr>
														<th>Experience </th>
														<th>Institution </th>
														<th>Position </th>
														<th>Country</th>
														<th>Year of commencement</th>
														<th>Year of Completion</th>
														<th>Document attachment</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<th><input type="text" name="experience[]" class="form-control">
														</th>
														<th><input type="text" name="e_institution[]" class="form-control">
														</th>
														<th><input type="text" name="e_position[]" class="form-control">
														</th>
														<th> <select name="e_country[]" class="form-control"
																style="width:200px;" data-plugin-selectTwo>
																<option value="">Select</option>
																<?php
           foreach ($countries as $row) {
             ?>
																<option value="<?php echo $row->country_name;?>">
																	<?php echo $row->country_name;?></option>
																<?php
           }
           ?>
															</select> </th>
														<th> <select name="e_commence_date[]" class="form-control "
																data-plugin-selectTwo>
																<option value="">Select</option>
																<?php 
          for($k = 1950; $k <= date("Y");$k++){
            ?>
																<option value="<?php echo $k;?>">
																	<?php echo $k;?>
																</option>
																<?php
          }?>
															</select>
														</th>
														<th> <select name="e_complete_date[]" class="form-control "
																data-plugin-selectTwo>
																<option value="">Select</option>
																<?php 
        for($k = 1950; $k <= date("Y");$k++){
          ?>
																<option value="<?php echo $k;?>">
																	<?php echo $k;?>
																</option>
																<?php
        }?>
															</select></th>
														<th><input type="checkbox" name="e_is_attached1"></th>
													</tr>
													<tr>
														<th><input type="text" name="experience[]" class="form-control">
														</th>
														<th><input type="text" name="e_institution[]" class="form-control">
														</th>
														<th><input type="text" name="e_position[]" class="form-control">
														</th>
														<th> <select name="e_country[]" class="form-control"
																style="width:200px;" data-plugin-selectTwo>
																<option value="">Select</option>
																<?php
       foreach ($countries as $row) {
         ?>
																<option value="<?php echo $row->country_name;?>">
																	<?php echo $row->country_name;?></option>
																<?php
       }
       ?>
															</select> </th>
														<th> <select name="e_commence_date[]" class="form-control "
																data-plugin-selectTwo>
																<option value="">Select</option>
																<?php 
      for($k = 1950; $k <= date("Y");$k++){
        ?>
																<option value="<?php echo $k;?>">
																	<?php echo $k;?>
																</option>
																<?php
      }?>
															</select>
														</th>
														<th> <select name="e_complete_date[]" class="form-control "
																data-plugin-selectTwo>
																<option value="">Select</option>
																<?php 
    for($k = 1950; $k <= date("Y");$k++){
      ?>
																<option value="<?php echo $k;?>">
																	<?php echo $k;?>
																</option>
																<?php
    }?>
															</select></th>
														<th><input type="checkbox" name="e_is_attached1"></th>
													</tr>
													<tr>
														<th><input type="text" name="experience[]" class="form-control">
														</th>
														<th><input type="text" name="e_institution[]" class="form-control">
														</th>
														<th><input type="text" name="e_position[]" class="form-control">
														</th>
														<th> <select name="e_country[]" class="form-control"
																style="width:200px;" data-plugin-selectTwo>
																<option value="">Select</option>
																<?php
   foreach ($countries as $row) {
     ?>
																<option value="<?php echo $row->country_name;?>">
																	<?php echo $row->country_name;?></option>
																<?php
   }
   ?>
															</select> </th>
														<th> <select name="e_commence_date[]" class="form-control "
																data-plugin-selectTwo>
																<option value="">Select</option>
																<?php 
  for($k = 1950; $k <= date("Y");$k++){
    ?>
																<option value="<?php echo $k;?>">
																	<?php echo $k;?>
																</option>
																<?php
  }?>
															</select>
														</th>
														<th> <select name="e_complete_date[]" class="form-control "
																data-plugin-selectTwo>
																<option value="">Select</option>
																<?php 
  for($k = 1950; $k <= date("Y");$k++){
    ?>
																<option value="<?php echo $k;?>">
																	<?php echo $k;?>
																</option>
																<?php
  }?>
															</select></th>
														<th><input type="checkbox" name="e_is_attached1"></th>
													</tr>
												</tbody>
											</table>
										</div>
										<!--end::Input group-->

										<!--begin::Actions-->
										<div class="d-flex flex-stack">
											<button type="button" class="btn btn-lg btn-light me-3"
												data-kt-element="targets-previous">Qualification</button>
											<button type="button" class="btn btn-lg btn-primary"
												data-kt-element="targets-next">
												<span class="indicator-label">Complete</span>
												<span class="indicator-progress">Please wait...
													<span
														class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											</button>
										</div>
										<!--end::Actions-->
									</div>
									<!--end::Wrapper-->
								</div>
								<!--end::Targets-->
							
							</form>
							<!--end::Form-->
						</div>
						<!--begin::Container-->
					</div>
					<!--end::Stepper-->
				</div>
				<!--end::Modal body-->
			</div>
			<!--end::Modal content-->
		</div>
		<!--end::Modal dialog-->
	</div>
	<!--end::Modal - Create Project-->

	<script>
		$(document).ready(function () {
			$(document).on("change", "#profile_pic", function () {
				var file_data = $(this).prop('files')[0];
				var form_data = new FormData();
				form_data.append('file', file_data);

				$.ajax({
					url: '<?php echo base_url("");?>company/upload_file_project',
					dataType: 'text',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					type: 'post',
					success: function (response) {
						$('#post_img_profile').html(
							'<img src="<?php echo SITE_URL."uploads/document/";?>/' +
							response +
							'" style="width:100%"><a href="javascript:void(0);" id="link_remove_image" class="list-btn btn btn-primary">Remove</a>'
						);
						$('#txt_profile_pic').val(response);
					},
					error: function (response) {
						$('#post_img_profile').html(response);
					}
				});
			});

			$(document).on("click", "#link_remove_image", function () {
				if (!confirm("Are you sure to remove this image?"))
					return false;
				$("#post_img_profile").html("");
				$('#txt_profile_pic').val("");
			});

			var num = 1;
			$(document).on("click","#link_add_doc",function () {
				num = num + 1;
				$.ajax({
					url: '<?php echo base_url() ?>student/get_docRow',
					type: "POST",
					data: "num=" + num,
					success: function (data) {
						if (data != "") {
							$("#div_document").append(data);
						}
					}
				});
			});
			$(document).on("click", ".link_remove", function () {
				var id = $(this).attr("rel");
				$(this).parent().parent().remove();
			});
		});
	</script>