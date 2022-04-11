<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
			<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
		</div>

		<h2 class="panel-title">Lead Email Template List</h2>
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
	<div class="row">
			<div class="col-sm-12">
				<div class="mb-md">
					<h2>
						<a href="<?php echo base_url("lead_email_template/add")?>" data-toggle="" title="Add New User" type="button" class="btn btn-primary" id="btn-add" data-target="#ammendment" style="float:right;"> Add <i class="fa fa-plus"></i> </a> 
					</h2>
				</div>
			</div>
		</div>
<br>

		<table class="table table-bordered table-striped mb-none" id="datatable-default">
			<thead>
				<tr>
					<th>Subject</th>
					<th>Description</th>
					<th>Active</th>
					<th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
	if(isset($emails)){
	
				foreach($emails as $row){
					?>
					<tr class="gradeX">
						<td><?php echo $row->email_subject;?></td>
						<td><?php echo $row->email_desc;?></td>
						<td><?php if($row->status == 1) echo 'Yes'; else echo 'No';?></td>
						<td class="actions">
							<?php echo anchor('lead_email_template/edit/'.$row->id,'<span class="glyphicon glyphicon-edit"></span>');?>
							<?php echo anchor('lead_email_template/delete/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>',array("class"=>"link_delete"));?>
						</td>
					</tr>
					<?php
				} 
			}else{

				?>
					<tr class="gradeX">
						<td colspan="4">
							Data not found
						</td>
					</tr>
				<?php
				}?>


			</tbody>
		</table>
</div>
</section>




</section>
</div>


</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
		$('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>start/add");})
		$("#checkall").click(function () { 
			$(".checkone").prop('checked', $(this).prop('checked'));
		});
		$(".link_delete").click(function(){
			if(!confirm('Are you sure to delete this Lead?'))
				return false;
		});
	});
    //This function is used for making a json data for cascade delete, publish and unpublish and call ajax
    function cascade(action){
    	if(confirm('Are you sure to proceed this action?')){
    		var ids = checkedCheckboxId();
    		var jsonData ={"object":{"ids":ids,"action":action}};
    		$.ajax({
    			url:"<?php echo base_url(); ?>start/cascadeAction",
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