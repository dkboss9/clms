<header class="card-header">

    <h4 class="card-title">
        <span class="va-middle">Joined users</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h4>
</header>
<div class="card-body">
    <div class="content">
        <table style="width: 100%;">
            <?php foreach($chat_members as $member){?>
            <tr>
                <td><?php echo $member['name'];?> (<?php echo $member['group_name'];?>)</td>
                <td><a href="javascript:void();" chatid="<?php echo $chat_id;?>" userid="<?php echo $member['userid'];?>" class="btn btn-danger link_remove_user">Remove</a></td>
            </tr>
            <?php   }   ?>

        </table>
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
                <td><?php echo $member->first_name;?> <?php echo $member->last_name;?>  (<?php echo $member->group_name;?>) </td>
                <td><a href="javascript:void();" chatid="<?php echo $chat_id;?>" userid="<?php echo $member->userid;?>"  class="btn btn-success link_invite_more">Invite</a></td>
            </tr>
            <?php   }   ?>

        </table>
    </div>
</div>