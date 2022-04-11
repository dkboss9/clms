

<!-- log: page -->
<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="" data-panel-toggle></a>
      <a href="#" class="" data-panel-dismiss></a>
    </div>

    <h2 class="panel-title">When Log List</h2>
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

  <table class="table table-bordered table-striped mb-none" id="datatable-example">
    <thead>
      <tr>
       <th>Log No.</th>
       <th>Content</th>
       <th>Module</th>
       <th>Action</th>
       <th>Actioned By</th>
       <th>Date</th>

     </tr>
   </thead>
   <tbody>

     <?php 
     foreach ($logs->result() as $log) {
      $content = unserialize($log->content);
      ?>
      <tr class="gradeX">
        <td><?php echo $log->log_id;?></td>
        <td><?php
         foreach ($content as $key => $value) {
          echo $key.': '.$value.'<br>';
        }
        ?>
      </td>
      <td><?php echo $log->module;?></td>
      <td><?php echo $log->action;?></td>
      <td><?php echo $log->user_name;?></td>
      <td><?php echo date("d-m-Y h:i:s",$log->added_date);?></td>


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
  $(document).ready(function() {
    $('#datatable-example').DataTable( {
      "order": [[ 0, "desc" ]]
    } );
  } );
</script>