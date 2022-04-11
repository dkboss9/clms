

<!-- start: page -->


<section class="panel">
  <header class="panel-heading">
    <div class="panel-actions">
      <a href="#" class="" data-panel-toggle=""></a>
      <a href="#" class="" data-panel-dismiss=""></a>
    </div>

    <h2 class="panel-title">General Settings</h2>
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
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-condensed mb-none">
      <thead>
        <tr>
          <th>SN</th>
          <th>Variable Name</th>
          <th>Config Option</th>
          <th>Config Value</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
       <?php
       $i = 1;
       foreach($result as $row):
        echo '<tr><td>'.$i.'</td>
      <td>'.$row->variable_name.'</td>
      <td>'.$row->config_option.'</td>';
      if($row->variable_name == 'auto_activate') {
        if($row->config_value == '1')
          echo '<td>Active</td>';
        else if($row->config_value == '0')
          echo '<td>Inactive</td>';
      }else {
        echo '<td>' . $row->config_value . '</td>';
      }
      echo '<td>'.anchor('generalsettings/edit/'.$row->config_id,'<span class="glyphicon glyphicon-edit"></span>').'</td>
    </tr>';

    $i++;
    endforeach;
    ?>

  </tbody>
</table>
</div>
</div>
</section>


</section>
</div>


</section>
