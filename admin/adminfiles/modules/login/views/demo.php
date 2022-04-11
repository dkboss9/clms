
<!DOCTYPE html>
<?php

$site_title = $this->generalsettingsmodel->getConfigData(43)->row();
$site_keyword = $this->generalsettingsmodel->getConfigData(44)->row();
$site_desc = $this->generalsettingsmodel->getConfigData(45)->row();
$site_url = $this->generalsettingsmodel->getConfigData(21)->row();

?>
<html lang="en">
	<!--begin::Head-->
	<head>
  <base href="../../">
  <title><?php echo $site_title->config_value; ?></title>
  <meta charset="utf-8" />
  <meta name="description" content="<?php echo $site_desc->config_value; ?>">
  <meta name="keywords" content="<?php echo $site_keyword->config_value; ?>" />

  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="article" />
  <meta property="og:title" content="<?php echo $site_title->config_value; ?>" />
  <meta property="og:url" content="<?php echo $site_title->config_value; ?>" />
  <meta property="og:site_name" content="<?php echo $site_url->config_value; ?>" />
  <link rel="canonical" href="<?php echo $site_url->config_value; ?>" />
  <link rel="shortcut icon" href="<?php echo base_url("assets/theme/dist/");?>assets/media/logos/favicon.ico" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="<?php echo base_url("assets/theme/dist/");?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url("assets/theme/dist/");?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="auth-bg">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Authentication - Signup Free Trial-->
			<div class="d-flex flex-column flex-xl-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-column flex-lg-row-fluid">
					<!--begin::Wrapper-->
					<div class="d-flex flex-row-fluid flex-center p-10">
						<!--begin::Content-->
						<div class="d-flex flex-column">
							<!--begin::Logo-->
							<a href="javascript:void();" class="mb-15">
								<img alt="Logo" src="<?php echo base_url("assets/theme/dist/");?>assets/media/logos/logo-compact.svg" class="h-60px" />
							</a>
							<!--end::Logo-->
							<!--begin::Title-->
							<h1 class="text-dark fs-3x mb-5">Welcome, Guest!</h1>
							<!--end::Title-->
							<!--begin::Description-->
							<div class="fw-bold fs-3 text-gray-400 mb-10">Plan your blog post by choosing a topic creating
							<br />an outline and checking facts</div>
							<!--begin::Description-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
					<!--begin::Illustration-->
					<div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-200px min-h-xl-450px" style="background-image: url(<?php echo base_url("assets/theme/dist/");?>assets/media/illustrations/sigma-1/5.png)"></div>
					<!--end::Illustration-->
				</div>
				<!--begin::Aside-->
				<!--begin::Content-->
				<div class="flex-row-fluid d-flex flex-center justfiy-content-xl-first p-10">
					<!--begin::Wrapper-->
					<div class="d-flex flex-center p-15 bg-body shadow rounded w-100 w-md-550px mx-auto ms-xl-20">
						<!--begin::Form-->
						<form class="form" novalidate="novalidate" action="<?php echo base_url("get-demo");?>" method="Post" id="kt_free_trial_form"  >
							<!--begin::Heading-->
							<div class="text-center mb-10">
								<!--begin::Title-->
								<h1 class="text-dark mb-3">30 Days Free Trial</h1>
								<!--end::Title-->
                <?php echo validation_errors(); ?>

								<!--begin::Link-->
								<div class="text-gray-400 fw-bold fs-4">Have questions ? Check out
								<a href="javascript:void();" class="link-primary fw-bolder">FAQ</a>.</div>
								<!--end::Link-->
							</div>
							<!--begin::Heading-->
              	<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">Company</label>
								<input class="form-control form-control-solid" type="text" placeholder="" name="company" id="company" value="<?php echo set_value("company");?>" autocomplete="off" />
                <input type="hidden" name="role" id="role" value="3">
							</div>
							<!--end::Input group-->

               	<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">ABN</label>
								<input class="form-control form-control-solid" type="text" placeholder="" name="abn" id="abn" value="<?php echo set_value("abn");?>" autocomplete="off" />
							</div>
							<!--end::Input group-->

               	<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">First Name</label>
								<input class="form-control form-control-solid" type="text" placeholder="" name="fname" id="fname" value="<?php echo set_value("fname");?>" autocomplete="off" />
							</div>
							<!--end::Input group-->

               	<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">Last Name</label>
								<input class="form-control form-control-solid" type="text" placeholder="" name="lname" id="lname" value="<?php echo set_value("lname");?>" autocomplete="off" />
							</div>
							<!--end::Input group-->

              	<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">Country</label>
                <select name="bill_country" id="bill_country" class="form-select form-select-lg form-select-solid"
                        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                        data-hide-search="true" >
                    <option value="">Select</option>
                    <?php 
            foreach ($countries as $row) {
              ?>
                    <option <?php if($row->country_id == 13) echo 'selected="selected"';?>
                      value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
                    <?php
            }
            ?>
                  </select>
							</div>
							<!--end::Input group-->

                 	<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">Phone Number</label>
								<input class="form-control form-control-solid" type="text" placeholder="" name="phone" id="phone" value="<?php echo set_value("phone");?>" autocomplete="off" />
							</div>
							<!--end::Input group-->

							<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">Email</label>
								<input class="form-control form-control-solid" type="email" placeholder="" name="email" autocomplete="off" />
							</div>
							<!--end::Input group-->

                  	<!--begin::Input group-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">Username</label>
								<input class="form-control form-control-solid" type="text" placeholder="" name="username" id="username" value="<?php echo set_value("username");?>" autocomplete="off" />
							</div>
							<!--end::Input group-->

							<!--begin::Input group-->
							<div class="mb-7 fv-row" data-kt-password-meter="true">
								<!--begin::Wrapper-->
								<div class="mb-1">
									<!--begin::Label-->
									<label class="form-label fw-bolder text-dark fs-6 required">Password</label>
									<!--end::Label-->
									<!--begin::Input wrapper-->
									<div class="position-relative mb-3">
										<input class="form-control form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
										<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
											<i class="bi bi-eye-slash fs-2"></i>
											<i class="bi bi-eye fs-2 d-none"></i>
										</span>
									</div>
									<!--end::Input wrapper-->
									<!--begin::Meter-->
									<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
										<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
									</div>
									<!--end::Meter-->
								</div>
								<!--end::Wrapper-->
								<!--begin::Hint-->
								<div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp; symbols.</div>
								<!--end::Hint-->
							</div>
							<!--end::Input group=-->
							<!--begin::Row-->
							<div class="fv-row mb-10">
								<label class="form-label fw-bolder text-dark fs-6 required">Confirm Password</label>
								<input class="form-control form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off" />
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="fv-row mb-10">
								<label class="form-check form-check-custom form-check-solid form-check-inline mb-5">
									<input class="form-check-input" type="checkbox" name="toc" value="1" />
									<span class="form-check-label fw-bold text-gray-700">I Agree 30 Days Free Use
									<a href="#" class="link-primary ms-1">Terms &amp; Conditions</a>.</span>
								</label>
							</div>
							<!--end::Row-->
							<!--begin::Row-->
							<div class="text-center pb-lg-0 pb-8">
								<button type="button" id="kt_free_trial_submit" class="btn btn-lg btn-primary fw-bolder">
									<span class="indicator-label">Create an Account</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
							<!--end::Row-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Right Content-->
			</div>
			<!--end::Authentication - Signup Free Trial-->
		</div>
		<!--end::Main-->
		<!--begin::Javascript-->
		<script>var hostUrl = '<?php echo base_url();?>';</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/plugins/global/plugins.bundle.js"></script>
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/authentication/sign-up/free-trial.js"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>