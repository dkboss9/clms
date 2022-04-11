<script type="text/javascript">
  function addpurpose () {
    var purpose_name = $("#purpose_name").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>purpose/addpurpose",
      data: "purpose_name="+purpose_name,
      success: function (msg) {
        var purpose = JSON.parse(msg);
        $("#sel_purpose").append('<option value="'+purpose.purpose_id+'">'+purpose.purpose_name+'</option>');
        $("#sel_purpose").val(purpose.purpose_id);
       // $("#form_purpose_model").hide();
       $(".btn-close").trigger("click");
     }
   });
    
  }

  function addAboutus () {
    $("#p_aboutus").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var about_name = $("#about_name").val();
    var about_form_id = $("#about_form_id").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>about_us/addAboutus",
      data: "about_name="+about_name,
      success: function (msg) {
        var d = JSON.parse(msg);
        if(about_form_id == 1){
          $("#about_us_client").append('<option value="'+d.id+'">'+d.name+'</option>');
          $("#about_us_client").val(d.id);
        }else{
          $("#about_us").append('<option value="'+d.id+'">'+d.name+'</option>');
          $("#about_us").val(d.id);
        }
       
        $("#p_aboutus").html('');
        $("#form_about_model").modal("hide");
      }
    });
    
  }

  function addConsultancy(){
    $("#p_consultancy").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var first_name = $("#consultancy_first_name").val();
    var last_name = $("#consultancy_last_name").val();
    var email = $("#consultancy_email").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>supplier/addConsultancy",
      data: "first_name="+first_name+"&last_name="+last_name+"&email="+email,
      success: function (msg) {
        var d = JSON.parse(msg);
        var content = ' <div class="checkbox-custom checkbox-primary">'+
        '<input type="checkbox" value="'+d.id+'" name="supplier[]" checked="">'+
        '<label for="checkboxExample2">'+d.name+'</label>'+
        '</div>';
        $("#div_consultancy").append(content);
        $("#p_consultancy").html('');
        $(".btn-close").trigger("click");
      }
    });
    
  }


  function addConsultant () {
    $("#p_consultant").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var url = window.location.href;
    var first_name = $("#consultant_first_name").val();
    var last_name = $("#consultant_last_name").val();
    var email = $("#consultant_email").val();
    var consultant_type = $("#consultant_type").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>employee/addConsultant",
      data: "first_name="+first_name+"&last_name="+last_name+"&email="+email,
      success: function (msg) {
        var d = JSON.parse(msg);
        if(d.response == 'success'){
          if (url.indexOf("project/add") >= 0 || url.indexOf("project/edit") >= 0){
            var content = ' <div class="checkbox-custom checkbox-primary">'+
            '<input type="checkbox" value="'+d.id+'" name="employee[]" checked="">'+
            '<label for="checkboxExample2">'+d.name+'</label>'+
            '</div>';
            $("#div_consultant").append(content);
          }else{
            if(consultant_type == 1){
              $("#assign_to").append('<option value="'+d.id+'">'+d.name+'</option>');
            $("#assign_to").val(d.id);
            }else{
              $("#consultant").append('<option value="'+d.id+'">'+d.name+'</option>');
            $("#consultant").val(d.id);
            }
           
          }

          $("#p_consultant").html('');
          $(".btn-close").trigger("click");
        }else{
          $("#p_consultant").html(d.err_msg);
        }
      }
    });

  }

  function addSource () {
    var source_name = $("#source_name").val(); 
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>source/addSource",
      data: "source_name="+source_name,
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#lead_source").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#lead_source").val(d.id);
        $(".btn-close").trigger("click");
      }
    });

  }

  function addUser () {
    $("#p_user").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var rate = "";
    $(".txt_rate").each(function(){
      rate+=$(this).attr("id")+':'+$(this).val()+',';
    });

    var fname    = $("#user_fname").val();
    var lname    = $("#user_lname").val(); 
    var email    = $("#user_email").val();
    var phone    = $("#user_phone").val();
    var referal_form_id = $("#referal_form_id").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>index.php/salerep/addUser",
      data: "fname="+fname+"&lname="+lname+"&email="+email+"&phone="+phone+"&rate="+rate+"&role="+role+"&action=submit",
      success: function (msg) {
        var d = JSON.parse(msg);
        if(d.response == 'success'){
          if(referal_form_id == 1){
            $("#user_client").append('<option value="'+d.id+'">'+d.name+'</option>');
            $("#user_client").val(d.id);
          }else{
            $("#user").append('<option value="'+d.id+'">'+d.name+'</option>');
            $("#user").val(d.id);
          }
       
          $("#p_user").html('');
          $("#form_user_model").modal('hide');
        }else{
          $("#p_user").html(d.err_msg);
        }
      }
    });

  }

  function addStatus () {
    var status_name = $("#status_name").val(); 
    var status_color = $("#status_color").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>lead_status/addStatus",
      data: "status_name="+status_name+"&status_color="+status_color,
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#sel_status").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#sel_status").val(d.id);
        $(".btn-close").trigger("click");
      }
    });

  }

  function addLeadType () {
    $("#p_lead_type").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var type_name = $("#type_name").val(); 
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>lead_type/addLeadType",
      data: "type_name="+type_name,
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#lead_type").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#lead_type").val(d.id);
        $("#p_lead_type").html('');
        $(".btn-close").trigger("click");
      }
    });

  }

  function addVisaType () {
    $("#p_visa_type").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var type_name = $("#visa_type_name").val(); 
    var cat_id = $('input[name="visa_type"]').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>visa/addVisaType",
      data: {
        cat_id:cat_id,
        type_name:type_name
        },
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#sub_visa_type").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#sub_visa_type").val(d.id);
        $("#p_visa_type").html('');
        $(".btn-close").trigger("click");
      }
    });

  }

  function addIntake () {
    $("#p_intake").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var intake_name = $("#intake_name").val(); 
    var intake_desc = $("#intake_desc").val(); 
    var intake_start_date = $("#intake_start_date").val(); 
    var intake_end_date = $("#intake_end_date").val(); 
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>intake/addIntake",
      data: "intake_name="+intake_name+"&intake_desc="+intake_desc+"&intake_start_date="+intake_start_date+"&intake_end_date="+intake_end_date,
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#intake").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#intake").val(d.id);
        $("#p_intake").html('');
        $(".btn-close").trigger("click");
      }
    });

  }

  function addCollege () {
    $("#p_college").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var college_country = $("#college_country").val(); 
    var college_name = $("#college_name").val(); 
    var college_desc = $("#college_desc").val(); 
    var college_contact_name = $("#college_contact_name").val();
    var college_contact_email = $("#college_contact_email").val();
    var college_contact_number = $("#college_contact_number").val();
    var college_trading_name = $("#college_trading_name").val();
    var college_city = $("#college_city").val();
    var college_expiry_date = $("#college_expiry_date").val();
    var college_abn = $("#college_abn").val();
    var college_college_level = $("#college_college_level").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>college/addCollege",
      data: "college_country="+college_country+"&college_name="+college_name+"&college_desc="+college_desc+
      "&college_contact_name="+college_contact_name+"&college_contact_email="+college_contact_email+
      "&college_contact_number="+college_contact_number+
      "&college_trading_name="+college_trading_name+
      "&college_city="+college_city+
      "&college_expiry_date="+college_expiry_date+
      "&college_abn="+college_abn+
      "&college_college_level="+college_college_level,
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#college").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#college").val(d.id);
        $("#p_college").html('');
        $(".btn-close").trigger("click");
      }
    });

  }

  function addDegree () {
    $("#p_degree").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var degree_name = $("#degree_name").val(); 
    var country = $("#country").val();
    var college = $("#college").val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>degree/addDegree",
      data: "degree_name="+degree_name+"&country="+country+"&college="+college,
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#degree").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#degree").val(d.id);
        $("#p_degree").html('');
        $(".btn-close").trigger("click");
      }
    });

  }

  function addCourse () {
    $("#p_course").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var course_degree = $("#course_degree").val(); 
    var course_name = $("#course_name").val(); 
    var course_desc = $("#course_desc").val(); 
    var course_period = $("#course_period").val(); 

    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>course/addCourse",
      data: "course_degree="+course_degree+"&course_name="+course_name+
      "&course_desc="+course_desc+"&course_period="+course_period,
      success: function (msg) {
        var d = JSON.parse(msg);
        $("#course").append('<option value="'+d.id+'">'+d.name+'</option>');
        $("#course").val(d.id);
        $("#p_course").html('');
        $(".btn-close").trigger("click");
      }
    });

  }

  function addVisaClass(){
   $("#p_visa_class").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var visa_class_name = $("#visa_class_name").val(); 


   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>visa_class/addVisaClass",
    data: "visa_class_name="+visa_class_name,
    success: function (msg) {
      var d = JSON.parse(msg);
      $("#visa_class").append('<option value="'+d.id+'">'+d.name+'</option>');
      $("#visa_class").val(d.id);
      $("#p_visa_class").html('');
      $(".btn-close").trigger("click");
    }
  });
 }

 function addProjectStatus(){
  $("#p_order_status").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
  var order_status = $("#order_status_name").val(); 


  $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>project_status/addProjectStatus",
    data: "order_status="+order_status,
    success: function (msg) {
      var d = JSON.parse(msg);
      $("#project_status").append('<option value="'+d.id+'">'+d.name+'</option>');
      $("#project_status").val(d.id);
      $("#p_order_status").html('');
      $(".btn-close").trigger("click");
    }
  });
}

