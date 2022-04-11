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
                        <a href="<?php echo base_url("order/add?tab=1&customer=$student_id")?>"><i class="fa fa-plus"></i>Add</a>
                        <a href="javascript:void();" class="link_edit"><i class="fa fa-edit"></i>Edit</a>
                    </div>
                </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                        <input type="hidden" name="enroll_id" id="enroll_id" value="<?php echo $enroll_id;?>">
                    </div>
                    <br>

                    <table class="table table-bordered table-striped mb-none" id="datatable-default"
                        style="width: 1700px;">
                        <thead>
                            <tr>
                                <th style="width:2%;"><input type="checkbox" name="all" id="checkall"></th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions"
                                    style="width: 10%;">Actions</th>
                                <th>Order Number</th>
                                <th>Customer Name</th>
                                <th>Nature of Order</th>
                                <th>Price</th>
                                <th>Due</th>
                                <th>Commision</th>
                                <th>Ordered Date</th>
                                <th>Order Status</th>
                                <th>Invoice Status</th>
                                <?php if($this->session->userdata("clms_front_user_group") != 14) {?>
                                <th>
                                    <?php if($this->input->get("archived")) echo 'Archived Date'; else echo 'Make Archive'; ?>

                                </th>
                             
                                <th> Start Date</th>
                                <th>Update price</th>
                                <th>Note</th>
                                <?php } ?>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($order->result() as $row) {
                             $publish = ($row->status == 1 ? '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span></a>' : '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span></a>');
                             $customer = $this->quotemodel->getCustomer($row->customer_id);

                             $status = $this->ordermodel->getstatus($row->order_status);
                             $invoice = $this->ordermodel->getinvoicestatus($row->invoice_status);
                             $install = $this->ordermodel->getOrderInstallers($row->order_id);
                             $notes = $this->ordermodel->getOrderInstallersNotes($row->order_id);
                             $counter = $this->ordermodel->getemailcount($row->order_id);
                             $orderseen = $this->ordermodel->countseen($row->order_id);
                             $note_string = '';
                             foreach ($notes as $note) {
                              $note_string.=$note->notes.'\n';
                              $note_string.= $note->first_name.' '.$note->last_name.' \t \t Added Date:'.date("d/m/Y",$note->added_date).'\n';
                            }
                            ?>
                            <tr class="gradeX">
                                <td><input type="checkbox" class="checkone" value="<?php echo $row->order_id; ?>" />
                                </td>
                                <td class="actions">
                                <?php if($this->session->userdata("clms_front_user_group") != 14) {?>
 
                                    <?php echo anchor('order/duplicate/'.$row->order_id.'?project=1',' <i class="fa fa-copy"></i>',array("class"=>"")).'&nbsp;'.anchor('order/edit/'.$row->order_id.'?project=1','<span class="glyphicon glyphicon-edit"></span>',array("class"=>"")).'&nbsp;'.$publish; //.'&nbsp;'.anchor('order/delete/'.$row->order_id.'?tab=1','<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete"));?>

                                    <?php if(!empty($install)){?>
                                    <a class="  change_install" href="#"
                                        onclick='return  confirmation_popup("Confirmation","Do you really want to change it? ","Cancel","Confirm","<?php echo base_url("order/install/".$row->order_id."?project=1");?>");'>
                                        <span class="glyphicon glyphicon-user"
                                            <?php echo !empty($install)  ? 'style="color:red;"':''; ?>>
                                        </span>
                                    </a>
                                    <?php 
                            }else{
                              ?>
                                    <a class="simple-ajax-popup-reminder  "
                                        href="<?php echo base_url("order/install/".$row->order_id);?>">
                                        <span class="glyphicon glyphicon-user"
                                            <?php echo !empty($install) > 0 ? 'style="color:red;"':''; ?>></span>
                                    </a>
                                    <?php
                            } ?>

                                    <a class="simple-ajax-popup123 "
                                        href="<?php echo base_url("order/payment/".$row->order_id."?project=1");?>"><span
                                            class="fa fa-dollar"></span></a>
                                    <a href="<?php echo base_url("order/download_order/".$row->order_id);?>" class=""><i
                                            class="glyphicon glyphicon-download-alt"></i></a>
                                    <a href="<?php echo base_url("order/details/".$row->order_id);?>?project=1"
                                        class=""><span class="glyphicon glyphicon-fullscreen"></span></a>
                                    <!--  <a href="<?php echo base_url("order/submit_order/".$row->order_id);?>?tab=1" class="link_email"><span class="glyphicon glyphicon-envelope">(<?php echo  $counter;?>)</span></a> -->
                                    <a href="<?php echo base_url("order/mail_preview/".$row->order_id);?>?project=1"
                                        class="link_email simple-ajax-popup123 "><span
                                            class="glyphicon glyphicon-envelope"> </span> (<?php echo  $counter;?>)</a>
                                    <a href="javascript:void(0);" class=""><i class="fa fa-eye"></i>
                                        (<?php echo $orderseen;?>)</a>
                                        <?php }else{ ?>
                                          <a href="<?php echo base_url("order/download_order/".$row->order_id);?>" class=""><i
                                            class="glyphicon glyphicon-download-alt"></i></a>
                                    <a href="<?php echo base_url("order/details/".$row->order_id);?>?project=1"
                                        class=""><span class="glyphicon glyphicon-fullscreen"></span></a>
                                     <?php  } ?>
                                </td>
                                <td><?php echo $row->order_number;?></td>
                                <td><a class="simple-ajax-popup btn-default"
                                        href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->first_name.' '.@$customer->last_name;?></a>
                                </td>
                                <td><?php echo @$row->product;?></td>
                                <td>
                                    <?php echo number_format($row->price,2);?>
                                </td>
                                <td>
                                    <?php echo number_format($row->due_amount,2);?>
                                </td>

                                <td>
                                    <?php echo number_format($row->commision,2);?>
                                </td>

                                <td><?php echo date("d/m/Y",$row->added_date);?></td>
                                <td>
                                    <span class="label"
                                        style="color:#fff;background:<?php echo @$status->color_code;?>"><?php echo @$status->name;?></span></br><?php echo @$install->first_name.' '.@$install->last_name;?>
                                    <br> <?php echo @$install->position_type;?>

                                </td>
                                <td>
                                    <span class="label"
                                        style="color:#fff;background:<?php echo @$invoice->color_code;?>"><?php echo @$invoice->status_name;?></span>
                                </td>
                                <?php if($this->session->userdata("clms_front_user_group") != 14) {?>
                                <td>
                                    <?php 
                             if($this->input->get("archived")){
                              echo date("d-m-Y",strtotime($row->archived_date));
                            }else{
                             if(($row->order_status == 17 || $row->order_status == 18 || $row->order_status == 21) && ($row->invoice_status == 8)){
                              ?>
                                    <a href="javascript:void(0);"
                                        onclick='return  confirmation("Confirmation","Are you sure you want to archive the order? ","Cancel","Confirm","<?php echo base_url("order/make_archive/".$row->order_id);?>");'
                                        class="btn btn-primary ">Archive</a>
                                    <?php
                            }elseif($row->order_status == 20){
                              ?>
                                    <a href="javascript:void(0);"
                                        onclick='return  confirmation("Confirmation","Are you sure you want to archive the order? ","Cancel","Confirm","<?php echo base_url("order/make_archive/".$row->order_id);?>");'
                                        class="btn btn-primary ">Archive</a>
                                    <?php
                            }
                          }
                          ?></td>
                     
                                <td><?php echo @$install->installed_date != '' ? @date("D",strtotime($install->installed_date)) : '';?>,<?php echo @$install->installed_date != '' ? @date("d/m/Y",strtotime($install->installed_date)) : '';?><?php 
                          if(count($notes)){
                            ?><span class="glyphicon glyphicon-comment spectail_note<?php echo $row->order_id;?>"></span>
                                    <?php } ?>
                                </td>

                                <td>
                              
                                    <?php 
                            if($row->price == 0){
                              ?>
                                    <a href="javascript:void(0);" class="link_update_price btn btn-primary"
                                        rel="<?php echo $row->order_id;?>" title=""> Update Price </a>
                                    <?php } ?>
                                </td>

                                <td>
                              
                                    <a href="<?php echo base_url("order/customer_note/".$row->order_id);?>?project=1"
                                        class="link_update btn btn-primary" rel="<?php echo $row->order_id;?>" title="">
                                        Note </a>
                                  
                                </td>
                                <?php } ?>

                            </tr>
                            <?php 
                        if(count($notes)){
                          ?>
                            <script type="text/javascript">
                                $("#document").ready(function () {
                                    $('.spectail_note<?php echo $row->order_id;?>').tooltip({
                                        'placement': 'bottom',
                                        'title': '<?php echo $note_string;?>'
                                    });
                                });
                            </script>
                            <?php } ?>
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
<script type="text/javascript">
   
  $(document).ready(function(){
    $(document).on("change","#installer",function(){
      if($(this).val() == 0)
        return false;
      var rate = $('option:selected', this).attr('rel');
      $("#hourly_rate").val(rate);
    });

    $(document).on("change","#payment_method",function(){ 
      var payment_method = $(this).val();
      if(payment_method == ''){
        $("#div_total_amount").hide();
        $("#div_flat").hide();
        $("#div_hourly").hide();
        return false;
      }else if(payment_method == "Hourly Rate"){
        $("#div_hourly").show();
        $("#div_flat").hide();
        $("#div_total_amount").show();
        calculate_hourly_total();
      }else{
        $("#div_flat").show();
        $("#div_hourly").hide();
        $("#div_total_amount").show();
        calculate_flat_total();
      }
    });
    $(document).on("blur","#hourly_rate",function(){
      calculate_hourly_total();
    });

    $(document).on("blur","#install_time",function(){
      calculate_hourly_total();
    });

    function calculate_hourly_total()
    {
     var hour = $("#install_time").val();
     var rate = $("#hourly_rate").val();
     var total = rate * hour;
     var fuel_amount = $("#fuel_amount").val();
     var transport_amount = $("#transport_amount").val();
     var others_amount = $("#others_amount").val();
     var total = parseFloat(total) + parseFloat(fuel_amount) + parseFloat(transport_amount) + parseFloat(others_amount);
     $("#total_amount").val(total);
   }

   $(document).on("blur","#flat_amount",function(){
    calculate_flat_total();
  });

   $(document).on("blur","#fuel_amount",function(){
    if($("#payment_method").val() == 'Hourly Rate')
      calculate_hourly_total();
    else
      calculate_flat_total();
  });

   $(document).on("blur","#transport_amount",function(){
     if($("#payment_method").val() == 'Hourly Rate')
      calculate_hourly_total();
    else
      calculate_flat_total();
  });

   $(document).on("blur","#others_amount",function(){
    if($("#payment_method").val() == 'Hourly Rate')
      calculate_hourly_total();
    else
      calculate_flat_total();
  });

   function calculate_flat_total(){
     var flat_amount = $("#flat_amount").val();
     var fuel_amount = $("#fuel_amount").val();
     var transport_amount = $("#transport_amount").val();
     var others_amount = $("#others_amount").val();
     var total = parseFloat(flat_amount) + parseFloat(fuel_amount) + parseFloat(transport_amount) + parseFloat(others_amount);
     $("#total_amount").val(total);
   }

   $(document).on("click","#employer",function(){
    $("#div_employer").show();
    $("#install_time").addClass("required");
  });
   $(document).on("click","#employee",function(){
    $("#div_employer").hide();
  });
   $(".toggle-order-menu").click(function(){
    $(".div_menu").toggle();
  });
   $(".link_update_price").click(function(){
    var id = $(this).attr("rel");
    $.ajax({
      url: '<?php echo base_url() ?>order/update_price',
      type: "POST",
      data: "order_id=" + id,
      success: function(data) { 

        $("#form_content").html(data);
        $('#form_update_price_model').modal();
      }        
    });

  });
   $('.fa-copy').tooltip({'placement': 'bottom','title':'Make Duplicate'});
   $('.glyphicon-user').tooltip({'placement': 'bottom','title':'Assign to Contractor'});
   $('.fa-dollar').tooltip({'placement': 'bottom','title':'Payment'});
   $('.glyphicon-download-alt').tooltip({'placement': 'bottom','title':'Download Order confirmation'});
   $('.glyphicon-fullscreen').tooltip({'placement': 'bottom','title':'Preview invoice'});
   $('.glyphicon-envelope').tooltip({'placement': 'bottom','title':'Send Order conirmation'});
   $('.fa-eye').tooltip({'placement': 'bottom','title':'Order Seen'});

   $('#datatable-default').DataTable( {
    "order": [[ 1, "desc" ]]
  } );
   $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});
   $('#addButton').bind('click',function(){window.location.assign("<?php echo base_url() ?>order/add?tab=1");})
   $("#checkall").click(function () { 
    $(".checkone").prop('checked', $(this).prop('checked'));
  });

   
   $(".link_archive").click(function(){
    if(!confirm('Are you sure to archive this job?'))
      return false;
  });
 });

