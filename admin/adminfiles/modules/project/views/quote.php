<!-- start: page -->

<!-- start: page -->
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#details123').trumbowyg();
  });
</script>
<section class="panel">
    <div class="panel-body case-body">
    <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>
        <?php $this->load->view("tab");?>
        <div class="case-list">
            <div class="row">
                <div class="col-sm-12">
                <div class="mig-top-sec">
                    <h4 class="mitgrate-tt">Invoices</h4>
                    <div class="adding">
                        <a href="<?php echo base_url("quote/add?project=1&customer=$student_id")?>"><i class="fa fa-plus"></i>Add</a>
                        <a href="javascript:void();" class="link_edit"><i class="fa fa-edit"></i>Edit</a>
                    </div>
                </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                        <input type="hidden" name="enroll_id" id="enroll_id" value="<?php echo $enroll_id;?>">
                    </div>
                    <br>

                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
              <thead>
                <tr>
                  <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
                  <th>Quote Number</th>
                  <th>Customer Name</th>
                  <th>Nature of Quote</th>
                  <th>Total</th>
                  <th>Quote Status</th>
                  <th>Quote Date</th>
                  <th>Expiry Date</th>
                  <th>Approve Quote</th>
                  <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($quote->result() as $row) {
                  $publish = ($row->status == 1 ? '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span></a>' : '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span></a>');
                  $customer = $this->quotemodel->getCustomer($row->customer_id);
                  $status = $this->quotemodel->getstatus($row->quote_satus);
                  $counter = $this->quotemodel->getemailcount($row->quote_id);
                  $quoteseen = $this->quotemodel->countseen($row->quote_id);
                  ?>
                  <tr class="gradeX">
                   <td><input type="checkbox" class="checkone" value="<?php echo $row->quote_id; ?>" /></td>
                   <td><?php echo $row->quote_number;?></td>
                   <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->first_name;?> <?php echo @$customer->last_name;?></a></td>
                   <td><?php echo $row->product;?></td>
                   <td><?php echo $row->total_price;?></td>

                   <td><span class="label" style="color:#fff;background:<?php echo @$status->color_code;?>"><?php echo @$status->name;?></span></td>
                   <td><?php echo date("d/m/Y",$row->added_date);?></td>
                   <td><?php echo date("d/m/Y",$row->expiry_date);?></td>
                   <td>
                     <?php
                   //  if($row->quote_satus == '19'){
                       ?>
                       <a href="<?php echo base_url("order/approve_quote/".$row->quote_id);?>" class="mb-xs mt-xs mr-xs btn btn-primary">Approve Quote</a>
                       <?php
                   //  }
                     ?>
                   </td>

                   <td class="actions">

                    <?php echo anchor('quote/duplicate/'.$row->quote_id.'?project=1',' <i class="fa fa-copy"></i>',array("class"=>"")).'&nbsp;'.anchor('quote/edit/'.$row->quote_id.'?project=1','<span class="glyphicon glyphicon-edit"></span>',array("class"=>"")).'&nbsp;'.$publish;?>
                    <a href="javascript:void(0);" onclick='return  confirmation("Confirmation","Are you sure you want to delete the item? ","Cancel","Confirm","<?php echo base_url("quote/delete/".$row->quote_id)?>");' class="" ><span class="glyphicon glyphicon-trash"></span></a>

                    <a href="<?php echo base_url("order/add_order?tab=1&customer=$student_id&quote_number=".$row->quote_number);?>" class=""><span class="fa fa-external-link-square"></span></a>
                    <a href="<?php echo base_url("quote/details/".$row->quote_id);?>?project=1" class=""><span class="glyphicon glyphicon-fullscreen"></span></a>
                    <!--  <a href="<?php echo base_url("quote/submit_quote/".$row->quote_id);?>?tab=1" class="link_email"><span class="glyphicon glyphicon-envelope">(<?php echo  $counter;?>)</span></a> -->
                    <a href="<?php echo base_url("quote/mail_preview/".$row->quote_id);?>?project=1" class="link_email simple-ajax-popup123 "><span class="glyphicon glyphicon-envelope">(<?php echo  $counter;?>)</span></a>
                    <?php if(file_exists("../uploads/pdf/Quote".$row->quote_number.".pdf")){?>
                    <a href="<?php echo SITE_URL.'uploads/pdf/Quote'.$row->quote_number.'.pdf'?>" target="_blank" class=""><i class="glyphicon glyphicon-download-alt"></i></a>
                    <?php } ?>

                    <a href="javascript:void(0);" class="">  <i class="fa fa-eye"></i> (<?php echo $quoteseen;?>)</a>
                  </td>
                </tr>
                <?php
              } ?>


            </tbody>
          </table>
                </div>
            </div>

        </div>
    </div>
</section>

</section>
</div>


</section>

<div id="form_update_price_model" class="modal fade" role="dialog">
  <div class="modal-dialog" >
    <div class="modal-content" id="form_content" >

    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
        $(".link_edit").click(function(){
            var chk = $(".checkone:checked").length;
            if(chk == 0){
                alert("Please, Select invoice to edit.");
                return false;
            }
            if(chk > 1){
                alert("Please, Select only one invoice to edit.");
                return false;
            }
            var invoice_id = 0;
            $(".checkone:checked").each(function(){
                quoteid = $(this).val();
            });

            window.location.href = '<?php echo base_url("quote/edit")?>/'+quoteid+'?project=1';
            });
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.fa-copy').tooltip({'placement': 'bottom','title':'Make Duplicate'});
    $('.fa-external-link-square').tooltip({'placement': 'bottom','title':'Add Order'});
    $('.glyphicon-fullscreen').tooltip({'placement': 'bottom','title':'Quote Detail'});
    $('.glyphicon-envelope').tooltip({'placement': 'bottom','title':'Send Mail'});
    $('.glyphicon-download-alt').tooltip({'placement': 'bottom','title':'Download Quote'});
    $('.fa-eye').tooltip({'placement': 'bottom','title':'Quote Seen'});


    
    
    $(".toggle-order-menu").click(function(){
      $(".div_menu").toggle();
    });
    $('#datatable-default').DataTable( {
      "order": [[ 1, "desc" ]]
    } );

    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
    $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>quote/add?tab=1");})
    $("#checkall").click(function () { 
      $(".checkone").prop('checked', $(this).prop('checked'));
    });

  });

  function cascade(action){

    confirmation("Confirmation","Are you sure you want to proceed this Action? ","Cancel","Confirm","",action,"<?php echo base_url(); ?>quote/cascadeAction");
    
  }
</script>
