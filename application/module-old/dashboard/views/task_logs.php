

<div id="custom-content" class="white-popup-block white-popup-block-md">

<h4 class="panel-title">
    Todo Task's Logs
</h4>
<hr>
<div class="form-group">
    <table width="100%">
        
        <thead>
            <tr>
                <th>Sn.</th>
                <th>Action</th>
                <th>Action By</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs->result() as $key => $row) {
                ?>
                <tr>
                    <td><?php echo ++$key;?></td>
                    <td><?php echo $row->action;?></td>
                    <td><?php echo $row->first_name.' '.$row->last_name;?></td>
                    <td><?php echo date("d-m-Y", strtotime($row->actioned_date));?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>

</div>

<script src="<?php echo base_url();?>assets/javascripts/theme.init.js"></script>


