



<!-- start: page -->
<?php 
if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
  ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>We must tell you! </strong> Please select company to add this data.
  </div>
  <?php
}
?>
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Appointment : [Counselling]</h2>
      </header>
      <div class="panel-body">

        <?php if(isset($error)){ ?>
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

          <?php echo $error; ?>
        </div>
        <?php  } ?>
        <?php
        $status = $this->appointmentmodel->getlead_status($result->status_id);
        $purpose = $this->appointmentmodel->getlead_purpose($result->purpose);
        $counseller = $this->appointmentmodel->getcompany_users($result->consultant);
        ?>
        <div class="form-group">
          <label class="col-md-4 "><strong>Lead Name :</strong> <?php echo $result->lead_name.' '.$result->lead_lname;?></label>
          <label class="col-md-4 "><strong>Purpose :</strong> <?php echo @$purpose->type_name;?></label>
          <label class="col-md-4 "><strong>Status :</strong> <span class="label" style="color:#fff;background:<?php echo $status->status_color;?>"><?php echo @$status->status_name;?></span> <a class="simple-ajax-popup-reminder btn btn-success" href="<?php echo base_url("appointment/detail/".$result->lead_id);?>" style="float:right;">Update Status</a></label>
        </div>
        <div class="form-group">
          <label class="col-md-4 "><strong>Date & Time :</strong> <?php echo date("d-m-Y",strtotime($result->booking_date)).' '.$result->booking_time;?></label>
          <label class="col-md-4 "><strong>Intrested Country :</strong> <?php echo $result->country;?></label>
          <label class="col-md-4 "><strong>Counseller :</strong> <?php echo @$counseller->first_name.' '.@$counseller->last_name;?></label>

        </div>

        <div class="form-group" id="div_favourite">
          <div class="col-md-12">
            <table class="table table-bordered table-striped mb-none" >

              <tbody>
                <tr>
                  <td colspan="4"> Favourites</td>
                </tr>
                <tr class="gradeX">
                 <?php 
                 $i=1;
                 foreach ($favourites as $row) {
                  ?>
                  <td id="td_fav<?php echo $row->fee_id;?>">
                    <p style="border-bottom:1px solid #dddddd;padding:10px;background:#f69c55;color:#ffffff;"><strong>Option <?php echo $i;?></strong></p>
                    <p > <strong>Country:</strong> <?php echo $row->country_name;?></p>
                    <p > <strong>Intake:</strong> <?php echo $row->intake;?></p>
                    <p > <strong>College:</strong> <?php echo $row->college;?></p>
                    <p > <strong>Degree:</strong> <?php echo $row->degree;?></p>
                    <p > <strong>Course:</strong> <?php echo $row->course;?></p>
                    <p > <strong>Course Duration:</strong> <?php echo $row->period;?></p>
                    <?php 

                    if($row->price > 0)
                      echo '<p> <strong>Semister Fee:</strong> '.$row->price.'</p>';
                    else
                     echo '<p> <strong>Semister Fee:</strong> - </p>';

                   if($row->y_price > 0)
                    echo '<p><strong>YearlY Fee:</strong> '.$row->y_price.'</p>';
                  else
                    echo '<p><strong>YearlY Fee:</strong> - </p>';

                  if($row->t_price > 0)
                   echo '<p><strong>Total Fee:</strong> '.$row->t_price.'</p>';
                 else
                  echo '<p><strong>Total Fee:</strong> - </p>';
                ?>
                <?php
                if($row->destinated_option > 0){
                  ?>
                  <p style="text-align:center;border:1px solid #dddddd;padding:10px;"> <a href="<?php echo base_url("appointment/remove_selected/".$row->lead_id."/".$row->fee_id);?>"  class="default_selected mb-xs mt-xs mr-xs btn btn-default">Selected</a></p>
                  <?php
                }else{
                  ?>
                  <p style="text-align:center;border:1px solid #dddddd;padding:10px;"> <a href="<?php echo base_url("appointment/make_selected/".$row->lead_id."/".$row->fee_id);?>"  class="default_selected mb-xs mt-xs mr-xs btn btn-success">Default as Selected</a></p>
                  <?php
                }

                ?>
                
                <p style="text-align:center;border:1px solid #dddddd;padding:10px;"> <a href="javascript:void(0);" rel="<?php echo $row->fee_id;?>" class="remove_favourite mb-xs mt-xs mr-xs btn btn-success">Remove</a></p>
                <p style="text-align:center;border:1px solid #dddddd;padding:10px;"> 
                  <a class="simple-ajax-popup-reminder mb-xs mt-xs mr-xs btn btn-success" href="<?php echo base_url("appointment/checklist/".$row->fee_id);?>">View Checklist</a>
                </p>
                <p style="text-align:center;border:1px solid #dddddd;padding:10px;">
                  <a class="simple-ajax-popup-reminder mb-xs mt-xs mr-xs btn btn-success" href="<?php echo base_url("appointment/download_form/".$row->fee_id);?>">View Downloadable Form</a>
                </p>
              </td>
              <?php
              if($i % 4 == 0)
                echo '</tr><tr>';
              $i++;
            }
            ?>

          </tr>


        </tbody>
      </table>
    </div>

  </div>   
      
