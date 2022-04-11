



<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Download : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("download/edit");?>" method="post" enctype='multipart/form-data'>
          <?php if(isset($error)){ ?>
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

            <?php echo $error; ?>
          </div>
          <?php  } ?>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Name</label>
            <div class="col-md-6">
              <input type="text" name="name" value="<?php echo $result->type_name;?>"  class="form-control" id="inputDefault" required>
              <?php echo form_error("name");?>
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
                 <option <?php if($row->type_id == $result->doc_type) echo 'selected="selected"';?> value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
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
            <input type="file" name="doc_name" value=""  class="form-control "  >
            <a href="<?php echo SITE_URL."uploads/student_documents/".$result->doc_name;?>" target="_blank"><?php echo $result->doc_name;?></a>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault">Description</label>
          <div class="col-md-6">
            <textarea name="doc_desc" class="form-control"><?php echo $result->doc_desc;?></textarea>
          </div>
        </div>



        <div class="form-group">
          <label class="col-md-3 control-label" for="inputDefault"></label>
          <div class="col-md-6">
            <input type="hidden" name="type_id" value="<?php echo $result->type_id;?>">
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