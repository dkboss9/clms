<script type="text/javascript">
	function edituser(){
		var role  = $("#user_role").val();
		var userid = $("#userid").val();
		var phone = $("#e_phone").val();
		var fname = $("#firstname").val();
		var lname = $("#lastname").val();	
		var email = $("#useremail").val();
		var user  = $("#user_name").val();
		var pass  = $("#user_password").val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>users/edit",
			data: "userid="+userid+"&fname="+fname+"&lname="+lname+"&username="+user+"&password="+pass+"&phone="+phone+"&email="+email+"&role="+role+"&action=update",
			success: function (msg) {
				if(msg=='yes'){
					$(".success-message").show();
					$(".success-message").html('User edited successfully');
					$(".success-message").delay(5000).slideUp('slow',function(){
						$(".success-message").html('');
					});
				}else{
					$(".error-message").show();
					$(".error-message").html(msg);
					$(".error-message").delay(5000).slideUp('slow',function(){
						$(".error-message").html('');
					});
					
				}
			}
		});
	}	
</script>
<div class="modal-dialog" style="width:500px;">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="myModalLabel">Edit User Details</h4>
    </div>
    <form name="edituser" id="edituserform" action="javascript:edituser();">
      <input type="hidden" name="userid" id="userid" value="<?php echo $users['userid'];?>" />
      <div class="modal-body">
        <div>
          <div class="clearBoth"></div>
          <div style="margin-top: 12px;">
            <div class="col-md-12">
              <div class="error-message" id="error-message"></div>
              <div class="success-message" id="success-message"></div>
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td width="40%"><label> Aministrator Role* </label></td>
                  <td width="60%"><select name="group" id="user_role" class="form-control" <?php if($users['username']=='admin') echo 'disabled="disabled"';?> required>
                      <option value="">--Select Role--</option>
                      <?php if(isset($group)) echo $group;?>
                    </select></td>
                </tr>
                <tr>
                  <td><label> First Name* </label></td>
                  <td><input type="text" name="fname" id="firstname" value="<?php echo $users['fname'];?>"  class="form-control" required/></td>
                </tr>
                <tr>
                  <td><label> Last Name* </label></td>
                  <td><input type="text" name="lname" id="lastname" value="<?php echo $users['lname'];?>"  class="form-control" required /></td>
                </tr>
                <tr>
                  <td><label> Email* </label></td>
                  <td><input type="email" name="email" id="useremail" value="<?php if(isset($users['email'])) echo $users['email'];?>" class="form-control" /></td>
                </tr>
                <tr>
                  <td><label> Phone*</label></td>
                  <td><input type="text" name="e_phone" id="e_phone" value="<?php if(isset($users['phone'])) echo $users['phone'];?>"  class="form-control" required /></td>
                </tr>
                <tr>
                  <td><label>Username*</label></td>
                  <td><input type="text" name="username" id="user_name" value="<?php echo $users['username'];?>" class="form-control" <?php if($users['username']=='admin') echo 'readonly="readonly"';?> required /></td>
                </tr>
                <tr>
                  <td><label>Password</label></td>
                  <td><input type="password" name="password"  class="form-control" id="user_password" /></td>
                </tr>
              </table>
            </div>
            <div class="clearBoth"></div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="submit" name="save" value="Save Details" class="btn btn-primary" />
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
    <!-- /.modal-content --> 
  </div>
  <!-- /.modal-dialog --> 
</div>