function addgst(){
  $("#p_gst").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
  var gst_name = $("#gst_name").val(); 
  var gst_value = $("#gst_value").val();

  $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>gst/addgst",
    data: "gst_name="+gst_name+"&gst_value="+gst_value,
    success: function (msg) {
      var d = JSON.parse(msg);
      $("#gst").append('<option value="'+d.id+'">'+d.name+'</option>');
      $("#gst").val(d.id);
      $("#gst").trigger("change");
      $("#p_gst").html('');
      $(".btn-close").trigger("click");
    }
  });
}

function addDoctype(){
 $("#p_doc_type").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
 var doc_type = $("#doc_type_name").val(); 

 $.ajax({
  type: "POST",
  url: "<?php echo base_url();?>doc_type/addDoctype",
  data: "doc_type="+doc_type,
  success: function (msg) {
    var d = JSON.parse(msg);
    $("#doc_type").append('<option value="'+d.id+'">'+d.name+'</option>');
    $("#doc_type").val(d.id);
    $("#p_doc_type").html('');
    $(".btn-close").trigger("click");
  }
});
}

function addPackage(){
   var new_package = $("#new_package").val();
   var new_package_price = $("#new_package_price").val();
   var row = $("#txt_row_number").val();

   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>package/addPackage",
    data: "new_package=" + new_package + "&new_package_price=" + new_package_price,
    success: function (msg) {
      $("#package"+row).append('<option value="'+msg+'" rel="'+new_package_price+'">'+new_package+'</option>');
      $("#package"+row).val(msg);
      $(".doccuments").trigger("change");
      $("#new_package").val('');
      $("#new_package_price").val('');
      $(".btn-close").trigger("click");
    }
  });

 }

 function addGroup(){
  $("#p_group").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var new_group = $("#new_group_name").val();
   var all_data = $("#all_data").is(":checked") ? 1 : 0;

   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>users/addgroup_popup",
    data: "group=" + new_group + "&all_data=" + all_data ,
    success: function (msg) {
      if(msg == 'Group Name Already Exist'){
        $("#p_group").html(msg);
      }else{
        $("#employee_type").append('<option value="'+msg+'">'+new_group+'</option>');
        $("#employee_type").val(msg);
        $(".btn-close").trigger("click");
        $("#p_group").html("");
      }
     
    }
  });

 }

 function addEmpLevel(){
  $("#p_emp_level").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var new_level = $("#new_level").val();
   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>employee_level/add",
    data: {
      name : new_level,
      action : 'add',
      submit : 1
    },
    success: function (msg) {
      if(msg == 'Group Name Already Exist'){
        $("#p_emp_level").html(msg);
      }else{
        $("#level").append('<option value="'+msg+'">'+new_level+'</option>');
        $("#level").val(msg);
        $(".btn-close").trigger("click");
        $("#p_emp_level").html("");
      }
     
    }
  });

 }

 function addEmpDepartment(){
  $("#p_emp_department").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var new_department = $("#new_department").val();
   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>department/add",
    data: {
      name : new_department,
      action : 'add',
      submit : 1
    },
    success: function (msg) {
     
        $("#department").append('<option value="'+msg+'">'+new_department+'</option>');
        $("#department").val(msg);
        $(".btn-close").trigger("click");
        $("#p_emp_department").html("");
      
     
    }
  });

 }

 function addEmpTransport(){
  $("#p_emp_transport").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var new_transport = $("#new_transport").val();
   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>employee_transport/add",
    data: {
      name : new_transport,
      action : 'add',
      submit : 1
    },
    success: function (msg) {
     
        $("#transport").append('<option value="'+msg+'">'+new_transport+'</option>');
        $("#transport").val(msg);
        $(".btn-close").trigger("click");
        $("#p_emp_transport").html("");
      
     
    }
  });

 }

 function addEmpPosition(){
  $("#p_emp_transport").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var new_position = $("#new_position").val();
   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>employee_position/add",
    data: {
      name : new_position,
      action : 'add',
      submit : 1
    },
    success: function (msg) {
     
        $("#position").append('<option value="'+msg+'">'+new_position+'</option>');
        $("#position").val(msg);
        $(".btn-close").trigger("click");
        $("#p_emp_position").html("");
      
     
    }
  });

 }

 function addEmpWage(){
  $("#p_emp_wage").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var new_wage = $("#new_wage").val();
   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>employee_type/add",
    data: {
      name : new_wage,
      action : 'add',
      submit : 1
    },
    success: function (msg) {
     
        $("#emp_type").append('<option value="'+msg+'">'+new_wage+'</option>');
        $("#emp_type").val(msg);
        $(".btn-close").trigger("click");
        $("#p_emp_wage").html("");
    }
  });

 }

 function addTaskstatus(){
  $("#p_task_status").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
   var new_task_status = $("#new_task_status").val();
   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>task_status/add",
    data: {
      name : new_task_status,
      action : 'add',
      submit : 1
    },
    success: function (msg) {
     
        $("#task_status").append('<option value="'+msg+'">'+new_task_status+'</option>');
        $("#task_status").val(msg);
        $(".btn-close").trigger("click");
        $("#p_task_status").html("");
    }
  });
 }

 function addPriority(){
    $("#p_priority").html('<img src="<?php echo base_url("assets/images/loading.gif");?>">');
    var new_priority = $("#new_priority").val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>priority/add",
      data: {
        name : new_priority,
        action : 'add',
        submit : 1
      },
      success: function (msg) {
      
          $("#priority").append('<option value="'+msg+'">'+new_priority+'</option>');
          $("#priority").val(msg);
          $(".btn-close").trigger("click");
          $("#p_priority").html("");
      }
    });
 }

