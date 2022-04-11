<tr>
  <td>
    <select name="doc_type[]" class="form-control doc_type student_doc_type mb-md required">
      <option value="">Select</option>
      <?php
        foreach ($doc_type as $row) {
         ?>
         <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
         <?php
       }
       ?>
    </select>
  </td>
  <td>
    <input type="file" name="document<?php echo $num;?>" class="form-control student_doc mb-md required" />
    <input type="hidden" name="file_name[]" class="file_name form-control" value="">
  </td>
  <td> <input type="text" name="description[]" class="form-control student_doc_desc mb-md"></td>
  <td>
    <a href="javascript:void(0);" class="link_remove" rel="<?php echo $num;?>"> <i class="bi bi-trash"></i></a>
  </td>
</tr>