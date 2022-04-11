
<?php if($this->session->userdata("usergroup") == 7){ ?>
<a href="<?php echo base_url("chat/chat_user/23");?>" class="btn btn-primary" style="float:right;">Chat with Admin</a>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <div class="tabs tabs-warning">


            <div class="tab-content">
                <div id="leads" class="tab-pane <?php if(!$this->input->get("tab")) echo 'active';?>">
                        <div class="row">
                            <div class="col-sm-4" style="border-right: 1px solid #dee2e6;">
                                <div class="mb-md">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <input type="search" name="txt_chat_user" id="txt_chat_user" class="form-control"
                                                placeholder="Search Messenger"> 
                                        </div>
                                        <div class="col-sm-2">
                                                <a href="javascript:void();"  class="btn btn-primary link_add_group" data-toggle="modal"  data-target="#addGroup"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                                        </div>
                                      
                                    </div>
                                    <hr>
                                    <ul class="nav nav-children li-userlist">
                                          <?php 
                                          foreach($chat_latest_messages as $cuser){ 
                                            $unseen = $this->chatmodel->get_unseen_msg($cuser->id,$this->session->userdata("clms_userid"));
                                            $members_1 = $this->chatmodel->chat_members_withuuid($cuser->uuid);
                                            $members = array_column($members_1,'name');
                                            $memberids = array_column($members_1,'userid');
                                              ?>
                                        <li class="<?php echo $cuser->uuid == @$chat->uuid ? 'active':'';?> ">
                                            <a href="<?php echo base_url("chat/messages/".$cuser->uuid);?>">
                                                <i class="fa fa-user" aria-hidden="true"
                                                    style="font-size: 18px;margin-left:0;margin-right:0;"></i>
                                                <?php echo in_array(23,$memberids) && $this->session->userdata("clms_userid") != 23 ? 'Khrouch Support' : $cuser->chat_name;?>  <?php echo $unseen->num_rows() > 0 ? '<i class="fa fa-circle" aria-hidden="true" style="float:right;"></i>' :''; ?>
                                                
                                                <?php echo  $cuser->first_name ?'<br>'.$cuser->first_name.' '.$cuser->last_name.':'. $cuser->message : "";?>
                                                <br>
                                                <?php echo implode(",",$members);?>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="mb-md">
                                    <?php if(!empty($chat)){ ?>
                                    <h3>
                                   <a href="javascript:void();" class="btn btn-primary link_edit_chat" data-toggle="modal"  data-target="#editGroup" > <i class="fa fa-pencil-square" aria-hidden="true"></i></a>
                                       <span class="chat_group_name"> 
                                           <?php echo in_array(23,$chat_member_ids)  && $this->session->userdata("clms_userid") != 23 ? "Khrouch Support" : $chat->chat_name;?>
                                        </span>
                                         <a href="javascript:void();" class="btn btn-primary link_invite" data-toggle="modal" chatid="<?php echo $chat->id;?>" data-target="#exampleModal" style="float:right;">Invite More</a></h3>
                                    <h4 class="chat_users">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <?php echo implode(',',$names); ?>
                                    </h4>
                                    <hr>
                                    <div class="wrapper-chat" id="chat_msgs">
                                        <?php 
                                            foreach($msgs as $msg){
                                                ?>
                                                <div class=" <?php echo $this->session->userdata("clms_userid") != $msg->userid ? 'tg-memessage tg-readmessage':'tg-offerermessage';?> ">
												
													<div class="tg-description">
														<p>
                                                            <?php echo $msg->message;?>
                                                            <?php if($msg->file){ ?>
                                                            <br>
                                                           <a href="<?php echo $msg->file;?>" target="_blank"> <i class="fa fa-download" aria-hidden="true"></i></a>
                                                            <?php } ?>
                                                        </p>
                                                     
														<div class="clearfix"></div>
														<time datetime="2017-08-08"><?php echo $msg->name;?>, <?php echo time_elapsed_string($msg->created_at);?></time>
														<div class="clearfix"></div>
													</div>
												</div>
                                                <?php
                                            }
                                        ?>
                                       
                                    </div>
                                    <div class="wrapper-chat-form">
                                        <form name="form_reply" id="form_reply" method="post"  action="javascript:send_message();" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control required txt_reply"
                                                        name="txt_reply" placeholder="Type Here &amp; Press Enter">
                                                </div>
                                            </div>
                                            <div class="row div-icon">
                                                <div class="col-sm-2">
                                                    <label for="file-input">
                                                        <img src="https://classibazaar.com.au/assets/images/attach.png"
                                                            class="mCS_img_loaded">
                                                    </label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <span id="filename">Submiting...</span>
                                                </div>
                                                <div class="col-sm-4">

                                                    <input id="chat_file" name="chat_file" type="hidden">
                                                    <input type="submit" value="Send" name="submit"
                                                        class="btn btn-success btn_reply">
                                                    <input id="file-input" name="file" type="file"
                                                        style="display:none;">
                                                </div>
                                            </div>

                                        </form>
                                    </div>
<?php }?>
                                </div>
                            </div>
                        </div>
                   

                </div>

            </div>
        </div>
    </div>

</div>

</section>
</div>
</section>
<!-- Invite member popup -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
   
      <div class="modal-body">
       
      </div>
 
    </div>
  </div>
</div>

<!-- Add Group Popup -->
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New chat group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo base_url("chat/create_group");?>" method="post" id="form-addgroup">
      <div class="modal-body-addgroup">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create Group</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Group Popup -->
<div class="modal fade" id="editGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit chat group</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="javascript:editGroup()" method="post" id="form-editgroup">
      <div class="modal-body-editgroup">
        <div class="form-body">
                <div class="content">
                    <div class="row">
                    <div class="col-sm-3">
                        Group Name:
                    </div>
                        <div class="col-sm-9">
                            <input type="text" class="form-control required" name="e_group_name" id="e_group_name" value="<?php echo @$chat->chat_name;?>"
                                placeholder="Type Here &amp; Press Enter">
                                <input type="hidden" name="e_chat_id" id="e_chat_id" value="<?php echo @$chat->id?>">
                        </div>
                    </div>


                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Edit Group</button>
      </div>
      </form>
    </div>
  </div>
</div>

						<script>
                   
							$(document).ready(function(){ 
								var chat_id = '<?php echo @$chat->id;?>';
								$('#file-input').on( 'change', function() {
									myfile= $( this ).val();
									var ext = myfile.split('.').pop();
									$('#filename').html('<img src="<?php echo base_url("assets/images/ajax-loader.gif");?>">'); 
									if(ext=="pdf" || ext=="docx" || ext=="doc" || ext=="gif" || ext=="jpg" || ext=="png"){
										var file_data = $(this).prop('files')[0];
										var uploaded_file = file_data.name;
										var form_data = new FormData();
										form_data.append('file', file_data);

										$.ajax({
											url: '<?php echo base_url("chat/upload_file");?>', 
											dataType: 'text', 
											cache: false,
											contentType: false,
											processData: false,
											data: form_data,
											type: 'post',
											success: function (response) { 
												$("#filename").html(uploaded_file);
												$("#chat_file").val(response);
                                                $("#filename").show();
											},
											error: function (response) {
												$('#filename').html(response); 
											}
										});
									} else{
										alert(ext);
									}
								});

                                 $("#form-addgroup").validate();
                                 $("#form-editgroup").validate();

                                $(".link_invite").click(function(){
                                    var chatid = $(this).attr("chatid");

                                    $.ajax({
                                    method: "POST",
                                    url: "<?php echo base_url("chat/invite_more_form");?>",
                                    data: {
                                        chatid:chatid
                                        }
                                    })
                                    .done(function( msg ) {
                                       $(".modal-body").html(msg);
                                    });
                                });

                                $(document).on("click",".link_invite_more",function(){
                                    if(!confirm("Are you sure to invite new user?"))
                                    return false;
                                    var chat_id = $(this).attr("chatid");
                                    var userid = $(this).attr("userid");
                                    var selector = $(this);
                                    $.ajax({
                                    method: "POST",
                                    url: "<?php echo base_url("chat/invite_more_user");?>",
                                    data: {
                                        chat_id:chat_id,
                                        userid:userid
                                        }
                                    })
                                    .done(function( msg ) {
                                       $(".chat_users").html(msg);
                                       selector.html("Invited");
                                    });
                                });

                                $(document).on("click",".link_remove_user",function(){
                                    if(!confirm("Are you sure to remove this user?"))
                                    return false;
                                    var chat_id = $(this).attr("chatid");
                                    var userid = $(this).attr("userid");
                                    var selector = $(this);
                                    $.ajax({
                                    method: "POST",
                                    url: "<?php echo base_url("chat/remove_more_user");?>",
                                    data: {
                                        chat_id:chat_id,
                                        userid:userid
                                        }
                                    })
                                    .done(function( msg ) {
                                       $(".chat_users").html(msg);
                                       selector.parent().parent().remove();
                                    });
                                });

                                $(document).on("click",".link_add_group",function(){
                                    $.ajax({
                                    method: "POST",
                                    url: "<?php echo base_url("chat/add_chat_group_form");?>",
                                    data: {
                                        chatid:''
                                        }
                                    })
                                    .done(function( msg ) {
                                       $(".modal-body-addgroup").html(msg);
                                    });
                                });

                                $(document).on("click","#txt_chat_user",function(){
                                    $(".li-userlist").html("");
                                });

                                $(document).on("keyup","#txt_chat_user",function(){
                                   var keyword = $(this).val();

                                   $.ajax({
                                    method: "POST",
                                    url: "<?php echo base_url("chat/search_group");?>",
                                    data: {
                                        keyword:keyword
                                        }
                                    })
                                    .done(function( msg ) {
                                        $(".li-userlist").html(msg);
                                    });
                                });

                                var page_number = 1;
				                var has_next_page = true;
                           
                                $('#chat_msgs').scroll(function() {
                                    var pos = $('#chat_msgs').scrollTop();
                                    if (pos == 0) {
                                        page_number = page_number+1;
                                        $.ajax({
                                            url: '<?php echo base_url("chat/get_more_chatmsg");?>',
                                            type: "GET",
                                            data: {
                                                page : page_number,
                                                chatid : '<?php echo @$chat->id;?>'
                                            },
                                            success: function(data) { 
                                                var response = JSON.parse(data);
                                                $("#chat_msgs").prepend(response.notifications);
                                                has_next_page = response.has_next_page;
                                            }        
                                        });
                                    }
                                });
							
							});
						</script>

<script language="javascript" type="text/javascript">  
	//create a new WebSocket object.
	var msgBox = $('#chat_msgs');
	//var wsUri = 'wss://websocket.classibazaar.com.au/wss'; 	
	var wsUri = '<?php echo $this->config->item("wsUri");?>'; 	
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) { // connection is open 
		// msgBox.append('<div class="system_msg" style="color:#bbbbbb">Welcome to my "Demo WebSocket Chat box"!</div>'); //notify user
	}
	// Message received from server
	websocket.onmessage = function(ev) {
		var response 		= JSON.parse(ev.data); //PHP sends Json data
		
		var res_type 		= response.type; //message type
		var user_message 	= response.message; //message text
		var user_name 		= response.name; //user name
		var user_color 		= response.color; //color
		var chatfile = response.chatfile;
		var profilePic = response.profilePic;

		var userid = response.userid;
		var sessionid = '<?php echo $this->session->userdata("clms_userid");?>';
		//if(userid == sessionid)
        var user_ids = JSON.parse(response.userid);

        console.log(user_ids,sessionid);
      
        if(!user_ids.includes(sessionid))
        var msg_class='tg-offerermessage';
        else
        var msg_class='tg-memessage tg-readmessage';

		var chatmsg = '<div class="'+msg_class+'">'+
											'<div class="tg-description"><p>' + user_message+'<br>';
											if(chatfile != "")
											chatmsg = chatmsg + '<a class="download_cv" href="'+chatfile+'" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>';
												
											chatmsg = chatmsg + '</p><div class="clearfix"></div>'+
												'<time datetime="2017-08-08">'+response.name+', Just now</time>'+
												'<div class="clearfix"></div>'
											'</div>'
										'</div>';

		
		switch(res_type){
			case 'usermsg_clms<?php echo @$chat->id;?>':
				msgBox.append(chatmsg);
				break;
			case 'system':
				//msgBox.append('<div style="color:#bbbbbb">' + user_message + '</div>');
				break;
		}
		msgBox[0].scrollTop = msgBox[0].scrollHeight; //scroll message 

	};
	
	websocket.onerror	= function(ev){ msgBox.append('<div class="system_error">Error Occurred - ' + ev.data + '</div>'); }; 
	websocket.onclose 	= function(ev){ msgBox.append('<div class="system_msg">Connection Closed</div>'); }; 

	//Message send button
	// $('.btn_reply').click(function(){
	// 	send_message();
	// });
	
	//User hits enter key 
	// $( "#form_reply" ).on( "keydown", function( event ) {
	//   if(event.which==13){
	// 	  send_message();
	//   }
	// });
	
	//Send message
	function send_message(){ 
		var message_input = $('.txt_reply'); //user message text
		// var name_input = $('#name'); //user name
		if(message_input.val() == ""){ //emtpy message?
			alert("Enter Some message Please!");
			return;
		}

		$("#filename").html("Submiting...");

				$.ajax({
						method: "POST",
						url: "<?php echo base_url("chat/add_newChatMsg");?>",
						data: {
							chatfile:$("#chat_file").val(), 
							txt_reply: message_input.val(),
							chat_id:'<?php echo @$chat->id;?>',
							post_id:''
							}
						})
						.done(function( msg ) {
							var msg = {
								message: message_input.val(),
								chatfile: $("#chat_file").val(),
								userid: '<?php echo json_encode(array_values($chat_member_ids));?>',
								name: '<?php echo $this->session->userdata("username");?>',
								type: "usermsg_clms<?php echo @$chat->id;?>",
								color : 'usermsg_clms',
								profilePic : ''
							};
						
							//convert and send data to server
							websocket.send(JSON.stringify(msg));	
							$("#filename").html("");
							$("#chat_file").val("");
							message_input.val(''); //reset message input
						});

	
	}

    function editGroup(){
                        var group_name = $("#e_group_name").val();
                        var chatid = $("#e_chat_id").val();        

                        $.ajax({
                                    method: "POST",
                                    url: "<?php echo base_url("chat/edit_chat");?>",
                                    data: {
                                        chatid:chatid,
                                        group_name:group_name
                                        }
                                    })
                                    .done(function( msg ) {
                                       $(".chat_group_name").html(group_name);
                                       $('#editGroup').modal('hide');
                                    });
                            }

                          
</script>