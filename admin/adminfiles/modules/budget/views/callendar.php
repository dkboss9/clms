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
    bottom: 740px;
    right: 25px;
  }
</style>
<?php 

$events = array();
foreach ($budgets->result() as $app) {
 $event = new stdClass;
 $event->title = $app->note;
 $event->cat1 = $app->cat1;
 $event->cat2 = $app->cat2;
 $event->cat3 = $app->cat3;
 $event->item_name = $app->type_name;
 $event->note = $app->note;
 $event->price = $app->price;
 $event->payment_time = $app->payment_time;
 $event->start = date('Y-m-d',$app->from_date);
 $event->end = date('Y-m-d',$app->end_date);
 $event->budget_id = $app->budget_id;
 $event->start_date = date("d/m/Y",$app->from_date);
 $event->end_date = date("d/m/Y",$app->end_date);
 $event->budget_status = $app->budget_status;
 
 $event->purpose = $app->purpose;
 
 if($app->budget_status != "1")
   $event->backgroundColor = 'RED';
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
           // location.reload();
         }, href:"#inline_content",escKey: false,overlayClose: false});
        },
        eventClick: function(calEvent, jsEvent, view) { 
         jQuery("#type option[value='"+calEvent.cat1 +"']").attr('selected', 'selected');
         jQuery("#purpose option[value='"+calEvent.purpose +"']").attr('selected', 'selected');
         jQuery("#price").val(calEvent.price);
         jQuery("#payment_time option[value='"+calEvent.payment_time +"']").attr('selected', 'selected');
         jQuery("#status option[value='"+calEvent.budget_status +"']").attr('selected', 'selected');
         jQuery("#note").val(calEvent.note);
         jQuery("#start_date").val(calEvent.start_date);
         jQuery("#end_date").val(calEvent.end_date);
         jQuery("#budget_id").val(calEvent.budget_id);
         $.ajax({
          url: '<?php echo base_url() ?>budget/get_items',
          type: "POST",
          data: "catid=" + calEvent.cat1 + "&itemid="+calEvent.cat3,
          success: function(data) { 
            if(data != ""){
              $("#select_item").html(data);
            }
          }        
        });
         jQuery("#select2-chosen-1").html(calEvent.item_name);
        // jQuery("#select_item option[value='"+calEvent.cat3 +"']").attr('selected', 'selected');
        var frm = document.getElementById('demo-form') || null;
        if(frm) {
         frm.action = '<?php echo base_url("budget/edit");?>' 
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
    <h2>Budget List</h2>

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

    <form id="demo-form" method="post" class="white-popup-block  form-horizontal" action="<?php echo base_url("budget/add");?>">
      <div class="form-group">
        <label class="col-md-3 control-label" for="type">Type</label>
        <div class="col-md-6">
          <select class="form-control" name="type" id="type" required>
            <option value="">Select</option>
            <option value="1">Income</option>
            <option value="2">Expense</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Item</label>
        <div class="col-md-6">
          <select data-plugin-selectTwo class="form-control populate" name="item" id="select_item" required>

          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="purpose">Purpose</label>
        <div class="col-md-6">
          <select class="form-control" name="purpose" id="purpose" required>
            <option value="">Select</option>
            <option value="Personal">Personal</option>
            <option value="Business">Business</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="price">Price</label>
        <div class="col-md-6">
          <input type="text" name="price" value=""  class="form-control" id="price" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label" for="payment_time">Payment Time</label>
        <div class="col-md-6">
          <select class="form-control" name="payment_time" id="payment_time" required>
            <option value="">Select</option>
            <?php 
            foreach ($payment_times as $row) {
             ?>
             <option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
             <?php
           }
           ?>
         </select>
       </div>
     </div>

     <div class="form-group">
      <label class="col-md-3 control-label" for="status">Status</label>
      <div class="col-md-6">
        <select class="form-control" name="status" id="status" required>
          <option value="">Select</option>
          <option value="Due">Due</option>
          <option value="Paid">Paid</option>

        </select>
      </div>
    </div>

    <div class="form-group">
      <label class="col-md-3 control-label">Note</label>
      <div class="col-md-9">
       <textarea name="details"  class="form-control" id="note" rows="8" required></textarea>
     </div>
   </div>

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

  <input type="hidden" name="budget_id" id="budget_id" value="0">

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
   $("#type").change(function(){
    var id = $(this).val();
    if(id == "")
      return false;
    $.ajax({
      url: '<?php echo base_url() ?>budget/get_items',
      type: "POST",
      data: "catid=" + id,
      success: function(data) { 
        if(data != ""){
          $("#select_item").html(data);
        }
      }        
    });
      /*$("#select_item").html('<optgroup label="Alaskan/Hawaiian Time Zone">'+
        '<option value="AK">Alaska</option><option value="HI">Hawaii</option></optgroup>'+
        '<optgroup label="Pacific Time Zone">'+
        '<option value="CA">California</option><option value="NV">Nevada</option><option value="OR">Oregon</option><option value="WA">Washington</option>'+
        '</optgroup>'); */
 });
 });

</script>