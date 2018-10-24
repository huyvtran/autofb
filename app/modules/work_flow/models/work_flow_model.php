<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class work_flow_model extends MY_Model {
	public function __construct(){
		parent::__construct();
	}


	public function getAllAccount(){
		$cate   = $this->model->get("*", CATEGORIES, "id = '".session("category")."' AND category = 'post'");
		$result = $this->model->fetch("*", FACEBOOK_ACCOUNTS, "status = 1".getDatabyUser(), "id", "asc");
		if(!empty($result)){
			foreach ($result as $key => $row) {
				$this->db->select("*");
				$this->db->where("account_id = '".$row->id."'");
				$this->db->where("type != 'friend'");

				if(session("category") && !empty($cate)){
					$group_id = json_decode($cate->data);
					if(!empty($group_id)){
						$this->db->where_in("pid", $group_id);
					}
				}
				
				$this->db->where("uid = '".session("uid")."'");
				$this->db->order_by("type", "desc");
				$query = $this->db->get(FACEBOOK_GROUPS);
				$result[$key]->groups = $query->result();
			}
		}

		return $result;
	}
	public function getAllAccountlike(){
		    $this->db->where("uid = '".session("uid")."'");  
		    $this->db->where("type != 'friend'");
            $query = $this->db->get(FACEBOOK_GROUPS);
		    return $query;
		}
		
	public function get_events($campaignId, $start, $end)
    {
        return $this->db->where("campaign_id = ", $campaignId)->where("time_post >=", $start)->get(FACEBOOK_SCHEDULES);
    }
    
    public function add_event($data)
    {
        $this->db->insert("work_flow", $data);
    }
    
    public function get_event_detail($id)
    {
        return $this->db->where("id", $id)->get(FACEBOOK_SCHEDULES);
    }
    
    public function update_event($id, $data)
    {
        $this->db->where("ID", $id)->update("work_flow", $data);
    }
    
    public function delete_event($id)
    {
        $this->db->where("ID", $id)->delete("work_flow");
    }

    private $cds = FACEBOOK_SCHEDULES;

	function get_cd_list() {
        /* Array of table columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array(
            'id',
            'account_name',
            'name',
            'group_type',
            'type',
            'time_post_show',
            'time_post',
            'status',
            'created', 
            'result'
        );

        if(segment(2) == "repost_pages"){
        	$aColumns = array(
	            'id',
	            'account_name',
	            'name',
	            'group_type',
	            'type',
	            'title',
	            'time_post_show',
	            'status',
	            'created', 
	            'result'
	        );
        }

 
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";
 
        /* Total data set length */
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count
            FROM $this->cds";
        $rResultTotal = $this->db->query($sQuery);
        $aResultTotal = $rResultTotal->row();
        $iTotal = $aResultTotal->row_count;
 
        /*
         * Paging
         */
        $sLimit = "";
        $iDisplayStart = $this->input->get_post('start', true);
        $iDisplayLength = $this->input->get_post('length', true);
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $sLimit = "LIMIT " . intval($iDisplayStart) . ", " .
                    intval($iDisplayLength);
        }

        $uri_string = $_SERVER['QUERY_STRING'];
        $uri_string = preg_replace("/%5B/", '[', $uri_string);
        $uri_string = preg_replace("/%5D/", ']', $uri_string);
 
        $get_param_array = explode("&", $uri_string);
        $arr = array();
        if(!empty($get_param_array)){
	        foreach ($get_param_array as $value) {
	            $v = $value;
	            $explode = explode("=", $v);
	            $arr[$explode[0]] = $explode[1];
	        }
	    }
 
        $index_of_columns = strpos($uri_string, "columns", 1);
        $index_of_start = strpos($uri_string, "start");
        $uri_columns = substr($uri_string, 7, ($index_of_start - $index_of_columns - 1));
        $columns_array = explode("&", $uri_columns);
        $arr_columns = array();
        foreach ($columns_array as $value) {
            $v = $value;
            $explode = explode("=", $v);
            if (count($explode) == 2) {
                $arr_columns[$explode[0]] = $explode[1];
            } else {
                $arr_columns[$explode[0]] = '';
            }
        }
 
        /*
         * Ordering
         */
        if(isset($arr['order[0][column]'])){
	        $sOrder = "ORDER BY ";
	        $sOrderIndex = $arr['order[0][column]'];
	        $sOrderDir = $arr['order[0][dir]'];
	        $bSortable_ = $arr_columns['columns[' . $sOrderIndex . '][orderable]'];
	        if ($bSortable_ == "true") {
	            $sOrder .= $aColumns[$sOrderIndex] .
	                    ($sOrderDir === 'asc' ? ' asc' : ' desc');
	        }
	    }else{
	    	$sOrder = "ORDER BY status DESC,id DESC";
	    }
	 
        
 		$test = 'cal';
 		$wCate = "type = '".$test."'";
 		$sWhere = "WHERE {$wCate} ".getDatabyUser()." ";
        $sSearchVal = $arr['search[value]'];
        if (isset($sSearchVal) && $sSearchVal != '') {
            $sWhere = $sWhere."AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        /* Individual column filtering */
        $sSearchReg = $arr['search[regex]'];
        for ($i = 0; $i < count($aColumns); $i++) {
        	if(isset($arr['columns[' . $i . '][searchable]'])){
	            $bSearchable_ = $arr['columns[' . $i . '][searchable]'];
	            if (isset($bSearchable_) && $bSearchable_ == "true" && $sSearchReg != 'false') {
	                $search_val = $arr['columns[' . $i . '][search][value]'];

	                if ($sWhere == "") {
	                    $sWhere = "WHERE type = '".$test."' AND ";
	                } else {
	                    $sWhere .= "AND type = '".$test."' AND ";
	                }
	                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($search_val) . "%' ";
	            }
	        }
        }
 
        /*
         * SQL queries
         * Get data to display
         */
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
        FROM $this->cds
        $sWhere
        $sOrder
        $sLimit
        ";
        $rResult = $this->db->query($sQuery);

        /* Data set length after filtering */
        $sQuery = "SELECT FOUND_ROWS() AS length_count";
        $rResultFilterTotal = $this->db->query($sQuery);
        $aResultFilterTotal = $rResultFilterTotal->row();
        $iFilteredTotal = $aResultFilterTotal->length_count;
 
        /*
         * Output
         */
        $sEcho = $this->input->get_post('draw', true);
        $output = array(
            "draw" => intval($sEcho),
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data" => array()
        );
 
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $row[] = $aRow[$col];
            }
            $row[0] =   '<input type="checkbox" name="id[]" id="md_checkbox_'.$row[0].'" class="filled-in chk-col-red checkItem" value="'.$row[0].'">
                        <label class="p0 m0" for="md_checkbox_'.$row[0].'">&nbsp;</label>';

            $row[7] =   '<span data-toggle="tooltip" title="'.$row[9].'">'.status_post($row[7]).'</span>';
            $output['data'][] = $row;
        }
 
        return $output;
    }

	public function getSchedules($type = ""){
		// var_dump($type);die;
		$this->db->select("*");
		switch ($type) {
			case 'cal': 
				// if(!permission("post")){
				// 	redirect(PATH);
				// }
				$this->db->where("type = '".$type."'");
				break;
			case 'post': 
				if(!permission("post")){
					redirect(PATH);
				}
				$this->db->where("category = '".$type."'");
				break;

			case 'friend':
				if(!permission("post_wall_friends")){
					redirect(PATH);
				}
				$this->db->where("category = '".$type."'");
				break;

			case 'message':
				if(!permission("direct_message")){
					redirect(PATH);
				}
				$this->db->where("category = '".$type."'");
				break;

			case 'join':
				if(!permission("join_groups")){
					redirect(PATH);
				}
				$this->db->where("category = '".$type."'");
				break;

			case 'comment':
				if(!permission("comment")){
					redirect(PATH);
				}
				$this->db->where("category = '".$type."'");
				break;
            	
            case 'auto_seeding':
				if(!permission("auto_seeding")){
					redirect(PATH);
				}
				$this->db->where("category = '".$type."'");
				break;
				
			case 'like':
				if(!permission("like")){
					redirect(PATH);
				}
				$this->db->where("category = '".$type."'");
				break;
				
			case 'add_friends':
				if(!permission("add_friends")){
					redirect(PATH);
				}
				$this->db->where("category = 'add'");
				break;
				
			case 'unfriends':
				if(!permission("unfriends")){
					redirect(PATH);
				}
				$this->db->where("category = 'unfriends'");
				break;
			case 'invite_to_groups':
				if(!permission("invite_to_groups")){
					redirect(PATH);
				}
				$this->db->where("category = 'invite_to_groups'");
				break;
			case 'invite_to_pages':
				if(!permission("invite_to_pages")){
					redirect(PATH);
				}
				$this->db->where("category = 'invite_to_pages'");
				break;
			case 'accept_friend_request':
				if(!permission("accept_friend_request")){
					redirect(PATH);
				}
				$this->db->where("category = 'accept_friend_request'");
				break;

			case 'repost_pages':
				if(!permission("repost_pages")){
					redirect(PATH);
				}
				$this->db->where("category = 'repost_pages'");
				break;
		}

		if(IS_ADMIN != 1){
			$this->db->where('uid', session("uid"));
		}
			$this->db->limit(500, 0);
		$query = $this->db->get(FACEBOOK_SCHEDULES);
		// $str = $this->db->last_query();
		// echo $str;
		// die;
		if($query->result()){
			return $query->result();
		}else{
			return false;
		}
	}

	public function getCampaign(){
		$result = $this->db->select('campaign_group.*,campaign.id as campaign_id, campaign.name as campaign_name, campaign.description as campaign_desc, campaign_group.name as campaign_group_name')
	    				->from(CAMPAIGN_GROUP)
	    				->join('campaign', 'campaign_group.id = campaign.campaign_group_id', 'left')
	    				->get()->result();
	    
	    return $result;
	}

	public function getCampaignAndSchedule($type = ""){
		$result = $this->db->select('facebook_schedules.*,campaign.id as campaign_id, campaign.name as campaign_name, campaign.description as campaign_desc, campaign_group.name as campaign_group_name')
	    				->from(FACEBOOK_SCHEDULES)
	    				->join('campaign', 'campaign.id = facebook_schedules.campaign_id', 'left')
	    				->join('campaign_group', 'campaign_group.id = campaign.campaign_group_id', 'left')
	    				->get()->result();
	    
	    return $result;
	}

	public function getCampaignGroup()
    {
        return $this->db->get(CAMPAIGN_GROUP)->result();
    }

	public function getCampaignById($campaignId)
    {
        return $this->db->where("id = ", $campaignId)->get(CAMPAIGN)->result();
    }

    public function getScheduleByCampId($campaignId)
    {
        return $this->db->where("campaign_id = ", $campaignId)->get(FACEBOOK_SCHEDULES);
    }

	public function copySchedule($campaignId){
		$campaign = $this->model->get("*", CAMPAIGN, "id = '". $campaignId . "'");
		$events = $this->model->getScheduleByCampId($campaignId);

		$captionCopy = $campaign->name . '_(Copy of '. $campaignId . ')';

		$dataCampaign = array(
			"campaign_group_id"    => $campaign->campaign_group_id,
    		"name"        => $captionCopy,
    		"description" => $campaign->description,
    		"date_created" => NOW,
    		"start_date"  => $campaign->start_date,
    		"end_date"  => $campaign->end_date,
    		"status"  => $campaign->status,
    		"uid"  => $campaign->uid,
		);

		$this->db->insert(CAMPAIGN, $dataCampaign);
		$campaignIdCopy = $this->db->insert_id();

		if(!empty($events)) {
			foreach($events->result() as $value) {
				$data = array(
		    		"category"          => $value->category,
		    		"uid"               => $value->uid,
		    		"account_id"        => $value->account_id,
		    		"account_name"      => $value->account_name,
		    		"group_id"          => $value->group_id,
		    		"group_type"        => $value->group_type,
		    		"name"              => $value->name,
		    		"time_post"         => $value->time_post,
		    		"time_post_show"    => $value->time_post_show,
		    		"repeat_post"       => $value->repeat_post,
		    		"repeat_time"       => $value->repeat_time,
		    		"repeat_end"        => $value->repeat_end,
		    		"status"            => $value->status,
		    		"cat_data"          => $value->cat_data,
		    		"type"              => 'cal',
		    		"campaign_id"       => $campaignIdCopy,
		    		"url"               => $value->url,
		    		"image"             => $value->image,
		    		"title"             => $value->title,
		    		"caption"           => $value->caption,
		    		"description"       => $value->description,
		    		"message"           => $value->message,
		    		"bot_like"          => 0,
					"chu_ky"	        => $value->chu_ky,
		    	);

		    	$this->db->insert(FACEBOOK_SCHEDULES, $data);

			}
		}
	}
}
