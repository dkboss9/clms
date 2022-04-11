


<style>
 .row-company{
    margin-top: 20px;
 }

</style>


<!-- start: page -->

<?php 
//$this->load->view("welcome_count");
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
    <div class="row row-company">
    <?php 
    $i=0;
        foreach($companies as $company){
          ?>
    
            <div class="col-md-6 ">
                <header class="panel-heading">
                    <h2 class="panel-title" style="text-align: center;text-transform: capitalize;font-weight:bold;"><?php echo $company->company_name;?></h2>
                    <h4 style="text-align: center;text-transform: capitalize;font-weight:bold;"><?php echo $company->group_name;?></h4>
                </header>
                <section class="card card-featured-left card-featured-primary mb-4 panel-body">
                    <div class="card-body">
                        <div class="widget-summary">
                         
                            <div class="widget-summary-col">
                                <div class="summary">
                                    <h4 class="title" style="text-align: right;"><span class="label" style="background: green;"><?php echo $company->first_name.' '.$company->last_name;?></span></h4>
                                    <h6><strong> Email:</strong> <?php echo $company->email;?> </h6>
                                    <h6><strong> Contact: </strong> <?php echo $company->phone;?></h6>
                                </div>
                                <div class="summary-footer">
                                    <a href="<?php echo base_url("welcome/select_company/".$company->user_group_company_id); ?>" class="text-muted text-uppercase"><span class="label" style="background: blue;">(Select)</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
    <?php
          $i++;
           echo $i % 2 == 0 ? '</div> <div class="row row-company">':'';
           
        }
    ?>
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
    $('.fa-mail-forward').tooltip({'placement': 'bottom','title':'Email'});
    $(".fa-user-md").tooltip({'placement': 'bottom','title':'Add Student'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>lms/add?tab=1");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });

    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Lead?'))
        return false;
    });

    
    $('#datatable-default').DataTable( {
      "order": [[ 1, "desc" ]]
    } );


  });

  function cascade(action){
    if(confirm('Are you sure to proceed this action?')){
      var ids = checkedCheckboxId();
      var jsonData ={"object":{"ids":ids,"action":action}};
      $.ajax({
        url:"<?php echo base_url(); ?>lms/cascadeAction",
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
