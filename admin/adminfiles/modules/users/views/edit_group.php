<input type="hidden" name="groupid" id="user_groupid" value="<?php echo $groupid;?>" />
<table border="0" class="table">
<tr>
    <td><label>Parent Group</label></td>
    <td>
      <select name="parent_group" id="parent_group_edit" class="form-control">
        <option></option>
        <?php
          foreach($parents as $parent){
            ?>
            <option value="<?php echo $parent->groupid; ?>" <?php echo $parent->groupid == $parent_id ? 'selected' : ''; ?>><?php echo $parent->group_name; ?></option>
            <?php
          }
          ?>
      </select>
    </td>
  </tr>
  <tr>
    <td><label>Group Name:</label></td>
    <td><input type="text" name="groupname" class="form-control" id="usergroupname" value="<?php echo $gname;?>"></td>
  </tr>
  <tr>
      <td><label>Allow all Data</label></td>
      <td><input type="checkbox" value="1" name="all_data_edit" id="all_data_edit" <?php echo $all_data == 1?'checked':'';?>></td>
  </tr>
</table>
