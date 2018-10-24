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
			"result" => $this->model->fetch("*", USER_MANAGEMENT, "history_id = '".session('uid')."'","id", "DESC")
		);
		$this->template->title(l('Quản lý'));
		$this->template->build('index', $data);
	}

	public function update(){
	//	if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$data = array(
			"result_agency" => $this->model->get("*", USER_MANAGEMENT, "id = '".session('uid')."'"),
			"result"  => $this->model->get("*", USER_MANAGEMENT, "id = '".get("id")."' and history_id = '".session('uid')."'"),
			"package" => $this->model->fetch("*", PACKAGE)
		);
		$this->template->title(l('User management'));
		$this->template->build('update', $data);
	}
	
	
	public function create(){
	//	if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$data = array(
			"result"  => $this->model->get("*", USER_MANAGEMENT, "id = '".get("id")."'"),
			"package" => $this->model->fetch("*", PACKAGE)
		);
		$this->template->title(l('Tạo tài khoản'));
		$this->template->build('create', $data);
	}



	public function ajax_update(){
		//if(IS_ADMIN != 1) redirect(PATH."dashboard");
		$id = (int)post("id");
		$result_agency  = $this->model->get("*", user_management, "id = '".session('uid')."'");
		if ($id != 0){
			$result  = $this->model->get("*", user_management, "id = {$id} and history_id = '".session('uid')."'");
        
			if (empty($result)) {
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Tài khoản không thuộc quản lý của bạn')
				)); 
			}
		} 	

		if(post("expiration_date") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Expiration date is required')
			));
		}

		if(post("timezone") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Timezone is required')
			));
		}

		$groups = (int)post("maximum_groups");
		$pages  = (int)post("maximum_pages");
		$friends  = (int)post("maximum_friends");
		   	
		$data = array(
			"fullname"         => post("fullname"),
			
			"email"            => post("email"),
			"admin"            => (int)post("admin"),
			"maximum_account"  => (int)post("maximum_account"),
			"maximum_groups"   => $groups,
			"maximum_pages"    => $pages,
			"maximum_friends"  => $friends,
			"expiration_date"  => date("Y-m-d", strtotime(post("expiration_date"))),
			"timezone"         => post("timezone"),
			"status"           => 1,
			"pid"			   => post("phone"),
			"changed"          => NOW
		);
		if(post("package-id")){
			$package_id = post("package-id");
			$package_id = explode('|', $package_id);
			$data["package_id"]       = $package_id[1];
			
		}else {
			$data["package_id"] = $result->package_id;
		}
		       
		if($id == 0){
			if(post("fullname") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Fullname is required')
			));
		}

		if(post("email") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Email is required')
			));
		}

		if(post("phone") == ""){
			ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Phone is required')
			));
		}
		
		if(!filter_var(post("email"), FILTER_VALIDATE_EMAIL)){
		  	ms(array(
				"st"    => "error",
				"label" => "bg-red",
				"txt"   => l('Invalid email format')
			));
		}
			if(post("password") == ""){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Password is required')
				));
			}

			if(strlen(post("password")) < 6){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Passwords must be at least 6 characters')
				));
			}

			if(post("password") != post("repassword")){
				ms(array(
					"st"    => "error",
					"label" => "bg-red",
					"txt"   => l('Password incorrect')
				));
			}
			if(post("time_for_agency") != 0){
				$data["agency"] = post("time_for_agency");
				$data_agency["agency"] = $result_agency->agency - $data["agency"];
				$this->db->update(USER_MANAGEMENT, $data_agency, "id = '".session('uid')."'");
			}
			$data["password"] = md5(post("password"));
			$data["type"]     = "direct";
			$data["created"]  = NOW;
			$data["history_id"]  = session('uid');
			$POST = $this->model->get('*', USER_MANAGEMENT, "email = '".post('email')."'");
			if(empty($POST)){
				$this->db->insert(USER_MANAGEMENT, $data);
				$id = $this->db->insert_id();
			}else {
				ms(array(
				'st' 	=> 'error',
				'label' => "bg-red",
				'txt' 	=> l('Email already exists')
			));
			}
			
		}else{

			if(post("password") != ""){
				if(strlen(post("password")) < 6){
					ms(array(
						"st"    => "error",
						"label" => "bg-red",
						"txt"   => l('Passwords must be at least 6 characters')
					));
				}

				if(post("password") != post("repassword")){
					ms(array(
						"st"    => "error",
						"label" => "bg-red",
						"txt"   => l('Password incorrect')
					));
				}

				$data["password"] = md5(post("password"));
			}
			
			if(post("time_for_agency") != 0){
				$data["agency"] = post("time_for_agency");
				$data_agency["agency"] = $result_agency->agency + $result->agency - $data["agency"];
				$this->db->update(USER_MANAGEMENT, $data_agency, "id = '".session('uid')."'");
			}
			$this->db->update(USER_MANAGEMENT, $data, array("id" => $id));
		}

		ms(array(
			"st"    => "success",
			"label" => "bg-light-green",
			"txt"   => l('Update successfully')
		));
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