<style type="text/css">
	.modal-footer {
		padding: 15px;
		text-align: right;
		border-top: 1px solid #e5e5e5;
		margin-top: 400px;
	}
	table {
		border-collapse: collapse;
	}

	td {
		padding-top: .5em;
		padding-bottom: .5em;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
	
		$('#edituser').on('hidden.bs.modal', function (e) {
			location.reload();
		});   
		$(".editIcon").click(function(){
			var id = $(this).attr('id');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>index.php/users/edit",
				data: "userid="+id+"&action=edit",
				success: function (msg) {
					if(msg!='no'){
						$("#content").html(msg);
						$("#edituser").modal('show');
					}else{
						$("#content").html("Error! while retrieving data");
						$("#edituser").modal('show');
					}}
				});
		});
		$(".deleteIcon").click(function(){
			var myid = $(this).attr('id');
			$.ajax({
				type  : "POST",
				url   : "<?php echo base_url();?>index.php/users/delete",
				data  : "userid="+myid+"&action=delete",
				success :function(msg){
					if(msg=='yes'){
						$("#row_"+myid).remove();
						$(".success-message").show();
						$(".success-message").html("User deleted successfully");
						$(".success-message").delay(5000).slideUp('slow',function(){
							$(".success-message").html('');
						})  
					}else{
						$(".error-message").show();
						$(".error-message").html("Error ! while deleting data");
						$(".error-message").delay(5000).slideUp('slow',function(){
							$(".error-message").html('');
						});
					}
				}

			});
		})
	
		
</script>

	<!-- start: page -->
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="" data-panel-toggle></a>
				<a href="#" class="" data-panel-dismiss></a>
			</div>

			<h2 class="panel-title">Users List</h2>
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
			<div class="row">
				<div class="col-sm-6">
					<div class="mb-md">
						<h2>Users List
							<!-- <a href data-toggle="modal" title="Add New User" type="button" class="btn btn-primary" data-target="#ammendment"> Add <i class="fa fa-plus"></i> </a>  -->
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> More <span class="caret"></span> </button>
								<ul class="dropdown-menu" role="menu">
									<!-- <li><a onclick="cascade('delete');">Delete Marked</a></li> -->
									<li><a onclick="cascade('publish');">Mark as Published
</a></li>
									<li><a onclick="cascade('unpublish');">Mark as Unpublished
