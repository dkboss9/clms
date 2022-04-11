<div class="container">
    <div class="row">
        <div class="col-md-2 visible-lg">
      <div class="affix"> <?php echo $this->mylibrary->getsublinks(25);?> </div>
    </div>
        <div class="col-md-10">
			<?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2))?>
            <div class="clearBoth"></div>
            <div style="margin-top:10px;">
                <div class="col-md-12" >                    
                        <div style="min-height: 70px;">
                            <div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
                                <div>
                                   
                                    <h1>
                                    	User Permission for 
										<?php 
											$user_id = $this->uri->segment(3);
											echo $this->usermodel->getusername($user_id); 
										?>
                                   </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <table cellpadding="5" cellspacing="0" border="0" width="100%" class="table table-striped table-hover">
                                <tbody>
                                    <?php echo $userpermissions; ?>
                                </tbody>
                            </table>
                        </div>                    
                   </div>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>
</div>