</script>

<div id="form_priority_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Priority</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_priority" action="javascript:addPriority();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_priority">Title</label>
             <div class="col-md-6">
              <input type="text" name="new_priority" value=""  class="form-control" id="new_priority" required>

            </div>
          </div>

        </div>

      </div>

    </div>
    <p style="text-align:center;" id="p_priority"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_taskstatus_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Task Status</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_taskstatus" action="javascript:addTaskstatus();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_task_status">Status</label>
             <div class="col-md-6">
              <input type="text" name="new_task_status" value=""  class="form-control" id="new_task_status" required>

            </div>
          </div>

        </div>

      </div>

    </div>
    <p style="text-align:center;" id="p_task_status"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_wage_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Wage</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_emp_wage" action="javascript:addEmpWage();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_position">Wage</label>
             <div class="col-md-6">
              <input type="text" name="new_wage" value=""  class="form-control" id="new_wage" required>

            </div>
          </div>

        </div>

      </div>

    </div>
    <p style="text-align:center;" id="p_emp_wage"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_position_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Position</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_position" action="javascript:addEmpPosition();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_position">Position</label>
             <div class="col-md-6">
              <input type="text" name="new_position" value=""  class="form-control" id="new_position" required>

            </div>
          </div>

        </div>

      </div>

    </div>
    <p style="text-align:center;" id="p_emp_position"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>


