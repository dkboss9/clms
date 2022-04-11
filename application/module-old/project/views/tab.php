<div class="row ">
    <div class="col-sm-12">
        <div class="mb-md case">
            <div class="user-detail">
                <figure>
                        <?php if($result->picture != ""){
                                ?>
  <img src="<?php echo SITE_URL."uploads/document/".$result->picture;?>" style="width:150px">
                                <?php
                        }else{ ?>
<img src="<?php echo base_url("assets/images/no_image.jpg")?>">
                      <?php
                        }
                        ?>
                        
                      
                </figure>

                <div class="user-info1">
                    <p><?php echo $result->first_name;?> <?php echo $result->last_name;?></p>
                    <p><?php echo $result->email;?></p>
                    <p><?php echo $result->mobile;?></p>
                    <p><?php echo $result->phone;?></p>
                </div>
            </div>

            <div class="reset-detail">

                <!-- <form class="reset-form">
                            <div class="form-group mb-2">
                                <input type="search" class="form-control" id="search" value=""
                                    placeholder="Search Mail">
                                <span class="btn-primary fa fa-search"></span>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2">Reset</button>
                        </form> -->
                <?php 
                            $link = $this->uri->segment(2);
                        ?>
                <div class="btn-group dash-mob">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <i
                            class="fa fa-bars" aria-hidden="true"></i> </button>
                    <ul class="dropdown-menu" role="menu">
                        <li <?php echo $link == 'dashboard'?'class="active"':'';?>><a
                                href="<?php echo base_url("project/dashboard/$student_id");?>">Dashboard</a></li>
                        <li <?php echo $link == 'profile'?'class="active"':'';?>><a
                                href="<?php echo base_url("project/profile/$student_id");?>">Profile</a></li>
                        <li <?php echo $link == 'invoice'?'class="active"':'';?>><a
                                href="<?php echo base_url("project/invoice/$student_id");?>">Invoice</a></li>
                        <li <?php echo $link == 'case' || $link == 'cases'?'class="active"':'';?>><a
                                href="<?php echo base_url("project/case/$student_id");?>">Case</a></li>
                        <li><a href="javascript:void();">Note</a></li>
                        <li><a href="javascript:void();">Email</a></li>
                        <li <?php echo $link == 'documents'?'class="active"':'';?>><a
                                href="<?php echo base_url("project/documents/$student_id");?>">Document</a></li>
                        <li <?php echo $link == 'appointments'?'class="active"':'';?>><a
                                href="<?php echo base_url("project/appointments/$student_id");?>">Appointment/Councelling</a>
                        </li>
                        <li><a href="javascript:void();">Collected Points</a></li>
                    </ul>
                </div>
                <!-- <button class="btn btn-primary add_profile"><i class="fa fa-plus"> </i> Add Profile</button> -->
               <?php
                  
                    echo $link == 'invoice' ? '<a class="btn btn-primary print" href="'.base_url("project/print_pdf/$student_id?tab=invoice&status=".$this->input->get("status")??'').'"><i class="fa fa-print"> </i> Print</a>':'';
                    echo $link == 'cases' ? '<a class="btn btn-primary print" href="'.base_url("project/print_pdf/$student_id?tab=cases").'"><i class="fa fa-print"> </i> Print</a>':'';
                    echo $link == 'notes' ? '<a class="btn btn-primary print" href="'.base_url("project/print_pdf/$student_id?tab=notes").'"><i class="fa fa-print"> </i> Print</a>':'';
                 //   echo $link == 'documents' ? '<a class="btn btn-primary print" href="'.base_url("project/print_pdf/$student_id?tab=documents").'"><i class="fa fa-print"> </i> Print</a>':'';
                    echo $link == 'appointments' ? '<a class="btn btn-primary print" href="'.base_url("project/print_pdf/$student_id?tab=appointments&appointment_date=".$this->input->get("appointment_date")??null).'"><i class="fa fa-print"> </i> Print</a>':'';
                    echo $link == 'points' ? '<a class="btn btn-primary print" href="'.base_url("project/print_pdf/$student_id?tab=points").'"><i class="fa fa-print"> </i> Print</a>':'';
               ?>
               
            </div>
        </div>
    </div>
</div>

<div class="dash-menu">
    <div class="row">
        <div class="col-sm-12">
            <div class="dash-menu-list">

                <ul class="cases-menu-pc">
                    <li <?php echo $link == 'dashboard'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/dashboard/$student_id");?>">Dashboard</a></li>
                    <li <?php echo $link == 'profile'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/profile/$student_id");?>">Profile</a></li>
                    <li <?php echo $link == 'invoice'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/invoice/$student_id");?>">Invoice</a></li>
                    <li <?php echo $link == 'case' || $link == 'cases'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/cases/$student_id");?>">Case</a></li>
                    <li <?php echo $link == 'notes'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/notes/$student_id");?>">Note</a></li>
                            <?php if($this->session->userdata("clms_front_user_group") != 14){ ?>
                    <li <?php echo $link == 'emails'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/emails/$student_id");?>">Email</a></li>
                            <?php }?>
                    <li <?php echo $link == 'documents'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/documents/$student_id");?>">Document</a></li>
                    <li <?php echo $link == 'appointments'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/appointments/$student_id");?>">Appointment/Councelling</a>
                    </li>
                    <li <?php echo $link == 'points'?'class="active"':'';?>><a
                            href="<?php echo base_url("project/points/$student_id");?>">Collected Points</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


