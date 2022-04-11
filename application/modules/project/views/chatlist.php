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
                                <!-- <a href="javascript:void();" href="javascript:void(0);" id="link_add_doc"  data-toggle="modal"  data-target="#addGroup"><i
                                        class="fa fa-plus"></i>Add</a> -->
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
                                        <th>Company</th>
                                        <th> </th>

                                    </tr>
                                </thead>
                                <tbody id="div_document">
                                    <?php
                                        foreach($companylist as $key => $company){
                                            $no = $key + 1;
                                            ?>
                                                <tr>
                                                <td><?php echo $no;?></td>
                                                    <td><?php echo $company->company_name?></td>
                                                    <td class="actions">
                                                    <a href="<?php echo base_url("project/notes/".$company->company_student_id)?>"><i class="fa fa-comment" aria-hidden="true"></i></a>
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
