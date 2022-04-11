<?php
class chat extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->container = 'main';
        $this->load->model("chatmodel");
        $this->load->library('uuid');
    }

    function index($userid) {
        
    }

    function chat_user($userid){
        if ($this->session->userdata("clms_userid") != "") {
            $login_userid = $this->session->userdata("clms_userid");
            $user = $this->usermodel->getuser($userid);
            if($user->num_rows() == 0){
                redirect("dashboard");
            }

            $user  = $user->row();

            $result = $this->chatmodel->check_chat_userid($login_userid,$userid);

            if(empty($result)){
                $uuid = $this->uuid->v4();
                $this->db->insert("chats",[
                    "user_ids" => $login_userid."#".$userid,
                    "created_at" => date("Y-m-d H:i:s"),
                    "uuid" => $uuid
                ]);

                $chatid = $this->db->insert_id();

                $this->db->insert("chat_members",[
                    "chat_id" => $chatid,
                    "created_at" => date("Y-m-d H:i:s"),
                    "user_id" => $login_userid
                ]);

                $this->db->insert("chat_members",[
                    "chat_id" => $chatid,
                    "created_at" => date("Y-m-d H:i:s"),
                    "user_id" => $userid
                ]);
                
            }else{
                $uuid = $result->uuid;
            }

            redirect("chat/messages/$uuid");
        }else{
            redirect("login");
        }
    }

    function search_group(){
        $keyword = $this->input->post("keyword");
        $chat_users = $this->chatmodel->search_group($keyword);

        if(!empty($chat_users)){

            foreach($chat_users as $cuser){
                $members = $cuser->type == 'group' ? $this->chatmodel->chat_members_withuuid($cuser->id) : [];
                $members = array_column($members,'name');
                $link = $cuser->type != 'group' ? base_url("chat/chat_user/".$cuser->id) : base_url("chat/messages/".$cuser->id);
                ?>
                <li>
                    <a href="<?php echo $link;?>">
                        <i class="fa fa-user" aria-hidden="true"
                            style="font-size: 18px;margin-left:0;margin-right:0;"></i>
                        <?php echo $cuser->name;?> <?php echo $cuser->type != 'group' ? '('.$cuser->type.')':''; ?>
                        <?php echo !empty($members) ? '<br>'.implode(",",$members):'';?>
                    </a>
                </li>
                <?php
            }
        }else{
        ?>
        <li><?php echo 'No result found for  "'.$keyword.'"'?></li>
        <?php
        }
    }

    function get_more_chatmsg(){
        $this->load->helper("mytools");
        $chat_id = $this->input->get("chatid");
        $notification_num = $this->chatmodel->chat_messages($chat_id)->num_rows();

        $page = $this->input->get('page')?$this->input->get('page'):1;
        $offset = ($page - 1) * 5; 
        $limit = array("start" => 5, "end" => $offset);

        $total_page = $notification_num / 5;
        $has_next_page = $total_page > $page ? true : false;
        
        $msgs = $this->chatmodel->chat_messages($chat_id,$limit)->result();
        $msgs = array_reverse($msgs);
        $string = '';

        foreach($msgs as $msg){
          $class = $this->session->userdata("clms_userid") != $msg->userid ? 'tg-memessage tg-readmessage':'tg-offerermessage';
          $file = $msg->file ? ' <br><a href="'. $msg->file.'" target="_blank"> <i class="fa fa-download" aria-hidden="true"></i></a>' : '';
           $string .= '<div class="'.$class.'">
            
                <div class="tg-description">
                    <p>'.$msg->message.$file.'</p>
                    <div class="clearfix"></div>
                    <time datetime="2017-08-08">'. $msg->name.', '.time_elapsed_string($msg->created_at).'</time>
                    <div class="clearfix"></div>
                </div>
            </div>';
        
        }

        
        $data["notifications"] = $string;
        $data['has_next_page'] = $has_next_page;
        $data['current_page'] = $page;
        $data['total_number'] = $notification_num;

        echo json_encode($data);

    }

    function messages($uuid=null){
        $this->load->helper("mytools");
        if ($this->session->userdata("clms_userid") != "") {
            $login_userid = $this->session->userdata("clms_userid");
            $chat = $this->db->where("uuid",$uuid)->get("chats")->row(); 
            $data['chat_latest_messages'] = $this->chatmodel->chat_latest_messages($login_userid)->result(); 
         //   echo $this->db->last_query(); die();
            if(!empty( $data['chat_latest_messages']) && empty($chat))
            $chat = $this->db->where("uuid",$data['chat_latest_messages'][0]->uuid)->get("chats")->row(); 
               // redirect("chat/messages/".$data['chat_latest_messages'][0]->uuid);
            $data['chat_users'] = $this->usermodel->listuser();
            $data['chat'] = $chat;
            if(!empty($chat)){
            $chat_members = $this->chatmodel->chat_members($chat->id);
            $data['chat_members'] = $chat_members;
            $data['names'] = array_column($chat_members,'name');
            $data['chat_member_ids'] = array_column($chat_members,'userid');
            foreach (array_keys($data['chat_member_ids'], $this->session->userdata("clms_userid")) as $key) {
                unset($data['chat_member_ids'][$key]);
            }
            $limit = array("start" => 5, "end" => 0);
            $data['msgs'] = $this->chatmodel->chat_messages($chat->id,$limit)->result();
            $data['msgs'] = array_reverse($data['msgs']);
            $this->chatmodel->makechatseen($chat->id,$this->session->userdata("clms_userid"));
            }
            $data['page'] 			= 'chat';
            $this->load->vars($data);
            $this->load->view($this->container);
        }else{
            redirect("login");
        }
    }
    
    function invite_more_form(){
        if ($this->session->userdata("clms_userid") != "") {
            $chat_id = $this->input->post("chatid");
            $data['chat_members'] = $this->chatmodel->chat_members($chat_id);
            $chat_member_ids = array_column($data['chat_members'],"userid");
            $data['non_chat_members'] = $this->chatmodel->getNonchatMembers($chat_member_ids);
            $data['chat_id'] = $chat_id;
            $this->load->view("invite_form",$data);
        }
    }

    function invite_more_user(){
        if ($this->session->userdata("clms_userid") != "") {
            $chat_id = $this->input->post("chat_id");
            $userid = $this->input->post("userid");

           $number = $this->db->where(["chat_id" => $chat_id, "user_id" => $userid])->get("chat_members")->num_rows();

           if($number == 0){
                $this->db->insert("chat_members",[
                    "chat_id" => $chat_id,
                    "created_at" => date("Y-m-d H:i:s"),
                    "user_id" => $userid
                ]);
            }

            $chat_members = $this->chatmodel->chat_members($chat_id);
            $chat_member_ids = array_column($chat_members,"userid");

            $this->db->where("id",$chat_id)->set("user_ids",implode("#", $chat_member_ids))->update("chats");

            $chat_member_names = array_column($chat_members,"name");
            echo '<i class="fa fa-user" aria-hidden="true"></i>'. implode(",", $chat_member_names);
        }
    }

    function remove_more_user(){
        if ($this->session->userdata("clms_userid") != "") {
            $chat_id = $this->input->post("chat_id");
            $userid = $this->input->post("userid");

            $this->db->where([
                "chat_id" => $chat_id,
                "user_id" => $userid
            ])->delete("chat_members");

            $chat_members = $this->chatmodel->chat_members($chat_id);

            $chat_member_ids = array_column($chat_members,"userid");
            $this->db->where("id",$chat_id)->set("user_ids",implode(",", $chat_member_ids))->update("chats");
            $chat_member_names = array_column($chat_members,"name");

            echo '<i class="fa fa-user" aria-hidden="true"></i>'. implode(",", $chat_member_names);
        }
    }


    function upload_file(){
        $config['upload_path'] = '../assets/uploads/chats/';
        $config['allowed_types'] = '*';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['max_size'] = 0;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file')) {
            echo $this->upload->display_errors();
        } else {
            $arr_image = $this->upload->data();
            echo $imagename = SITE_URL.'assets/uploads/chats/' . $arr_image["file_name"];
           //echo $imagename = $this->custom_upload->upload_file('./assets/uploads/job_files/' . $arr_image["file_name"],'job_files/');
        }
    }

    function add_chat_group_form(){
        if ($this->session->userdata("clms_userid") != "") {
            $chat_id = $this->input->post("chatid");
            $data['non_chat_members'] = $this->chatmodel->getNonchatMembers();
            $data['chat_id'] = $chat_id;
            $this->load->view("add_group_form",$data);
        }
    }

    function add_newChatMsg(){
        if ($this->session->userdata("clms_userid")) {
            $userid = $this->session->userdata("clms_userid");
            $chat_id = $this->input->post("chat_id");
            $chatfile = $this->input->post("chatfile");
            $comment = $this->input->post("txt_reply");
           
           // die();
            $comment_arr = array(
              "message"=>$comment,
              "created_at"=>date("Y-m-d H:i:s"),
              "file"=> $chatfile,
              "user_id" => $userid,
              "chat_id"=>$chat_id
            );
           // print_r($comment);
            $this->db->insert("chat_messages",$comment_arr);
        
            $chat = $this->db->where("id",$chat_id)->get("chats")->row();

            $chat_members = $this->chatmodel->chat_members($chat->id);
          
            foreach($chat_members as $member){
                $notification = array(
                    "content" =>$this->session->userdata("username")." has add new message ".$comment,
                    "link"=>"chat/messages/".$chat->uuid,
                    "from_id" => $userid,
                    "to_id" => $member['userid'],
                    "added_date" => date("Y-m-d H:i:s")
                  );

                  $this->db->insert("pnp_company_notification",$notification);
            }
           
    }
}

function create_group(){
    if ($this->session->userdata("clms_userid")) {
        $name = $this->input->post("group_name");
        $users = $this->input->post("chat_users")? $this->input->post("chat_users"):[];
        array_push($users,$this->session->userdata("clms_userid"));
        $uuid = $this->uuid->v4();
        $this->db->insert("chats",[
            "chat_name" => $name,
            "created_at" => date("Y-m-d H:i:s"),
            "uuid" => $uuid,
            "user_ids" => implode("#",$users)
        ]);

        $chatid = $this->db->insert_id();

        foreach($users as $user){
            $this->db->insert("pnp_chat_members",[
                "chat_id"=> $chatid,
                "user_id"=> $user,
                "created_at" => date("Y-m-d H:i:s")
            ]);
        }
        redirect("chat/messages/".$uuid);
    }else{
        redirect("login");
    }
}

function edit_chat(){
    if ($this->session->userdata("clms_userid")) {
        $chat_id = $this->input->post("chatid");
        $name = $this->input->post("group_name");
        $this->db->where("id",$chat_id);
        $this->db->set("chat_name",$name);
        $this->db->update("chats");
    }else{
        redirect("login");
    }
}
    

}