<div id="form_transport_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Transport</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_transport" action="javascript:addEmpTransport();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_transport">Transport</label>
             <div class="col-md-6">
              <input type="text" name="new_transport" value=""  class="form-control" id="new_transport" required>

            </div>
          </div>

        </div>

      </div>

    </div>
    <p style="text-align:center;" id="p_emp_transport"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_department_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Department</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_department" action="javascript:addEmpDepartment();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_department">Department</label>
             <div class="col-md-6">
              <input type="text" name="new_department" value=""  class="form-control" id="new_department" required>

            </div>
          </div>

        </div>

      </div>

    </div>
    <p style="text-align:center;" id="p_emp_department"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_emplevel_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Employee Level</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_emp_level" action="javascript:addEmpLevel();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_group_name">Level</label>
             <div class="col-md-6">
              <input type="text" name="new_level" value=""  class="form-control" id="new_level" required>

            </div>
          </div>

        </div>

      </div>

    </div>
    <p style="text-align:center;" id="p_emp_level"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_empgroup_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Employee Group</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_group" action="javascript:addGroup();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div  class="tab-pane active">

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_group_name">Type</label>
             <div class="col-md-6">
              <input type="text" name="new_group_name" value=""  class="form-control" id="new_group_name" required>

            </div>
          </div>

          <div class="form-group">
             <label class="col-md-3 control-label" for="all_data">All Data</label>
             <div class="col-md-6">
              <input type="checkbox" name="all_data" value=""  id="all_data" >

            </div>
          </div>

        </div>

      </div>

    </div>
  
    <p style="text-align:center;" id="p_group"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_package_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" style="width:600px;" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Package</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_package" action="javascript:addPackage();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div id="add-contact" class="tab-pane active">

             <div class="form-group">
               <label class="col-md-3 control-label" for="new_package">Package Type</label>
               <div class="col-md-6">
                <input type="text" name="new_package" value=""  class="form-control" id="new_package" required>

              </div>
            </div>

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_package_price">Package Price</label>
             <div class="col-md-6">
              <input type="number" name="new_package_price" value=""  class="form-control" id="new_package_price" required>

            </div>
          </div>

        </div>

      </div>

    </div>

    <p style="text-align:center;" id="p_degree"> </p>
    <div class="row mb-lg">
      <div class="col-sm-9 col-sm-offset-3">
        <input type="hidden" name="txt_row_number" id="txt_row_number" value="1">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</form>

