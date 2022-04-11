	<!--begin::Modal - Create Project-->
	<div class="modal fade" id="kt_modal_create_project" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-650px" id="popup_edit">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header">
					<!--begin::Modal title-->
					<h2>Create Company</h2>
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
									<h3 class="stepper-title">Account Info</h3>
								</div>
								<!--end::Step 1-->
								<!--begin::Step 2-->
								<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Profile Info</h3>
								</div>
								<!--end::Step 2-->
								<!--begin::Step 3-->
								<div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Billing Info</h3>
								</div>
								<!--end::Step 3-->
								<!--begin::Step 4-->
								<!-- <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Qualification</h3>
								</div> -->
								<!--end::Step 4-->
								<!--begin::Step 5-->
								<!-- <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
									<h3 class="stepper-title">Experience</h3>
								</div> -->
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
											<h1 class="fw-bolder text-dark">Account Info</h1>
											<!--end::Title-->
											<!--begin::Description-->
											<!-- <div class="text-muted fw-bold fs-4">If you need more info, please check out
												<a href="#" class="link-primary fw-bolder">FAQ Page</a></div> -->
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
											<label class="required fs-6 fw-bold mb-2 required">Password</label>
											<!--end::Label-->
											<!--begin::Input-->
												<input type="password" name="password" id="password" class="form-control form-control-solid" autocomplete="off" required />
											<!--end::Input-->
										</div>
										<!--end::Input group-->
									
										<!--begin::Actions-->
										<div class="d-flex justify-content-end">
											<button type="button" class="btn btn-lg btn-primary"
												data-kt-element="type-next">
												<span class="indicator-label">Profile Info</span>
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
											<h1 class="fw-bolder text-dark">Profile Info</h1>
											<!--end::Title-->
											<!--begin::Description-->
											<!-- <div class="text-muted fw-bold fs-4">If you need more info, please check
												<a href="#" class="link-primary">Project Guidelines</a></div> -->
											<!--end::Description-->
										</div>
										<!--end::Heading-->

										<div class="fv-row mb-8">
										
											<!--begin::Label-->
											<label class="required fs-6 fw-bold mb-2 required">Due date</label>
											<!--end::Label-->
											<!--begin::Input-->
												<input type="text" name="duedatenumber" id="duedatenumber" class="form-control form-control-solid" autocomplete="off" required />
											<!--end::Input-->

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