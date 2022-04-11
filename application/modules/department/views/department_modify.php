



  <!-- start: page -->
  <section class="panel">
    <header class="panel-heading">
      <div class="panel-actions">
        <a href="#" class="" data-panel-toggle></a>
        <a href="#" class="" data-panel-dismiss></a>
      </div>

      <button style="margin-right:10px;" class="btn btn-primary pull-right" id="btn-submit" value="submit" name="submit1" type="submit"> <span class="glyphicon glyphicon-floppy-disk"></span> Save </button>
      <h2> Modify Permission for
                    <?php 
											echo $department->name;
										?>
                  </h2>
    </header>
    
    <div class="panel-body">
      <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>

<form id="modifygrouppermission" method="post" action="<?php echo base_url(); ?>/department/edit_department_perm/<?php echo $this->uri->segment(3);?>">
        
        <div class="col-md-12">
          <table cellpadding="5" cellspacing="0" border="0" width="100%" class="table table-striped table-hover">
            <tbody>
            <tr><td colspan="5"><input type="checkbox" name="check_all" id="check_all">Check All</td></tr>
            <?php echo $grouppermissions; ?>
            </tbody>
          </table>
        </div>
        <input type="hidden" name="txt_permission" value="1">
      </form>
</div>
</section>




</section>
</div>


</section>

<script>
$(document).ready(function(){
  $("#btn-submit").click(function(){ 
    $("#modifygrouppermission").submit();
   });

   $("#check_all").click(function(){
      $(".chk_perm").prop("checked",$(this).prop("checked"));
    });
});
</script>
