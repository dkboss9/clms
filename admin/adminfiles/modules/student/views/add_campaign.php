<div class="modal fade" id="kt_modal_add_campaigns" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px" id="popup_lead_edit">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_add_user_header">
                <!--begin::Modal title-->
                <h2 class="fw-bolder">Add Campaign</h2>
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
                <form id="kt_modal_add_campaign_form" class="form"
                    action="<?php echo base_url("student/add_campaign");?>" method="post">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header"
                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">

                          <!--begin::Input group-->
                          <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-bold fs-6 mb-2">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="name" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                          <!--begin::Input group-->
                          <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Detail</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea type="text" name="detail" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="" value="" id="detail" ></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Attach file</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" name="campaign_file" id="campaign_file" class="form-control doccuments">
                            <table style="width: 100%;" id="div_document_campaign">
                            </table>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Start Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="start_date" id="start_date"
                                    class="campaign_date form-control form-control-solid mb-3 mb-lg-0" value=""
                                    autocomplete="off">
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class=" fs-6 fw-bold mb-2 reuired">End Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="end_date" id="end_date"
                                    class="campaign_date form-control form-control-solid mb-3 mb-lg-0" value=""
                                    autocomplete="off">
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                        </div>

                        <!--end::Input group-->




                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-bold fs-6 mb-2">Goals </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <table style="width: 100%;" id="div_goals">
                                <tr>
                                    <th style="width: 21%;">Number</th>
                                    <th style="width: 21%;">Goal type</th>
                                    <th style="width: 21%;">Goal name</th>
                                    <th style="width: 21%;">End date</th>
                                    <th style="width: 16%;"><button type="button" name="btn-goal"
                                    id="btn-goal" class="btn btn-primary" style="float: right;">+ Goal</button></th>
                                </tr>
                                <tr>
                                    <td><input type="number" name="txt_number[]" class="form-control "></td>
                                    <td>
                                        <select name="goal_type[]" class="form-select form-control-solid">
                                            <option value=""></option>
                                            <?php 
                      foreach($goal_types as $goal){
                        ?>
                                            <option value="<?php echo $goal->id;?>"><?php echo $goal->name;?></option>
                                            <?php
                      }
                    ?>
                                        </select>
                                    </td>
                                    <td><input type="text" name="goal_name[]" value="" class="form-control ">
                                    </td>
                                    <td><input type="text" name="goal_end_date[]" value=""
                                            class="form-control datepicker "></td>
                                    <td></td>
                                </tr>
                            </table>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                          <!--begin::Input group-->
                          <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-bold fs-6 mb-2">Lead by </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <?php 
                                foreach ($users as $user ) {
                                if($user['company'] != ''){
                                ?>
                                <div class="row">
                                <label class="col-md-3 control-label" for="inputDefault"></label>
                                <div class="col-md-9">
                                <!-- <input type="checkbox" name="is_allowed[]" value="<?php echo $user['company_id'];?>"> -->
                                    <strong> <?php echo $user['company'];?></strong> <br> <br>

                                    <?php
                                        foreach($user['data'] as $emp){
                                        ?>
                                    <div style="float:left;margin-right:20px;width:200px;">
                                    <input type="checkbox" name="assign_to[]"
                                        value="<?php echo $emp->id;?>">
                                        <?php
                                        $group = $emp->employee_type ? $emp->employee_type : $emp->group_name;
                                        echo $emp->first_name." ".$emp->last_name;
                                        ?>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                                </div>
                                <div style="clear: both;"></div>
                                <?php
                                }
                                }
                                ?>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                           <!--begin::Input group-->
                           <div class="row g-9 mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class="required fs-6 fw-bold mb-2">Status</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="status" class="form-select form-control-solid" >
                                    <option value="">Select</option>
                                    <?php foreach($campaign_status as $status){?>
                                    <option value="<?php echo $status;?>"><?php echo $status;?></option>
                                   <?php } ?>
                                </select>
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row fv-plugins-icon-container">
                                <!--begin::Label-->
                                <label class=" fs-6 fw-bold mb-2 required">Priority</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="priority" class="form-select form-control-solid">
                                    <option value="">Select</option>
                                    <?php foreach($campaign_priority as $priority){?>
                                    <option value="<?php echo $priority;?>"><?php echo $priority;?></option>
                                   <?php } ?>
                                </select>
                                <!--end::Input-->
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <!--end::Col-->
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

<script>
    $(document).ready(function(){
        $("#btn-goal").click(function(){
      var content = '  <tr>\
                <td><input type="number" name="txt_number[]" class="form-control"></td>\
                <td>\
                  <select name="goal_type[]" class="form-select form-control-solid">\
                    <option value=""></option>';
                    <?php 
                      foreach($goal_types as $goal){
                        ?>
                        content += '<option value="<?php echo $goal->id;?>"><?php echo $goal->name;?></option>';
                        <?php
                      }
                    ?>
        content +=' </select>\
                </td>\
                <td><input type="text" name="goal_name[]" value="" class="form-control"></td>\
                <td><input type="text" name="goal_end_date[]" value="" class="form-control datepicker"></td>\
                <td><a href="javascript:void(0);" class="btn btn-danger list-btn"><i class="bi bi-x-circle-fill"></i></a></td>\
              </tr>'
      $("#div_goals").append(content);

        $('.datepicker').datepicker({
          format: 'dd-mm-yyyy',
          startDate: '-3d'
        });

    });

    $(document).on("click",".list-btn",function(){
      if(!confirm("Are you sure to remove this data?"))
        return false;
      $(this).parent().parent().remove();
    });

   
    });
</script>