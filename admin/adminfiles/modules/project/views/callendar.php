
<style type="text/css">
  table {
    border-collapse: collapse;
  }

  td {
    padding-top: .5em;
    padding-bottom: .5em;
  }
</style>
<?php 
//echo '<pre>';
//print_r($projects->result()); 
$events = array();
foreach ($projects->result() as $app) {
  $emps = $this->projectmodel->get_projectEmployee($app->project_id);
  $string = "";
  if(count($emps)>0){
    $string = "Employees:";
    foreach ($emps as $row) {
     $string.=@$row->first_name.' '.substr(@$row->last_name, 0,1).', ';
   }}
   $sups = $this->projectmodel->get_projectSupplier($app->project_id);
   if(count($sups) >0){
     $string .= ". Suppliers:";
     foreach ($sups as $row) {
      $string.=@$row->first_name.' '.substr(@$row->last_name, 0,1).', ';
    }}
    $event = new stdClass;
    $event->title = $app->first_name.' '.$app->last_name.': '.$app->project_title.'.'.$string;
    $event->title1 = $app->project_title;
    $event->lead_type = $app->lead_type;
    $event->sales_rep = $app->sales_rep;
    $event->category = $app->category;
    $event->subcategory = $app->subcategory;
    $event->subcategory2 = $app->subcategory2;
    $event->subcategory3 = $app->subcategory3;
    $event->subcategory4 = $app->subcategory4;
    $event->customer_id = $app->customer_id;
    $event->description = $app->description;
    $event->note = $app->note;
    $event->price = $app->price;
    $event->gst = $app->gst;
    $event->total = $app->total;
    $event->shipping = $app->shipping;
    $event->grand_total = $app->grand_total;


    $event->start = date('Y-m-d',$app->start_date);
 //$event->duration = intval($app->duration)*60;
    $event->end = date('Y-m-d',$app->end_date);
    $event->project_id = $app->project_id;
    $event->start_date = date("d/m/Y",$app->start_date);
    $event->end_date = date("d/m/Y",$app->end_date);

    $event->project_status = $app->project_status;

    if($app->code != "")
     $event->backgroundColor = $app->code;
   else
     $event->backgroundColor = '#0088cc';

   $events[] = $event;
 }
//echo '<pre>';
//print_r($events); die();
 ?>
 <script type="text/javascript">
  /*
Name:       Pages / Calendar - Examples
Written by:   Okler Themes - (http://www.okler.net)
Theme Version:  1.4.1
*/

