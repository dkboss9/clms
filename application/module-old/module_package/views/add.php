<style type="text/css">
  .notrequired{
    color: #777 !important;
  }

  input.notrequired{
    border-color: #cccccc !important;
  }
</style>



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
          <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Package : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("module_package/add");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="name">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value=""  class="form-control" id="name" required>
              <?php echo form_error("name");?>
            </div>
          </div>
          <h3>Order Term</h3>
          <div class="form-group">
            <label class="col-md-3 control-label" for="txt_month">Monthly Price</label>
            <div class="col-md-2">
              <input type="text" name="txt_month" id="txt_month" class="form-control required" >
            </div>
            <label class="col-md-2 control-label notrequired" for="txt_month_discount">Discounted Price</label>
            <div class="col-md-2">
             <input type="text" name="txt_month_discount" id="txt_month_discount" class="form-control notrequired" >
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="txt_3month">3 Months Price</label>
          <div class="col-md-2">
           <input type="text" name="txt_3month" id="txt_3month" class="form-control required" >
         </div>
         <label class="col-md-2 control-label notrequired" for="txt_3month_discount">Discounted Price</label>
         <div class="col-md-2">
           <input type="text" name="txt_3month_discount" id="txt_month" class="form-control notrequired" >
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label" for="txt_6month">6 Months Price</label>
        <div class="col-md-2">
         <input type="text" name="txt_6month" id="txt_6month" class="form-control required" >
       </div>
       <label class="col-md-2 control-label notrequired" for="txt_6month_discount">Discounted Price</label>
       <div class="col-md-2">
         <input type="text" name="txt_6month_discount" id="txt_6month_discount" class="form-control notrequired" >
       </div>
     </div>

     <div class="form-group">
      <label class="col-md-3 control-label" for="txt_12month">12 Months Price</label>
      <div class="col-md-2">
       <input type="text" name="txt_12month" id="txt_12month" class="form-control required" >
     </div>
     <label class="col-md-2 control-label notrequired" for="txt_12month_discount">Discounted Price</label>
     <div class="col-md-2">
       <input type="text" name="txt_12month_discount" id="txt_12month_discount" class="form-control notrequired" >
     </div>
   </div>
   <div id="div_desc">
     <div class="form-group">
      <label class="col-md-3 control-label" for="desc">Package Description</label>
      <div class="col-md-6">
        <input type="text" name="desc[]" value=""  class="form-control" id="desc" required>
        <?php echo form_error("name");?>
      </div>
      <div class="col-md-1"><a href="javascript:void(0);" id="link_more">Add more</a></div>
    </div>
  </div>
  <div class="form-group"></div>
  <div class="form-group">
    <label class="col-md-3 control-label" for="inputDefault"></label>
    <div class="col-md-6">
      <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
      <a href="<?php echo base_url("module_package");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
    </div>
  </div>
</form>
</div>
</section>
</div>
</div>
<!-- end: page -->
</section>
</div>
</section>
<script type="text/javascript">
  $(document).ready(function(){
    var num = 0;
    $("#link_more").click(function(){
      num = num + 1;
      var content = '<div class="form-group" id="row_desc'+num+'">'+
      '<label class="col-md-3 control-label" for="desc"></label>'+
      '<div class="col-md-6">'+
      '<input type="text" name="desc[]" value=""  class="form-control" id="desc" required>'+
      '</div>'+
      '<div class="col-md-1"><a href="javascript:void(0);" rel="'+num+'" class="link_remove"><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></div>'+
      '</div>';
      $("#div_desc").append(content);
    });

    $(document).on("click",".link_remove",function(){
      if(!confirm("Are you sure to remove this field?"))
        return false;

      var row = $(this).attr("rel");
      $("#row_desc"+row).remove();
    });
  });
</script>