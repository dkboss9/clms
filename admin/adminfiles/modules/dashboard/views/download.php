
<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>

<script src="<?php echo base_url("");?>assets/vendor/chartist/chartist.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?php echo base_url("");?>assets/vendor/flot/jquery.flot.resize.js"></script>


<style>
 .activeClass{
   background-color: #86D1FD;
 }
 .top-icon li{
  list-style: none;
  display: inline-block;
  padding: 0% 3.3%;
}
.top-icon li a i{
  font-size: 36px;
}
.project-calender a i{
  font-size: 45px;
  display: block;
}
.project-calender a{
  color: green;
  text-align: center;
}
.event-calender a i{
  font-size: 45px;
  display: block;
}
.event-calender a{
  color: pink;
  text-align: center;
}
.task-calender a i{
  font-size: 45px;
  display: block;
}
.task-calender a{
  color: orange;
  text-align: center;
}
@media(max-width: 767px){
  .top-icon li{
    padding: 0% 2.5%;
  }
}
</style>


<!-- start: page -->

<?php 
//$this->load->view("dashboard_count");
?>
<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message") ?>
</div>
<?php
}
?>
<div class="row">
  <section class="panel">
    <div class="panel-body">
      <div class="tabs tabs-warning">
            <div class="row">

              <div class="col-sm-6">

                <div class="mb-md">
                  <h2>
                    <button 
                    id="addButton"
                    data-toggle="tooltip" 
                    title="Add New Record"
                    type="button" 
                    class="btn btn-primary"> Add <i class="fa fa-plus"></i> </button>

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
              </div>
            </div>
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
              <thead>
                <tr>
                  <th><input type="checkbox" name="all" id="checkall" ></th>
                  <th>Title</th>
                  <th>Type</th>
                  <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($downloads->result() as $acc) {
                 $publish = ($acc->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
                 ?>
                 <tr class="gradeX">
                   <td><input type="checkbox" class="checkone" value="<?php echo $acc->type_id; ?>" /></td>
                   <td><a href="<?php echo SITE_URL."uploads/student_documents/".$acc->doc_name;?>" target="_blank"><?php echo $acc->typename;?></a></td>
                   <td><?php echo $acc->type_name;?></td>
                   <td class="actions">

                    <?php echo anchor('download/edit/'.$acc->type_id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.$publish.'&nbsp;'.anchor('download/delete/'.$acc->type_id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
                  </td>
                </tr>
                <?php
              } ?>


            </tbody>
          </table>
      
    </div>
  </div>
</section>
</div>


</section>
</div>
</section>

<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>download/add?tab=1");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });

    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });

  });

  function cascade(action){
    if(confirm('Are you sure to proceed this action?')){
      var ids = checkedCheckboxId();
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
      var jsonData ={"object":{"ids":ids,"action":action}};
      $.ajax({
        url:"<?php echo base_url(); ?>download/cascadeAction",
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
