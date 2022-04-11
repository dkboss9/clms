


<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
    

        <h2 class="panel-title">Permission <span style="float: right;"><input type="checkbox" name="chk_all" id="chk_all" > ChecK all </span> </h2>
      </header>
      <div class="panel-body">
      <form id="modifyuserpermission" method="post" action="<?php echo base_url(); ?>module_package/permission/<?php echo $this->uri->segment(3);?>">
         <div>
          <button type="button" class="btn btn-danger pull-right" onclick="window.location.assign('<?php echo base_url();?>index.php/module_package');return false;"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
          <button style="margin-right:10px;" class="btn btn-primary pull-right" value="submit" name="submit" type="submit"> <span class="glyphicon glyphicon-floppy-disk"></span> Save </button>
          <h2> Modify Permission for

          </h2>
        </div>
        <div class="col-md-12">
          <table cellpadding="5" cellspacing="0" border="0" width="100%" class="table table-striped table-hover">
            <tbody>
              <?php echo $grouppermissions; ?>
            </tbody>
          </table>
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

<script>
  $(document).ready(function(){
    $("#chk_all").click(function(){
      $(".chk_module").prop("checked",$(this).prop("checked"));
    })
  });
</script>