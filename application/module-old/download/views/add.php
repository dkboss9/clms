



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Download : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("download/add");?>" method="post" enctype='multipart/form-data'>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value=""  class="form-control"  required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Type</label>
            <div class="col-md-6">
              <select name="doc_type" id="doc_type" class="form-control required" data-plugin-selectTwo>
                <option value="">Select</option>
                <?php
                foreach ($doc_type as $row) {
                 ?>
                 <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                 <?php
               }
               ?>
             </select>
           </div>
           <div class="col-md-1">
             <a href="javascript:void(0);" id="link_doc_type"><i class="glyphicon glyphicon-plus"></i></a>
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">File</label>
          <div class="col-md-6">
            <input type="file" name="doc_name" value=""  class="form-control required"  >
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Description</label>
          <div class="col-md-6">
           <textarea name="doc_desc" class="form-control"></textarea>
         </div>
       </div>



       <div class="form-group">
        <label class="col-md-3 control-label" for="inputDefault"></label>
        <div class="col-md-6">
          <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
          <a href="<?php echo base_url("dashboard/download");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<?php
$this->load->view("lms/add_purpose");
?>
<script type="text/javascript">
  $(document).ready(function(){ 
    $("#link_doc_type").click(function(){ 
      $("#form_doc_type_model").modal();
    });
    $("#form_doc_type").validate();
  });
</script>