(function( $ ) {

  'use strict';

  var initCalendarDragNDrop = function() {
    $('#external-events div.external-event').each(function() {

      // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
      // it doesn't need to have a start or end
      var eventObject = {
        title: $.trim($(this).text()) // use the element's text as the event title
      };

      // store the Event Object in the DOM element so we can get to it later
      $(this).data('eventObject', eventObject);

      // make the event draggable using jQuery UI
      $(this).draggable({
        zIndex: 999,
        revert: true,      // will cause the event to go back to its
        revertDuration: 0  //  original position after the drag
      });

    });
  };

  var initCalendar = function() {
    var $calendar = $('#calendar');
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $calendar.fullCalendar({
      header: {
        left: 'title',
        right: 'prev,today,next,basicDay,basicWeek,month'
      },

      timeFormat: 'h:mm T',

      titleFormat: {
        month: 'MMMM YYYY',      // September 2009
          week: "MMM D YYYY",      // Sep 13 2009
          day: 'dddd, MMM D, YYYY' // Tuesday, Sep 8, 2009
        },

        themeButtonIcons: {
          prev: 'fa fa-caret-left',
          next: 'fa fa-caret-right',
        },
        dayClick: function(date, jsEvent, view) { 
          var event_date = moment(date).format('DD/MM/YYYY');
          $("#event_date").val(event_date);
          $.colorbox({inline:true, href:"#inline_content",escKey: false,overlayClose: false});
        },
        eventClick: function(calEvent, jsEvent, view) { 
          jQuery("#project_id").val(calEvent.project_id);
          jQuery("#title").val(calEvent.title1);
          jQuery("#lead_type option[value='"+calEvent.lead_type +"']").attr('selected', 'selected');
          jQuery("#sales_rep option[value='"+calEvent.sales_rep +"']").attr('selected', 'selected');
          jQuery("#category option[value='"+calEvent.category +"']").attr('selected', 'selected');
          if(calEvent.category > 0){
            var catid = $(this).val();
            $.ajax({
              url: '<?php echo base_url() ?>lms/get_subcategory',
              type: "POST",
              data: "catid=" + calEvent.category,
              success: function(data) { 
                if(data != ""){
                  $("#sub_category").html(data);
                  jQuery("#sub_category option[value='"+calEvent.subcategory +"']").attr('selected', 'selected');
                  $("#div_sub_category").show();
                }
              }        
            });
          }

          if(calEvent.subcategory > 0){
            var catid = $(this).val();
            $.ajax({
              url: '<?php echo base_url() ?>lms/get_subcategory',
              type: "POST",
              data: "catid=" + calEvent.subcategory,
              success: function(data) { 
                if(data != ""){
                  $("#sub_category2").html(data);
                  jQuery("#sub_category2 option[value='"+calEvent.subcategory2 +"']").attr('selected', 'selected');
                  $("#div_sub_category2").show();
                }
              }        
            });
          }

          if(calEvent.subcategory2 > 0){
            var catid = $(this).val();
            $.ajax({
              url: '<?php echo base_url() ?>lms/get_subcategory',
              type: "POST",
              data: "catid=" + calEvent.subcategory2,
              success: function(data) { 
                if(data != ""){
                  $("#sub_category3").html(data);
                  jQuery("#sub_category3 option[value='"+calEvent.subcategory3 +"']").attr('selected', 'selected');
                  $("#div_sub_category3").show();
                }
              }        
            });
          }

          if(calEvent.subcategory3 > 0){
            var catid = $(this).val();
            $.ajax({
              url: '<?php echo base_url() ?>lms/get_subcategory',
              type: "POST",
              data: "catid=" + calEvent.subcategory3,
              success: function(data) { 
                if(data != ""){
                  $("#sub_category4").html(data);
                  jQuery("#sub_category4 option[value='"+calEvent.subcategory4 +"']").attr('selected', 'selected');
                  $("#div_sub_category4").show();
                }
              }        
            });
          }

          jQuery("#customer option[value='"+calEvent.customer_id +"']").attr('selected', 'selected');
          jQuery("#description").val(calEvent.description);
          jQuery("#price").val(calEvent.price);
          jQuery("#gst").val(calEvent.gst);
          jQuery("#total").val(calEvent.total);
          jQuery("#shipping").val(calEvent.shipping);
          jQuery("#grand").val(calEvent.grand_total);
          jQuery("#project_status option[value='"+calEvent.project_status +"']").attr('selected', 'selected');
          jQuery("#note").val(calEvent.note);
          jQuery("#start_date").val(calEvent.start_date);
          jQuery("#end_date").val(calEvent.end_date);

          $.ajax({
            url: '<?php echo base_url() ?>project/get_projectPackage',
            type: "POST",
            data: "project_id=" + calEvent.project_id,
            success: function(data) { 
              if(data != ""){
                var data = JSON.parse(data);
                var out = "";
                var i;
                //console.log(data);
                $("#div_document").html("");
                for(i = 0; i < data.length; i++) {
                  console.log(data[i]);
                  var num = i+1;
                  $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
                    '<td>  <select name="package[]" id="package'+num+'" rel="'+num+'" class="form-control doccuments">'+
                    '<option value="">Select</option>'+
                    <?php 
                    foreach ($packages as $package) {
                     ?>

                     '<option value="<?php echo $package->package_id;?>"><?php echo $package->package_name; ?></option>'+
                     <?php }?>
                     '</select>'+
                     '</td>'+
                     '<td> <input type="text" name="qty[]" value="'+data[i].qty+'" rel="'+num+'" id="package_qty_'+num+'" class="package_qty" style="width:50px;margin-left:20px;"></td>'+
                     '<td> <input type="text" name="unit_price[]" value="'+data[i].unit_price+'" rel="'+num+'" id="unit_price_'+num+'" class="unit_price" style="width:50px"></td>'+
                     '<td> <input type="text" name="package_price[]" value="'+data[i].total_price+'" rel="'+num+'" id="package_price_'+num+'" class="package_price" style="width:50px"></td>'+
                     '<td><a href="javascript:void(0);" class="link_remove" rel="'+num+'"> Remove</a></td></tr>');
                  /*$("#package_price_check_"+data[i].package_id).prop('checked', true);
                  $("#package_qty_"+data[i].package_id).val(data[i].qty);
                  $("#unit_price_"+data[i].package_id).val(data[i].unit_price);
                  $("#package_price_"+data[i].package_id).val(data[i].total_price); */
                  jQuery("#package"+num +" option[value='"+data[i].package_id +"']").attr('selected', 'selected');
                }

              }
            }        
          });

$.ajax({
  url: '<?php echo base_url() ?>project/get_projectEmployee',
  type: "POST",
  data: "project_id=" + calEvent.project_id,
  success: function(data) { 
    if(data != ""){
      var data = JSON.parse(data);
      var out = "";
      var i;
               // console.log(data);
               for(i = 0; i < data.length; i++) {
                $("#check_employee"+data[i].employee_id).prop('checked', true);
              }

            }
          }        
        });

$.ajax({
  url: '<?php echo base_url() ?>project/get_projectSupplier',
  type: "POST",
  data: "project_id=" + calEvent.project_id,
  success: function(data) { 
    if(data != ""){
      var data = JSON.parse(data);
      var out = "";
      var i;
              //  console.log(data);
              for(i = 0; i < data.length; i++) {
                $("#check_supplier"+data[i].supplier_id).prop('checked', true);
              }

            }
          }        
        });
var frm = document.getElementById('demo-form') || null;
if(frm) {
  frm.action = '<?php echo base_url("project/edit");?>' 
}
$.colorbox({inline:true, href:"#inline_content",escKey: false,overlayClose: false});
},
eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {
       // console.log(event.event_date);
       // console.log(delta._days);
       var strDate = event.event_date.split('/'),
       nrAddDays = 35,
       date = new Date(parseInt(strDate[2]), parseInt(strDate[1])-1, parseInt(strDate[0]));
       /* Add nr of days*/
       date.setDate(date.getDate() + delta._days);
       var event_date = moment(date).format('DD/MM/YYYY');
       $.ajax({
        url: '<?php echo base_url() ?>events/drag_event',
        type: "POST",
        data: "date=" + event_date + "&eventid=" + event.eventid,
        success: function(data) { 
          location.reload();
        }        
      });
     },

     editable: false,
      droppable: false, // this allows things to be dropped onto the calendar !!!

      events: <?php echo json_encode($events);?>
    });

    // FIX INPUTS TO BOOTSTRAP VERSIONS
    var $calendarButtons = $calendar.find('.fc-header-right > span');
    $calendarButtons
    .filter('.fc-button-prev, .fc-button-today, .fc-button-next')
    .wrapAll('<div class="btn-group mt-sm mr-md mb-sm ml-sm"></div>')
    .parent()
    .after('<br class="hidden"/>');

    $calendarButtons
    .not('.fc-button-prev, .fc-button-today, .fc-button-next')
    .wrapAll('<div class="btn-group mb-sm mt-sm"></div>');

    $calendarButtons
    .attr({ 'class': 'btn btn-sm btn-default' });
  };

  $(function() {
    initCalendar();
    initCalendarDragNDrop();
  });

}).apply(this, [ jQuery ]);
</script>

