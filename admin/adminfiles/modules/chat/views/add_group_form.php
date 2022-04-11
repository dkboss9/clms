<div class="form-body">
    <div class="content">
        <div class="row">
        <div class="col-sm-3">
            Group Name:
        </div>
            <div class="col-sm-9">
                <input type="text" class="form-control required" name="group_name"
                    placeholder="Type Here &amp; Press Enter">
            </div>
        </div>


    </div>
</div>

<header class="card-header">

    <h4 class="card-title">
        <span class="va-middle">Invite more users</span>
    </h4>
</header>
<div class="card-body">
    <div class="content div_more_user">
        <table style="width: 100%;">
            <?php foreach($non_chat_members as $member){?>
            <tr>
                <td><?php echo $member->first_name;?> <?php echo $member->last_name;?>
                    (<?php echo $member->group_name;?>) </td>
                <td><input type="checkbox" value="<?php echo $member->userid;?>" name="chat_users[]" class="chat_users"></td>
            </tr>
            <?php   }   ?>

        </table>
    </div>
</div>