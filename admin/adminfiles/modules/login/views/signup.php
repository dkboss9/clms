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
  <link href="<?php echo base_url("assets/theme/dist/");?>assets/css/custom.css" rel="stylesheet" type="text/css" />
  <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="auth-bg">
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Authentication - Multi-steps-->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid stepper stepper-pills stepper-dark stepper-column"
      id="kt_create_account_stepper">
      <!--begin::Aside-->
      <div class="d-flex flex-column flex-lg-row-auto w-xl-400px positon-xl-relative bg-dark">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-400px scroll-y">
          <!--begin::Header-->
          <div class="d-flex flex-row-fluid flex-column align-items-center align-items-lg-start p-10 p-lg-20">
            <!--begin::Logo-->
            <?php
                  $row = $this->generalsettingsmodel->getConfigData(24)->row();
              ?>
            <a href="javascript:void();" class="mb-10 mb-lg-20">
              <img alt="Logo" src="<?php echo SITE_URL."uploads/logo/".$row->config_value;?>" class="h-40px" />
            </a>
            <!--end::Logo-->
            <!--begin::Nav-->
            <div class="stepper-nav">
              <!--begin::Step 1-->
              <div class="stepper-item current" data-kt-stepper-element="nav">
                <!--begin::Line-->
                <div class="stepper-line w-45px"></div>
                <!--end::Line-->
                <!--begin::Icon-->
                <div class="stepper-icon w-45px h-45px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">1</span>
                </div>
                <!--end::Icon-->
                <!--begin::Label-->
                <div class="stepper-label">
                  <h3 class="stepper-title">Package</h3>
                  <div class="stepper-desc fw-bold">Setup Your Package Details</div>
                </div>
                <!--end::Label-->
              </div>
              <!--end::Step 1-->
              <!--begin::Step 2-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <!--begin::Line-->
                <div class="stepper-line w-45px"></div>
                <!--end::Line-->
                <!--begin::Icon-->
                <div class="stepper-icon w-45px h-45px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">2</span>
                </div>
                <!--end::Icon-->
                <!--begin::Label-->
                <div class="stepper-label">
                  <h3 class="stepper-title">Account Info</h3>
                  <div class="stepper-desc fw-bold">Setup Your Account Settings</div>
                </div>
                <!--end::Label-->
              </div>
              <!--end::Step 2-->
              <!--begin::Step 3-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <!--begin::Line-->
                <div class="stepper-line w-45px"></div>
                <!--end::Line-->
                <!--begin::Icon-->
                <div class="stepper-icon w-45px h-45px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">3</span>
                </div>
                <!--end::Icon-->
                <!--begin::Label-->
                <div class="stepper-label">
                  <h3 class="stepper-title">Billing Address</h3>
                  <div class="stepper-desc fw-bold">Your Business Related Info</div>
                </div>
                <!--end::Label-->
              </div>
              <!--end::Step 3-->
              <!--begin::Step 4-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <!--begin::Line-->
                <div class="stepper-line w-45px"></div>
                <!--end::Line-->
                <!--begin::Icon-->
                <div class="stepper-icon w-45px h-45px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">4</span>
                </div>
                <!--end::Icon-->
                <!--begin::Label-->
                <div class="stepper-label">
                  <h3 class="stepper-title">Billing Details</h3>
                  <div class="stepper-desc fw-bold">Set Your Payment Methods</div>
                </div>
                <!--end::Label-->
              </div>
              <!--end::Step 4-->
              <!--begin::Step 5-->
              <div class="stepper-item" data-kt-stepper-element="nav">
                <!--begin::Line-->
                <div class="stepper-line w-45px"></div>
                <!--end::Line-->
                <!--begin::Icon-->
                <div class="stepper-icon w-45px h-45px">
                  <i class="stepper-check fas fa-check"></i>
                  <span class="stepper-number">5</span>
                </div>
                <!--end::Icon-->
                <!--begin::Label-->
                <div class="stepper-label">
                  <h3 class="stepper-title">Completed</h3>
                  <div class="stepper-desc fw-bold">Woah, we are here</div>
                </div>
                <!--end::Label-->
              </div>
              <!--end::Step 5-->
            </div>
            <!--end::Nav-->
          </div>
          <!--end::Header-->
          <!--begin::Illustration-->
          <div
            class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-250px"
            style="background-image: url(<?php echo base_url("assets/theme/dist/");?>assets/media/illustrations/sigma-1/16.png)">
          </div>
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
          <div class="w-lg-700px p-10 p-lg-15 mx-auto">
            <!--begin::Form-->
            <form class="my-auto pb-5" novalidate="novalidate" action="<?php echo base_url("login/register");?>" method="Post" id="kt_create_account_form">
              <!--begin::Step 1-->
              <div class="current" data-kt-stepper-element="content">
                <!--begin::Wrapper-->
                <div class="w-100">
                  <!--begin::Heading-->
                  <div class="pb-10 pb-lg-15">
                    <!--begin::Title-->
                    <h2 class="fw-bolder d-flex align-items-center text-dark">Choose Account Type
                      <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                        title="Billing is issued based on your selected account type"></i></h2>
                    <!--end::Title-->
                    <!--begin::Notice-->
                    <div class="text-muted fw-bold fs-6">If you need more info, please check out
                      <a href="javascript:void();" class="link-primary fw-bolder">Help Page</a>.</div>
                    <!--end::Notice-->
                  </div>
                  <!--end::Heading-->
                  <!--begin::Input group-->
                  <div class="fv-row">
                    <!--begin::Row-->
                    <div class="row">
                      <!--begin::Col-->
                      <?php
                    foreach ($packages as $row) {
                      ?>
                      <div class="col-lg-6 div_package">
                        <!--begin::Option-->
                        <input type="radio" class="btn-check btn-package" name="package" class="package"
                          value="<?php echo $row->package_id;?>" package="<?php echo $row->name;?>"
                          id="kt_create_account_form_account_type_personal<?php echo $row->package_id;?>" />
                        <label
                          class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-10"
                          for="kt_create_account_form_account_type_personal<?php echo $row->package_id;?>">
                          <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                          <span class="svg-icon svg-icon-3x me-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                              fill="none">
                              <path
                                d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                fill="black" />
                              <path opacity="0.3"
                                d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                fill="black" />
                            </svg>
                          </span>
                          <!--end::Svg Icon-->
                          <!--begin::Info-->
                          <span class="d-block fw-bold text-start">
                            <span class="text-dark fw-bolder d-block fs-4 mb-2"><?php echo $row->name;?></span>
                            <!-- <span class="text-muted fw-bold fs-6">If you need more info, please check it out</span> -->
                          </span>
                          <!--end::Info-->
                        </label>
                        <!--end::Option-->
                      </div>
                      <?php } ?>
                      <!--end::Col-->
                      <!--begin::Col-->

                      <!--end::Col-->
                    </div>

                    <div class="fv-row mb-10">
                      <!--begin::Label-->
                      <label class="form-label required">Order Term:</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <select name="order_term" id="order_term" class="form-select form-select-lg form-select-solid"
                        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                        data-hide-search="true">
                        <option></option>
                      </select>
                      <!--end::Input-->
                    </div>

                    <div class="fv-row mb-10 div_price" style="display:none;">
                      <!--begin::Label-->
                      <label class="form-label required">Package Price:</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <input type="hidden" name="txt_package_price" id="txt_package_price" value="">
                      <span id="span_package_price">-</span>
                      <!--end::Input-->
                    </div>

                    <div class="fv-row mb-10">
                      <!--begin::Label-->
                      <label class="form-label ">Description:</label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <textarea name="description" class="form-control" id="description"
                        class="form-select form-select-lg form-select-solid"></textarea>
                      <!--end::Input-->
                    </div>

                    <div class="fv-row mb-10">
                      <!--begin::Label-->
                      <label class="form-label required">
                        <input type="checkbox" id="AgreeTerms" name="agreeterms">
                        I agree with <a href="javascript:void(0);" id="term-of-use">terms of use</a>

                      </label>
                      <!--end::Label-->
                      <!--begin::Input-->
                      <!--end::Input-->
                    </div>



                    <!--end::Row-->
                  </div>
                  <!--end::Input group-->
                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Step 1-->
              <!--begin::Step 2-->
              <div class="" data-kt-stepper-element="content">
                <!--begin::Wrapper-->
                <div class="w-100">
                  <!--begin::Heading-->
                  <div class="pb-10 pb-lg-15">
                    <!--begin::Title-->
                    <h2 class="fw-bolder text-dark">Account Info</h2>
                    <!--end::Title-->
                    <!--begin::Notice-->
                    <div class="text-muted fw-bold fs-6">If you need more info, please check out
                      <a href="#" class="link-primary fw-bolder">Help Page</a>.</div>
                    <!--end::Notice-->
                  </div>
                  <!--end::Heading-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Company Name</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-lg form-control-solid" name="company"
                      placeholder="" value="" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3"><?php echo $account_setting->abn_title;?></label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-lg form-control-solid" name="abn" placeholder=""
                      value="<?php echo set_value("abn");?>" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3">Phone</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-lg form-control-solid" name="phone"
                      placeholder="" value="<?php echo set_value("phone");?>" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">First Name</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-lg form-control-solid" name="fname"
                      placeholder="" value="<?php echo set_value("fname");?>" />
                    <input type="hidden" name="role" id="role" value="3">
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Last Name</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control form-control-lg form-control-solid" name="lname"
                      placeholder="" value="<?php echo set_value("lname");?>" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="email" name="email" id="email" value="<?php echo set_value("email");?>"
                      class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Username</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="email" name="username" id="username" value="<?php echo set_value("username");?>"
                      class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Password</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password" name="password" id="password" value=""
                      class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Confirm Password</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password" name="cpassword" id="cpassword" value=""
                      class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->


                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Step 2-->
              <!--begin::Step 3-->
              <div class="" data-kt-stepper-element="content">
                <!--begin::Wrapper-->
                <div class="w-100">
                  <!--begin::Heading-->
                  <div class="pb-10 pb-lg-12">
                    <!--begin::Title-->
                    <h2 class="fw-bolder text-dark">Business Details</h2>
                    <!--end::Title-->
                    <!--begin::Notice-->
                    <div class="text-muted fw-bold fs-6">If you need more info, please check out
                      <a href="#" class="link-primary fw-bolder">Help Page</a>.</div>
                    <!--end::Notice-->
                  </div>
                  <!--end::Heading-->
                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Address 1</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="email" name="address1" id="address1" value="<?php echo set_value("address1");?>"
                      class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3">Address 2</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="email" name="address2" id="address2" value="<?php echo set_value("address2");?>"
                      class="form-control form-control-lg form-control-solid" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->


                  <!--begin::Input group-->
                  <div class="mb-10 fv-row">
                    <!--begin::Label-->
                    <label class="form-label mb-3 required">Country</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="bill_country" id="bill_country" class="form-select form-select-lg form-select-solid"
                        data-control="select2" data-placeholder="Select..." data-allow-clear="true"
                        data-hide-search="true">
                      <option value="">Select</option>
                      <?php 
                        foreach ($countries as $row) {
                          ?>
                      <option <?php if($row->country_id == $countryid) echo 'selected="selected"';?>
                        value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
                      <?php
                        }
                        ?>
                    </select>
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row state_aus">
                    <!--begin::Label-->
                    <label class="form-label mb-3 ">State</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select name="bill_state" id="bill_state" class="form-control form-control-lg form-select-solid">
                      <option value="">Select</option>
                      <?php 
                      foreach ($states as $row) {
                        ?>
                        <option value="<?php echo $row->state_name;?>"><?php echo $row->state_name;?></option>
                        <?php
                      }
                      ?>
                    </select>
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="mb-10 fv-row state_nep" style="display: none;">
                    <!--begin::Label-->
                    <label class="form-label mb-3 ">State</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" name="txt_bill_state" id="txt_bill_state"
                      class="form-control form-control-lg form-control-solid" value="">

                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->




                  <!--begin::Input group-->
                  <div class="fv-row mb-0">
                    <!--begin::Label-->
                    <label class="fs-6 fw-bold form-label ">Zip Code</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input name="postcode" class="form-control form-control-lg form-control-solid"
                      value="<?php echo set_value("postcode");?>" />
                    <!--end::Input-->
                  </div>
                  <!--end::Input group-->
                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Step 3-->
              <!--begin::Step 4-->
              <div class="" data-kt-stepper-element="content">
                <!--begin::Wrapper-->
                <div class="w-100">
                  <!--begin::Heading-->
                  <div class="pb-10 pb-lg-15">
                    <!--begin::Title-->
                    <h2 class="fw-bolder text-dark">Package Details</h2>
                    <!--end::Title-->
                    <!--begin::Notice-->
                    <div class="text-muted fw-bold fs-6">Package: <span class="span_package"></span></div> <br>
                    <div class="text-muted fw-bold fs-6">Order Term: <span class="span_order_term"></span></div><br>
                    <div class="text-muted fw-bold fs-6">Amount: <span class="span_order_amount"></span></div>
                    <!--end::Notice-->
                  </div>
                  <!--end::Heading-->
                  <!--begin::Heading-->
                  <div class="pb-10 pb-lg-15">
                    <!--begin::Title-->
                    <h2 class="fw-bolder text-dark">Billing Details</h2>
                    <!--end::Title-->
                    <!--begin::Notice-->
                    <div class="text-muted fw-bold fs-6">If you need more info, please check out
                      <a href="#" class="text-primary fw-bolder">Help Page</a>.</div>
                    <!--end::Notice-->
                  </div>
                  <!--end::Heading-->

                  <!--begin::Input group-->
                  <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span class="required">Select Payment Type</span>

                    </label>
                    <!--end::Label-->

                    <div class="row">
                      <!--begin::Col-->

                      <div class="col-lg-6 payment-radio-class">
                        <!--begin::Option-->
                        <input type="radio" class="btn-check payment_method" name="payment_method" value="stripe" checked="checked"
                          id="payment-stripe" />
                        <label
                          class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-10"
                          for="payment-stripe">
                          <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                          <span class="svg-icon svg-icon-3x me-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                              fill="none">
                              <path
                                d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                fill="black" />
                              <path opacity="0.3"
                                d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                fill="black" />
                            </svg>
                          </span>
                          <!--end::Svg Icon-->
                          <!--begin::Info-->
                          <span class="d-block fw-bold text-start">
                            <span class="text-dark fw-bolder d-block fs-4 mb-2">Stripe</span>
                            <!-- <span class="text-muted fw-bold fs-6">If you need more info, please check it out</span> -->
                          </span>
                          <!--end::Info-->
                        </label>
                        <!--end::Option-->
                      </div>

                      <!--end::Col-->
                      <!--begin::Col-->

                      <div class="col-lg-6 payment-radio-class">
                        <!--begin::Option-->
                        <input type="radio" class="btn-check payment_method" name="payment_method" value="bank"
                          id="payment-bank" />
                        <label
                          class="btn btn-outline btn-outline-dashed btn-outline-default p-7 d-flex align-items-center mb-10"
                          for="payment-bank">
                          <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                          <span class="svg-icon svg-icon-3x me-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                              fill="none">
                              <path
                                d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14ZM21 19V17C21 16.4 20.6 16 20 16H18V20H20C20.6 20 21 19.6 21 19ZM21 7V5C21 4.4 20.6 4 20 4H18V8H20C20.6 8 21 7.6 21 7Z"
                                fill="black" />
                              <path opacity="0.3"
                                d="M17 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H17C17.6 2 18 2.4 18 3V21C18 21.6 17.6 22 17 22ZM10 7C8.9 7 8 7.9 8 9C8 10.1 8.9 11 10 11C11.1 11 12 10.1 12 9C12 7.9 11.1 7 10 7ZM13.3 16C14 16 14.5 15.3 14.3 14.7C13.7 13.2 12 12 10.1 12C8.10001 12 6.49999 13.1 5.89999 14.7C5.59999 15.3 6.19999 16 7.39999 16H13.3Z"
                                fill="black" />
                            </svg>
                          </span>
                          <!--end::Svg Icon-->
                          <!--begin::Info-->
                          <span class="d-block fw-bold text-start">
                            <span class="text-dark fw-bolder d-block fs-4 mb-2">Bank transfer</span>
                            <!-- <span class="text-muted fw-bold fs-6">If you need more info, please check it out</span> -->
                          </span>
                          <!--end::Info-->
                        </label>
                        <!--end::Option-->
                      </div>

                      <!--end::Col-->
                    </div>

                  </div>
                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="d-flex flex-column mb-7 fv-row div_bank" style="display:none !important;">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span> AusNep Group Pty Ltd.<br/>BSB: 062 475 <br/>A/C No.: 1009 5913<br/>  Common Wealth Bank</span>
                    </label>
                   
                  </div>


                  <!--end::Input group-->

                  <!--begin::Input group-->
                  <div class="div_eway">
                  <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                      <span class="required">Name On Card</span>
                      <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                        title="Specify a card holder's name"></i>
                    </label>
                    <!--end::Label-->
                    <input type="text" class="form-control form-control-solid" placeholder="" name="card_name"
                      value="" />
                      <input type="hidden" name="access_token" id="access_token" value="">
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="d-flex flex-column mb-7 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-bold form-label mb-2">Card Number</label>
                    <!--end::Label-->
                    <!--begin::Input wrapper-->
                    <div class="position-relative">
                      <!--begin::Input-->
                      <input type="text" data-stripe="number" class="form-control form-control-solid" placeholder="Enter card number"
                        name="card_number" value="" />
                      <!--end::Input-->
                      <!--begin::Card logos-->
                      <div class="position-absolute translate-middle-y top-50 end-0 me-5">
                        <img src="<?php echo base_url("assets/theme/dist/");?>assets/media/svg/card-logos/visa.svg"
                          alt="" class="h-25px" />
                        <img
                          src="<?php echo base_url("assets/theme/dist/");?>assets/media/svg/card-logos/mastercard.svg"
                          alt="" class="h-25px" />
                        <img
                          src="<?php echo base_url("assets/theme/dist/");?>assets/media/svg/card-logos/american-express.svg"
                          alt="" class="h-25px" />
                      </div>
                      <!--end::Card logos-->
                    </div>
                    <!--end::Input wrapper-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="row mb-10">
                    <!--begin::Col-->
                    <div class="col-md-8 fv-row">
                      <!--begin::Label-->
                      <label class="required fs-6 fw-bold form-label mb-2">Expiration Date</label>
                      <!--end::Label-->
                      <!--begin::Row-->
                      <div class="row fv-row">
                        <!--begin::Col-->
                        <div class="col-6">
                          <select name="expiry_month" data-stripe="exp_month" class="form-select form-select-solid"
                            data-control="select2" data-hide-search="true" data-placeholder="Month">
                            <option></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                          </select>
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                          <select name="expiry_year" class="form-select form-select-solid" data-control="select2"
                            data-hide-search="true" data-placeholder="Year" data-stripe="exp_year">
                            <option></option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                            <option value="2031">2031</option>
                            <option value="2032">2032</option>
                          </select>
                        </div>
                        <!--end::Col-->
                      </div>
                      <!--end::Row-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-4 fv-row">
                      <!--begin::Label-->
                      <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                        <span class="required">CVV</span>
                        <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                          title="Enter a card CVV code"></i>
                      </label>
                      <!--end::Label-->
                      <!--begin::Input wrapper-->
                      <div class="position-relative">
                        <!--begin::Input-->
                        <input type="text" value="" id="ccv" name="ccv" data-stripe="cvc"
                          class="form-control form-control-solid" minlength="3" maxlength="4" placeholder="CVV">
                        <!--end::Input-->
                        <!--begin::CVV icon-->
                        <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                          <!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
                          <span class="svg-icon svg-icon-2hx">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                              fill="none">
                              <path d="M22 7H2V11H22V7Z" fill="black" />
                              <path opacity="0.3"
                                d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19ZM14 14C14 13.4 13.6 13 13 13H5C4.4 13 4 13.4 4 14C4 14.6 4.4 15 5 15H13C13.6 15 14 14.6 14 14ZM16 15.5C16 16.3 16.7 17 17.5 17H18.5C19.3 17 20 16.3 20 15.5C20 14.7 19.3 14 18.5 14H17.5C16.7 14 16 14.7 16 15.5Z"
                                fill="black" />
                            </svg>
                          </span>
                          <!--end::Svg Icon-->
                        </div>
                        <!--end::CVV icon-->
                      </div>
                      <!--end::Input wrapper-->
                    </div>
                    <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                  <!--begin::Input group-->
                  <div class="d-flex flex-stack">
                    <!--begin::Label-->
                    <div class="me-5">
                      <label class="fs-6 fw-bold form-label">Save Card for further billing?</label>
                      <div class="fs-7 fw-bold text-muted">If you need more info, please check budget planning</div>
                    </div>
                    <!--end::Label-->
                    <!--begin::Switch-->
                    <label class="form-check form-switch form-check-custom form-check-solid">
                      <input class="form-check-input" type="checkbox" value="1" checked="checked" />
                      <span class="form-check-label fw-bold text-muted">Save Card</span>
                    </label>
                    <!--end::Switch-->
                  </div>
                  </div>
                  <!--end::Input group-->
                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Step 4-->
              <!--begin::Step 5-->
              <div class="" data-kt-stepper-element="content">
                <!--begin::Wrapper-->
                <div class="w-100">
                  <!--begin::Heading-->
                  <div class="pb-8 pb-lg-10">
                    <!--begin::Title-->
                    <h2 class="fw-bolder text-dark">Your Are Done!</h2>
                    <!--end::Title-->
                    <!--begin::Notice-->
                    <div class="text-muted fw-bold fs-6">If you need more info, please
                      <a href="../dist/authentication/sign-in/basic.html" class="link-primary fw-bolder">Sign In</a>.
                    </div>
                    <!--end::Notice-->
                  </div>
                  <!--end::Heading-->
                  <!--begin::Body-->
                  <div class="mb-0">
                    <!--begin::Text-->
                    <div class="fs-6 text-gray-600 mb-5">Writing headlines for blog posts is as much an art as it is a
                      science and probably warrants its own post, but for all advise is with what works for your great
                      &amp; amazing audience.</div>
                    <!--end::Text-->
                    <!--begin::Alert-->
                    <!--begin::Notice-->
                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
                      <!--begin::Icon-->
                      <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                      <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                          <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black" />
                          <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black" />
                        </svg>
                      </span>
                      <!--end::Svg Icon-->
                      <!--end::Icon-->
                      <!--begin::Wrapper-->
                      <div class="d-flex flex-stack flex-grow-1">
                        <!--begin::Content-->
                        <div class="fw-bold">
                          <h4 class="text-gray-900 fw-bolder">We need your attention!</h4>
                          <div class="fs-6 text-gray-700">To start using great tools, please, please
                            <a href="#" class="fw-bolder">Create Team Platform</a></div>
                        </div>
                        <!--end::Content-->
                      </div>
                      <!--end::Wrapper-->
                    </div>
                    <!--end::Notice-->
                    <!--end::Alert-->
                  </div>
                  <!--end::Body-->
                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Step 5-->
              <!--begin::Actions-->
              <div class="d-flex flex-stack pt-15">
                <div class="mr-2">
                  <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                    <span class="svg-icon svg-icon-4 me-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="black" />
                        <path
                          d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                          fill="black" />
                      </svg>
                    </span>
                    <!--end::Svg Icon-->Previous</button>
                </div>
                <div>
                  <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="submit">
                    <span class="indicator-label">Submit
                      <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                      <span class="svg-icon svg-icon-4 ms-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)"
                            fill="black" />
                          <path
                            d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                            fill="black" />
                        </svg>
                      </span>
                      <!--end::Svg Icon--></span>
                    <span class="indicator-progress">Please wait...
                      <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                  </button>
                  <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                    <span class="svg-icon svg-icon-4 ms-1">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)"
                          fill="black" />
                        <path
                          d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                          fill="black" />
                      </svg>
                    </span>
                    <!--end::Svg Icon--></button>
                </div>
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
    <!--end::Authentication - Multi-steps-->
  </div>
  <!--end::Main-->
  <!--begin::Javascript-->
  <script>
    var hostUrl = "<?php echo base_url();?>";
  </script>
  <!--begin::Global Javascript Bundle(used by all pages)-->
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/plugins/global/plugins.bundle.js"></script>
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/scripts.bundle.js"></script>
  <!--end::Global Javascript Bundle-->
  <!--begin::Page Custom Javascript(used by this page)-->
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/custom/utilities/modals/create-account.js">
  </script>
  <!--end::Page Custom Javascript-->
  <script src="<?php echo base_url("assets/theme/dist/");?>assets/js/jquery.validate.js"></script>
  <script>
    $(document).ready(function () {
      $("#sign_in_form").validate();

      $(".div_package").click(function () {
        var package_id = $(this).find(".btn-package").val();
        if (package_id == "")
          return false;

        $.ajax({
          url: '<?php echo base_url() ?>company/getPackagePrice',
          type: "POST",
          data: "package_id=" + package_id,
          success: function (data) {
            if (data != "") {
              $("#order_term").html(data);
              //  $("#order_term").select2("destroy").select2();
              $(".div_price").hide();
            }
          }
        })
      });

      $(document).on("change", "#order_term", function () {
        var price = $('option:selected', this).attr('price');
        var discountprice = $('option:selected', this).attr('discountprice');
        if (price > discountprice && discountprice > 0)
          var price1 = discountprice;
        else
          var price1 = price;
        $("#span_package_price").html('AUD ' + price1);
        $("#txt_package_price").val(price1);
        $(".div_price").show();

        var package = $('input[name="package"]:checked').attr("package");
        var order_term = $("#order_term").val();

        $(".span_package").html(package);
        $(".span_order_term").html(order_term);
        $(".span_order_amount").html('AUD ' + price1);
      });

      $("#bill_country").change(function () {
        var country = $(this).val();
        if (country == 13) {
          $(".state_aus").show();
          $(".state_nep").hide();
          $.ajax({
            url: '<?php echo base_url() ?>company/get_state_new',
            type: "POST",
            data: "country=" + country,
            success: function (data) {
              if (data != "") {
                $("#bill_state").html(data);
              }
            }
          });
        } else {
          $(".state_aus").hide();
          $(".state_nep").show();
        }
      });

      $('.payment-radio-class').click(function () { 
        var method = $(this).find(".payment_method").val();
        if (method == 'bank') {
          $('.bank-info').slideDown();
          $('#extrachargesinfo2').hide();
          $(".div_bank").show();
          $(".div_eway").hide();
        }

        if (method == 'stripe') {
          $('.bank-info').slideUp();
          $('#extrachargesinfo2').show();
          $(".div_bank").hide();
          $(".div_eway").show();
        }
      });
    });
  </script>
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
 //Stripe.setPublishableKey('pk_test_JIbsTfUxDOQnFUt7LzE9fkzr');
 Stripe.setPublishableKey('<?php echo $this->mylibrary->getSiteEmail(85);?>');
  $(function() {
    var $form = $('#kt_create_account_form');
    $("#ccv").blur(function(event) {
    // Disable the submit button to prevent repeated clicks:
    

    // Request a token from Stripe:
    if( $('input[name=payment_method]:checked').val() == 'stripe'){ 
      Stripe.card.createToken($form, stripeResponseHandler);
    }
    // Prevent the form from being submitted:
    return false;
  });
  });
  function stripeResponseHandler(status, response) {

   if (response.error) {
    alert(response.error.message);
  } else {
    $("#access_token").val(response.id);
    console.log(response.id);
  }
}
</script>
  <!--end::Javascript-->
</body>
<!--end::Body-->

</html>