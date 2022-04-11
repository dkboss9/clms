

<section role="main" class="content-body">
 <header class="page-header">
  <h2>Effective Lead Management System</h2>
<!--
    <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
        <li>
          <a href="index.html">
            <i class="fa fa-home"></i>
          </a>
        </li>
        <li><span>Tables</span></li>
        <li><span>Advanced</span></li>
      </ol>

      <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
    </div>
  -->
</header>

<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Company : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form id="form" method="post" action="<?php echo base_url("company/edit");?>" enctype="multipart/form-data">

          <div class="form-group">
            <label class="col-md-3 control-label" for="fname">First Name</label>
            <div class="col-md-6">
             <input type="text" name="fname" id="fname" value="<?php echo $result->first_name;?>" class="form-control" required />
             <input type="hidden" name="role" id="role" value="3">
           </div>
         </div>

         <div class="form-group">
           <label class="col-md-3 control-label" for="lname">Last Name</label>
           <div class="col-md-6">
            <input type="text" name="lname" id="lname" value="<?php echo $result->last_name;?>" class="form-control" required />
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-3 control-label">Email</label>
          <div class="col-md-6">
           <input type="email" name="email" id="email" value="<?php echo $result->email;?>" class="form-control"  required/>
           <?php echo form_error("email");?>
         </div>
       </div>

       <div class="form-group">
        <label class="col-md-3 control-label">Company Name</label>
        <div class="col-md-6">
          <input type="text" name="company" id="company" value="<?php echo $result->company_name;?>" class="form-control"  required/>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-3 control-label">Address</label>
        <div class="col-md-6">
          <input type="text" name="address" id="address" value="<?php echo $result->address;?>" class="form-control"  required/>
        </div>
      </div>


      <div class="form-group">
        <label class="col-md-3 control-label">Phone</label>
        <div class="col-md-6">
         <input type="text" name="phone" id="phone" value="<?php echo $result->phone;?>" class="form-control" />
       </div>
     </div>
     <div class="form-group">
       <label class="col-md-3 control-label" for="cart_image">Logo</label>
       <div class="col-md-6">
        <?php if($result->thumbnail != "" && file_exists("../assets/uploads/users/thumb/".$result->thumbnail)) echo '<img src="'.SITE_URL."assets/uploads/users/thumb/".$result->thumbnail.'" width="50" height="50">';?>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-3 control-label">Replace Logo</label>
      <div class="col-md-6">
       <input type="file" name="logo" id="logo"  class="form-control" />
     </div>
   </div>

   <div class="form-group">
    <label class="col-md-3 control-label">Username</label>
    <div class="col-md-6">
     <input type="text" name="username" id="username" class="form-control" value="<?php echo $result->user_name;?>" required />
     <?php echo form_error("username");?>
   </div>
 </div>

 <div class="form-group">
  <label class="col-md-3 control-label">Password</label>
  <div class="col-md-6">
  <input type="password" name="password" id="password" class="form-control"  />
 </div>
</div>

<div class="form-group">
  <label class="col-md-3 control-label" for="inputDefault"></label>
  <div class="col-md-6">
    <input type="hidden" name="userid" value="<?php echo $result->userid;?>">
    <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
    <a href="<?php echo base_url("company");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
  </div>
</div>
</form>
</div>
</section>
</div>
</div>
<!-- end: page -->
</section>
</div>
</section>
