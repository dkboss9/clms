
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
foreach ($leads->result() as $app) {

  $event = new stdClass;
  $event->title = $app->lead_name.' '.$app->lead_lname;

  $event->start = date('Y-m-d',strtotime($app->booking_date)).'T'.$app->booking_time;
 //$event->duration = intval($app->duration)*60;
  $event->project_id = $app->lead_id;
  $event->start_date = date("d/m/Y",strtotime($app->booking_date));

  $event->project_status = $app->status_id;


  $event->backgroundColor = '#0088cc';

  $events[] = $event;
}
//echo '<pre>';
//print_r($events); die();
?>
<script type="text/javascript">


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
          $("#booking_date").val(event_date);
          $("#form_payment_modal").modal();
        },
        eventClick: function(calEvent, jsEvent, view) { 
          var lead_id = calEvent.project_id;
          $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>appointment/edit_appointment",
            data: "appid="+lead_id,
            success: function (msg) {
              $("#div_payment_record").html(msg);
            }
          });
          $("#form_payment_modal").modal();
        },
        eventDrop: function( event, delta, revertFunc, jsEvent, ui, view ) {
       // console.log(event.event_date);
       // console.log(delta._days);
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

      <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>

    <div class="form-group">
     <a class="mb-xs mt-xs mr-xs btn btn-success" href="<?php echo base_url("dashboard/appointment");?>">List View</a>
    </div>
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

<div id="form_payment_modal" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Appointment</h4>
        </div>

        <div id="div_payment_record">

          <form id="form_lead" action="<?php echo base_url("appointment/callendar");?>" method="post" enctype='multipart/form-data'>

            <div class="form-group"> </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Booking Date</label>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text" data-plugin-datepicker="" name="booking_date" id="booking_date" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label">Booking Time</label>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </span>
                  <input type="text" data-plugin-timepicker="" name="booking_time" id="booking_time" value="0:00" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="purpose">Purpose</label>
              <div class="col-md-6">
                <select class="form-control mb-md" name="purpose">
                  <option value="">Select</option>
                  <?php 
                  foreach($purpose as $row){
                    ?>
                    <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                    <?php
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-md-3 control-label" for="inputDefault">Are you from Nepal?</label>
              <div class="col-md-6">
                <input type="radio" name="from_nepal" id="nepal_yes" value="1" class="required"> Yes &nbsp;&nbsp;&nbsp;
                <input type="radio" name="from_nepal" id="nepal_no" value="0" class="required"> No
              </div>

            </div>

            <div class="form-group" id="div_nepal" style="display:none;">
              <label class="col-md-3 control-label" for="">Select your interested country</label>
              <div class="col-md-6">
                <select class="form-control mb-md" name="country">
                  <option value="">Country</option>
                  <?php
                  foreach ($countries as $country) {
                   ?>
                   <option <?php if("Australia" == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
                   <?php
                 }
                 ?>
               </select>
             </div>
           </div>

           <div class="form-group" id="div_located" style="display:none;">
            <label class="col-md-3 control-label" for="inputDefault">Where are you located at the moment?</label>
            <div class="col-md-6">
              <select class="form-control mb-md" name="country">
                <option value="">Country</option>
                <?php
                foreach ($countries as $country) {
                 ?>
                 <option <?php if("Australia" == $country->country_name) echo 'selected="selected"';?> value="<?php echo $country->country_name;?>"><?php echo $country->country_name;?></option>
                 <?php
               }
               ?>
             </select>
           </div>
         </div>


         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">First Name</label>
          <div class="col-md-6">
            <input type="text" name="name" value="<?php echo @$db->database_name;?>"  class="form-control required" id="" >
            <?php echo form_error("name");?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Last Name</label>
          <div class="col-md-6">
            <input type="text" name="lname" value=""  class="form-control required" id="" >

          </div>
        </div>



        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Email</label>
          <div class="col-md-6">
            <input type="email" name="email" value="<?php echo @$db->email;?>"  class="form-control required" id="email" >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Mobile</label>
          <div class="col-md-6 control-label">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-phone"></i>
              </span>
              <input id="phone" name="phone" value="<?php echo @$db->phone;?>" data-plugin-masked-input=""  class="form-control number">
            </div>
          </div>
        </div>


        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </form>


    </div>

  </div>
</div>
</div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    //$(".fc-day").trigger("click");
    $("#form_lead").validate();
    $("#nepal_yes").click(function(){
      $("#div_nepal").show();
      $("#div_located").hide();
    });

    $("#nepal_no").click(function(){
      $("#div_nepal").hide();
      $("#div_located").show();
    });


  });
</script>

