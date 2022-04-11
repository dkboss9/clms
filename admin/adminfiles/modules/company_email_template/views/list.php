<!-- start: page -->
<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
			<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
		</div>

		<h2 class="panel-title">Email Template List</h2>
	</header>

	<div class="panel-body">
		<?php if($this->session->flashdata("success_message")){?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
		</div>
		<?php
	}
	if(isset($news)){
		?>

		<table class="table table-bordered table-striped mb-none" id="datatable-default">
			<thead>
				<tr>
					<th>Subject</th>
					<th>Description</th>
					<th>SMS</th>
					<th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				foreach($news as $key=>$value){
					?>
					<tr class="gradeX">
						<td><?php echo $news[$key]['title'];?></td>
						<td><?php echo $news[$key]['description'];?></td>
						<td><?php if($news[$key]['sms'] == 1) echo 'Yes'; else echo 'No';?></td>
						<td class="actions">

							<?php echo anchor('company_email_template/edit/'.$news[$key]['newsid'],'<span class="glyphicon glyphicon-edit"></span>');?>
						</td>
					</tr>
					<?php
				} ?>


			</tbody>
		</table>
		<?php
	}else{
		?>
		<?php 
		if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
			?>
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>We must tell you! </strong> Please select company to see email list.
			</div>
			<?php
		}
		?>
		<?php
	}
	?>
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