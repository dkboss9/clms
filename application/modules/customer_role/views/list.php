<script type="text/javascript">
	$(document).ready(function(){
		$('.alert-success').hide();
		<?php if($this->session->flashdata('success')){?>
			$(".alert-success").show();
			$(".alert-success").html('<?php echo $this->session->flashdata('success');?>');
			$(".alert-success").delay(4000).slideUp('slow',function(){
				$(".alert-success").html('');
			});
		<?php } ?>
	});
</script>
<div class="container">
  <div class="row">
    <div class="col-md-2 visible-lg">
      <div class="affix">
        <?php echo $this->mylibrary->getsublinks(24);?>
      </div>
    </div>
    <div class="col-md-10">
      <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2)) ?>
      <div class="page-header">
        <div class="btn-group pull-right" style="margin-right:10px;"> <?php echo $pagination; ?> </div>
        <div class="pull-right paging">
          <span><?php echo $pagenumbers; ?></span> </div>
        <h2>Manage Roles
        
          				<button 
                        id="addButton"
                        data-toggle="tooltip" 
                        title="Add New Record"
                        type="button" 
                        class="btn btn-default"> <span class="glyphicon glyphicon-plus-sign"></span> 
                        </button>
          
          <!-- Single button -->
          <div class="btn-group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
            <ul class="dropdown-menu" role="menu">
              <li><a onclick="cascade('delete');">Delete Marked</a></li>
              <li><a onclick="cascade('publish');">Mark as Published
</a></li>
              <li><a onclick="cascade('unpublish');">Mark as Unpublished
</a></li>
            </ul>
          </div>
        </h2>
      </div>
      <div>
        <div class="alert alert-success"></div>
        <table class="table table-striped table-hover">
          <tr>
            <th width="20"><input type="checkbox" name="all" id="checkall" ></th>
            <th><a>Role</a> <a href=""><span class="glyphicon glyphicon-sort-by-attributes"></span></a></th>
            <th width="10%">Action</th>
          </tr>
          <?php echo $roles; ?>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
        $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>index.php/customer_role/add");})
    });
    //This function is used for making a json data for cascade delete, publish and unpublish and call ajax
    function cascade(action){
		if(confirm('Are you sure to proceed this action?')){
			var ids = checkedCheckboxId();
			var jsonData ={"object":{"ids":ids,"action":action}};
			$.ajax({
				url:"<?php echo base_url(); ?>index.php/customer_role/cascadeAction",
				type:"post",
				data:jsonData,
				success: function(msg){
				   location.reload();
				}
			});
		}else{
			return false;	
		}
     }

</script> 