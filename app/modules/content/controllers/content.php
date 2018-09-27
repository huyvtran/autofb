<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class content extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model(get_class($this).'_model', 'model');
		permission_view();
	}

	public function index(){
	                    
		$data = array(
		    "category_data" => $this->model->fetch("*", category_data, "status = 1"),
			//"result"  => $this->model->fetch("*", save_data, "caption>2000", "id" , "DESC"),
			"result"  => $get_data
		);
		$this->template->title(l('Content'));
		$this->template->build('index', $data);
	}
	

		 public function ajax_page()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        
        $books = $this->model->getAllAccountlike();
        $data = array();
        
            foreach($books->result() as $r) {
                    
                    if(empty($r->description)){
                        $data[] = array(
                        '<input type="checkbox" name="id[]" id="md_checkbox_'.$r->id.'" class="filled-in chk-col-red checkItem">
                        <label class="p0 m0" for="md_checkbox_'.$r->id.'">&nbsp;</label>',
                        $r->cat_data,
                        "Bài viết sưu tầm",
                        (int)$r->caption,
                        (int)$r->title,
                         $r->message,
                        
                    );
                    }else{
                   $data[] = array(
                        '<input type="checkbox" name="id[]" id="md_checkbox_'.$r->id.'" class="filled-in chk-col-red checkItem">
                        <label class="p0 m0" for="md_checkbox_'.$r->id.'">&nbsp;</label>',
                        $r->cat_data,
                        '<a href="https://facebook.com/'.$r->description.'" target="_blank"> <i class="fa fa-link" aria-hidden="true"></i> xem nội dung</a>',
                        (int)$r->caption,
                        (int)$r->title,
                         $r->message,
                        
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

//		 public function ajax_page()
    //{
    //    // Datatables Variables
    //    $draw = intval($this->input->get("draw"));
    //    $start = intval($this->input->get("start"));
    //    $length = intval($this->input->get("length"));
    //    
    //    $order = $this->input->get("order");

    //   $col = 0;
    //   $dir = "";
    //   if(!empty($order)) {
    //       foreach($order as $o) {
    //           $col = $o['column'];
    //           $dir= $o['dir'];
    //       }
    //   }
    //   if($dir != "asc" && $dir != "desc") {
    //       $dir = "asc";
    //   }
    // 
    //         $columns_valid = array(
    //        "id", 
    //        "cat_data", 
    //        "caption", 
    //        "title", 
    //        "message"
    //    );

    //    if(!isset($columns_valid[$col])) {
    //        $order = null;
    //    } else {
    //        $order = $columns_valid[$col];
    //    }

    // 
    //   $books = $this->model->get_books($start, $length, $order, $dir);

    //    //$books = $this->model->getAllAccountlike();
    //    //$books= $this->model->get("*", save_data, "cat_data= '".post('account')."'");
    //    $data = array();
    //   // var_dump ($books); die();
    //        foreach($books->result() as $r) {
    //                
    //                if(empty($r->description)){
    //                    $data[] = array(
    //                    '<input type="checkbox" name="id[]" id="md_checkbox_'.$r->id.'" class="filled-in chk-col-red checkItem">
    //                    <label class="p0 m0" for="md_checkbox_'.$r->id.'">&nbsp;</label>',
    //                    $r->cat_data,
    //                    "",
    //                    (int)$r->caption,
    //                    (int)$r->title,
    //                     $r->message,
    //                    
    //                );
    //                }else{
    //               $data[] = array(
    //                    '<input type="checkbox" name="id[]" id="md_checkbox_'.$r->id.'" class="filled-in chk-col-red checkItem">
    //                    <label class="p0 m0" for="md_checkbox_'.$r->pid.'">&nbsp;</label>',
    //                    $r->cat_data,
    //                    '<a href="https://facebook.com/'.$r->description.'" target="_blank"> <i class="fa fa-link" aria-hidden="true"></i> xem nội dung</a>',
    //                    (int)$r->caption,
    //                    (int)$r->title,
    //                     $r->message,
    //                    
    //                );
    //                }
    //    }
    //    
    //    $total_books = $this->model->get_total_books();

    //    $output = array(
    //        "draw" => $draw,
    //          "recordsTotal" => $total_books,
    //          "recordsFiltered" => $total_books,
    //          "data" => $data
    //      );
    //    //            $output = array(
    //    //       "draw" => $draw,
    //    //         "recordsTotal" => $books->num_rows(),
    //    //         "recordsFiltered" => $books->num_rows(),
    //    //         "data" => $data
    //    //    );
    //   //     print_r ($output);
    //      echo json_encode($output);
    //      exit();
    // }
}