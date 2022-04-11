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

<?php if($this->session->flashdata("error_message")){?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>Well done!</strong> <?php echo $this->session->flashdata("error_message"); ?>
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
                            <h4 class="mitgrate-tt">Document Type</h4>
                            <div class="adding">
                                <a href="javascript:void();" href="javascript:void(0);" id="link_add_doc"  data-toggle="modal"  data-target="#addGroup"><i
                                        class="fa fa-plus"></i>Add</a>
                                <!-- <a href="javascript:void();"><i class="fa fa-edit"></i>Edit</a> -->
                            </div>
                        </div>

                    </div>
                    <div>
                        <input type="hidden" name="student_id" id="student_id" value="<?php echo $student_id;?>">
                    </div>

                    <div id="w4-profile" class="tab-pane">


                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-none" id="">
                                <thead>
                                    <tr>
                                        <th>Sn.</th>
                                        <th>Document Type</th>
                                        <th> </th>

                                    </tr>
                                </thead>
                                <tbody id="div_document">
                                    <?php
                                        foreach($doc_types as $key => $type){
                                            $no = $key + 1;
                                            ?>
                                                <tr>
                                                <td><?php echo $no;?></td>
                                                    <td><?php echo $type->type_name?></td>
                                                    <td class="actions">
                                                        <a href="javascript:void(0);" typeid="<?php echo $type->type_id;?>" title="<?php echo $type->type_name;?>" class="link_edit" data-toggle="modal"  data-target="#addGroup"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> 
                                                        <a href="<?php echo base_url("project/delete_doctype/$type->type_id")?>" class="link_remove" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>



                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

</section>
</div>


</section>


<!-- Add Group Popup -->
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Docuemnt type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url("project/add_doctype");?>" method="post" id="form-add">
                <div class="modal-body-addgroup">
                    <div class="form-body" style="padding: 15px;">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-3">
                                    Title:
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" name="title" id="txt_title" class="form-control required" value="">
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="doc_typeid" id="doc_typeid" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#form-add").validate();
        $(document).on("click",".link_edit",function(){
            var typeid = $(this).attr("typeid");
            var title = $(this).attr("title")
            $("#txt_title").val(title);
            $("#doc_typeid").val(typeid);
        });
        $(document).on("click", ".link_remove", function () {
            if (!confirm("Are you sure to delete this record?"))
                return false;

        });
    });
</script>