function cascade(action){

  confirmation("Confirmation","Are you sure you want to proceed this Action? ","Cancel","Confirm","",action,"<?php echo base_url(); ?>order/cascadeAction");

}
</script>

<script type="text/javascript">
  $(document).ready(function(){

   $("#finance").click(function(){
     if ($(this).prop('checked')==true){ 
      $("#div_payment_term").show();
      $("#payment_terms").addClass("required");
    }else{
      $("#div_payment_term").hide();
      $("#payment_terms").removeClass("required");
    }
  });
   $("#customer").change(function(){
    var customer = $(this).val();
    $.ajax({
      url: '<?php echo base_url() ?>quote/getCustomerDetails',
      type: "POST",
      data: "customer_id=" + customer,
      success: function(data) { 
        $("#div_customer_detail").html(data);
      }        
    });
  });
   $("#radio_yes").click(function(){
    $("#div_old").show();
    $("#div_new").hide();
  });

   $("#radio_no").click(function(){
    $("#div_old").hide();
    $("#div_new").show();
  });
 });
</script>

<script type="text/javascript">
  $(document).ready(function(){

    $(document).on("click",'input[name=gst_applicable]',function(){
      if($(this).val() == 1){
        $("#div_gst").show();
      }else{
        $("#div_gst").hide();
      }
      calculate_price();
    });

    $(document).on("click",'input[name=radio_gst]',function(){

      calculate_price();
    });


    function get_discount(){
      var amount = 0;
      var discount = $("#discount").val();
      var price = $("#price").val();
      if ($("#is_flat").prop('checked')==true){ 
        if(discount > 0)
          amount = parseFloat(price) * (parseFloat(discount)/100);
      }else{
        amount = discount;
      }

      return amount;
    }

    function calculate_price(){
     var discount = get_discount();
     var price = $("#price").val();
     var sub_total = parseFloat(price) - parseFloat(discount);
     $("#subtotal").val(sub_total);
     if($('input[name=gst_applicable]:checked').val() == 1){
      if($('input[name=radio_gst]:checked').val() == 1){
       var gst = sub_total/10;
       $("#gst").val(gst);
     }else{
      var gst = sub_total/11;
      $("#gst").val(gst.toFixed(2));
      gst = 0;
    }

  }else{
    var gst = 0;
  }

  var total_price = parseFloat(gst) + parseFloat(sub_total);
  $("#total_price").val(total_price);

  var advance_payment = $("#advance_payment").val();
  var due = total_price - parseFloat(advance_payment);
  $("#due_amount").val(due);
}

$(document).on("blur","#discount",function(){
  calculate_price();
});

$(document).on("click","#is_flat",function(){
  calculate_price();
});

$("#new_customer").click(function(){
  $("#div_customer").show();
  $("#div_old_customer").hide();
});
$("#old_customer").click(function(){
  $("#div_customer").hide();
  $("#div_old_customer").show();
});
var num = 1;
$(document).on("click","#add_more",function(){ 
  var cond = 1;
  $(".package_desc").each(function(){
    var id = $(this).attr("rel");
    if($("#package_desc_"+id).val() == ""){
     cond = 0;
   }

   if($("#package_qty_"+id).val() == ""){
     cond = 0;
   }

   if($("#package_price_"+id).val() == ""){
     cond = 0;
   }

 });
  if(cond == 0){
    alert("Enter all value First.");
    return false;
  }

  var num = $(".package_desc").length;
  num = num + 1;
  $("#div_document").append('<tr style="margin-top:10px;" id="tr_'+num+'">'+
    '<td> <input type="text" name="package_desc[]" value="" rel="'+num+'" id="package_desc_'+num+'" class="package_desc form-control" > </td>'+
    '<td style="padding-left:10px;"> <input type="text" name="short_desc[]" value="" rel="'+num+'" id="short_desc_'+num+'" class="short_desc form-control" > </td>'+
    '<td> <input type="text" name="package_qty[]" value="1" rel="'+num+'" id="package_qty_'+num+'" class="package_qty form-control number" style="width:50px;margin-left:20px;"></td>'+
    '<td><input type="text" name="package_price[]" value="0" rel="'+num+'" id="package_price_'+num+'" class="package_price form-control number" style="width:100px;margin-left:20px;"></td>'+
    '<td><a href="javascript:void(0);" class="link_remove" rel="'+num+'"> Remove</a></td></tr>');
});

$(document).on('blur','.package_price',function(){
  var total_price = 0;
  $(".package_price").each(function(){
    var id = $(this).attr("rel");
    var qty = $("#package_qty_"+id).val();
    var price = $(this).val();
    total_price += parseFloat(price) * parseFloat(qty);
  });
  $("#price").val(total_price);
  calculate_price();
});
$(document).on('click', '.link_remove' ,function(){
  var id = $(this).attr("rel");
  $("#tr_"+id).remove(); 
  $(".package_price").trigger("blur");
});

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
    invoice_id = $(this).val();
  });

  window.location.href = '<?php echo base_url("order/edit")?>/'+invoice_id+'?project=1';
});

});
</script>