<section role="main" class="content-body">
  <header class="page-header">
    <h2>Projects</h2>

    <div class="right-wrapper pull-right">
      <a class="sidebar-right-toggle" href="<?php echo base_url("logout");?>"><i class="fa fa-power-off"></i></a>
    </div>
  </header>

  <!-- start: page -->
  <section class="panel">
    <div class="panel-body">
      <?php 
      if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
        ?>
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <strong>We must tell you! </strong> Please select company to add this data.
        </div>
        <?php
      }
      ?>
      <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>

    <div class="row">
      <div class="col-md-12">
        <div id="calendar"></div>
      </div>

    </div>
  </div>
</section>

<!-- end: page -->
</section>
</div>


</section>
<div style="display:none;">
  <div id="inline_content">

    <form id="demo-form" method="post" class="white-popup-block  form-horizontal" action="<?php echo base_url("project/add");?>">
      <div class="row">
        <div class="col-sm-12">
          <h3>Add Projects</h3>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-3 control-label" for="title">Project Title</label>
        <div class="col-md-6">
          <input type="text" name="title"  value="" class="form-control" id="title" required>

        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="lead_type">Lead Type</label>
        <div class="col-md-6">
          <select name="lead_type" class="form-control" id="lead_type" required>
            <option value="">Select</option>
            <?php 
            foreach ($lead_types as $row) {
             ?>
             <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
             <?php
           }
           ?>
         </select>
       </div>
     </div>

     <div class="form-group">
      <label class="col-md-3 control-label" for="sales_rep">Sale Reps</label>
      <div class="col-md-6">
        <select name="user" class="form-control mb-md" id="sales_rep" required>
          <option value="">Select</option>
          <?php 
          foreach($users as $user){
            ?>
            <option value="<?php echo $user->userid;?>"><?php echo $user->first_name.' '.$user->last_name;?></option>
            <?php
          }
          ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Product Category</label>
      <div class="col-md-6">
        <select name="category" id="category" class="form-control mb-md" required>
          <option value="">Select</option>
          <?php 
          foreach ($category as $cat) {
            ?>
            <option value="<?php echo $cat->cat_id;?>"><?php echo $cat->cat_name;?></option>
            <?php 
          }
          ?>
        </select>
      </div>
    </div>
    <div class="form-group" id="div_sub_category" style="display:none;">
      <label class="col-md-3 control-label" for="inputDefault">Sub Category</label>
      <div class="col-md-6">
        <select name="sub_category" id="sub_category" class="form-control mb-md" >
          <option value="">Select</option>

        </select>
      </div>
    </div>
    <div class="form-group" id="div_sub_category2" style="display:none;">
      <label class="col-md-3 control-label" for="inputDefault">Sub Category 2nd</label>
      <div class="col-md-6">
        <select name="sub_category2" id="sub_category2" class="form-control mb-md" >
          <option value="">Select</option>

        </select>
      </div>
    </div>

    <div class="form-group" id="div_sub_category3" style="display:none;">
      <label class="col-md-3 control-label" for="inputDefault">Sub Category 3rd</label>
      <div class="col-md-6">
        <select name="sub_category3" id="sub_category3" class="form-control mb-md" >
          <option value="">Select</option>

        </select>
      </div>
    </div> 

    <div class="form-group" id="div_sub_category4" style="display:none;">
      <label class="col-md-3 control-label" for="inputDefault">Sub Category 4th</label>
      <div class="col-md-6">
        <select name="sub_category4" id="sub_category4" class="form-control mb-md" >
          <option value="">Select</option>

        </select>
      </div>
    </div> 

    <div class="form-group">
      <label class="col-md-3 control-label" for="customer">Customer</label>
      <div class="col-md-6">
        <select name="customer" id="customer" class="form-control"  required>
         <option value="">Select</option>
         <?php 
         foreach ($customer as $row) {
          ?>
          <option value="<?php echo $row->customer_id;?>"><?php echo $row->customer_name;?></option>
          <?php
        }
        ?>
      </select>

    </div>
    <label class="col-md-3 control-label" id="customer_info"></label>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="description">Description</label>
    <div class="col-md-6">
      <textarea name="description"  class="form-control" id="description"  ></textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">Package</label>
    <div class="col-md-9">

      <table style="width: 100%;" id="div_document">
        <tr>
          <td><strong>Package</strong></td>
          <td><strong>Quantity</strong></td>
          <td><strong>Unit Price</strong></td>
          <td><strong>Total Price</strong></td>
          <td></td>
        </tr>
        <tr>
          <td>  <select name="package[]" rel="1" id="package1" class="form-control doccuments">
            <option value="">Select</option>
            <?php 
            foreach ($packages as $package) {
             ?>
             <option value="<?php echo $package->package_id;?>"><?php echo $package->package_name; ?></option>
             <?php }?>
           </select>
         </td>
         <td> <input type="text" name="qty[]" value="1" rel="1" id="package_qty_1" class="package_qty" style="width:50px;margin-left:20px;"></td>
         <td> <input type="text" name="unit_price[]" value="0" rel="1" id="unit_price_1" class="unit_price" style="width:50px"></td>
         <td> <input type="text" name="package_price[]" value="0" rel="1" id="package_price_1" class="package_price" style="width:50px"></td>
         <td></td>
       </tr>
     </table>
     <a href="javascript:void(0);" id="add_more">Add</a>
   </div>

 </div>



 <div class="form-group">
  <label class="col-md-3 control-label" for="price">Product Price</label>
  <div class="col-md-6">
    <input type="text" name="price" value="0" rel="<?php echo $gst->config_value;?>"  class="form-control" id="price" required>

  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="price">GST</label>
  <div class="col-md-6">
    <input type="hidden" name="gst" value="<?php echo $gst->config_value;?>"  class="form-control" id="gst" required>

    <label class="col-md-3 control-label" for="price"><?php echo $gst->config_value;?> %</label>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="total">Total</label>
  <div class="col-md-6">
    <input type="text" name="total" value="" rel="<?php echo $gst->config_value;?>" class="form-control" id="total" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="shipping">Shipping</label>
  <div class="col-md-6">
    <input type="text" name="shipping" value="0"  class="form-control" id="shipping" >

  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="grand">Grand Total</label>
  <div class="col-md-6">
    <input type="text" name="grand" value="0"  class="form-control" id="grand" readonly="">
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="project_status">Status</label>
  <div class="col-md-6">
    <select name="project_status" id="project_status" class="form-control" required>
     <option value="">Select</option>
     <?php 
     foreach ($project_status as $row) {
      ?>
      <option value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
      <?php
    }
    ?>
  </select>

