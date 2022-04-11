
<script language="javascript">
	$(document).ready(function(){
		$("#faq").validate();
	});
	window.onload = function(){
		CKEDITOR.replace('faq_content');
	};
</script>
<div class="container">
	<div class="row">
		<div class="col-md-2 visible-lg">
			<div class="affix">
				<?php echo $this->mylibrary->getsublinks(1);?>
			</div>
		</div>
		<div class="col-md-10">
			<?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2))?>
			<div class="clearBoth"></div>
			<div style="margin-top:10px;">
				<div class="col-md-12" >
					<?php echo form_open_multipart('content/add',array('id'=>'faq'));?>
					<div style="min-height: 70px;">
						<div class="page-header" data-spy="affix" data-offset-top="52" id="fix-page-header">
							<div>
								<button class="btn btn-danger pull-right" type="button" onclick="window.location.assign('<?php echo base_url();?>index.php/content/listall');"> <span class="glyphicon glyphicon-floppy-remove"></span> Cancel </button>
								<button style="margin-right:10px;" class="btn btn-primary pull-right" value="submit" name="submit" type="submit"> <span class="glyphicon glyphicon-floppy-disk"></span> Save </button>
								<h2>Add login content </h2>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<table cellpadding="5" cellspacing="0" border="0" width="100%" class="table-tab">
							<tbody>
								<tr>
									<td width="10%"><label for="category_id">Title * :</label></td>
									<td><input type="text" name="cat_title" required /></td>
								</tr>
								<tr>
									<td width="10%"><label for="faq_title">Content * :</label></td>
									<td><textarea name="content" required rows="6" cols="60"></textarea></td>
								</tr>

							</tbody>
						</table>
					</div>
					<?php echo form_close();?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>