<script type="text/javascript">
  function confirmation_popup(heading, question, cancelButtonTxt, okButtonTxt, callback,action='',cascadelink='') {

    var confirmModal = 
    $('<div class="modal" >' +        
      '<div class="modal-dialog" >' +
      '<div class="modal-content ch_mcont" >' +
      '<div class="modal-header ch_mheader">' +
      '<a class="close" data-dismiss="modal" >&times;</a>' +
      '<h3><span class="modal-icon" style="width:10%;float:none;"><i class="fa fa-question-circle"></i></span><strong>' + heading +'</strong></h3>' +
      '</div>' +

      '<div class="modal-body ch_mbody" style="height:200px;">' +
      '<p>' + question + '</p>' +
      '</div>' +

      '<div class="modal-footer ch_mfooter">' +
      '<a href="#!" class="btn btn-primary" data-dismiss="modal">' + 
      cancelButtonTxt + 
      '</a>' +
      '<a href="'+callback+'" id="okButton" class="btn btn-danger simple-ajax-popup-reminder">' + 
      okButtonTxt + 
      '</a>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>');

    confirmModal.find('#okButton').click(function(event) {
      confirmModal.modal('hide');
    }); 

    confirmModal.modal('show');    
    $('.simple-ajax-popup-reminder').magnificPopup({
      type: 'ajax',
      callbacks: {
        ajaxContentAdded: function() {   
          $('#form_install').validate();
          var date = new Date();
          date.setDate(date.getDate());

          $('#reminder_date').datepicker({ 
            format: 'dd/mm/yyyy',
            startDate: date
          });

          $('#deadline_date').datepicker({ 
            format: 'dd/mm/yyyy',
            startDate: date
          });

        }
  }
});
    return false;
  };  

</script>
