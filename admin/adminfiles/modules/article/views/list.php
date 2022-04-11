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
      <div class="affix"> <?php echo $this->mylibrary->getsublinks(1);?> </div>
    </div>
    <div class="col-md-10">
      <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2)) ?>
      <div class="page-header">
        <div class="btn-group pull-right" style="margin-right:10px;"> <?php echo $pagination; ?> </div>
        <div class="pull-right paging"> <span><?php echo $pagenumbers; ?></span> </div>
        <h2>Manage Pages
          <button 
                        id="addButton"
                        data-toggle="tooltip" 
                        title="Add New Record"
                        type="button" 
                        class="btn btn-default"> <span class="glyphicon glyphicon-plus-sign"></span> </button>
        </h2>
      </div>
      <div>
        <div class="alert alert-success"></div>
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th width="5%">SN</th>
              <th style="text-align:left;">Page Title</th>
              <th width="10%">Added Date</th>
              <th width="5%">Status</th>
              <th width="15%">Option</th>
            </tr>
          </thead>
          <tbody>
            <?php 
		if(isset($article)){ 
			foreach($article as $key=>$value):
				$class = ($key%2==0)?'class="odd"':'class="even"';
				echo '<tr '.$class.'><td>'.$key.'</td>';
				echo '<td style="text-align:left;">'.$article[$key]['title'].'</td>';
				echo '<td>'.$article[$key]['added_date'].'</td>';
				echo '<td>'.anchor('article/changestatus/'.$article[$key]['status'].'/'.$article[$key]['articleid'],$article[$key]['publish']).'</td>';
				echo '<td>'.anchor('article/edit/'.$article[$key]['articleid'],'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.anchor('article/delete/'.$article[$key]['articleid'],'<span class="glyphicon glyphicon-trash"></span>',array('onclick'=>"if(confirmationBox()){return true;} return false;")).'</td>';
			endforeach;
		}else{
			echo '<tr><td colspan="100%" style="text-align:center">'.$norecord.'</td></tr>';
		}
	  ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
        $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>index.php/article/add");})
    });
</script> 