<?php 
if(!$this->session->userdata("clms_company") || $this->session->userdata("clms_company") == ""){
  ?>
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <strong>We must tell you! </strong> Please select company to add this data.
</div>
<?php
}
?>
<!-- start: page -->
<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="" data-panel-toggle></a>
          <a href="#" class="" data-panel-dismiss></a>
        </div>

        <h2 class="panel-title">course fee : [New]</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" id="form" action="<?php echo base_url("course_fee/add");?>"
          method="post" enctype='multipart/form-data'>
          <div class="form-group">
            <label class="col-md-3 control-label" for="country">Country</label>
            <div class="col-md-6">
              <select class="form-control required" data-plugin-selectTwo name="country" id="country">
                <option value="">Select</option>
                <?php
              foreach ($countries as $row) {
               ?>
                <option value="<?php echo $row->country_id;?>"><?php echo $row->country_name;?></option>
                <?php
             }
             ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="intake">Intake</label>
            <div class="col-md-6">
              <select class="form-control required" data-plugin-selectTwo name="intake" id="intake">
                <option value="">Select</option>
                <?php
            foreach ($intakes as $row) {
             ?>
                <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                <?php
           }
           ?>
              </select>
            </div>
            <div class="col-md-3">
              <a href="javascript:void(0);" id="link_intake"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">College</label>
            <div class="col-md-6">
              <select class="form-control required" data-plugin-selectTwo name="college" id="college">
                <option value="">Select</option>
                <?php
        foreach ($colleges as $row) {
         ?>
                <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                <?php
       }
       ?>
              </select>
            </div>
            <div class="col-md-3">
              <a href="javascript:void(0);" id="link_college"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Degree</label>
            <div class="col-md-6">
              <select class="form-control required" data-plugin-selectTwo name="degree" id="degree">
                <option value="">Select</option>
                <?php
      foreach ($degree as $row) {
       ?>
                <option value="<?php echo $row->type_id;?>"><?php echo $row->type_name;?></option>
                <?php
     }
     ?>
              </select>
            </div>
            <div class="col-md-3">
              <a href="javascript:void(0);" id="link_degree"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Course</label>
            <div class="col-md-6">
              <select class="form-control required" data-plugin-selectTwo name="course" id="course">
                <option value="">Select</option>
              </select>
            </div>
            <div class="col-md-3">
              <a href="javascript:void(0);" id="link_course"><i class="glyphicon glyphicon-plus"></i></a>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Currency</label>
            <div class="col-md-6">
              <select class="form-control required" data-plugin-selectTwo name="currency" id="currency">
                <option value="">Select</option>
                <?php 
    foreach ($currencies as $row) {
     ?>
                <option value="<?php echo $row->currency_code;?>"
                  <?php if($row->currency_code == 'AUD') echo 'selected="selected"';?>><?php echo $row->currency_code;?>
                </option>
                <?php
   }
   ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Semester Fee</label>
            <div class="col-md-6">
              <input type="number" name="fee" class="form-control required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Tri-semester Fee</label>
            <div class="col-md-6">
              <input type="number" name="tri_fee" class="form-control required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Yearly Fee</label>
            <div class="col-md-6">
              <input type="number" name="y_fee" class="form-control required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Total Fee</label>
            <div class="col-md-6">
              <input type="number" name="t_fee" class="form-control required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Duration</label>
            <div class="col-md-6">
              <input type="radio" name="duration" class="required" value="Semester"> Semester &nbsp; &nbsp; &nbsp;
              <input type="radio" name="duration" class="required" value="Tri-semester">Tri-semester &nbsp; &nbsp;
              &nbsp;
              <input type="radio" name="duration" class="required" value="Yearly"> Yearly &nbsp; &nbsp; &nbsp;
              <input type="radio" name="duration" class="required" value="Total"> Total
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-3">
              <table class="table table-bordered table-striped mb-none">
                <tr>
                  <th><input type="checkbox" id="chk_all_list"></th>
                  <th>Offer letter checklist</th>
                </tr>
                <tbody>
                  <?php 
      foreach ($checklist->result() as $row) {
       ?>
                  <tr>
                    <td><input type="checkbox" class="chk_list" name="chk_list[]" value="<?php echo $row->type_id;?>">
                    </td>
                    <td> <?php echo $row->type_name;?></td>
                  </tr>
                  <?php
     }
     ?>


                </tbody>
              </table>
            </div>

            <div class="col-md-3">
              <table class="table table-bordered table-striped mb-none">
                <tr>
                  <th><input type="checkbox" id="chk_all_coe_list"></th>
                  <th>Coe processing checklist</th>
                </tr>
                <tbody>
                  <?php 
      foreach ($checklist->result() as $row) {
       ?>
                  <tr>
                    <td><input type="checkbox" class="chk_coe_list" name="chk_coe_list[]" value="<?php echo $row->type_id;?>">
                    </td>
                    <td> <?php echo $row->type_name;?></td>
                  </tr>
                  <?php
     }
     ?>


                </tbody>
              </table>
            </div>

            <div class="col-md-3">
              <table class="table table-bordered table-striped mb-none">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="chk_all_form"></th>
                    <th>Downloadable Form</th>
                    <th>Type</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
      foreach ($downloads->result() as $acc) {
       $publish = ($acc->status == 1 ? '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span>' : '<span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span>');
       ?>
                  <tr class="gradeX">
                    <td><input type="checkbox" class="chk_form" name="chk_form[]" value="<?php echo $acc->type_id;?>">
                    </td>
                    <td><a href="<?php echo SITE_URL."uploads/student_documents/".$acc->doc_name;?>"
                        target="_blank"><?php echo $acc->typename;?></a></td>
                    <td><?php echo $acc->type_name;?></td>

                  </tr>
                  <?php
     } ?>


                </tbody>
              </table>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault">Commission (%)</label>
            <div class="col-md-3">
              <input type="number" min="0" max="100" name="commision" class="form-control" id="commission" value="">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-1">
              Bonus
            </div>
            <div class="col-md-2">
              <input type="radio" name="bonus" class="radio-bonus" value="Yes"> Yes
              <input type="radio" name="bonus" class="radio-bonus" value="No" checked> No
            </div>
          </div>

          <div class="form-group">
          <div class="col-md-3"></div>
            <div class="col-md-6">
                <table class="table table-bordered table-striped mb-none tbl_bonus" style="display: none;">
                  <thead>
                    <tr>
                      <th>Enrolled per Intake</th>
                      <th>Student From</th>
                      <th>Student To</th>
                      <th>Amount</th>
                      <th><button type="button" name="btn-more" id="btn-more" class="btn btn-primary">Add more</button> </th>
                    </tr>
                  </thead>
                  <tbody id="tbody-bonus">
                   
                  </tbody>
                </table>
              </div>
          </div>

          <div class="form-group">
            <label class="col-md-3 control-label" for="inputDefault"></label>
            <div class="col-md-6">
              <input type="submit" name="submit" value="submit" class="mb-xs mt-xs mr-xs btn btn-success">
              <a href="<?php echo base_url("course_fee");?>" class="mb-xs mt-xs mr-xs btn btn-danger">Back</a>
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
<?php
$this->load->view("lms/add_purpose");
?>
<script type="text/javascript">
  $(document).ready(function () {
    $(".radio-bonus").click(function(){
      var bonus = $("input[name=bonus]:checked").val();
      //alert(bonus);
      if(bonus == 'Yes'){
        $(".tbl_bonus").show();
      }else{
        $(".tbl_bonus").hide();
      }
    });
    $("#btn-more").click(function(){
      var bonus = '<tr>\
                      <td><input type="number" min="1" name="txt_enrolled_per_intaked[]" class="form-control required"></td>\
                      <td><input type="number" min="1" name="student_from[]" class="form-control required"></td>\
                      <td><input type="number" min="1" name="student_to[]" class="form-control required"></td>\
                      <td><input type="number" min="1" name="amount[]" class="form-control required"></td>\
                      <td><a href="javascript:void();" class="link_delete"><span class="glyphicon glyphicon-trash" data-original-title="" title=""></span></a></td>\
                  </tr>';
                  $("#tbody-bonus").append(bonus);
    });

    $(document).on("click",".link_delete",function(){
      if(!confirm("Are you sure to delete this record?"))
        return false;

        $(this).parent().parent().remove();
    });
    $("#link_course").click(function () {
      var degree = $("#degree").val();
      if (degree != "") {
        var text = $("#degree option:selected").text();
        if ($("#course_degree option[value='" + degree + "']").length == 0) {
          $("#course_degree").append('<option value="' + degree + '">' + text + '</option>');
          $("#course_degree").val(degree);
        } else {
          $("#course_degree").val(degree);
        }

      }
      $("#form_course_model").modal();
    });

    $("#link_degree").click(function () {
      $("#form_degree_model").modal();
    });
    $("#link_college").click(function () {
      $("#form_college_model").modal();
    });

    $("#link_intake").click(function () {
      $("#form_intake_model").modal();
    });
    $("#degree").change(function () {
      var degree = $(this).val();
      // alert(degree);
      $.ajax({
        url: '<?php echo base_url() ?>course_fee/getCourse',
        type: "POST",
        data: "degree=" + degree,
        success: function (data) {
          if (data != "") {
            $("#course").html(data);
          }
        }
      });
    });
    $("#country").change(function () {
      var country = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>course_fee/getColleges',
        type: "POST",
        data: "country=" + country,
        success: function (data) {
          if (data != "") {
            $("#college").html(data);
          }
        }
      });
    });
    $('#chk_all_list').on('click', function () {
      $(".chk_list").prop('checked', this.checked);
    });

    $('#chk_all_coe_list').on('click', function () {
      $(".chk_coe_list").prop('checked', this.checked);
    });

    $('#chk_all_form').on('click', function () {
      $(".chk_form").prop('checked', this.checked);
    });

    $("#college").change(function () {
      var college = $(this).val();
      $.ajax({
        url: '<?php echo base_url() ?>course_fee/getDegree',
        type: "POST",
        data: "college=" + college,
        success: function (data) {
          if (data != "") {
            $("#degree").html(data);
          }
        }
      });
    });


  });
</script>