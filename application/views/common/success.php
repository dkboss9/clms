
	<div class="container">
		<div class="row">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">
				<div class="error-template success">
					<h1> Success!</h1>
					<div class="success-icon">
						<img src="<?php echo base_url("assets/images/icons/success.png");?>">
					</div>
					<div class="error-details">
						<h3> <?php echo $this->session->flashdata('success');?></h3>
					</div>
					<div class="error-actions" style="margin: 30px 0 40px 0;">
						<div class="row">
                            <div class="col-xs-12 col-md-12">
                            <a href="<?php echo base_url();?>" class="btn btn-primary btn-lg" style="background: #00cc67;border-color: #00cc67; padding:10px 25px;"><span class="glyphicon glyphicon-home"></span>
                            Go Home </a>
                        </div>
                        
                    </div>

					</div>
				</div>
			</div>
			<div class="col-md-3">
			</div>
		</div>
	</div>
