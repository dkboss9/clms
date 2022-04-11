<style type="text/css">
#cboxClose {
  position: absolute;
  bottom: 600px;
  right: 25px;
}
</style>
<?php 
// echo '<pre>';
// print_r($installer->result()); 
$events = array();
foreach ($installer->result() as $app) {
 $event = new stdClass;
 $installers = $this->ordermodel->getorder_installer($app->order_id);
 //print_r($installers);
 $install_type =  $this->install_typemodel->getdata($app->install_type)->row();
 $order_installer = '';
 $order_installer_fullname = '';
 foreach($installers as $intaller){
   $order_installer .= substr(@$intaller->first_name, 0, 1).' '.substr(@$intaller->last_name, 0, 1).',';
   $order_installer_fullname .= @$intaller->first_name.' '.@$intaller->last_name.'('.$intaller->position_type.'),';
 }
 $order_installer = rtrim($order_installer, ',');
 $order_installer_fullname = rtrim($order_installer_fullname, ','); 
 $event->title = $order_installer.', '.$app->address;

 $event->order_installer_fullname = @$order_installer_fullname;
 
 $event->start = $app->installed_date.'T'.$app->installed_time;
 $event->installer = $app->installer;
 $event->installer_type = @$install_type->name;
 $event->eventid = $app->order_id;
 $event->event_date = date("d/m/Y",strtotime($app->installed_date));
 $event->event_time = $app->installed_time;
 $event->time_allocate_by = $app->time_allocate_by;
 $event->allocated_time = $app->allocated_time;

 $event->payment_method = $app->payment_method;
 $event->hourly_rate = $app->hourly_rate;
 $event->total_hour = $app->total_hour;
 $event->flat_amount = $app->flat_amount;
 $event->fuel_amount = $app->fuel_amount;
 $event->transport_amount = $app->transport_amount;
 $event->others_amount = $app->others_amount;
 $event->total_amount = $app->total_amount;
 $event->assign_by = $app->assign_by;

 if($app->color_code != "")
   $event->backgroundColor = $app->color_code;
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
Written by:   Okler Themes - (http://www.ausnep.com.au)
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
         // $("#event_date").val(event_date);
        //  $.colorbox({inline:true, href:"#inline_content",escKey: true,overlayClose: true});
      },
      eventClick: function(calEvent, jsEvent, view) { //alert(calEvent.eventid);

        $.ajax({
          url: '<?php echo base_url() ?>order/calender_notes',
          type: "POST",
          data: "eventid=" + calEvent.eventid,
          success: function(data) { 
            $("#special_notes").html(data);
          }        
        });

        var order_id = calEvent.eventid;
        $.ajax({
          url: '<?php echo base_url() ?>order/get_order_detail',
          type: "POST",
          data: "orderid=" + calEvent.eventid,
          success: function(data) { 
            $("#span_address").html(data);
          }        
        });
        console.log(calEvent);
        $("#order_id").val(order_id);
        $("#installer").val(calEvent.order_installer_fullname);
        $("#install_type").val(calEvent.installer_type);
        $("#reminder_date").val(calEvent.event_date);
        $("#time").val(calEvent.event_time);
        $("#allocate_by").val(calEvent.time_allocate_by);
        $("#hourly_rate").val(calEvent.hourly_rate);
        $("#install_time").val(calEvent.total_hour);
        $("#flat_amount").val(calEvent.flat_amount);
        $("#fuel_amount").val(calEvent.fuel_amount);
        $("#transport_amount").val(calEvent.transport_amount);
        $("#others_amount").val(calEvent.others_amount);
        $("#payment_method").val(calEvent.payment_method);
        $("#flat_install_time").val(calEvent.allocated_time);
        $("#assign_by").val(calEvent.assign_by);
        $("#total_amount").val(calEvent.total_amount);

        if(calEvent.time_allocate_by == 'Employer'){
          $("#div_time").show();
        }else{
         $("#div_time").hide();
       }

       //$("#install_time").val(calEvent.allocated_time);
       $("#span_installer").html(calEvent.order_installer_fullname);
       $("#span_install_type").html(calEvent.installer_type);
       $("#span_reminder_date").html(calEvent.event_date);
       $("#span_time").html(calEvent.event_time);
       $("#span_allocate_by").html(calEvent.time_allocate_by);
       if(calEvent.time_allocate_by == 'Employer'){
        $("#div_employer").show();
      }else{
       $("#div_employer").hide();
     }
     $("#span_allocate_install_time").html(calEvent.allocated_time);
     $("#span_payment_method").html(calEvent.payment_method);

     if(calEvent.payment_method == 'Hourly Rate'){
      $("#div_hourly").show();
      $("#div_flat").hide();
      $("#div_total_amount").show();
    }

    if(calEvent.payment_method == 'Flat Rate'){
      $("#div_hourly").hide();
      $("#").show();
      $("#div_total_amount").show();
    }

    $("#span_hourly_rate").html(calEvent.hourly_rate);
    $("#span_install_time").html(calEvent.total_hour);
    $("#span_flat_install_time").html(calEvent.allocated_time)
    $("#span_flat_amount").html(calEvent.flat_amount);
    $("#span_fuel_amount").html(calEvent.fuel_amount);
    $("#span_others_amount").html(calEvent.others_amount);
    $("#span_transport_amount").html(calEvent.transport_amount);
    $("#span_total_amount").html(calEvent.total_amount);
    $("#span_assign_by").html(calEvent.assign_by);

    console.log(calEvent);

    $.colorbox({inline:true, href:"#inline_content",width:'600px',height:'600px'});
  },
  eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {


  },

  editable: false,
      droppable: false, // this allows things to be dropped onto the calendar !!!
      drop: function(date, allDay) { // this function is called when something is dropped
        var $externalEvent = $(this);
        // retrieve the dropped element's stored Event Object
        var originalEventObject = $externalEvent.data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.className = $externalEvent.attr('data-event-class');

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#RemoveAfterDrop').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }

      },
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


<div class="tabs tabs-warning">
 
  <div class="tab-content">
    <!-- start: page -->
    <section class="panel">
      <div class="panel-body">
        <?php 
        if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
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
</div>
</div>
<!-- end: page -->
</section>
</div>


</section>
<div style="display:none;">
  <div id="inline_content">

   <div class="form-group">
    <div class="table-responsive">
      <table class="table invoice-items" >
        <thead>
          <tr class="h4 text-dark">
            <th id="cell-item" class="text-weight-semibold">Special note</th>
          </tr>
        </thead>
        <tbody id="special_notes">
        </tbody>
      </table>
    </div>
    
  </div>
  <hr>
  <form method="post"  action="<?php echo base_url("order/callendar_install");?>">
    <input type="hidden" name="installer" id="installer" value="">
    <input type="hidden" name="install_type" id="install_type" value="">
    <input type="hidden" name="reminder_date" id="reminder_date" value="">
    <input type="hidden" name="time" id="time" value="">
    <input type="hidden" name="allocate_by" id="allocate_by" value="">
    <input type="hidden" name="hourly_rate" id="hourly_rate" value="">
    <input type="hidden" name="install_time" id="install_time" value="">
    <input type="hidden" name="flat_amount" id="flat_amount" value="">
    <input type="hidden" name="fuel_amount" id="fuel_amount" value="">
    <input type="hidden" name="transport_amount" id="transport_amount" value="">
    <input type="hidden" name="others_amount" id="others_amount" value="">
    <input type="hidden" name="total_amount" id="total_amount" value="">
    <input type="hidden" name="payment_method" id="payment_method" value="">
    <input type="hidden" name="flat_install_time" id="flat_install_time" value="">
    <input type="hidden" name="assign_by" id="assign_by" value="">

    <div class="form-group">
      <label class="col-md-3 control-label">Address</label>
      <div class="col-sm-6">
       <span id="span_address"></span>
     </div>
   </div>

   <div class="form-group">
    <label class="col-md-3 control-label">Installer</label>
    <div class="col-sm-6">
      <span id="span_installer"></span>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label">Install Type</label>
    <div class="col-sm-6">
      <span id="span_install_type"></span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-3 control-label">Installed Date</label>
    <div class="col-md-6">
     <span id="span_reminder_date"></span>
   </div>
 </div>
 <div class="form-group">
  <label class="col-md-3 control-label">Installed Time</label>
  <div class="col-md-6">
   <span id="span_time">

   </span>
 </div>
</div>
<!-- <div class="form-group">
  <label class="col-md-3 control-label">Allocate Time by</label>
  <div class="col-md-6">
   <span id="span_allocate_by"> </span>
 </div>
</div> -->
<div id="div_employer">
  <div class="form-group" >
    <label class="col-md-3 control-label">Payment Method</label>
    <div class="col-md-6">
      <span id="span_payment_method"> </span>
    </div>
  </div>

  <div class="form-group" id="div_hourly">
    <label class="col-md-3 control-label">Hourly Rate</label>
    <div class="col-md-3">
      <span id="span_hourly_rate"></span>
    </div>
    <label class="col-md-3 control-label">Total Hours</label>
    <div class="col-md-3">
      <span id="span_install_time"></span>
    </div>
  </div>
  <div class="form-group" id="div_flat" >
    <div class="form-group" >
      <label class="col-md-3 control-label">Install time</label>
      <div class="col-md-3">
        <span id="span_flat_install_time"></span>
      </div>
      <label class="col-md-3 control-label">Amount</label>
      <div class="col-md-3">
        <span id="span_flat_amount"></span>
      </div>
    </div>
  </div>

  <div class="form-group" >

    <label class="col-md-3 control-label">Fuel</label>
    <div class="col-md-3">
      <span id="span_fuel_amount"></span>
    </div>
     <label class="col-md-3 control-label">Transport</label>
    <div class="col-md-3">
     <span id="span_transport_amount"></span>
   </div>
  </div>
  <div class="form-group" >
   <label class="col-md-3 control-label">Others</label>
   <div class="col-md-3">
     <span id="span_others_amount"></span>
   </div>
 </div>

 <div class="form-group" id="div_total_amount" >
  <label class="col-md-3 control-label">Total Amount</label>
  <div class="col-sm-3">
    <span id="span_total_amount"></span>
  </div>
</div>

<div class="form-group" style="display: none" id="div_time">
  <label class="col-md-3 control-label">Allocate Time</label>
  <div class="col-md-6">
   <span id="span_allocate_install_time">
   </span>
 </div>
</div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Job Assigned by</label>
  <div class="col-sm-6">
    <span id="span_assign_by"></span>    
  </div>
</div>
<div class="form-group">
  <label class="col-md-3 control-label">Special Note</label>
  <div class="col-sm-6">
    <textarea name="note" id="note" class="form-control"></textarea>
  </div>
</div>



<div class="form-group">
  <label class="col-md-3 control-label"></label>
  <div class="col-sm-6">
    <input type="checkbox" name="send_mail" value="1" checked=""> Send email to Installer. <br/>
    <input type="checkbox" name="copy_me" value="1" checked=""> Send copy of email to me. <br/>
    <input type="checkbox" name="pdf_attachment" value="1" > Send pdf attachment
  </div>
</div>
<div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="hidden" name="calendar" value="1">
    <input type="hidden" value="" id="order_id" name="order_id">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" class="btn btn-default">Reset</button>
  </div>
</div>

</form>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    var date = new Date();
    date.setDate(date.getDate());
    $('#reminder_date').datepicker({ 
      format: 'dd/mm/yyyy',
      startDate: date
    });
    $(document).on("click","#employer",function(){
      $("#div_time").show();
      $("#install_time").addClass("required");
    });
    $(document).on("click","#employee",function(){
      $("#div_time").hide();
    });
  });
</script>