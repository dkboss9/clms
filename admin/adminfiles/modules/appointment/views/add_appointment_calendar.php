<div class="modal fade" id="kt_modal_add_event" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px" id="div_edit_apppointment">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="<?php echo base_url("appointment/add");?>" method="post" id="kt_modal_add_event_form">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder" data-kt-calendar="title">Add Appointment</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_event_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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
                <div class="modal-body py-10 px-lg-17">
                      <!--begin::Input group-->
                      <div class="row row-cols-lg-2 g-10">
                        <div class="col">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2 required">First Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="firstname" autocomplete="off" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col" data-kt-calendar="datepicker">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2 required">Last Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="lname" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="lastname" autocomplete="off"/>
                                <!--end::Input-->
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                       <!--begin::Input group-->
                       <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold  mb-2">Counseller</label>
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
                       <div class="row row-cols-lg-2 g-10">
                        <div class="col">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2 ">Appointment Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-solid" name="booking_date"
                                    placeholder="Pick a start date" id="kt_calendar_datepicker_start_date" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col" data-kt-calendar="datepicker">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Appointment Time</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="booking_time" id="booking_time"
                                        class="form-select form-select-solid fw-bolder" data-kt-select2="true"
                                        data-placeholder="Select option" data-allow-clear="true"
                                        data-kt-user-table-filter="role" data-hide-search="true">
                                        <option></option>
                                    </select>
                                <!--end::Input-->
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                      <!--begin::Input group-->
                      <div class="row row-cols-lg-2 g-10">
                        <div class="col">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2 required">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="email" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col" data-kt-calendar="datepicker">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Lead By</label>
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
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                      <!--begin::Input group-->
                      <div class="row row-cols-lg-2 g-10">
                        <div class="col">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2 ">Country</label>
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
                            </div>
                        </div>
                        <div class="col" data-kt-calendar="datepicker">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Mobile</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input id="phone" name="phone" value="<?php echo @$phone;?>" data-plugin-masked-input=""  class="form-control form-control-solid mb-3 mb-lg-0">

                                <!--end::Input-->
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->

                       <!--begin::Input group-->
                       <div class="row row-cols-lg-2 g-10">
                        <div class="col">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2 ">Reminder Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="reminder_date" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="" value="<?php echo date("d-m-Y",strtotime("+1 day"))?>" id="kt_calendar_datepicker_end_date" />
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="col" data-kt-calendar="datepicker">
                            <div class="fv-row mb-9">
                                <!--begin::Label-->
                                <label class="fs-6 fw-bold mb-2">Reminder Time</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="reminder_time" value="0:00"
                                class="form-control form-control-solid mb-3 mb-lg-0" id="kt_calendar_datepicker_start_time">
                                <!--end::Input-->
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                 
                    <!--begin::Input group-->
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-bold mb-2">Note</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea name="note"
                                class="form-control form-control-solid mb-3 mb-lg-0"></textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <input type="hidden" name="txt_submit" value="1">
                    <input type="hidden" name="list_type" value="calendar">
                    <button type="reset" id="kt_modal_add_event_cancel" class="btn btn-light me-3">Cancel</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" id="kt_modal_add_event_submit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>