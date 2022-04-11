

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
<script src="<?php echo base_url("");?>assets/javascripts/ui-elements/examples.lightbox.js"></script>
<script src="<?php echo base_url("");?>assets/javascripts/theme.init.js"></script>