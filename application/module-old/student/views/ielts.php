




<link rel="stylesheet" href="<?php echo base_url("assets/stylesheets/trumbowyg.min.css");?>">
<script src="<?php echo base_url("assets/javascripts/trumbowyg.js");?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#trumbowyg').trumbowyg();

  });
</script>


<?php 
if(!$this->session->userdata("clms_front_companyid") || $this->session->userdata("clms_front_companyid") == ""){
  ?>
  <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>We must tell you! </strong> Please select company to add this data.
  </div>
  <?php
}
?>
<?php if($this->session->flashdata("success_message")){?>
<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
</div>
<?php
}
?>

<?php 
$this->load->view('detail');
?>

<div class="row" id="div_task" >
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">Client : Ielts : [Edit]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form_discussion" action="<?php echo current_url();?>" method="post" enctype='multipart/form-data'>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="w4-cc">Have you completed an IELTS test in the last 2 years? </label>
            <div class="col-sm-6">
              <input type="radio" name="have_ielts" id="ielts_yes" value="1" <?php if($result->ielts == '1') echo 'checked="checked"'; ?>> Yes
              <input type="radio" name="have_ielts" id="ielts_no" value="0" <?php if($result->ielts == '0') echo 'checked="checked"'; ?>> No
            </div> 
          </div>
          <div id="div_ielts" <?php if($result->ielts == '0') echo 'style="display:none;"'; ?>>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="cc-via-online">Listening</label>
              <div class="col-sm-3">
                <input type="number" class="form-control <?php if($result->ielts == '1') echo 'required'; ?>" name="listening" id="listening" value="<?php echo $result->listening;?>" >
              </div>
              <label class="col-sm-2 control-label" for="cc-via-online">Writing</label>
              <div class="col-sm-3">
                <input type="number" class="form-control <?php if($result->ielts == '1') echo 'required'; ?>" name="writing" id="writing" value="<?php echo $result->writing;?>" >
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label" for="cc-via-online">Reading</label>
              <div class="col-sm-3">
                <input type="number" class="form-control <?php if($result->ielts == '1') echo 'required'; ?>" name="reading" id="reading" value="<?php echo $result->reading;?>">
              </div>
              <label class="col-sm-2 control-label" for="cc-via-online">Speaking</label>
              <div class="col-sm-3">
                <input type="number" class="form-control <?php if($result->ielts == '1') echo 'required'; ?>" name="speaking" id="speaking" value="<?php echo $result->speaking;?>">
              </div>
            </div>
          </div>

          <div class="form-group"> </div>

          <div class="form-group">
            <label class="col-sm-3 control-label" for="cc-via-online" style="text-align:left;">Have you completed a TOEFL? </label>
            <div class="col-sm-3">
              <input type="radio" name="have_toefl" id="toefl_yes" value="1" <?php if($result->toefl == 1) echo 'checked="checked"';?>> Yes &nbsp;&nbsp;&nbsp;
              <input type="radio" name="have_toefl" id="toefl_no" value="0" <?php if($result->toefl == 0) echo 'checked="checked"';?>> No
            </div>
            <div class="col-sm-6">
              <div id="div_toefl" <?php if($result->toefl == 0) echo 'style="display:none;"';?>>
                <label class="col-sm-5 control-label" for="cc-via-online" style="text-align:left;">Total TOEFL iBT Score? </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control number <?php if($result->toefl == 1) echo 'required';?>" name="txt_toefl" id="txt_toefl" value="<?php echo $result->toefl_score;?>" >
                </div>
              </div>
            </div>

          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a PTE? </label>
            <div class="col-sm-3">
              <input type="radio" name="have_pte" id="pte_yes" value="1" <?php if($result->pte == 1) echo 'checked="checked"';?>> Yes &nbsp;&nbsp;&nbsp;
              <input type="radio" name="have_pte" id="pte_no" value="0" <?php if($result->pte == 0) echo 'checked="checked"';?>> No
            </div>
            <div class="col-sm-6">
              <div id="div_pte" <?php if($result->pte == 0) echo 'style="display:none;"';?>>
                <label class="col-sm-5 control-label" for="txt_pte" style="text-align:left;">Total PTE Score? </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control number <?php if($result->pte == 1) echo 'required';?>" name="txt_pte" id="txt_pte" value="<?php echo $result->pte_score;?>" >
                </div>
              </div>
            </div>

          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a SAT? </label>
            <div class="col-sm-3">
              <input type="radio" name="have_sat" id="sat_yes" value="1" <?php if($result->sat == 1) echo 'checked="checked"';?>> Yes &nbsp;&nbsp;&nbsp;
              <input type="radio" name="have_sat" id="sat_no" value="0" <?php if($result->sat == 0) echo 'checked="checked"';?>> No
            </div>
            <div class="col-sm-6">
              <div id="div_sat" <?php if($result->pte == 0) echo 'style="display:none;"';?>>
                <label class="col-sm-5 control-label" for="txt_sat" style="text-align:left;">Total SAT Score? </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control number <?php if($result->sat == 1) echo 'required';?>" name="txt_sat" id="txt_sat" value="<?php echo $result->sat_score;?>" >
                </div>
              </div>
            </div>

          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a GRE? </label>
            <div class="col-sm-3">
              <input type="radio" name="have_gre" id="gre_yes" value="1" <?php if($result->gre == 1) echo 'checked="checked"';?> > Yes &nbsp;&nbsp;&nbsp;
              <input type="radio" name="have_gre" id="gre_no" value="0" <?php if($result->gre == 0) echo 'checked="checked"';?>> No
            </div>
            <div class="col-sm-6">
              <div id="div_gre" <?php if($result->gre == 0) echo 'style="display:none;"';?> >
                <label class="col-sm-5 control-label" for="txt_gre" style="text-align:left;">Total GRE Score? </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control number <?php if($result->gre == 1) echo 'required';?>" name="txt_gre" id="txt_gre" value="<?php echo $result->gre_score;?>" >
                </div>
              </div>
            </div>

          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label"  style="text-align:left;">Have you completed a GMAT? </label>
            <div class="col-sm-3">
              <input type="radio" name="have_gmat" id="gmat_yes" value="1"  <?php if($result->gmat == 1) echo 'checked="checked"';?> > Yes &nbsp;&nbsp;&nbsp;
              <input type="radio" name="have_gmat" id="gmat_no" value="0"  <?php if($result->gmat == 0) echo 'checked="checked"';?>> No
            </div>
            <div class="col-sm-6">
              <div id="div_gmat" <?php if($result->gmat == 0) echo 'style="display:none;"';?>>
                <label class="col-sm-5 control-label" for="txt_gmat" style="text-align:left;">Total GMAT Score? </label>
                <div class="col-sm-5">
                  <input type="text" class="form-control number <?php if($result->gmat == 1) echo 'required';?>" name="txt_gmat" id="txt_gmat" value="<?php echo $result->gmat_score;?>" >
                </div>
              </div>
            </div>

          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("task");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<script type="text/javascript">
  $(document).ready(function(){
    $("#toefl_yes").click(function(){
      $("#div_toefl").show();
      $("#txt_toefl").addClass("required");
    });

    $("#toefl_no").click(function(){
      $("#div_toefl").hide();
      $("#txt_toefl").removeClass("required");
    });

    $("#pte_yes").click(function(){
      $("#div_pte").show();
      $("#txt_pte").addClass("required");
    });

    $("#pte_no").click(function(){
      $("#div_pte").hide();
      $("#txt_pte").removeClass("required");
    });

    $("#sat_yes").click(function(){
      $("#div_sat").show();
      $("#txt_sat").addClass("required");
    });

    $("#sat_no").click(function(){
      $("#div_sat").hide();
      $("#txt_sat").removeClass("required");
    });

    $("#gre_yes").click(function(){
      $("#div_gre").show();
      $("#txt_gre").addClass("required");
    });

    $("#gre_no").click(function(){
      $("#div_gre").hide();
      $("#txt_gre").removeClass("required");
    });

    $("#gmat_yes").click(function(){
      $("#div_gmat").show();
      $("#txt_gmat").addClass("required");
    });

    $("#gmat_no").click(function(){
      $("#div_gmat").hide();
      $("#txt_gmat").removeClass("required");
    });


    $("#addButton").click(function(){
      $("#div_task").toggle();
    });
    $("#form_discussion").validate();
    $(".link_delete").click(function(){
      if(!confirm('Are you sure to delete this Record?'))
        return false;
    });
    $("#ielts_no").click(function(){
      $("#div_ielts").hide();
      $("#listening").removeClass("required");
      $("#writing").removeClass("required");
      $("#speaking").removeClass("required");
      $("#reading").removeClass("required");
    });

    $("#ielts_yes").click(function(){
      $("#div_ielts").show();
      $("#listening").addClass("required");
      $("#writing").addClass("required");
      $("#speaking").addClass("required");
      $("#reading").addClass("required");
    });
  });
</script>