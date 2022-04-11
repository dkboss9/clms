<div class="row">
  <div class="col-md-12">
    <section class="panel">

      <div class="panel-body">
       <div class="form-group">
        <label class="col-md-4 control-label" >  <h3><?php echo $result->first_name.' '.$result->last_name;?></h3></label>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Dob: </strong><?php echo $result->dob;?></label>
        <label class="col-md-4 control-label" ><strong>Passport No: </strong> <?php echo $result->passport_no;?></label>
        <label class="col-md-4 control-label" ><strong>Contact No: </strong> <?php if($result->phone != "")echo $result->phone.',';?> <?php echo $result->mobile;?></label>
      </div>

      <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Email: </strong><?php echo $result->email;?></label>
        <label class="col-md-4 control-label" ><strong>Address: </strong> <?php echo $result->address;?></label>
        <label class="col-md-4 control-label" ><strong>Gender: </strong> <?php echo $result->sex;?></label>
      </div>
      <?php 
if($result->referral != '')
  $referal = $this->usermodel->getuser($result->referral)->row();

?>
 <div class="form-group">
        <label class="col-md-4 control-label" ><strong>Referral: </strong><?php echo @$referal->first_name.' '.@$referal->last_name;?></label>
       
      </div>
<?php
?>

    </div>
  </section>
</div>
</div>
<?php
$discussions = $this->studentmodel->getnotes($result->id);
$documents = $this->studentmodel->getDoccuments($result->id);
$qualifications = $this->studentmodel->getQualifications($result->id);
$experiences = $this->studentmodel->getExperinces($result->id);

?>
<div class="row">
  <div class="col-md-12">
    <section class="panel">

      <div class="panel-body">
        <a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo ($this->uri->segment(2) == 'notes') ? 'btn-active' : 'btn-default';?>" href="<?php echo base_url("student/notes/".$result->company_student_id);?>">Notes (<?php echo count($discussions);?>)</a>
        <a class="mb-xs mt-xs mr-xs modal-basic btn  <?php echo ($this->uri->segment(2) == 'documents') ? 'btn-active' : 'btn-default';?>" href="<?php echo base_url("student/documents/".$result->company_student_id);?>">Documents (<?php echo count($documents);?>)</a>
        <a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo ($this->uri->segment(2) == 'qualifications') ? 'btn-active' : 'btn-default';?> " href="<?php echo base_url("student/qualifications/".$result->company_student_id);?>">Qualifications (<?php echo count($qualifications);?>)</a>
        <a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo ($this->uri->segment(2) == 'experiences') ? 'btn-active' : 'btn-default';?>" href="<?php echo base_url("student/experiences/".$result->company_student_id);?>">Experiences (<?php echo count($experiences);?>)</a>
        <a class="mb-xs mt-xs mr-xs modal-basic btn <?php echo ($this->uri->segment(2) == 'ielts') ? 'btn-active' : 'btn-default';?>" href="<?php echo base_url("student/ielts/".$result->company_student_id);?>">IELTS  (<?php echo $result->ielts == '1'? 'Done' : 'Not Done';?>)</a>
      </div>
    </section>
  </div>
</div>