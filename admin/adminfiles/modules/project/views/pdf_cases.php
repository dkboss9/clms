<table>
    <tr>
        <th>Sn.</th>
        <th>Enrolment Number</th>
        <th>Client</th>
        <th>Visa Type</th>
        <th>Sales Rep</th>
        <th>Grand Total</th>
        <th>Commission Rate</th>
        <th>Commission</th>
        <th>Added Date</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Lead Type</th>
        <th>Is Assigned</th>
    </tr>

    <?php 
                foreach ($enrolls->result() as $key => $row) {
                  $assign = 0;
                  $emps = $this->projectmodel->get_projectEmployee($row->project_id);
                  if(count($emps) > 0)
                    $assign = 1;
                  $sups = $this->projectmodel->get_projectSupplier($row->project_id);
                  if(count($sups) > 0)
                    $assign = 1;
                  $publish = ($row->status == 1 ? 'Published' : 'Unpublished');
                  ?>
    <tr class="gradeX">
        <td><?php echo $key+1;?></td>
        <td><?php echo $row->order_no;?></td>
        <td><?php echo $row->fname.' '.$row->lname;?></td>
        <td><?php echo $row->visa == 14 ? 'Education':'Migration';?></td>
        <td><?php echo $row->first_name.' '.$row->last_name;?></td>
        <td>$<?php echo $row->grand_total;?></td>
        <td>$<?php echo $row->commission_rate;?>%</td>
        <td>$<?php echo $row->commission;?></td>
        <td><?php echo date("d/m/Y",$row->added_date);?></td>
        <td><?php echo date("d/m/Y",$row->start_date);?></td>
        <td><?php echo date("d/m/Y",$row->end_date);?></td>
        <td><?php echo $row->type_name;?></td>
        <td><?php echo $assign == 0 ? 'Not Yet':'Done'; ?></td>
    </tr>
    <?php
              } ?>

</table>