</div>
</div>
</div>

<div id="form_doc_type_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_doc_type" id="form_doc_type" action="javascript:addDoctype();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Doc Type</h4>
          </div>
          <p> &nbsp;</p>


          <div class="form-group">
            <label class="col-md-3 control-label" for="gst_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="doc_type_name" id="doc_type_name" value=""  class="form-control" required>
            </div>
          </div>

          <p style="text-align:center;" id="p_doc_type"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="form_gst_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_gst" id="form_gst" action="javascript:addgst();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Tax Type</h4>
          </div>
          <p> &nbsp;</p>


          <div class="form-group">
            <label class="col-md-3 control-label" for="gst_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="gst_name" id="gst_name" value=""  class="form-control" required>
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-3 control-label" for="gst_value">Value (%)</label>
            <div class="col-md-9">
              <input type="text" name="gst_value" id="gst_value" value=""  class="form-control number " required>
            </div>
          </div>




          <p style="text-align:center;" id="p_gst"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="form_project_status_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_project_status" id="form_project_status" action="javascript:addProjectStatus();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Order Status</h4>
          </div>
          <p> &nbsp;</p>


          <div class="form-group">
            <label class="col-md-3 control-label" for="order_status_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="order_status_name" id="order_status_name" value=""  class="form-control" required>
            </div>
          </div>




          <p style="text-align:center;" id="p_order_status"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="form_visa_class_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_visa_class" id="form_visa_class" action="javascript:addVisaClass();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Visa Class</h4>
          </div>
          <p> &nbsp;</p>
          <?php
         // $course_degree = $this->enrollmodel->getDegree();
          ?>


          <div class="form-group">
            <label class="col-md-3 control-label" for="visa_class_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="visa_class_name" id="visa_class_name" value=""  class="form-control" required>
            </div>
          </div>




          <p style="text-align:center;" id="p_visa_class"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="form_course_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <form name="form_course" id="form_course" action="javascript:addCourse();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Course</h4>
          </div>
          <p> &nbsp;</p>
          <?php
         // $course_degree = $this->enrollmodel->getDegree();
          ?>
          <div class="form-group">
           <label class="col-md-3 control-label" for="country">Degree</label>
           <div class="col-md-9">
             <select class="form-control " name="course_degree" id="course_degree">
              <option value="">Select</option>
              <?php
             /* foreach ($course_degree as $row) {
               ?>
               <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
               <?php
             } */
             ?>
           </select>
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="degree_name">Name</label>
        <div class="col-md-9">
          <input type="text" name="course_name" id="course_name" value=""  class="form-control" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="course_desc">Description</label>
        <div class="col-md-9">
          <textarea name="course_desc" id="course_desc" class="form-control"></textarea>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Course Duration</label>
        <div class="col-md-9">
          <select name="course_period" id="course_period" class="form-control required">
            <option value="">Select</option>
            <option value="6 Months">6 Months</option>
            <option value="1 Year">1 Year</option>
            <option value="2 Years">2 Years</option>
            <option value="3 Years">3 Years</option>
            <option value="4 Years">4 Years</option>
            <option value="5 Years">5 Years</option>
          </select>
        </div>
      </div>

      <p style="text-align:center;" id="p_course"> </p>
      <div class="modal-footer">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </form>
