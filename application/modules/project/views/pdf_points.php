<table style="width:100%;">
    <tr>
        <td>Sn.</td>
        <td>Enrolment Number</td>
        <td>Client</td>
        <td>Visa Type</td>
        <td>Points</td>
    </tr>

    <?php 
        foreach ($enrolls->result() as $key => $row) {
            ?>
    <tr >
        <td><?php echo $key+1;?></td>
        <td><?php echo $row->order_no;?></td>
        <td><?php echo $row->fname.' '.$row->lname;?></td>
        <td><?php echo $row->visa == 14 ? 'Education':'Migration';?></td>
        <td class="actions">
            <?php echo $row->collected_points;?>
        </td>
    </tr>
    <?php
              } ?>
</table>