<div id="form_package_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
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
               <div class="col-md-9">
                <input type="text" name="new_package" value=""  class="form-control" id="new_package" required>

              </div>
            </div>

            <div class="form-group">
             <label class="col-md-3 control-label" for="new_package_price">Package Price</label>
             <div class="col-md-9">
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

<div id="form_timeline_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Timeline</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_timeline" action="javascript:addTimeline();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div id="add-contact" class="tab-pane active">

             <div class="form-group">
               <label class="col-md-3 control-label" for="new_timeline">Timeline</label>
               <div class="col-md-9">
                <input type="text" name="new_timeline" value=""  class="form-control" id="new_timeline" required>

              </div>
            </div>

          </div>

        </div>

      </div>

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

<div id="form_quotefrom_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" >
      <header class="panel-heading">
       <h2 class="panel-title"> Add Quote From</h2>
     </header>
     <form class="form-horizontal form-bordered" id="form_quotefrom" action="javascript:addquotefrom();" method="post" enctype='multipart/form-data'>
      <div class="modal-content">
        <div class="tabs tabs-warning">

          <div class="tab-content">
            <div id="add-contact" class="tab-pane active">

             <div class="form-group">
               <label class="col-md-3 control-label" for="new_timeline">Quote from</label>
               <div class="col-md-9">
                <input type="text" name="new_quotefrom" value=""  class="form-control" id="new_quotefrom" required>

              </div>
            </div>

          </div>

        </div>

      </div>

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

<script type="text/javascript">
  function addPackage(){
   var new_package = $("#new_package").val();
   var new_package_price = $("#new_package_price").val();
   var row = $("#txt_row_number").val();

   $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>inverter/addPackage",
    data: "new_package=" + new_package + "&new_package_price=" + new_package_price,
    success: function (msg) {
      $("#package_desc_"+row).append('<option value="'+new_package+'" rel="'+new_package_price+'">'+new_package+'</option>');
      //alert(row);
      $("#package_desc_"+row).val(new_package);
      $(".package_name").trigger("change");
      $("#new_package").val('');
      $("#new_package_price").val('');
      $(".btn-close").trigger("click");
    }
  });

 }

 function addTimeline(){
  var new_timeline = $("#new_timeline").val();

  $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>threatre/addTimeline",
    data: "new_timeline=" + new_timeline,
    success: function (msg) {
      $("#timeline").append('<option value="'+msg+'">'+new_timeline+'</option>');
      $("#timeline").val(msg);
      $(".btn-close").trigger("click");
    }
  });
}

function addquotefrom(){
  var quotefrom = $("#new_quotefrom").val();

  $.ajax({
    type: "POST",
    url: "<?php echo base_url();?>quote_from/new_quotefrom",
    data: "quotefrom=" + quotefrom,
    success: function (msg) {
      $("#quote_from").append('<option value="'+msg+'">'+quotefrom+'</option>');
      $("#quote_from").val(msg);
      $(".btn-close").trigger("click");
    }
  });
}
</script>

