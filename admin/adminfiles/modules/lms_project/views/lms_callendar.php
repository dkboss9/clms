
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
    bottom: 1230px;
    right: 25px;
  }
</style>
<?php 

$events = array();
foreach ($projects->result() as $app) {
 $event = new stdClass;
 $event->title = $app->task_name;
 $event->title1 = $app->task_name;
 $event->start = date('Y-m-d',$app->start_date);
 $event->assign_to = $app->user_id;
 $event->end = date('Y-m-d',$app->end_date);
 $event->project_id = $app->task_id;
 $event->start_date = date("d/m/Y",$app->start_date);
 $event->end_date = date("d/m/Y",$app->end_date);
 $event->project_status = $app->task_status;
 $event->details = $app->task_detail;
 $event->existing = $app->is_existing;
 $event->order_id = $app->order_id;
 
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
         // $("#event_date").val(event_date);
         // $("#btn-reset").trigger("click");
         $('#trumbowyg').trumbowyg();
         $.colorbox({inline:true,onClosed: function() {
           // location.reload();
         }, href:"#inline_content",escKey: false,overlayClose: false});
       },
       eventClick: function(calEvent, jsEvent, view) { 
       //  jQuery("#assign_to option[value='"+calEvent.assign_to +"']").attr('selected', 'selected');
       //  jQuery("#task_status option[value='"+calEvent.task_status +"']").attr('selected', 'selected');
       
       if(calEvent.existing == '1')
        $("#radio_yes").trigger("click");
      else
        $("#radio_no").trigger("click");
      jQuery("#project_order option[value='"+calEvent.order_id +"']").attr('selected', 'selected');
      
      jQuery("#project_status option[value='"+calEvent.project_status +"']").attr('selected', 'selected');
      jQuery("#project_title").val(calEvent.title1);
      jQuery("#trumbowyg").val(calEvent.details);
      $('#trumbowyg').trumbowyg('destroy');
      $('#trumbowyg').trumbowyg();

      $.ajax({
        url: '<?php echo base_url() ?>lms_project/get_projectUser',
        type: "POST",
        data: "project_id=" + calEvent.project_id,
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

      jQuery("#start_date").val(calEvent.start_date);
      jQuery("#end_date").val(calEvent.end_date);
      
      jQuery("#project_id").val(calEvent.project_id);
      var frm = document.getElementById('demo-form') || null;
      if(frm) {
       frm.action = '<?php echo base_url("lms_project/edit");?>' 
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

<section role="main" class="content-body">
  <header class="page-header">
    <h2>Project list</h2>

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

    <form class="white-popup-block  form-horizontal" id="demo-form" action="<?php echo base_url("lms_project/add");?>" method="post" enctype='multipart/form-data'>
      <div class="row">
        <div class="col-sm-12">
          <h3>Add New Project</h3>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Is Existing Order?</label>
        <div class="col-md-6">
          <input type="radio" name="is_existing" id="radio_yes" value="1"> Yes
          <input type="radio" name="is_existing" id="radio_no" value="0"> No
        </div>
      </div>

      <div class="form-group" id="div_order">
        <label class="col-md-3 control-label" for="inputDefault">Order</label>
        <div class="col-md-6">
          <select class="form-control" name="project_order" id="project_order" >
            <option value="">Select</option>
            <?php 
            foreach ($orders as $row) {
             ?>
             <option value="<?php echo $row->project_id;?>"><?php echo $row->project_title;?></option>
             <?php
           }
           ?>
         </select>
       </div>
       <div class="col-md-3" id="div_customer"></div>
     </div>

     <div class="form-group">
      <label class="col-md-3 control-label" for="inputDefault">Project Title</label>
      <div class="col-md-6">
        <input type="text" name="name" id="project_title" value=""  class="form-control" id="inputDefault" required>
      </div>
    </div>


    <div class="form-group">
     <label class="col-md-3 control-label">Project Details</label>
     <div class="col-md-9">
      <textarea name="details" id="trumbowyg"  class="form-control" rows="8" required></textarea>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Assign To</label>
    <div class="col-md-9">
      <?php 
      $i = 0;
      foreach ($users as $user ) {
        ?>
        <div style="float:left;margin-right:20px;width:200px;">
          <input type="checkbox" name="assign_to[]" id="assign_to<?php echo $user->userid;?>" value="<?php echo $user->userid;?>"><?php echo $user->first_name." ".$user->last_name.' ( '.$user->group_name.' )';?>
        </div>
        <?php
        $i++;
      }
      ?>
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault">Status</label>
    <div class="col-md-6">
      <select class="form-control" name="status" id="project_status" required>
        <option value="">Select</option>
        <?php 
        foreach ($status as $row) {
         ?>
         <option value="<?php echo $row->status_id;?>"><?php echo $row->status_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>

 </div>
<?php /*
       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault">Priority</label>
        <div class="col-md-6">
          <select class="form-control" name="priority" required>
            <option value="">Select</option>
            <option value="Normal">Normal</option>
            <option value="High">High</option>
            <option value="Urgent">Urgent</option>
          </select>
        </div>
      </div>
*/ ?>
<div class="form-group">
  <label class="col-md-3 control-label">Start Date</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">
        <i class="fa fa-calendar"></i>
      </span>
      <input type="text" data-plugin-datepicker="" name="start_date" id="start_date" class="form-control">
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
      <input type="text" data-plugin-datepicker="" name="end_date" id="end_date" class="form-control">
    </div>
  </div>
</div>

<?php
if($form->num_rows()>0){
  $row = $form->row();
  //pds_form_render($row->forms_id);
}
?>
<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="task_id" id="project_id" value="">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("lms_project/lms_callendar");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<script type="text/javascript">
  $(document).ready(function(){
   $("#div_order").hide();
   $("#radio_yes").click(function(){
    $("#div_order").show();
  });
   $("#radio_no").click(function(){
    $("#div_order").hide();
  });
   $("#project_order").change(function(){
    var orderid = $(this).val();
    if(orderid == "")
      return false;
    $.ajax({
      url: '<?php echo base_url() ?>lms_project/getOrderdetail',
      type: "POST",
      data: "orderid=" + orderid,
      success: function(data) { 
        $("#div_customer").html(data);
      }        
    }); 
  });
 });
  
</script>
