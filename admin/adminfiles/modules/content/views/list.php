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
        <?php echo $this->mylibrary->getsublinks(1);?>
      </div>
    </div>
    <div class="col-md-10">
      <?php createBreadcrumb($this->uri->segment(1), $this->uri->segment(2)) ?>
      <div class="page-header">
        <div class="btn-group pull-right" style="margin-right:10px;"> <?php echo $pagination; ?> </div>
        <div class="pull-right paging">
          <span><?php //echo $pagenumbers; ?></span> </div>
          <h2>Manage Login Content</h2>
         <!-- <button 
          id="addButton"
          data-toggle="tooltip" 
          title="Add New Record"
          type="button" 
          class="btn btn-default"> <span class="glyphicon glyphicon-plus-sign"></span> 
        </button> -->

        <!-- Single button -->
        <!--<div class="btn-group">
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
          <ul class="dropdown-menu" role="menu">
            <li><a onclick="cascade('delete');">Delete Marked</a></li>
            <li><a onclick="cascade('publish');">Mark as Published
</a></li>
            <li><a onclick="cascade('unpublish');">Mark as Unpublished
</a></li>
          </ul>
        </div>-->
      </h2>
    </div>
    <div>
      <div class="alert alert-success"></div>
      <table class="table table-striped table-hover">
        <tr>

          <th><a>Title</a> <a href=""><span class="glyphicon glyphicon-sort-by-attributes"></span></a></th>
          <th width="10%">Action</th>
        </tr>
        <?php 
        if ($contents->num_rows() > 0) {
          $faq = '';
          foreach ($contents->result() as $row):
            $publish = ($row->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
          $faq .= '<tr>
          <td>' . $row->title . '</td>
          <td>'.anchor('content/edit/'.$row->id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'</td>';
          $faq .= '</tr>';
          endforeach;
          /*.'&nbsp;'.anchor('content/delete/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>',array('onclick'=>"if(confirmationBox()){return true;} return false;"))*/
          //$query->free_result();
        }else {
          $faq = '';
          $faq .= '<tr><td colspan="4" style="text-align:center;">No records exist.</td></tr>';
        }
        echo $faq;
        ?>
      </table>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>index.php/content/add");})
  });
    //This function is used for making a json data for cascade delete, publish and unpublish and call ajax
    function cascade(action){
      if(confirm('Are you sure to proceed this action?')){
        var ids = checkedCheckboxId();
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
        var jsonData ={"object":{"ids":ids,"action":action}};
        $.ajax({
          url:"<?php echo base_url();?>index.php/slider/cascadeAction",
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