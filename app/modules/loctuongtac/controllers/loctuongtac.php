<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class loctuongtac extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		permission_view();
	}

    private $unfriends;
	public function index(){
		$data = array(
			"accounts" => $this->model->fetch("*", FACEBOOK_ACCOUNTS, "status = 1".getDatabyUser())
		);
		$this->template->title(l('Lọc Tương Tác'));
		$this->template->build('index', $data);
	}

	public function ajax_search_group(){
		$account = $this->model->get("*", FACEBOOK_ACCOUNTS, "status = 1 AND id = '".post("account")."'".getDatabyUser());
	    $data_userlikes1 = array ();
	    $array_friends = array ();
		
		if(empty($account)){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Facebook account not exist')
			));
		}

		if(post('keyword') == ""){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Vui lòng thêm số bài viết')
			));
		}

		$limit = post("keyword");
        $access_token = $account->access_token;

        // get post in user feed
	    $get_post = file_get_contents_curl("https://graph.facebook.com/me/feed?fields=id&limit=".$limit."&access_token=".$access_token);
       
	    // get user like post
	    foreach ($get_post->data as $key22=>$row22){
            $get_userlike = file_get_contents_curl("https://graph.facebook.com/v1.0/".$row22->id."/likes?access_token=".$access_token);
	        foreach  ($get_userlike->data as $key1=>$row1){
	            
	        // user id to array     
	        array_push($data_userlikes1,$row1->id);

	     }
	    }
	    
	     $data_userlikes1 = array_unique($data_userlikes1);
	      //select friend to array
	      
	    $friends   = $this->model->fetch("*", FACEBOOK_GROUPS,  "status = 1 AND account_id = {$account->id} AND type = 'friend'");
	      foreach ($friends as $row4){
	         
	         $iii = 0;
	         foreach ($data_userlikes1 as $row5){
	             if ($row4->pid == $row5){
	                 $iii = 1;
	             }
	         }
	         if($iii == 0){
	                array_push($array_friends,$row4);
	         }  
	         if(count($array_friends)==post('limit'))
	         break;
	     }
	     $data = array(
			"result" => $array_friends
		);

		$this->load->view("ajax_group", $data);
	     
	  
	}
	

	public function ajax_save_schedules(){
		$data = array();
		$groups = $this->input->post('id');
		$account = $this->model->get("*", FACEBOOK_ACCOUNTS, "status = 1 AND id = '".post("account")."'".getDatabyUser());
		if(empty($account)){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Facebook account not exist')
			));
		}

		$data = array(
			"category"    => "unfriends",
			"type"        => "unfriends"
		);

		if(post('time_post') == ""){
			$json[] = array(
				"st"    => "valid",
				"label" => "bg-red",
				"text"  => l('Time post is required')
			);
		}

		if(empty($groups)){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Select at least a group')
			));
		}

		if(post('auto_repeat') != 0){
			$data["repeat_post"] = 1;
			$data["repeat_time"] = (int)post("auto_repeat");
			$data["repeat_end"]  = date("Y-m-d", strtotime(post('repeat_end')));
		}else{
			$data["repeat_post"] = 0;
		}

		$count = 0;
		$deplay = (int)post('deplay')*60;
		$list_deplay = array();
		for ($i=0; $i < count($groups); $i++) { 
			$list_deplay[] = $deplay*$i;
		}

		$auto_pause = (int)post('auto_pause');
		if($auto_pause != 0){
			$pause = 0;
			$count_deplay = 0;
			for ($i=0; $i < count($list_deplay); $i++) { 
				$item_deplay = 1;
				if($auto_pause == $count_deplay){
					$pause += post('time_pause')*60;
					$count_deplay = 0;
				}

				$list_deplay[$i] += $pause;
				$count_deplay++;
			}
		}

		shuffle($list_deplay);

		$time_post_show = strtotime(post('time_post').":00");
		$time_now  = strtotime(NOW) + 60;
		if($time_post_show < $time_now){
			$time_post_show = $time_now;
		}

		$date = new DateTime(date("Y-m-d H:i:s", $time_post_show), new DateTimeZone(TIMEZONE_USER));
		$date->setTimezone(new DateTimeZone(TIMEZONE_USER));
		$time_post = $date->format('Y-m-d H:i:s');

		foreach ($groups as $key => $group) {
			$group  = explode("{-}", $group);
			if(count($group) == 4){
				$data["uid"]            = session("uid");
				$data["group_type"]     = $group[0];
				$data["account_id"]     = $account->id;
				$data["account_name"]   = $account->username;
				$data["group_id"]       = $group[1];
				$data["name"]           = $group[2];
				$data["privacy"]        = $group[3];
				$rand = (rand(100,600));
				$data["time_post"]      = date("Y-m-d H:i:s", strtotime($time_post) + $list_deplay[$key] + $rand);
				$data["time_post_show"] = date("Y-m-d H:i:s", $time_post_show + $list_deplay[$key]+ $rand);
				$data["status"]         = 1;
				$data["deplay"]         = $deplay;
				$data["changed"]        = NOW;
				$data["created"]        = NOW;

				$this->db->insert(FACEBOOK_SCHEDULES, $data);
		//        print_r ($data);
				$count++;
			}
		}
        
        
        
		if($count != 0){
			ms(array(
				"st"    => "success",
				"label" => "bg-green",
				"txt"   => l('Successfully')
			));
		}else{
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('The error occurred during processing')
			));
		}
	}
}