</div>
</div>
</div>
<div id="form_degree_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_degree" id="form_degree" action="javascript:addDegree();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Degree</h4>
          </div>
          <p> &nbsp;</p>

          <div class="form-group">
            <label class="col-md-3 control-label" for="degree_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="degree_name" id="degree_name" value=""  class="form-control" required>
            </div>
          </div>

          <p style="text-align:center;" id="p_degree"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="form_college_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <form name="form_college" id="form_college" action="javascript:addCollege();" method="post">
      <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Institute</h4>
          </div>
          <p> &nbsp;</p>
      <div class="form-group">
            <label class="col-md-2 control-label" for="college_name">Name</label>
            <div class="col-md-3">
              <input type="text" name="college_name" value=""  class="form-control required" id="college_name" >
            </div>
            <label class="col-md-3 control-label" for="college_trading_name">Trading Name</label>
            <div class="col-md-3">
              <input type="text" name="college_trading_name" value=""  class="form-control" id="college_trading_name" required>
            </div>
        </div>

       
         <div class="form-group">
           <label class="col-md-2 control-label" for="country">Country</label>
           <div class="col-md-3">
             <select class="form-control" data-plugin-selectTwo id="college_country"  name="college_country"  required>
              <option value="">Select</option>
              <?php
              foreach ($countries as $row) {
               ?>
               <option value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
               <?php
             }
             ?>
           </select>
         </div>
         <label class="col-md-3 control-label" for="college_city">City</label>
           <div class="col-md-3">
             <select class="form-control " data-plugin-selectTwo  name="college_city"  id="college_city">
              <option value="">Select</option>
             
           </select>
         </div>
       </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="college_expiry_date">Agreement expiry date</label>
        <div class="col-md-3">
          <input type="text" name="college_expiry_date" value=""  class="form-control datepicker" id="college_expiry_date" required>
        </div>
        <label class="col-md-3 control-label" for="college_contact_name">Contact person name</label>
        <div class="col-md-3">
          <input type="text" name="college_contact_name" value=""  class="form-control" id="college_contact_name" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="college_contact_email">Email</label>
        <div class="col-md-3">
          <input type="email" name="college_contact_email" value=""  class="form-control email" id="college_contact_email" required>
        </div>
        <label class="col-md-3 control-label" for="college_contact_number">Contact Number</label>
        <div class="col-md-3">
        <input type="text" name="college_contact_number" value=""  class="form-control" id="college_contact_number" >
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label" for="college_abn">ABN</label>
        <div class="col-md-3">
          <input type="text" name="college_abn" value=""  class="form-control " id="college_abn" required>
        </div>
        <label class="col-md-3 control-label" for="college_desc">Description</label>
        <div class="col-md-3"> 
          <textarea name="college_desc" id="college_desc" class="form-control" ></textarea>
        </div>
      </div>

    
      <div class="form-group">
        <label class="col-md-2 control-label" for="college_college_level">Level of College</label>
        <div class="col-md-3">
        <select class="form-control required" data-plugin-selectTwo  name="college_college_level" id="college_college_level">
              <option value="">Select</option>
              <?php 
                foreach($levels??[] as $level){
                  ?>
                  <option value="<?php echo $level->id;?>"><?php echo $level->name;?></option>
                  <?php
                }
              ?>
                        
           </select>
        </div>
      
      </div>


      <p style="text-align:center;" id="p_college"> </p>
      <div class="modal-footer">
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </form>
</div>
</div>
</div>
<div id="form_intake_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_intake" id="form_intake" action="javascript:addIntake();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Intake</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-9">
              <input type="text" name="intake_name" id="intake_name" value=""  class="form-control"  required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Description</label>
            <div class="col-md-9">
              <textarea name="intake_desc" id="intake_desc" class="form-control" ></textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Form Submit Start Date</label>
            <div class="col-md-9">
              <input type="text" data-plugin-datepicker="" name="intake_start_date" id="intake_start_date" value=""  class="form-control" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Form Submit End Date</label>
            <div class="col-md-9">
              <input type="text" data-plugin-datepicker="" name="intake_end_date" id="intake_end_date" value=""  class="form-control" required>
            </div>
          </div>

          <p style="text-align:center;" id="p_intake"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="form_visa_type_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <form name="form_visa_type" id="form_visa_type" action="javascript:addVisaType();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add visa type</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="type_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="visa_type_name" id="visa_type_name" value=""  class="form-control required"  >
            </div>
          </div>

          <p style="text-align:center;" id="p_visa_type"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="form_lead_type_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_lead_type" id="form_lead_type" action="javascript:addLeadType();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add lead type</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="type_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="type_name" id="type_name" value=""  class="form-control required"  >
            </div>
          </div>

          <p style="text-align:center;" id="p_lead_type"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="form_status_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content">
      <form name="form_status" id="form_status" action="javascript:addStatus();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add lead Status</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="status_name">Name</label>
            <div class="col-md-9">
              <input type="text" name="status_name" id="status_name" value=""  class="form-control required"  >
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label" for="status_color">Color</label>
            <div class="col-md-9">
              <input type="text" data-plugin-colorpicker="" name="status_color" id="status_color" value="#3a1de8"  class="form-control required" >
            </div>
          </div>
          <p> &nbsp;</p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="form_user_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <form name="form_user" id="form_user" action="javascript:addUser();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Referee</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="user_fname">First Name</label>
            <div class="col-md-9">
             <input type="text" name="user_fname" id="user_fname" class="form-control required"  />
             <input type="hidden" name="role" id="role" value="3">
           </div>
         </div>

         <div class="form-group">
           <label class="col-md-3 control-label" for="user_lname">Last Name</label>
           <div class="col-md-9">
            <input type="text" name="user_lname" id="user_lname" class="form-control required"  />
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Email</label>
          <div class="col-md-9">
            <input type="email" name="user_email" id="user_email" class="form-control required"  />
          </div>
        </div>

        <?php /*
        if(isset($lead_types)){
          foreach ($lead_types as $row) {
            ?>
            <div class="form-group">
              <label class="col-md-3 control-label"><?php echo $row->type_name;?> Rate</label>
              <div class="col-md-6">
                <input type="text" name="rate[]" id="<?php echo $row->type_id;?>" class="form-control number txt_rate" />
              </div>
            </div>

            <?php
          }
        } */
        ?>

        <div class="form-group">
          <label class="col-md-3 control-label">Phone</label>
          <div class="col-md-9">
           <input type="text" name="user_phone" id="user_phone" class="form-control" />
         </div>
       </div>
       <p style="text-align:center;color:red;" id="p_user"> </p>
       <div class="modal-footer">
       <input type="hidden" name="referal_form_id" id="referal_form_id" value="" >
        <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>
  </form>
