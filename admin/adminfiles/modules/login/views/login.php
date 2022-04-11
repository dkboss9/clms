<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<?php

$site_title = $this->generalsettingsmodel->getConfigData(43)->row();
$site_keyword = $this->generalsettingsmodel->getConfigData(44)->row();
$site_desc = $this->generalsettingsmodel->getConfigData(45)->row();
$site_url = $this->generalsettingsmodel->getConfigData(21)->row();

?>
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
  <link href="<?php echo base_url("assets/theme/dist/");?>assets/plugins/global/plugins.bundle.css" rel="stylesheet"
    type="text/css" />
  <link href="<?php echo base_url("assets/theme/dist/");?>assets/css/style.bundle.css" rel="stylesheet"
    type="text/css" />
    <link href="<?php echo base_url("assets/theme/dist/");?>assets/css/custom.css" rel="stylesheet"
    type="text/css" />
  <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<?php
  $row = $this->generalsettingsmodel->getConfigData(24)->row();
  ?>
<!--begin::Body-->

<body id="kt_body" class="auth-bg">
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
      <!--begin::Aside-->
      <div class="d-flex flex-column flex-lg-row-auto bg-primary w-xl-600px positon-xl-relative">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-600px scroll-y">
          <!--begin::Header-->
          <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
            <!--begin::Logo-->
            <a href="javascript:void();" class="py-9 pt-lg-20">
              <img alt="Logo" src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" class="h-70px" />
            </a>
            <?php 
                   $row = $this->generalsettingsmodel->getConfigData(20)->row();
                  ?>
            <!--end::Logo-->
            <!--begin::Title-->
            <h1 class="fw-bolder text-white fs-2qx pb-5 pb-md-10">Welcome to <?php echo $row->config_value;?></h1>
            <!--end::Title-->
            <!--begin::Description-->
            <p class="fw-bold fs-2 text-white">Plan your blog post by choosing a topic creating
              <br />an outline and checking facts</p>
            <!--end::Description-->
          </div>
          <!--end::Header-->
          <!--begin::Illustration-->
          <div
            class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px"
            style="background-image: url(assets/media/illustrations/sigma-1/17.png)"></div>
          <!--end::Illustration-->
        </div>
        <!--end::Wrapper-->
      </div>
      <!--begin::Aside-->
      <!--begin::Body-->
      <div class="d-flex flex-column flex-lg-row-fluid py-10">
        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid">
          <!--begin::Wrapper-->
          <div class="w-lg-500px p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <form class="form w-100" novalidate="novalidate" id="sign_in_form"
              action="<?php echo current_url();?>" method="POST">
              <!--begin::Heading-->
              <div class="text-center mb-10">
                <?php 
                   $row = $this->generalsettingsmodel->getConfigData(20)->row();
                  ?>
                <!--begin::Title-->
                <h1 class="text-dark mb-3">Sign In to <?php  echo $row->config_value;?></h1>
                <!--end::Title-->
                <!--begin::Link-->
                <div class="text-gray-400 fw-bold fs-4">New Here?
                  <a href="<?php echo base_url("register");?>" class="link-primary fw-bolder">Create an Account</a>
                </div>
                <!--end::Link-->
              </div>
              <!--begin::Heading-->
              <!--begin::Input group-->
              <div class="fv-row mb-10">
                <!--begin::Label-->
                <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input class="form-control form-control-lg form-control-solid" type="email" name="username"
                  autocomplete="off" required />
                <!--end::Input-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="fv-row mb-10">
                <!--begin::Wrapper-->
                <div class="d-flex flex-stack mb-2">
                  <!--begin::Label-->
                  <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                  <!--end::Label-->
                  <!--begin::Link-->
                  <a href="<?php echo base_url("forgot-password");?>" class="link-primary fs-6 fw-bolder">Forgot
                  Password ?</a>
                  <!--end::Link-->
                </div>
                <!--end::Wrapper-->
                	<!--begin::Input-->
									<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" required/>
									<!--end::Input-->

              </div>
              <!--end::Input group-->
              <!--begin::Actions-->
              <div class="text-center">
                <?php if($this->session->flashdata('error_msg')!=""){ ?>
                <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('error_msg'); ?>
                </div>
                <?php  } ?>

             
                <!--begin::Submit button-->
                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                  <span class="indicator-label">Continue</span>
                  <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <input type="hidden" name="company_id" value="<?php echo $user->userid;?>">
                <!--end::Submit button-->
                <!--begin::Separator-->
                <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
                <!--end::Separator-->
                <?php
          $row = $this->generalsettingsmodel->getConfigData(82)->row();
          ?>
                <!--begin::Google link-->
                <a href="<?php echo base_url("get-demo");?>" class="btn btn-flex flex-center btn-light btn-lg w-100 mb-5"> Get
                  <?php echo $row->config_value;?> Days Free Trial</a>
                <!--end::Google link-->

              </div>
              <!--end::Actions-->
            </form>
            <!--end::Form-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Content-->
        <!--begin::Footer-->
        <div class="d-flex flex-center flex-wrap fs-6 p-5 pb-0">
          <!--begin::Links-->
          <div class="d-flex flex-center fw-bold fs-6">
            <a href="https://keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">About</a>
            <a href="https://devs.keenthemes.com" class="text-muted text-hover-primary px-2" target="_blank">Support</a>
            <a href="https://themes.getbootstrap.com/product/craft-bootstrap-5-admin-dashboard-theme"
              class="text-muted text-hover-primary px-2" target="_blank">Purchase</a>
          </div>
          <!--end::Links-->
        </div>
        <!--end::Footer-->
      </div>
      <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
  </div>
  <!--end::Main-->
  <!--begin::Javascript-->
  <script>
    var hostUrl = "assets/";

  </script>
  <!--begin::Global Javascript Bundle(used by all pages)-->
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/plugins/global/plugins.bundle.js"></script>
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/scripts.bundle.js"></script>
  <!--end::Global Javascript Bundle-->
  <!--begin::Page Custom Javascript(used by this page)-->
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/authentication/sign-in/general.js"></script>
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/jquery.validate.js"></script>
  <!--end::Page Custom Javascript-->
  <!--end::Javascript-->
  <script>
    $(document).ready(function(){
      $("#sign_in_form").validate();
    });
  </script>
</body>
<!--end::Body-->

</html>