
<link rel="stylesheet" href="<?php echo base_url("");?>assets/stylesheets/trumbowyg.min.css">
<script src="<?php echo base_url("");?>assets/javascripts/trumbowyg.js"></script>
<script type="text/javascript">


  $(document).ready(function(){
    $('#details123').trumbowyg();
  });
</script>

<?php 
if($this->session->flashdata("success_message"))
{
  ?>
  <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message");?>
  </div>
  <?php
}
?>

<div class="row">
  <div class="col-md-12">
    <div class="tabs tabs-warning">
    

    <?php echo $this->load->view("tab");?>

                        <div class="tab-content">
                          <div id="leads" class="tab-pane <?php if(!$this->input->get("tab")) echo 'active';?>">
                            <div class="row">
                              <section class="panel">

                                <div class="panel-body">
                                 <div class="visible-xs toggle-order-menu"  data-target="html" >
                                  <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                                </div>

                              </div>
                            </section>
                            <div class="col-sm-12">
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
                                     <!--  <li><a onclick="cascade('delete');">Delete Marked</a></li> -->
                                     <li><a onclick="cascade('publish');">Mark as Publish</a></li>
                                     <li><a onclick="cascade('unpublish');">Mark as Unpublish</a></li>
                                   </ul>
                                 </div>
                                 <?php /*   <a href="<?php echo base_url("dashboard/export_order?status=$ostatus&invoice=$invoice");?>" class="btn btn-primary"> Export  </a> */?>
                               </h2>

                             </div>
                           </div>
                         </div>
                           <div class="row">

                            <form method="get" action="<?php echo current_url() ?>" enctype="multipart/form-data" style="margin-top: 35px;">
                              <?php if($this->session->userdata("usergroup") != 9){ ?>
                              <div class="col-md-3">
                                Referral:
                                <select name="referral_id" class="form-control">
                                 <option value="">Select Referral</option>
                                 <?php 
                                 foreach ($referral_users->result() as $row) {
                                  ?>
                                  <option value="<?php echo $row->userid;?>" <?php if(@$search_referral == $row->userid) echo 'selected="selected"';?>><?php echo $row->first_name;?> <?php echo $row->last_name;?></option>
                                  <?php
                                }
                                ?>
                              </select>
                              <input type="hidden" name="status" value="<?php echo @$search_status;?>">
                               <input type="hidden" name="archived" value="<?php echo @$archived;?>">
                                <input type="hidden" name="invoice" value="<?php echo @$invoice;?>">
                                 <input type="hidden" name="archived" value="<?php echo @$archived;?>">
                            </div>
                            <?php } ?>
                            <div class="col-md-3">
                              From Date
                              <input type="text" name="from_date" class="form-control datepicker" placeholder="From Date" readonly="" value="<?php echo @$from_date;?>">
                            </div>
                            <div class="col-md-3">
                              To Date
                              <input type="text" name="to_date" class="form-control datepicker" placeholder="To Date" value="<?php echo @$to_date;?>" readonly="" >
                            </div>
                            <div class="col-md-1">
                             <br>
                             <input type="submit" name="submit" value="Search" class="btn btn-primary" style="margin-bottom: 15px;">

                           </div>
                           <div class="col-md-2">
                            <br>
                             <a href="<?php echo base_url("order/export?status=".$search_status."&referral_id=".$search_referral."&from_date=".$from_date."&to_date=".$to_date)?>" class=" btn btn-primary">Export</a>
                           </div>

                         </form>

                       </div>

                         <table class="table table-bordered table-striped mb-none" id="datatable-default">
                          <thead>
                            <tr>
                              <th style="width:2%;"><input type="checkbox" name="all" id="checkall" ></th>
                              <th>Order Number</th>
                              <th>Customer Name</th>
                               <th>Referral</th>
                              <th>Nature of Order</th>
                              <th>Price</th>
                              <th>Commision</th>
                              <th>Ordered Date</th>
                              <th>Order Status</th>

                              <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
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
                             $referrals = $this->usermodel->getuser($row->referral_id)->row();
                             $note_string = '';
                             foreach ($notes as $note) {
                              $note_string.=$note->notes.'\n';
                              $note_string.= $note->first_name.' '.$note->last_name.' \t \t Added Date:'.date("d/m/Y",$note->added_date).'\n';
                            }
                            ?>
                            <tr class="gradeX">
                             <td><input type="checkbox" class="checkone" value="<?php echo $row->order_id; ?>" /></td>
                             <td><?php echo $row->order_number;?></td>
                             <td><a class="simple-ajax-popup btn-default" href="<?php echo base_url("customer/details/".$row->customer_id);?>"><?php echo @$customer->customer_name;?></a></td>
                             <td><?php echo @$referrals->first_name. ' '.@$referrals->last_name;?></td>
                             <td><?php echo @$row->product;?></td>
                             <td>
                               <?php echo number_format($row->price,2);?> 
                             </td>

                             <td >
                              <?php echo number_format($row->commision,2);?>
                            </td>

                            <td><?php echo date("d/m/Y",$row->added_date);?></td>
                            <td>
                              <span class="label" style="color:#fff;background:<?php echo @$status->color_code;?>"><?php echo @$status->name;?></span>

                            </td>

                            <td class="actions">
                              <?php 
                              if($row->order_status == 15){
                                echo anchor('order/edit/'.$row->order_id.'?tab=1','<span class="glyphicon glyphicon-edit"></span>',array("class"=>""));
                              }
                              echo '&nbsp;'.$publish;
                              if($row->order_status == 15){
                                echo '&nbsp;'.anchor('order/delete/'.$row->order_id.'?tab=1','<span class="glyphicon glyphicon-trash"></span>',array('class'=>"link_delete "));
                              }
                              ?>

                            </td>
                          </tr>
                          <?php 
                          if(count($notes)){
                            ?>
                            <script type="text/javascript">
                              $("#document").ready(function(){
                                $('.spectail_note<?php echo $row->order_id;?>').tooltip({'placement': 'bottom','title':'<?php echo $note_string;?>'});
                              });
                            </script>
                            <?php } ?>
                            <?php
                          } ?>


                        </tbody>
                      </table>
                    </div>
                    <div id="customer" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "patient") echo 'active';?>">


                    </div>
                    <div id="quote" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "patient") echo 'active';?>">


                    </div>
                    <div id="orders" class="tab-pane <?php if($this->input->get("tab") && $this->input->get("tab") == "order") echo 'active';?>">


                    </div>
                  </div>
                </div>
              </div>

            </div>
            <!-- start: page -->
<!--
<div class="row">
  <div class="col-md-6 col-lg-12 col-xl-6">
    <section class="panel">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="chart-data-selector ready" id="salesSelectorWrapper">

             <div id="datepicker">Welcome to Delite Coupons.</div>

           </div>
         </div>

       </div>
     </div>
   </section>
 </div>
 
</div>
-->
<!-- Form -->
<!-- end: page -->
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
  $( function() {
    $( ".datepicker" ).datepicker({ format: 'dd/mm/yyyy' });
  } );
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

        }
    // e.t.c.
  }
});
    return false;
  };  

</script>

