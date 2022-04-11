




<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();

  });
</script>


<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>

<?php 
$this->load->view('detail');
?>


<?php 
$downloads    = $this->appointmentmodel->listDownloadForm($enroll->fee_id);
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
       $i++;
     } ?>


   </tbody>
 </table>
 <?php }else{
  echo "No Downloadable form in added for this option.";
} ?>

<!-- start: page -->

<!-- end: page -->
</section>
</div>
</section>
<script type="text/javascript">
  $(document).ready(function(){
   $("#addButton").click(function(){
    $("#div_task").toggle();
  });
   $("#form_discussion").validate();
   $(".link_delete").click(function(){
    if(!confirm('Are you sure to delete this Record?'))
      return false;
  });
 });
</script>