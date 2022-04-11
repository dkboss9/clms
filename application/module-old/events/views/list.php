<style type="text/css">
  #cboxClose {
    position: absolute;
    bottom: 600px;
    right: 25px;
  }
</style>
<?php 
//echo '<pre>';
//print_r($myevents->result()); die();
$events = array();
foreach ($myevents->result() as $app) {
 $event = new stdClass;
 $event->title = $app->first_name.' '.$app->last_name.': '.$app->event_name;
 $event->title1 = $app->event_name;
 $event->start = date('Y-m-d',$app->event_date).'T'.$app->event_time;
 //$event->duration = intval($app->duration)*60;
 //$event->end = date('Y-m-d',$app->appointment_date).'T'.date("H:i:s",$app->appointment_time);
 $event->eventid = $app->event_id;
 $event->event_date = date("d/m/Y",$app->event_date);
 $event->event_time = $app->event_time;
 $event->event_status = $app->event_status;
 $event->details = $app->event_details;
 $event->reminder = $app->reminder_time;
 $event->event_action = $app->action;
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
         jQuery("#reminder option[value='"+calEvent.reminder +"']").attr('selected', 'selected');
         jQuery("#event_status option[value='"+calEvent.event_status +"']").attr('selected', 'selected');
         jQuery("#event_name").val(calEvent.title1);
         jQuery("#event_details").val(calEvent.details);
         jQuery("#event_date").val(calEvent.event_date);
         jQuery("#event_time").val(calEvent.event_time);
         jQuery("#event_id").val(calEvent.eventid);
         jQuery("#event_action").val(calEvent.event_action);
         
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

     editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
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

<section role="main" class="content-body">
  <header class="page-header">
    <h2>Events</h2>

    <div class="right-wrapper pull-right">
      <a class="sidebar-right-toggle" href="<?php echo base_url("logout");?>"><i class="fa fa-power-off"></i></a>
    </div>
  </header>

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
      <?php /*<div class="col-md-3">
        <p class="h4 text-weight-light">Draggable Events</p>

        <hr />

        <div id='external-events'>
          <div class="external-event label label-default" data-event-class="fc-event-default">Default Event</div>
          <div class="external-event label label-primary" data-event-class="fc-event-primary">Primary Event</div>
          <div class="external-event label label-success" data-event-class="fc-event-success">Success Event</div>
          <div class="external-event label label-warning" data-event-class="fc-event-warning">Warning Event</div>
          <div class="external-event label label-info" data-event-class="fc-event-info">Info Event</div>
          <div class="external-event label label-danger" data-event-class="fc-event-danger">Danger Event</div>
          <div class="external-event label label-dark" data-event-class="fc-event-dark">Dark Event</div>

          <hr />
          <div>
            <div class="checkbox-custom checkbox-default ib">
              <input id="RemoveAfterDrop" type="checkbox"/>
              <label for="RemoveAfterDrop">remove after drop</label>
            </div>
          </div>
        </div>
      </div> */ ?>
    </div>
  </div>
</section>

<!-- end: page -->
</section>
</div>


</section>
<div style="display:none;">
  <div id="inline_content">

    <form id="demo-form" method="post" class="white-popup-block  form-horizontal" action="<?php echo base_url("events/add");?>">
      <div class="row">
        <div class="col-sm-12">
          <h3>Add Event</h3>
        </div>
      </div>
      <div class="form-group mt-lg">
        <label class="col-sm-3 control-label">Event Title</label>
        <div class="col-sm-6">
          <input type="text" name="name" id="event_name"  class="form-control" placeholder="" required/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Event Details</label>
        <div class="col-sm-6">
         <textarea name="details" id="event_details"  class="form-control" rows="8" required></textarea>
       </div>
     </div>
     <div class="form-group">
       <label class="col-md-3 control-label">Event Date</label>
       <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          <input type="text" data-plugin-datepicker="" name="date" id="event_date" value="" class="form-control" required>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">Event Time</label>
      <div class="col-md-6">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-clock-o"></i>
          </span>
          <input type="text" data-plugin-timepicker="" value="" name="event_time" id="event_time" class="form-control" data-plugin-options="{ &quot;showMeridian&quot;: false }" required>
        </div>
      </div>
    </div>     
    

    <div class="form-group">
      <label class="col-md-3 control-label" for="reminder">Remind me</label>
      <div class="col-md-6">

       <select  name="reminder" id="reminder" class="form-control mb-md" >
        <option value="">Select</option>
        <?php 
        for($i = 1; $i<=5; $i++) {
         ?>
         <option value="<?php echo $i;?>">Before <?php echo $i; ?> hours</option>
         <?php
       }
       ?>
     </select>

     
   </div>
 </div> 

 <div class="form-group">
   <label class="col-md-3 control-label" for="event_status">Status</label>
   <div class="col-md-6">

     <select  name="event_status" id="event_status" class="form-control mb-md" >
      <?php 
      foreach($event_status as $stat) {
       ?>
       <option value="<?php echo $stat->status_id;?>"><?php echo $stat->status_name;?></option>
       <?php
     }
     ?>
   </select>


 </div>
</div> 

<div class="form-group">
  <label class="col-sm-3 control-label">Action</label>
  <div class="col-sm-6">
    <textarea name="event_action" id="event_action"  class="form-control"></textarea>
  </div>
</div>

<div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="hidden" name="event_id" id="event_id" value="0">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" class="btn btn-default">Reset</button>
  </div>
</div>

</form>

</div>
</div>