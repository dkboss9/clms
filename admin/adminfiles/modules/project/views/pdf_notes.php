<table style="width: 100%;">
    <tr>
        <td>Sn.</td>
        <td>Added By</td>
        <td>Message</td>
        <td>Time</td>
    </tr>
    <?php foreach($notes as $key => $note){ ?>
           <tr>
               <td><?php echo $key + 1;?></td>
               <td><?php echo $note->first_name;?> <?php echo $note->last_name;?></td>
               <td>  <?php echo $note->comment;?></td>
               <td><?php echo date("d F, Y",strtotime($note->added_at));?> at <?php echo date("h:i a",strtotime($note->added_at));?> </td>
            </tr>
    <?php } ?>
</table>