<div class="form-search row">
  <form class="form-bordered" id="form_lead" action="<?php echo base_url("appointment/counselling/".$result->lead_id);?>" method="get" >
  
   <div class="form-group">
    <div class="col-md-2">
      <select class="form-control mb-md" data-plugin-selectTwo  name="country" id="country">
        <option value="">Country</option>
        <?php
        foreach ($countries as $row) {
         ?>
         <option value="<?php echo $row->country_id;?>" <?php if($row->country_id == $search_country) echo 'selected="selected"';?>><?php echo $row->country_name;?></option>
         <?php
       }
       ?>
     </select>
   </div>

   <div class="col-md-2">
     <select class="form-control mb-md" data-plugin-selectTwo  name="intake">
      <option value="">Intake</option>
      <?php
      foreach ($intakes as $row) {
       ?>
       <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $search_intake) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
       <?php
     }
     ?>
   </select>
 </div>

 <div class="col-md-2">
   <select class="form-control mb-md" data-plugin-selectTwo  name="college" id="college">
    <option value="">College</option>
    <?php
    foreach ($colleges as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $search_college) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
</div>

<div class="col-md-2">
  <select class="form-control mb-md" data-plugin-selectTwo  name="degree" id="degree">
    <option value="">Degree</option>
    <?php
    foreach ($degrees as $row) {
     ?>
     <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $search_degree) echo 'selected="selected"';?>><?php echo $row->type_name;?></option>
     <?php
   }
   ?>
 </select>
</div>

<div class="col-md-2">
 <select class="form-control mb-md" data-plugin-selectTwo  name="course" id="course">
  <option value="">Course</option>
  <?php
  foreach($courses as $row){
    ?>
    <option value="<?php echo $row->type_id;?>" <?php if($row->type_id == $search_course) echo 'selected="seleted"';?>><?php echo $row->type_name;?></option>
    <?php
  }
  ?>
</select>
</div>

<div class="col-md-2">
  <input type="submit" name="submit" class="mb-xs mt-xs mr-xs btn btn-success" value="Find Options">
</div>