</div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="note">Admin Note</label>
  <div class="col-md-6">

    <textarea name="note" class="form-control" id="note" ></textarea>
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Start Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="start_date"  id="start_date" class="form-control" required>
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">End Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="end_date" id="end_date" class="form-control" required>
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Add Employee</label>
  <div class="col-md-6">
    <div class="input-group">

      <?php 
      foreach ($employees as $row) {
       ?>
       <div class="checkbox-custom checkbox-primary">
         <input type="checkbox" value="<?php echo $row->userid;?>" name="employee[]" id="check_employee<?php echo $row->userid;?>">
         <label for="checkboxExample2"><?php echo $row->first_name.' '.$row->last_name; ?></label>
       </div>
       <?php
     }
     ?>
   </div>
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label">Add Suppliers</label>
  <div class="col-md-6">
    <div class="input-group">

      <?php 
      foreach ($suppliers as $row) {
       ?>
       <div class="checkbox-custom checkbox-primary">
         <input type="checkbox" value="<?php echo $row->userid;?>" name="supplier[]" id="check_supplier<?php echo $row->userid;?>">
         <label for="checkboxExample2"><?php echo $row->first_name.' '.$row->last_name; ?></label>
       </div>
       <?php
     }
     ?>
   </div>
 </div>
</div>

<div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="hidden" name="project_id" id="project_id" value="0">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" class="btn btn-default">Reset</button>
  </div>
