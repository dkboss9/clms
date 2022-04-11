<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
 $(document).ready(function(){
 //  $('#trumbowyg').trumbowyg();
});
</script>
<style type="text/css">
  #cboxClose {
    position: absolute;
    top: 25px;
    right: 25px;
  }
</style>
<?php 

$events = array();
foreach ($tasks->result() as $app) {
 $event = new stdClass;
 $event->title = $app->first_name.' '.$app->last_name.': '.$app->task_name;
 $event->title1 = $app->task_name;
 $event->start = date('Y-m-d',$app->start_date);
 $event->assign_to = $app->assign_to;
 $event->assign_by = $app->assign_by;
 $event->end = date('Y-m-d',$app->end_date);
 $event->task_id = $app->task_id;
 $event->start_date = date("d-m-Y",$app->start_date);
 $event->end_date = date("d-m-Y",$app->end_date);
 $event->task_status = $app->task_status;
 $event->details = $app->task_detail;
 $event->priority = $app->priority;
 
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
          $("#btn-reset").trigger("click");
          $('#trumbowyg').trumbowyg();
          $.colorbox({inline:true,onClosed: function() {
         }, href:"#inline_content",escKey: false,overlayClose: false});
        },
        eventClick: function(calEvent, jsEvent, view) { 
          //jQuery("#assign_to option[value='"+calEvent.assign_to +"']").attr('selected', 'selected');
          jQuery("#task_status option[value='"+calEvent.task_status +"']").attr('selected', 'selected');
          jQuery("#task_name").val(calEvent.title1);
          jQuery("#trumbowyg").val(calEvent.details);
          $('#trumbowyg').trumbowyg('destroy');
          $('#trumbowyg').trumbowyg();
          jQuery("#start_date").val(calEvent.start_date);
          jQuery("#end_date").val(calEvent.end_date);
          jQuery("#priority").val(calEvent.priority);
          jQuery("#task_id").val(calEvent.task_id);
          jQuery("#assign_to").val(calEvent.assign_to);
          jQuery("#assign_by").val(calEvent.assign_by);
          $.ajax({
            url: '<?php echo base_url() ?>task/get_taskUser',
            type: "POST",
            data: "task_id=" + calEvent.task_id,
            success: function(data) { 
              if(data != ""){
                var data = JSON.parse(data);
                var out = "";
                var i;
                //console.log(data);
                for(i = 0; i < data.length; i++) {
                  $("#assign_to"+data[i].user_id).prop('checked', true);
                }

              }
            }        
          });
          var frm = document.getElementById('demo-form') || null;
          if(frm) {
           frm.action = '<?php echo base_url("task/edit");?>' 
         }
         $.colorbox({inline:true,onClosed: function() {
          //location.reload();
        }, href:"#inline_content",escKey: false,overlayClose: false});
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

    <form id="demo-form" method="post" class="white-popup-block  form-horizontal" action="<?php echo base_url("task/add");?>">
      <div class="row">
        <div class="col-sm-12">
          <h3>Add New Task</h3>
        </div>
      </div>

      <div class="form-group mt-lg">
        <label class="col-sm-3 control-label">Start Date</label>
        <div class="col-sm-9">
          <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text" name="start_date" id="start_date" class="form-control datepicker" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="form-group mt-lg">
        <label class="col-sm-3 control-label">Task Title</label>
        <div class="col-sm-9">
          <input type="text" name="name" id="task_name" class="form-control" placeholder="" required/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Task Details</label>
        <div class="col-sm-9">
         <textarea name="details" id="trumbowyg"  class="form-control" rows="8" required></textarea>
       </div>
     </div>

     <div class="form-group mt-lg">
        <label class="col-sm-3 control-label">Due Date</label>
        <div class="col-sm-9">
          <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input type="text"  name="end_date" id="end_date" class="form-control datepicker" autocomplete="off">
          </div>
        </div>
      </div>

      <div class="form-group mt-lg">
        <label class="col-sm-3 control-label">Assign By</label>
        <div class="col-sm-9">
        <select class="form-control" name="assign_by" id="assign_by" required>
            <option value="">Select</option>
            <?php 
            foreach ($users as $user ) {
              ?>
              <option value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>


      <div class="form-group mt-lg">
        <label class="col-sm-3 control-label">Assign To</label>
        <div class="col-sm-9">
        <select class="form-control" name="assign_to" id="assign_to" required>
            <option value="">Select</option>
            <?php 
            foreach ($users as $user ) {
              ?>
              <option value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name;?></option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>

 
    
  <div class="form-group">
    <label class="col-sm-3 control-label">Status</label>
    <div class="col-sm-9">
      <select class="form-control" name="status" id="task_status" required>
        <option value="">Select</option>
        <?php 
        foreach ($task_status as $row) {
         ?>
         <option value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>
 </div>
 <div class="form-group">
  <label class="col-sm-3 control-label">Priority</label>
  <div class="col-sm-9">
    <select class="form-control" name="priority" id="priority" required>
      <option value="">Select</option>
      <option value="Normal">Normal</option>
      <option value="High">High</option>
      <option value="Urgent">Urgent</option>
    </select>
  </div>
</div>


<input type="hidden" name="task_id" id="task_id" value="0">

<div class="row mb-lg">
  <div class="col-sm-9 col-sm-offset-3">
    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
    <button type="reset" id="btn-reset" class="btn btn-default">Reset</button>
  </div>
</div>
</form>

</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#demo-form").validate();
  });
</script>

<script>
  $(document).ready(function(){
    $(".datepicker").datepicker({  format: 'dd-mm-yyyy'});
  });
</script>