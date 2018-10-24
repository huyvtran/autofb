<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class auto_all extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		permission_view();
	}

	public function index(){
		$data = array(
			"result"     => $this->model->getAllAccount(),
			"category_data"       => $this->model->fetch("*", category_data, "status = 1"),
			"categories" => $this->model->fetch("*", CATEGORIES, "category = 'post'".getDatabyUser()),
			"categories_user" => $this->model->fetch("*",user_categories, "uid = '".session("uid")."'")
		);
		$this->template->title(l('Auto all')); 
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
        
		            foreach($account as $g) {
                $data[] = array(
                    '<input type="checkbox" name="id[]" id="md_checkbox_'.$g->fid.'" class="filled-in chk-col-red checkItem" value="profile{-}'.$g->id.'{-}'.$g->username.'{-}'.$g->fid.'{-}'.$g->name.'{-}0">
                    <label class="p0 m0" for="md_checkbox_'.$g->fid.'">&nbsp;</label>',
                    $g->username,
                    $g->fullname,
                    "profile",
                     "",
                    '<a href="https://facebook.com/'.$g->fid.'" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> Xem ngay</a>',
                    ""
                    
                );
            }
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
                        '<a href="https://facebook.com/'.$r->pid.'" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> Xem ngay</a>',
                        ""
                        
                    );
            } 
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
				//$get_data = $this->model->fetch("*", save, "user_category = '".$select_data_cat."' and uid = '".session("uid")."'");
				$this->db->select('id');
				$this->db->from('save');
				$this->db->where('status = ', 1);
				$this->db->where("user_category= '".$select_data_cat."'");
				$this->db->where("uid= '".session("uid")."'");
				$count_allcat =  $this->db->count_all_results();
				$random = rand(0,$count_allcat-1);
				
				$this->db->select('*');
				$this->db->from('save');
				$this->db->where("user_category= '".$select_data_cat."'");
				$this->db->where("uid= '".session("uid")."'");
				$this->db->where('status = ', 1);
				$this->db->limit(1,$random);
				$get_data = $this->db->get()->result();
    	    
			}else {	    
    	    //$get_data = $this->model->fetch("*", save_data, "cat_data = '$select_data_cat'");
    	    $this->db->select('id');
            $this->db->from('save_data');
            $this->db->where('status = ', 1);
            $this->db->where("cat_data= '".$select_data_cat."'");
            $count_allcat =  $this->db->count_all_results();

			$random = rand(1,$count_allcat-1);
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
					//$data["unique_link"]    = 0;
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
}