
<div id="custom-content" class="white-popup-block white-popup-block-md">
  <h3>Checklist</h3>
  <div class="row">
    <div class="col-md-12">
      <?php
      if($checklist->num_rows() > 0){
        ?>
        <table class="table table-bordered table-striped mb-none" >

          <tbody>
            <?php 
            $i = 1;
            foreach ($checklist->result() as $row) {
             ?>
             <tr>
               <td ><?php echo $i;?>. <?php echo $row->type_name;?></td>
             </tr>
             <?php
             $i++;
           }
           ?>

           <tr>
             <td style="text-align:right;"> <a href="<?php echo base_url("appointment/download_checklist/".$fee_id);?>" class="btn btn-primary">pdf</a></td>
           </tr>


         </tbody>
       </table>
       <?php }else{
        echo 'No checklist added for this Option';
      } ?>
    </div>
  </div>
</div>



