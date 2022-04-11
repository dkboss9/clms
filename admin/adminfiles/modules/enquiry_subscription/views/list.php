


  <?php
  if($this->session->userdata("clms_company") && $this->session->userdata("clms_company") > 0){ 
    ?>
    <div class="row">
      <div class="col-md-12 col-lg-4 col-xl-4">
        <section class="panel panel-featured-left panel-featured-quartenary">
          <div class="panel-body">
            <div class="widget-summary">
              <div class="widget-summary-col widget-summary-col-icon">
                <div class="summary-icon bg-quartenary">
                 <i class="fa fa-usd"></i>
               </div>
             </div>
             <div class="widget-summary-col">
              <div class="summary">
                <h3 class="title"><strong>Enquiry Credits</strong></h3>
                <div class="info">
                  <span class="text-primary" style="font-size: 18px"><?php echo $company->enquiry_credit;?></span>
                </div>

              </div>

            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-12 col-lg-4 col-xl-4">
      <section class="panel panel-featured-left panel-featured-primary">
        <div class="panel-body">
          <div class="widget-summary">
            <div class="widget-summary-col widget-summary-col-icon">
              <div class="summary-icon bg-primary">
                <i class="fa fa-life-ring"></i>
              </div>
            </div>
            <div class="widget-summary-col">
              <div class="summary">
                <h3 class="title"><strong>Enquiry Used</strong></h3>
                <div class="info">
                 <span class="text-primary" style="font-size: 18px"><?php echo $company->enquiry_credit-$company->balance_enquiry;?></span>
               </div>

             </div>

           </div>
         </div>
       </div>
     </section>
   </div>
   <div class="col-md-12 col-lg-4 col-xl-4">
    <section class="panel panel-featured-left panel-featured-secondary">
      <div class="panel-body">
        <div class="widget-summary">
          <div class="widget-summary-col widget-summary-col-icon">
            <div class="summary-icon bg-secondary">
             <i class="glyphicon glyphicon-lock"></i>
           </div>
         </div>

         <div class="widget-summary-col">
          <div class="summary">
            <h3 class="title"><strong>Enquiry Balance</strong></h3>
            <div class="info">
              <span class="text-primary" style="font-size: 18px">
               <?php echo $company->balance_enquiry;?>
             </span>
           </div>
         </div>

       </div>
     </div>
   </div>
 </section>
</div>
</div>

<?php
}
?>

<!-- start: page -->
<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="" data-panel-toggle></a>
      <a href="#" class="" data-panel-dismiss></a>
    </div>

    <h2 class="panel-title">Enquiry package list</h2>
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
        <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
        <th>Company</th>
        <th>Credits</th>
        <th>Price</th>
        <th>Payment Method</th>
        <th>Invoice Status</th>
        <!--  <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th> -->
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach ($status->result() as $row) {
        ?>
        <tr class="gradeX">
         <td><input type="checkbox" class="checkone" value="<?php echo $row->id; ?>" /></td>
         <td><?php echo $row->company_name;?></td>
         <td><?php echo $row->credits;?></td>
         <td><?php echo $row->price;?></td>
         <td><?php echo $row->payment_method;?></td>
         <td><?php echo $row->invoice_status;?></td>
          <!--  <td class="actions">

            <?php echo anchor('enquiry_subscription/edit/'.$row->id,'<span class="glyphicon glyphicon-edit"></span>').'&nbsp;'.'&nbsp;'.anchor('enquiry_subscription/delete/'.$row->id,'<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>
          </td> -->
        </tr>
        <?php
      } ?>


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
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>enquiry_subscription/add");})
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
      if(ids.length == 0){
        alert("Select atleast one data to proceed this action");
        return false;
      }
        var jsonData ={"object":{"ids":ids,"action":action}};
        $.ajax({
          url:"<?php echo base_url(); ?>enquiry_subscription/cascadeAction",
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