</div>
</div>
</div>
<div id="form_source_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_source" id="form_source" action="javascript:addSource();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add lead source</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-9">
              <input type="text" name="source_name" id="source_name" value=""  class="form-control required" id="inputDefault" >
            </div>
          </div>
          <p> &nbsp;</p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="form_purpose_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_purpose" id="form_purpose" action="javascript:addpurpose();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add purpose</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-9">
              <input type="text" name="purpose_name" id="purpose_name" value=""  class="form-control required" id="inputDefault" >
            </div>
          </div>
          <p> &nbsp;</p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="form_about_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_about" id="form_about" action="javascript:addAboutus();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">How did you know about us?</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-9">
              <input type="text" name="about_name" id="about_name" value=""  class="form-control required" id="inputDefault" >
            </div>
          </div>
          <p style="text-align:center;" id="p_aboutus"> &nbsp;</p>
          <div class="modal-footer">
            <input type="hidden" name="about_form_id" id="about_form_id" value="" >
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="form_consultant_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_consultant" id="form_consultant" action="javascript:addConsultant();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Consultant</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="consultant_first_name">First Name</label>
            <div class="col-md-9">
              <input type="text" name="consultant_first_name" id="consultant_first_name" value=""  class="form-control required"  >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="consultant_last_name">Last Name</label>
            <div class="col-md-9">
              <input type="text" name="consultant_last_name" id="consultant_last_name" value=""  class="form-control required"  >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="consultant_email">Email</label>
            <div class="col-md-9">
              <input type="email" name="consultant_email" id="consultant_email" value=""  class="form-control required"  >
            </div>
          </div>
          <p style="text-align:center;color:red;" id="p_consultant"> </p>
          <div class="modal-footer">
            <input type="hidden" name="consultant_type" id="consultant_type" value="">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="form_consultancy_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content"  >
      <form name="form_consultancy" id="form_consultancy" action="javascript:addConsultancy();" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Consultancy</h4>
          </div>
          <p> &nbsp;</p>
          <div class="form-group">
            <label class="col-md-3 control-label" for="consultancy_first_name">First Name</label>
            <div class="col-md-9">
              <input type="text" name="consultancy_first_name" id="consultancy_first_name" value=""  class="form-control required"  >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="consultancy_last_name">Last Name</label>
            <div class="col-md-9">
              <input type="text" name="consultancy_last_name" id="consultancy_last_name" value=""  class="form-control required"  >
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="consultancy_email">Email</label>
            <div class="col-md-9">
              <input type="email" name="consultancy_email" id="consultancy_email" value=""  class="form-control required"  >
            </div>
          </div>
          <p style="text-align:center;" id="p_consultancy"> </p>
          <div class="modal-footer">
            <input type="submit" name="btn-submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Submit">
            <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>