</div>

</form>

</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
   $("#demo-form").validate();
   $("#customer").change(function(){
    var id = $(this).val();

    $.ajax({
      url: '<?php echo base_url() ?>lms/get_customerDetails',
      type: "POST",
      data: "customerid=" + id,
      success: function(data) { 
        $("#customer_info").html(data);
      }        
    });
  });

   $(document.body).on('change', '.package_qty' ,function(){
    var id = $(this).attr("rel");
    if($("#package"+id).val()=="")
      return false;
    var qty = $(this).val();
    var price = $("#unit_price_"+id).val();
    $("#package_price_"+id).val(parseFloat(qty)*parseFloat(price));
    $(".package_price").trigger("blur");
  });


   $(document.body).on('change', '.unit_price' ,function(){
    var id = $(this).attr("rel");
    if($("#package"+id).val()=="")
      return false;
    var price = $(this).val();
    var qty = $("#package_qty_"+id).val();
    $("#package_price_"+id).val(parseFloat(qty)*parseFloat(price));
    $(".package_price").trigger("blur");
  });


   $(document.body).on('blur', '.package_price' ,function(){
    var package_total = 0;
    $(".doccuments").each(function(){
        //if ($(this).prop('checked')) {
          var id = $(this).attr('rel');
          var price = $("#package_price_"+id).val();
          package_total+=parseFloat(price);
     // }
     $("#price").val(package_total);
   });
    $("#price").trigger("blur");
  });
   var num = 1;
   $("#add_more").click(function(){
    var cond = 1;
    $(".doccuments").each(function(){
      if($(this).val() == ""){
       cond = 0;

     }

   });
    if(cond == 0){
      alert("Select Package First.");
      return false;
    }

     // var num = $(".doccuments").length;
     num = num + 1;
     $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
      '<td>  <select name="package[]" id="package'+num+'" rel="'+num+'" class="form-control doccuments">'+
      '<option value="">Select</option>'+
      <?php 
      foreach ($packages as $package) {
       ?>
       '<option value="<?php echo $package->package_id;?>"><?php echo $package->package_name; ?></option>'+
       <?php }?>
       '</select>'+
       '</td>'+
       '<td> <input type="text" name="qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty" style="width:50px;margin-left:20px;"></td>'+
       '<td> <input type="text" name="unit_price[]" value="0" rel="'+num+'" id="unit_price_'+num+'" class="unit_price" style="width:50px"></td>'+
       '<td> <input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price" style="width:50px"></td>'+
       '<td><a href="javascript:void(0);" class="link_remove" rel="'+num+'"> Remove</a></td></tr>');
   });