</div>
</form>
</div>
<form class="form-horizontal form-bordered" id="form_lead" action="<?php echo base_url("appointment/counselling/".$result->lead_id);?>" method="post" >
 <div class="form-group">

 </div>
 <div class="form-group">

  <div class="col-md-12 table-responsive">
    <table class="table table-bordered table-striped mb-none" >

      <tbody>

       <tr class="gradeX">
         <?php 
         $i=1;
         foreach ($counsells as $row) {
          ?>
          <td id="td_<?php echo $row->fee_id;?>" >
            <p style="border-bottom:1px solid #dddddd;padding:10px;background:#f69c55;color:#ffffff;"><input type="checkbox" name="chk_option[]" value="<?php echo $row->fee_id;?>"> <strong>Option <?php echo $i;?></strong></p>
            <p > <strong>Country:</strong> <?php echo $row->country_name;?></p>
            <p > <strong>Intake:</strong> <?php echo $row->intake;?></p>
            <p > <strong>College:</strong> <?php echo $row->college;?></p>
            <p > <strong>Degree:</strong> <?php echo $row->degree;?></p>
            <p > <strong>Course:</strong> <?php echo $row->course;?></p>
            <p > <strong>Course Duration:</strong> <?php echo $row->period;?></p>
            <?php 

            if($row->price > 0)
              echo '<p> <strong>Semister Fee:</strong> '.$row->price.'</p>';
            else
             echo '<p> <strong>Semister Fee:</strong> - </p>';

           if($row->y_price > 0)
            echo '<p><strong>YearlY Fee:</strong> '.$row->y_price.'</p>';
          else
            echo '<p><strong>YearlY Fee:</strong> - </p>';

          if($row->t_price > 0)
           echo '<p><strong>Total Fee:</strong> '.$row->t_price.'</p>';
         else
          echo '<p><strong>Total Fee:</strong> - </p>';
        ?>
        <p style="text-align:center;border:1px solid #dddddd;padding:10px;"> <a href="javascript:void(0);" rel="<?php echo $row->fee_id;?>" class="link_fav mb-xs mt-xs mr-xs btn btn-success">Default in Favorite</a></p>
        <p style="text-align:center;border:1px solid #dddddd;padding:10px;"> 
          <a class="simple-ajax-popup-reminder mb-xs mt-xs mr-xs btn btn-success" href="<?php echo base_url("appointment/checklist/".$row->fee_id);?>">View Checklist</a>
        </p>
        <p style="text-align:center;border:1px solid #dddddd;padding:10px;">
          <a class="simple-ajax-popup-reminder mb-xs mt-xs mr-xs btn btn-success" href="<?php echo base_url("appointment/download_form/".$row->fee_id);?>">View Downloadable Form</a>
        </p>
      </td>
      <?php
      if($i % 4 == 0)
        echo '</tr><tr>';
      $i++;
    }
    ?>

  </tr>


</tbody>
</table>
</div>

</div>


<div class="form-group">
  <div class="col-md-6">
    <input type="hidden" name="lead_id" value="<?php echo $result->lead_id;?>">
    <?php 
    if(!empty($counsells)){
    ?>
    <input type="submit" name="submit" value="Add to favorite" class="mb-xs mt-xs mr-xs btn btn-success">
    <?php } ?>
    <?php if($this->input->get("project") == 1 && $result->student_id){?>
      <a href="<?php echo base_url("project/appointments/".$result->student_id);?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
    <?php }else{ ?>
      <a href="<?php echo base_url("appointment");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
   <?php } ?>
   
  </div>
</div>
</form>
</div>
</section>






</div>
</div>

<!-- end: page -->
</section>
</div>


</section>
<script type="text/javascript">
  $(document).ready(function(){
    $("#form_lead").validate();
    $("#nepal_yes").click(function(){
      $("#div_nepal").show();
      $("#div_located").hide();
    });

    $("#nepal_no").click(function(){
      $("#div_nepal").hide();
      $("#div_located").show();
    });

    $(".link_fav").click(function(){
      var fee_id = $(this).attr("rel");
      $.ajax({
        url: '<?php echo base_url() ?>appointment/make_favourite',
        type: "POST",
        data: "fee_id=" + fee_id + "&lead_id=<?php echo $result->lead_id;?>",
        success: function(data) { 
         $("#td_"+fee_id).remove();
         $("#div_favourite").html(data);
       }        
     });
    });

  });
</script>

<script type="text/javascript">
  $(document).ready(function(){ 
    $("#degree").change(function(){
      var degree = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>course_fee/getCourse',
        type: "POST",
        data: "degree=" + degree,
        success: function(data) { 
          if(data != ""){
            $("#course").html(data);
            $("#course").select2()
          }
        }        
      });
    });
    $("#country").change(function(){
      var country = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>course_fee/getColleges',
        type: "POST",
        data: "country=" + country,
        success: function(data) { 
          if(data != ""){
            $("#college").html(data);
            $("#college").select2()
          }
        }        
      });
    });
    $(document).on("click",".remove_favourite",function(){
      var fee_id = $(this).attr("rel");
      $.ajax({
        url: '<?php echo base_url() ?>appointment/remove_favourite',
        type: "POST",
        data: "fee_id=" + fee_id + "&lead_id=<?php echo $result->lead_id;?>",
        success: function(data) { 
         $("#td_fav"+fee_id).remove();
       }        
     });
    });
  });
</script>