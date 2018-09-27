<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class agency extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		permission_view();
	}

	public function index(){
		$data = array(
			"result" => $this->model->fetch("*", USER_MANAGEMENT, "history_id = '".session('uid')."'")
		);
		$this->template->title(l('Quản lý'));
		$this->template->build('index', $data);
	}

	public function update(){
	//	if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$data = array(
			"result"  => $this->model->get("*", USER_MANAGEMENT, "id = '".get("id")."'"),
			"package" => $this->model->fetch("*", PACKAGE)
		);
		$this->template->title(l('User management'));
		$this->template->build('update', $data);
	}

	public function ajax_update(){
	    //echo "<pre>";
	//	if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$id = (int)post("rf");
	//	$id = "45";
        $result  = $this->model->fetch("*", user_management, "id = {$id} and history_id = '".session('uid')."'");
        
        $affiliate = json_decode ($result[0]->affiliate);
        
    	if (empty($result[0])) {
    	   	ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Tài khoản không thuộc quản lý của bạn')
			)); 
    	}    else{
        $package_name = post("package-id");
        $package_id = $this->model->fetch("*", PACKAGE, "name = '".$package_name."'");
        $permission = json_decode ($package_id[0]->permission);

        
        $day = strtotime(NOW) + $package_id[0]->day * 24 *3600;
        $day1 = date("Y-m-d H:i:s",$day);
        
        $affiliate->paided  = $affiliate->paided + $package_id[0]->price;
		
		$data = array(
			"package_id"       => $package_id[0]->id,
			"maximum_account"  => $permission->maximum_account,
			"maximum_groups"   => $permission->maximum_groups,
			"maximum_pages"    => $permission->maximum_pages,
			"maximum_friends"  => $permission->maximum_pages,
			"expiration_date"  => $day1,
			"changed"          => NOW
		);
		
        $data['affiliate'] = json_encode($affiliate);
        
		$this->db->update(USER_MANAGEMENT, $data, "id = {$id}");

		 ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		)); 
    	}
	} 

	public function ajax_action_item(){
	//	if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$id = (int)post('id');
		$POST = $this->model->get('*', USER_MANAGEMENT, "id = '{$id}'");
		if(!empty($POST)){
			switch (post("action")) {
				case 'delete':
					$this->db->delete(USER_MANAGEMENT, "id = '{$id}'");
					$this->db->delete(FACEBOOK_ACCOUNTS, "uid = '{$id}'");
					$this->db->delete(FACEBOOK_SCHEDULES, "uid = '{$id}'");
					$this->db->delete(SAVE, "uid = '{$id}'");
					$this->db->delete(CATEGORIES, "uid = '{$id}'");
					$this->db->delete(facebook_groups, "uid = '{$id}'");
					break;
				
				case 'active':
					$this->db->update(USER_MANAGEMENT, array("status" => 1), "id = '{$id}'");
					break;

				case 'disable':
					$this->db->update(USER_MANAGEMENT, array("status" => 0), "id = '{$id}'");
					break;
			}
		}

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
	}

	public function ajax_action_multiple(){
	//	if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$ids =$this->input->post('id');
		if(!empty($ids)){
			foreach ($ids as $id) {
				$POST = $this->model->get('*', USER_MANAGEMENT, "id = '{$id}'");
				if(!empty($POST)){
					switch (post("action")) {
						case 'delete':
							$this->db->delete(USER_MANAGEMENT, "id = '{$id}'");
							$this->db->delete(FACEBOOK_ACCOUNTS, "uid = '{$id}'");
							$this->db->delete(FACEBOOK_SCHEDULES, "uid = '{$id}'");
							$this->db->delete(SAVE, "uid = '{$id}'");
							$this->db->delete(CATEGORIES, "uid = '{$id}'");
							$this->db->delete(facebook_groups, "uid = '{$id}'");
							break;
						case 'active':
							$this->db->update(USER_MANAGEMENT, array("status" => 1), "id = '{$id}'");
							break;

						case 'disable':
							$this->db->update(USER_MANAGEMENT, array("status" => 0), "id = '{$id}'");
							break;
					}
				}
			}
		}

		print_r(json_encode(array(
			'st' 	=> 'success',
			'txt' 	=> l('Update successfully')
		)));
	}


}