$(document.body).on('click', '.link_remove' ,function(){
  var id = $(this).attr("rel");
  $("#tr_"+id).remove(); 
  $(".package_price").trigger("blur");
});
$(document.body).on('change', '.doccuments' ,function(){
  var packageid = $(this).val();
  var id = $(this).attr("rel");
  $.ajax({
    url: '<?php echo base_url() ?>project/get_packageDetails',
    type: "POST",
    data: "packageid=" + packageid,
    success: function(data) { 
     if(data != ""){
      var data = JSON.parse(data);
      var out = "";
      var i;
      console.log(data);
      for(i = 0; i < data.length; i++) {
       // $("#package_qty_"+id).val(data[i].qty);
       $("#unit_price_"+id).val(data[i].price);
       $("#package_price_"+id).val(data[i].price);
       $(".package_price").trigger("blur");
     }

   }
 }        
}); 

});

$("#price").blur(function(){
  var price = $(this).val();
  if(price == "")
    return false;
  var gst = $(this).attr("rel");
  var total = parseFloat(price) + ((parseFloat(price)/100)*parseFloat(gst));
  $("#total").val(total);
  var shipping = $("#shipping").val();
  $("#grand").val(parseFloat(shipping)+parseFloat(total));
});

$("#total").blur(function(){
  var gst = $(this).attr("rel");
  var total = $(this).val();
  if(total == "")
    return false;
  var price = (parseFloat(total)*100)/(parseFloat(gst)+100);
  $("#price").val(price);
  var shipping = $("#shipping").val();
  $("#grand").val(parseFloat(shipping)+parseFloat(total));
});
$("#shipping").blur(function(){
  var shipping = $(this).val();
  var total = $("#total").val();
  $("#grand").val(parseFloat(shipping)+parseFloat(total));
});
$("#category").change(function(){
 $("#div_sub_category").hide();
 $("#div_sub_category2").hide();
 $("#div_sub_category3").hide();
 $("#div_sub_category4").hide();
 jQuery("#sub_category option[value='']").attr('selected', 'selected');
 jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
 jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
 jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
 var catid = $(this).val();
 $.ajax({
  url: '<?php echo base_url() ?>lms/get_subcategory',
  type: "POST",
  data: "catid=" + catid,
  success: function(data) { 
    if(data != ""){
      $("#sub_category").html(data);
      $("#div_sub_category").show();
    }
  }        
});
});

$("#sub_category").on("change",function(){
  $("#div_sub_category2").hide();
  $("#div_sub_category3").hide();
  $("#div_sub_category4").hide();
  jQuery("#sub_category2 option[value='']").attr('selected', 'selected');
  jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
  jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
  var catid = $(this).val();
  $.ajax({
    url: '<?php echo base_url() ?>lms/get_subcategory',
    type: "POST",
    data: "catid=" + catid,
    success: function(data) { 
      if(data != ""){
        $("#sub_category2").html(data);
        $("#div_sub_category2").show();
      }
    }        
  });
});

$("#sub_category2").on("change",function(){
  $("#div_sub_category3").hide();
  $("#div_sub_category4").hide();

  jQuery("#sub_category3 option[value='']").attr('selected', 'selected');
  jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
  var catid = $(this).val();
  $.ajax({
    url: '<?php echo base_url() ?>lms/get_subcategory',
    type: "POST",
    data: "catid=" + catid,
    success: function(data) { 
      if(data != ""){
        $("#sub_category3").html(data);
        $("#div_sub_category3").show();
      }
    }        
  });
});

$("#sub_category3").on("change",function(){
  $("#div_sub_category4").hide();
  jQuery("#sub_category4 option[value='']").attr('selected', 'selected');
  var catid = $(this).val();
  $.ajax({
    url: '<?php echo base_url() ?>lms/get_subcategory',
    type: "POST",
    data: "catid=" + catid,
    success: function(data) { 
      if(data != ""){
        $("#sub_category4").html(data);
        $("#div_sub_category4").show();
      }
    }        
  });
});



});
</script>