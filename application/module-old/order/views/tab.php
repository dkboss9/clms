<div class="row">
	<div class="col-md-12">
		<section class="panel">

			<div class="panel-body">
				<h3><?php echo $order->patient;?></h3>
				<p><?php echo $order->procedure_name;?></p>
				
				

			</div>
		</section>
	</div>
</div> 
<div class="row">
	<div class="col-md-12">
		<section class="panel">

			<div class="panel-body">
				<a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo $this->uri->segment(2) == "comment"? 'btn-active': 'btn-default';?>" href="<?php echo base_url("order/comment/".$this->uri->segment(3));?>">Comments (<?php echo count($comments);?>)</a>
				<a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo $this->uri->segment(2) == "file"? 'btn-active': 'btn-default';?>" href="<?php echo base_url("order/file/".$this->uri->segment(3));?>">Upload File (<?php echo count($discussions);?>)</a>
				<a class="mb-xs mt-xs mr-xs modal-basic btn btn-default" href="<?php echo base_url("order/");?>">Manage Order</a>

			</div>
		</section>
	</div>
</div> 