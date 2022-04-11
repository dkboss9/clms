<ul class="notifications">

    <?php
$alerts = $this->welcomemodel->getStudentNotifications();
$alert_num = $this->welcomemodel->getStudentNotifications('0');
?>
    <li>
        <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
            <i class="fa fa-user"></i>
            <span class="badge"
                id="count_notification"><?php echo $alert_num->num_rows() > 0 ? $alert_num->num_rows():'';?></span>
        </a>

        <div class="dropdown-menu notification-menu">
            <div class="notification-title">
                <span class="pull-right label label-default"><?php echo $alert_num->num_rows();?></span>
                Notifications
            </div>

            <div class="content">
                <ul>
                    <?php 
                if($alerts->num_rows()>0){
                    foreach ($alerts->result() as $alert) {
                        ?>
                    <li>
                        <a href="<?php echo base_url($alert->link);?>" class="clearfix">

                            <span class="message">
                                <?php echo $alert->content;?>
                                <br>
                                On <?php echo date("d M, Y",strtotime($alert->added_date));?>
                            </span>
                        </a>
                        <hr />
                    </li>
                    <?php
                    }}else{?>
                    <li>
                        <a href="#" class="clearfix">

                            <span class="title">No Notification Found.</span>

                        </a>
                        <hr />
                    </li>
                    <?php
                }
                ?>
                    <div class="text-right">
                        <a href="#" class="view-more">Hide</a>
                    </div>
            </div>
        </div>
    </li>

</ul>