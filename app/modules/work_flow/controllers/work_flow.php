<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class work_flow extends MX_Controller {

	public function __construct(){
		parent::__construct();
		// $this->load->model('Schedules_model');
		$this->load->model(get_class($this).'_model', 'model');
		$this->load->helper('form');
		permission_view();
	}
	

	public function index(){
		$data = array(
			"result"     => $this->model->getCampaign(),
			"campaign_group"       => $this->model->fetch("*", campaign_group, "status = 0"),
			"campaign" => $this->model->fetch("*", CAMPAIGN, "status = 0"),
		);
		$this->template->title(l('Work flow')); 
		$this->template->build('index', $data);
		 
	}
	
	public function schedule(){
		$data = array(
			"result"     => $this->model->getAllAccount(),
			"category_data"       => $this->model->fetch("*", category_data, "status = 1"),
			"categories" => $this->model->fetch("*", CATEGORIES, "category = 'post'".getDatabyUser()),
		);
		$this->template->title(l('Work flow schedule')); 
		$this->template->build('schedule', $data);
		 
	}

	public function manager(){
		$type = 'cal';
		$data = array(
			"result" => $this->model->getSchedules($type),
			// "result" => $this->model->get_cd_list(),
			"account"=> $this->model->fetch("*", FACEBOOK_ACCOUNTS, getDatabyUser(0))
		);
		
		$this->template->title(l('Work flow manager')); 
		$this->template->build('manager', $data);
		 
	}

	public function manager_group(){
		$data = array(
			"result" => $this->model->getCampaignGroup(),
			"account"=> $this->model->fetch("*", FACEBOOK_ACCOUNTS, getDatabyUser(0))
		);
		
		$this->template->title(l('Work flow manager group')); 
		$this->template->build('manager_group', $data);
		 
	}
	
	public function add_group_campaign(){
		$data = array(
			"result"     => $this->model->getAllAccount(),
			"category_data"       => $this->model->fetch("*", category_data, "status = 1"),
			"categories" => $this->model->fetch("*", CATEGORIES, "category = 'post'".getDatabyUser()),
		);
		$this->template->title(l('Add New Schedule Work flow')); 
		$this->template->build('add_group_campaign', $data);
	}

	public function save_group_campaign(){
		$data   = array();
		$groups = $this->input->post('id');
		
		if(post('name') == ""){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Name is required'),
			));
		}
		
		$count = 0;
		$start_date = strtotime(post('start_date').":00");
		$time_now  = strtotime(NOW) + 60;
		if($start_date < $time_now){
			$start_date = $time_now;
		}

		$end_date = strtotime(post('end_date').":00");

		$data["uid"]            = session("uid");
		$data["name"]           = post ('name');
		$data["description"]    = post ('description');
		$data["start_date"]     = date("Y-m-d H:i:s", $start_date);
		$data["end_date"]       = date("Y-m-d H:i:s", $end_date);
		$data["date_created"]        = NOW;
        
		$this->db->insert(CAMPAIGN_GROUP, $data);
		$count++;

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

	public function edit_group_campaign(){
		if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$data = array(
			"result" => $this->model->get("*", CAMPAIGN_GROUP, "id = '".get("id")."'"),
		);
		$this->template->title(l('Update campaign group'));
		$this->template->build('edit_group_campaign', $data);
	}

	public function update_group_campaign(){
		$campaign_group_id = $this->input->post('campaign_group_id');
		$data   = array();
		
		if(post('name') == ""){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Name is required'),
			));
		}
		
		$count = 0;
		$start_date = strtotime(post('start_date').":00");
		$time_now  = strtotime(NOW) + 60;
		if($start_date < $time_now){
			$start_date = $time_now;
		}

		$end_date = strtotime(post('end_date').":00");

		$data["name"]                  = post ('name');
		$data["description"]           = post ('description');
		$data["start_date"]            = date("Y-m-d H:i:s", $start_date);
		$data["end_date"]              = date("Y-m-d H:i:s", $end_date);
		
		$this->db->update(CAMPAIGN_GROUP, $data, array("id" => $campaign_group_id));

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	
	}	

	public function add_campaign(){
		$data = array(
			"groupCampaign"       => $this->model->fetch("*", campaign_group, "status = 0"),
		);
		$this->template->title(l('Add New Campaign')); 
		$this->template->build('add_campaign', $data);
	}

	public function save_campaign(){
		$data   = array();
		
		if(post('name') == ""){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Name is required'),
			));
		}
		
		$count = 0;
		$start_date = strtotime(post('start_date').":00");
		$time_now  = strtotime(NOW) + 60;
		if($start_date < $time_now){
			$start_date = $time_now;
		}

		$end_date = strtotime(post('end_date').":00");

		$data["uid"]                   = session("uid");
		$data["campaign_group_id"]     = post ('campaign_group_id');
		$data["name"]                  = post ('name');
		$data["description"]           = post ('description');
		$data["start_date"]            = date("Y-m-d H:i:s", $start_date);
		$data["end_date"]              = date("Y-m-d H:i:s", $end_date);
		$data["date_created"]          = NOW;
        
		$this->db->insert(CAMPAIGN, $data);
		$count++;

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

	public function add_new(){
		$data = array(
			"result"     => $this->model->getAllAccount(),
			"category_data"       => $this->model->fetch("*", category_data, "status = 1"),
			"categories" => $this->model->fetch("*", CATEGORIES, "category = 'post'".getDatabyUser()),
		);
		$this->template->title(l('Add New Schedule Work flow')); 
		$this->template->build('add', $data);
	}

	public function update(){
		if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$data = array(
			"event" => $this->model->get("*", FACEBOOK_SCHEDULES, "id = '".get("id")."'"),
			"result"     => $this->model->getAllAccount(),
			"category_data"       => $this->model->fetch("*", category_data, "status = 1"),
			"categories" => $this->model->fetch("*", CATEGORIES, "category = 'post'".getDatabyUser()),
		);
		$this->template->title(l('Update Schedule Work flow'));
		$this->template->build('update', $data);
	}	
    
	public function ajax_action_multiple(){
		$ids =$this->input->post('id');		

		// if(post("action") == "delete_all"){
		// 	$this->db->delete(FACEBOOK_SCHEDULES, "category = '".post("category")."'".getDatabyUser());
		// }

		if(post("action") == "delete_campaign_group"){
			$this->db->delete(CAMPAIGN_GROUP, "id = '{$ids}'");
		}

		if(post("action") == "copy"){
			$this->model->copySchedule($ids);
		}

		if(post("action") == "delete"){
			$POST = $this->model->get('*', CAMPAIGN, "id = '{$ids}'".getDatabyUser());
			if(!empty($POST)){
				$this->db->delete(CAMPAIGN, "id = '{$ids}'");
				$events = $this->model->getScheduleByCampId($ids);
				if(!empty($events)) {
					$this->db->delete(FACEBOOK_SCHEDULES, "campaign_id = '{$ids}'");
				}
			}
		}

		ms(array(
			'st' 	=> 'success',
			'txt' 	=> l('-successfully')
		));
	}

    public function get_events()
     {
         // Our Start and End Dates
     	 $campaignId = $this->input->get("campaign_id", true);
         $start = $this->input->get("start");
         $end = $this->input->get("end");
    
         $startdt = new DateTime('now'); // setup a local datetime
         $startdt->setTimestamp($start); // Set the date based on timestamp
         $start_format = $startdt->format('Y-m-d H:i:s');
    
         $enddt = new DateTime('now'); // setup a local datetime
         $enddt->setTimestamp($end); // Set the date based on timestamp
         $end_format = $enddt->format('Y-m-d H:i:s');
    
         $events = $this->model->get_events($campaignId, $start_format, $end_format);
        
         $data_events = array();
    
         foreach($events->result() as $r) {
         	$type = ($r->privacy == "CLOSED" || $r->privacy == "SECRET") ? 1 : 0;
         	$selectPGP = $r->group_type.'{-}'.$r->account_id.'{-}'.$r->account_name.'{-}'.$r->group_id.'{-}'.$r->name.'{-}'.$type;

         	$deplay = $r->deplay / 60;
         	$auto_repeat = (!empty($r->repeat_time)) ? $r->repeat_time : 0;
	        $data_events[] = array(
	            "id" => $r->id,
	            "selectPGP" => $selectPGP,
	            "title" => $r->cat_data,
	            "deplay" => $deplay,
	            "auto_repeat" => $auto_repeat,
	            "description" => $r->description,
	            "chu_ky" => $r->chu_ky,
	            "end" => $r->repeat_end,
	            "start" => $r->time_post_show
	        );
         }

         echo json_encode(array("events" => $data_events));
         exit();
     }

	public function ajax_save_schedules(){
		$groups = $this->input->post('id');
		$campaignId = (int)$this->input->post('campaign_id');
		// var_dump($campaignId);die;
    	$select_data_cat = post('select_data_cat');
    	$get_save_user = $this->model->fetch("id", user_categories,  "id = '".$select_data_cat."' and uid = '".session("uid")."'");
    	
	    $repeat_end = strtotime(post('repeat_end'));
	    $auto_repeat = ((int)post("auto_repeat"));
	    if(post('time_post') == ""){
			$json[] = array(
				"st"    => "valid",
				"label" => "bg-red",
				"text"  => l('Time post is required')
			);
		}
        $chu_ky = post("chu_ky");
        $typePost = 'text';
		
        $time_now  = strtotime(NOW) + 60;
        $time_post_show1 = strtotime(post('time_post').":00");
        
		if(empty($groups)){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Select at least a Page/Group/Profile')
			));
		}
	
		$count = 0;
		$deplay = (int)post('deplay')*60;
		$list_deplay = array();
		
		for ($i=0; $i < count($groups); $i++) { 
			$list_deplay[] = $deplay*$i;
		}

		shuffle($list_deplay);
		$time_post_show = strtotime(post('time_post').":00");

		$date = new DateTime(date("Y-m-d H:i:s", $time_post_show), new DateTimeZone(TIMEZONE_USER));
		$date->setTimezone(new DateTimeZone(TIMEZONE_SYSTEM));
		$time_post = $date->format('Y-m-d H:i:s');
		
		foreach ($groups as $key => $group) {
			if (!empty($get_save_user)){
	    	    $this->db->select('id');
	            $this->db->from('save');
	            $this->db->where('status = ', 1);
	            $this->db->where("user_category= '".$select_data_cat."'");
	            $this->db->where("uid= '".session("uid")."'");
	            $count_allcat =  $this->db->count_all_results();
			    $random = rand(0,$count_allcat);
			    
			    $this->db->select('*');
	            $this->db->from('save');
	            $this->db->where("user_category= '".$select_data_cat."'");
	            $this->db->where("uid= '".session("uid")."'");
	            $this->db->where('status = ', 1);
	            $this->db->limit(1,$random);
	            $get_data = $this->db->get()->result();
	    	    
	    	}else {	    
	    	    $this->db->select('id');
	            $this->db->from('save_data');
	            $this->db->where('status = ', 1);
	            $this->db->where("cat_data= '".$select_data_cat."'");
	            $count_allcat =  $this->db->count_all_results();

				$random = rand(0,$count_allcat);
				$this->db->select('*');
	            $this->db->from('save_data');
	            $this->db->where('status = ', 1);
	            $this->db->where("cat_data= '".$select_data_cat."'");
	            $this->db->limit(1,$random);
	            $get_data= $this->db->get()->result();
	    	}

		    $data = 0;
	    	$rand_data = rand(0, (count($get_data)-1));
            $data2 = (array)$get_data[0];
	    	$data = array(
	    		"category"    => $data2[category],
	    		"type"        => $data2[type],
	    		"campaign_id" => $campaignId,
	    		"url"         => $data2[url],
	    		"image"       => $data2[image],
	    		"title"       => $data2[title],
	    		"caption"     => $data2[caption],
	    		"description" => $data2[description],
	    		"message"     => $data2[message],
	    		"bot_like"    => 0,
				"chu_ky"	  => $chu_ky,
	    	);
            $data["cat_data"] = $select_data_cat;
		    
			$group  = explode("{-}", $group);
			if(count($group) == 6){
				$data["uid"]            = session("uid");
				$data["group_type"]     = $group[0];
				$data["account_id"]     = $group[1];
				$data["account_name"]   = $group[2];
				$data["group_id"]       = $group[3];
				$data["name"]           = $group[4];
				$data["privacy"]        = $group[5];					
				$data["unique_link"]    = 0;
				$rand_post = rand(120,180);
				$data["time_post"]      = date("Y-m-d H:i:s", strtotime($time_post) + $list_deplay[$key] + $rand_post);
				$data["time_post_show"] = date("Y-m-d H:i:s", $time_post_show + $list_deplay[$key] + $rand_post);
				$data["deplay"]         = $deplay;
				$data["changed"]        = NOW;
				$data["created"]        = NOW;
				$data["status"]         = 1;
				if($auto_repeat != 0){
			        $data["repeat_post"] = 8;
			        $data["repeat_time"] = $auto_repeat;
			        $data["repeat_end"]  = date("Y-m-d", $repeat_end);
		        }else{
			    $data["repeat_post"] = 0;
		        }
				
				$this->db->insert(FACEBOOK_SCHEDULES, $data);
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

	public function update_schedules(){
		$event_id = $this->input->post('eventid');
		$campaignId = $this->input->post('campaign_id');
		$groups = $this->input->post('id');
    	$select_data_cat = post('select_data_cat');
    	$get_save_user = $this->model->fetch("id", user_categories,  "id = '".$select_data_cat."' and uid = '".session("uid")."'");
    	
	    $repeat_end = strtotime(post('repeat_end'));
	    $auto_repeat = ((int)post("auto_repeat"));
	    if(post('time_post') == ""){
			$json[] = array(
				"st"    => "valid",
				"label" => "bg-red",
				"text"  => l('Time post is required')
			);
		}
        $chu_ky = post("chu_ky");
        $typePost = 'cal';
		
        $time_now  = strtotime(NOW) + 60;
        $time_post_show1 = strtotime(post('time_post').":00");
        
		if(empty($groups)){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Select at least a Page/Group/Profile')
			));
		}
	
		$count = 0;
		$deplay = (int)post('deplay')*60;
		$list_deplay = array();
		
		for ($i=0; $i < count($groups); $i++) { 
			$list_deplay[] = $deplay*$i;
		}

		shuffle($list_deplay);
		$time_post_show = strtotime(post('time_post').":00");

		$date = new DateTime(date("Y-m-d H:i:s", $time_post_show), new DateTimeZone(TIMEZONE_USER));
		$date->setTimezone(new DateTimeZone(TIMEZONE_SYSTEM));
		$time_post = $date->format('Y-m-d H:i:s');
		
		foreach ($groups as $key => $group) {
			if (!empty($get_save_user)){
	    	    $this->db->select('id');
	            $this->db->from('save');
	            $this->db->where('status = ', 1);
	            $this->db->where("user_category= '".$select_data_cat."'");
	            $this->db->where("uid= '".session("uid")."'");
	            $count_allcat =  $this->db->count_all_results();
			    $random = rand(0,$count_allcat);
			    
			    $this->db->select('*');
	            $this->db->from('save');
	            $this->db->where("user_category= '".$select_data_cat."'");
	            $this->db->where("uid= '".session("uid")."'");
	            $this->db->where('status = ', 1);
	            $this->db->limit(1,$random);
	            $get_data = $this->db->get()->result();
	    	    
	    	}else {	    
	    	    $this->db->select('id');
	            $this->db->from('save_data');
	            $this->db->where('status = ', 1);
	            $this->db->where("cat_data= '".$select_data_cat."'");
	            $count_allcat =  $this->db->count_all_results();

				$random = rand(0,$count_allcat);
				$this->db->select('*');
	            $this->db->from('save_data');
	            $this->db->where('status = ', 1);
	            $this->db->where("cat_data= '".$select_data_cat."'");
	            $this->db->limit(1,$random);
	            $get_data= $this->db->get()->result();
	    	}

		    $data = 0;
	    	$rand_data = rand(0, (count($get_data)-1));
            $data2 = (array)$get_data[0];
	    	$data = array(
	    		"category"    => $data2[category],
	    		"type"        => $typePost,
	    		"campaign_id" => $campaignId,
	    		"url"         => $data2[url],
	    		"image"       => $data2[image],
	    		"title"       => $data2[title],
	    		"caption"     => $data2[caption],
	    		"description" => $data2[description],
	    		"message"     => $data2[message],
	    		"bot_like"    => 0,
				"chu_ky"	  => $chu_ky,
	    	);
            $data["cat_data"] = $select_data_cat;
		    
			$group  = explode("{-}", $group);
			if(count($group) == 6){
				$data["uid"]            = session("uid");
				$data["group_type"]     = $group[0];
				$data["account_id"]     = $group[1];
				$data["account_name"]   = $group[2];
				$data["group_id"]       = $group[3];
				$data["name"]           = $group[4];
				$data["privacy"]        = $group[5];					
				$data["unique_link"]    = 0;
				$rand_post = rand(120,180);
				$data["time_post"]      = date("Y-m-d H:i:s", strtotime($time_post) + $list_deplay[$key] + $rand_post);
				$data["time_post_show"] = date("Y-m-d H:i:s", $time_post_show + $list_deplay[$key] + $rand_post);
				$data["deplay"]         = $deplay;
				$data["changed"]        = NOW;
				$data["created"]        = NOW;
				$data["status"]         = 1;
				if($auto_repeat != 0){
			        $data["repeat_post"] = 8;
			        $data["repeat_time"] = $auto_repeat;
			        $data["repeat_end"]  = date("Y-m-d", $repeat_end);
		        }else{
			    $data["repeat_post"] = 0;
		        }
				
				// $this->db->insert(FACEBOOK_SCHEDULES, $data);
				// $count++;

				$this->db->update(FACEBOOK_SCHEDULES, $data, array("id" => $event_id));
			}
		}

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	
	}
}