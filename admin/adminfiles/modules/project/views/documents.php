<!-- start: page -->
<section class="panel">
    <div class="panel-body case-body">
    <?php if($this->session->flashdata("success_message")){?>
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Well done!</strong> <?php echo $this->session->flashdata("success_message"); ?> 
      </div>
      <?php
    }
    ?>
        <?php $this->load->view("tab");?>
        <div class="migrate-menu">
            <div class="row">
                <div class="col-sm-12">
                    <div class="migrate-menu-list">
                        <div class="mig-top-sec">
                            <h4 class="mitgrate-tt">Documents</h4>
                            <div class="adding">
                            <a href="javascript:void();" href="javascript:void(0);" id="link_add_doc"><i class="fa fa-plus"></i>Add</a>
                                <!-- 
                                <a href="javascript:void();"><i class="fa fa-edit"></i>Edit</a> -->
                            </div>
                        </div>

                    </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                    </div>
                    <form id="form" method="post" action="<?php echo base_url("project/documents/$student_id");?>"
                            enctype="multipart/form-data" class="form-horizontal" novalidate="novalidate">
                    <div id="w4-profile" class="tab-pane">

                        <?php
                        $documents = $this->studentmodel->getDoccuments($student_id);
                        ?>
<div class="table-responsive">
                        <table class="table table-bordered table-striped mb-none" id="">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Document </th>
                                    <th>Description</th>
                                    <th> </th>

                                </tr>
                            </thead>
                            <tbody id="div_document">
                                <?php 
                                $i = 1;
                                foreach ($documents as $docs) {
                                ?>
                                <tr>
                                    <td>
                                        <?php 
                                        foreach ($doc_type as $row) {
                                        ?>
                                        <?php if($row->type_id == $docs->doc_type) echo $row->type_name;?>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td> <a href="<?php echo SITE_URL."uploads/student_documents/".$docs->doc_name; ?>"
                                            target="_blank"><?php echo $docs->doc_name;?></a></td>
                                    <td><?php echo $docs->doc_desc;?></td>
                                    <td>
                                        <a href="javascript:void(0);" class="link_remove" rel="<?php echo $i;?>"
                                            docid="<?php echo $docs->id;?>"><i class="fa fa-trash-o"
                                                aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
</div>
                        <div class="form-group">
                                        <div class="col-md-12 div_submit " style="text-align: right;">
                                            <br>
                                            <input type="submit" name="save" class="btn btn-primary" value="Save Documents">
                                    </div>
                                    </div>


                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

</section>
</div>


</section>

<script>
    $(document).ready(function(){
        $(".div_submit").hide();
        var num=1;
        $("#link_add_doc").click(function(){
            // var num = $(".div_row").length;
            num = num + 1;

            $.ajax({
                url: '<?php echo base_url() ?>student/get_docRow',
                type: "POST",
                data: "num=" + num,
                success: function(data) { 
                if(data != ""){
                    $("#div_document").append(data);
                    $(".div_submit").show();
                }
                }        
            });
        });

        $(document).on("click",".link_remove",function(){
        if(!confirm("Are you sure to delete this record?"))
            return false;

        if($(this).attr("docid")){
            var docid = $(this).attr("docid");
            $.ajax({
            url: '<?php echo base_url() ?>student/delete_docRow',
            type: "POST",
            data: "docid=" + docid,
            success: function(data) { 
            
            }        
            });
        }
        var id = $(this).attr("rel");
        $(this).parent().parent().remove();
        var num = $(".student_doc_type").length;
        if(num == 0)
            $(".div_submit").hide();
        });
    });
</script>