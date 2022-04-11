<div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px" id="popup_lead_edit">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add Appointment</h2>
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
                <form id="kt_modal_add_user_form" class="form" action="<?php echo base_url("appointment/add");?>" method="post">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                     

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">First Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="firstname" autocomplete="off" />
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Last Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="lname" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="lastname" autocomplete="off"/>
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>

                        

                        <!--end::Input group-->
          
         

                     
                        <!--begin::Input group-->
                        <div class="fv-row mb-7 " >
                            <!--begin::Label-->
                            <label class=" fw-bold fs-6 mb-2 ">counseller:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                data-placeholder="Select option" data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="true" name="counseller"
                                id="consultant" data-plugin-selectTwo>
                                <option value="">Select</option>
                                <?php 
              foreach($counselers as $user){
                ?>
                  <option value="<?php echo $user->id;?>"><?php echo $user->first_name;?> <?php echo $user->last_name;?></option>
                <?php
              }
            ?>
                            </select>
                            <!--end::Input-->
                            </div>

                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row g-9 mb-7">
                                <!--begin::Col-->
                                <div class="col-md-6 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-bold mb-2">Appointment Date</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="booking_date"
                                        class="form-control form-control-solid mb-3 mb-lg-0" placeholder="" value=""
                                        id="booking_date" />
                                    <!--end::Input-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-md-6 fv-row fv-plugins-icon-container">
                                    <!--begin::Label-->
                                    <label class=" fs-6 fw-bold mb-2">Appointment Time</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="booking_time" id="booking_time"
                                        class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true"
                                        data-kt-user-table-filter="role" data-hide-search="true">
                                        <option></option>
                                    </select>
                                    <!--end::Input-->
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Col-->
                            </div>

                            <!--end::Input group-->

                               <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="email" />
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class=" fs-6 fw-bold mb-2">Lead By</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="lead_by" id="lead_source"
                                        class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true"
                                        data-kt-user-table-filter="role" data-hide-search="true">
            <option value="">Select</option>
            <?php 
                foreach($source as $row){
                  ?>
                   <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                  <?php
                }
            ?>
          </select>
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <!--end::Input group-->

                           <!--begin::Input group-->
                           <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Country</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="country" id="country" class="form-select form-select-solid fw-bolder"
                                data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true"
                                data-kt-user-table-filter="role" data-hide-search="true">
                                <option value="">Country</option>
                                <?php
              foreach ($countries as $country) {
               ?>
                                <option <?php if("Australia" == $country->country_name) echo 'selected="selected"';?>
                                    value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?>
                                </option>
                                <?php
             }
             ?>
                            </select>
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class=" fs-6 fw-bold mb-2">Mobile</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="phone" name="phone" value="<?php echo @$phone;?>" data-plugin-masked-input=""  class="form-control form-control-solid mb-3 mb-lg-0">
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <!--end::Input group-->

                        <!--begin::Input group-->
                     
                           <!--begin::Input group-->
                           <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class=" fs-6 fw-bold mb-2 ">Reminder Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="reminder_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="" value="<?php echo date("d-m-Y",strtotime("+1 day"))?>" id="date" />
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container " >
                                <!--begin::Label-->
                                <label class=" fs-6 fw-bold mb-2">Reminder Time</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="reminder_time" value="0:00"
                                class="form-control form-control-solid mb-3 mb-lg-0" id="time">
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-bold fs-6 mb-2">Note</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="note"
                                class="form-control form-control-solid mb-3 mb-lg-0"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                          <!--begin::Input group-->
                          <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class=" fw-bold fs-6 mb-2">Send Email ?</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" name="send_email"
                                        id="send_email" />
                                    <span class="form-check-label fw-bold text-muted">Yes</span>
                                </label>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Actions-->
                    <div class="text-center pt-15">
                        <input type="hidden" name="txt_submit" value="1">
                        <button type="reset" class="btn btn-light me-3"
                            data-kt-users-modal-action="cancel">Discard</button>
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
    </div>
    <!--end::Modal dialog-->
</div>