
<div id="custom-content" class="white-popup-block white-popup-block-md">
  <h3>Downloadable Form</h3>
  <div class="row">
    <div class="col-md-12">
      <?php 
      if($downloads->num_rows() > 0){
        ?>
        <table class="table table-bordered table-striped mb-none" id="datatable-default">
          <thead>
            <tr>
              <th>Sn.</th>
              <th>Title</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $i = 1;
            foreach ($downloads->result() as $acc) {
             $publish = ($acc->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
             ?>
             <tr class="gradeX">
               <td><?php echo $i;?></td>
               <td><a href="<?php echo SITE_URL."uploads/student_documents/".$acc->doc_name;?>" target="_blank"><?php echo $acc->typename;?></a></td>
               <td><?php echo $acc->type_name;?></td>

             </tr>
             <?php
           } ?>


         </tbody>
       </table>
       <?php }else{
        echo "No Downloadable form in added for this option.";
      } ?>
    </div>
  </div>
</div>



