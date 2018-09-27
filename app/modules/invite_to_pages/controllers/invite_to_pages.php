<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class invite_to_pages extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		permission_view();
	}

	public function index(){
		$data = array(
			"result"  => $this->model->getAllAccount(),
			"accounts" => $this->model->fetch("*", FACEBOOK_ACCOUNTS, "status = 1".getDatabyUser())
		);
		$this->template->title(l('Auto invite to pages'));
		$this->template->build('index', $data);
	}
	
		public function ajax_page()
     {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $account = $result = $this->model->fetch("*", FACEBOOK_ACCOUNTS, "status = 1".getDatabyUser(), "id", "asc");
        
        
        $books = $this->model->getAllAccountlike();
        $data = array();
        
            foreach($books->result() as $r) {
            foreach($account as $g) {
 
                if ($g->id == $r->account_id)
                   $data[] = array(
                        '<input type="checkbox" name="id[]" id="md_checkbox_'.$r->pid.'" class="filled-in chk-col-red checkItem" value="'.$r->type.'{-}'.$r->account_id.'{-}'.$g->username.'{-}'.$r->pid.'{-}'.$r->name.'{-}0">
                        <label class="p0 m0" for="md_checkbox_'.$r->pid.'">&nbsp;</label>',
                        $g->username,
                        $r->name,
                        $r->type,
                         $r->privacy,
                        $r->category,
                        ""
                        
                    );
            } 
        }
            
            foreach($account as $a) {
                $data[] = array(
                    '<input type="checkbox" name="id[]" id="md_checkbox_'.$a->fid.'" class="filled-in chk-col-red checkItem" value="profile{-}'.$a->id.'{-}'.$a->username.'{-}'.$a->fid.'{-}'.$a->name.'{-}0">
                    <label class="p0 m0" for="md_checkbox_'.$a->fid.'">&nbsp;</label>',
                    $a->username,
                    $a->fullname,
                    "profile",
                     "",
                    "",
                    ""
                    
                );
            }
          $output = array(
               "draw" => $draw,
                 "recordsTotal" => $books->num_rows(),
                 "recordsFiltered" => $books->num_rows(),
                 "data" => $data
            );
       //     print_r ($output);
          echo json_encode($output);
          exit();
     }

	public function ajax_save_schedules(){
		$data = array();
		$groups = $this->input->post('id');

		if(!post("group_id")){
			ms(array(
				"st"    => "valid",
				"label" => "bg-red",
				"txt"   => l('Page ID is requied')
			));
		}

		$data = array(
			"title"       => post("group_id"),
			"category"    => "invite_to_pages",
			"type"        => "invite_to_pages"
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
				"txt"   => l('Select at least a facebook user')
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
			if(count($group) == 6){
				$data["uid"]            = session("uid");
				$data["group_type"]     = $group[0];
				$data["account_id"]     = $group[1];
				$data["account_name"]   = $group[2];
				$data["group_id"]       = $group[3];
				$data["name"]           = $group[4];
				$data["privacy"]        = $group[5];
				$rand = (rand(100,600));
				$data["time_post"]      = date("Y-m-d H:i:s", strtotime($time_post) + $list_deplay[$key] + $rand);
				$data["time_post_show"] = date("Y-m-d H:i:s", $time_post_show + $list_deplay[$key] + $rand);
				$data["status"]         = 1;
				$data["deplay"]         = $deplay;
				$data["changed"]        = NOW;
				$data["created"]        = NOW;

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
}