</a></li>
								</ul>
							</div>
						</h2>
					</div>
				</div>
			</div>
			<table class="table table-bordered table-striped mb-none" id="datatable-default1">
				<thead>
					<tr>
						<th width="2%"><input type="checkbox" name="all" id="checkall" ></th>
						<th>#</th>
						<th>Full Name</th>
						<th>Phone</th>
						<th>Email</th>
						<th class="hidden-phone">Admin Role</th>
						<th class="sorting_disabled" rowspan="1" colspan="1" aria-label="Actions" style="width: 99px;">Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user) {
						$publish = ($user->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
						?>
						<tr class="gradeX">
							<td><input type="checkbox" class="checkone" value="<?php echo $user->userid;?>" /></td>
							<td><?php echo $user->userid;?></td>
							<td><a class="simple-ajax-popup btn-default"   href="<?php echo base_url("users/assign_dashboard/".$user->userid);?>"><?php echo $user->first_name." ".$user->last_name; ?></a></td>
							<td><?php echo $user->phone;?></td>
							<td><?php echo $user->email;?></td>
							<td class="center hidden-phone"><?php echo $user->group_name;?></td>
							<td class="actions">
								<?php
								if($this->session->userdata("usergroup") == 1){
									?>
									<a class="simple-ajax-popup btn-default"   href="<?php echo base_url("users/assign_company/".$user->userid);?>"><i class="fa fa-support"></i></a>
									<?php
								}
								echo $publish."&nbsp;&nbsp;";
								
								if($user->user_group!='1' && $user->user_group!='2'){
									echo ' <a href="'. base_url(""). 'users/perm_modify/'. $user->user_group_company_id .'"  class=""><span class="glyphicon glyphicon-asterisk">&nbsp;</span></a>';
								}
								if($user->user_group =='1'){
									echo '<a class="icons editIcon" id="'.$user->userid.'"><span class="glyphicon glyphicon-edit">&nbsp;</span></a>';
									echo  ' <a  class="icons deleteIcon" id="'.$user->userid.'"><span class="glyphicon glyphicon-eye">&nbsp;</span></a>';
								}
								?>

							</td>
						</tr>
						<?php } ?>


					</tbody>
				</table>
			</div>
		</section>
	</section>
</div>


</section>
<script type="text/javascript">
	function cascade(action){
		var ids = checkedCheckboxId();
		var jsonData ={"object":{"ids":ids,"action":action,"field":"userid","status_field":"status","table":"users"}};
		$.ajax({
			url:"<?php echo base_url();?>index.php/users/cascadeAction",
			type:"post",
			data:jsonData,
			success: function(msg){
				location.reload();
			}
		});
	}
</script>
<div class="modal fade" id="ammendment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<script type="text/javascript">
		function addUser(){ 
			var role   = $("#role").val();
			var fname    = $("#fname").val();
			var lname    = $("#lname").val(); 
			var email    = $("#email").val();
			var phone    = $("#phone").val();
			var user     = $("#username").val();
			var pass     = $("#password").val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url();?>index.php/users/add",
				data: "fname="+fname+"&lname="+lname+"&username="+user+"&password="+pass+"&email="+email+"&phone="+phone+"&role="+role+"&action=submit",
				success: function (msg) { 
					if(msg=='yes'){
						$(".success-message").show();
						$(".success-message").html('User added successfully');
						$(".success-message").delay(4000).slideUp('slow',function(){
							$(".success-message").html('');
							location.href='<?php echo base_url();?>index.php/users/settings'; 
						});
						$("#fname").val('');  
						$("#lname").val('');  
						$("#cpassword").val('');  
						$("#email").val('');
						$("#password").val(''); 
						$("#username").val('');
						$("#phone").val('');      
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
				<h4 class="modal-title" id="myModalLabel">Add User</h4>
			</div>
			<form action="javascript:addUser()">
				<div class="modal-body">
					<div>
						<div class="clearBoth"></div>
						<div style="margin-top: 12px;">
							<div class="col-md-12">
								<div class="error-message" id="error-message"></div>
								<div class="success-message" id="success-message"></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="2">
									<tr>
										<td width="40%">User Role</td>
										<td width="60%"><select name="role" id="role" class="form-control" >
											<option value="">Choose Role</option>
											<?php if(isset($group)) echo $group;?>
										</select></td>
									</tr>
									<tr>
										<td>First Name</td>
										<td><input type="text" name="fname" id="fname" class="form-control" required /></td>
									</tr>
									<tr>
										<td>Last Name</td>
										<td><input type="text" name="lname" id="lname" class="form-control" required /></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><input type="email" name="email" id="email" class="form-control"  required/></td>
									</tr>
									<tr>
										<td>Phone</td>
										<td><input type="text" name="phone" id="phone" class="form-control" /></td>
									</tr>
									<tr>
										<td>Username</td>
										<td><input type="text" name="username" id="username" class="form-control" required /></td>
									</tr>
									<tr>
										<td>Password</td>
										<td><input type="password" name="password" id="password" class="form-control" required /></td>
									</tr>
									<tr>
										<td>Confirm Password</td>
										<td><input type="password" name="confirm_password" id="confirm_password" class="form-control" required /></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
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
	<!-- /.modal --> 
</div>
<div class="modal fade" id="edituser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div id="content"> </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

		$('#datatable-default1').DataTable( {
        "order": [[ 1, "desc" ]]
    } );

		var password = document.getElementById("password")
	, confirm_password = document.getElementById("confirm_password");

	function validatePassword(){
	if(password.value != confirm_password.value) {
		confirm_password.setCustomValidity("Passwords Don't Match");
	} else {
		confirm_password.setCustomValidity('');
	}
	}

	password.onchange = validatePassword;
	confirm_password.onkeyup = validatePassword;
	});

	function cascade(action){
		if(!confirm("Are you sure to perform this action?"))
			return false;
			
		var ids = checkedCheckboxId();
		if(ids.length == 0){
			alert("Select atleast one data to proceed this action");
			return false;
		}
		var jsonData ={"object":{"ids":ids,"action":action,"field":"userid","status_field":"status","table":"users"}};
		$.ajax({
			url:"<?php echo base_url();?>users/cascadeAction",
			type:"post",
			data:jsonData,
			success: function(msg){
				location.reload();
			}
		});
	}
</script>