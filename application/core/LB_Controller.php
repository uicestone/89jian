<?php
class LB_Controller extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		
		/*
		 * 自动载入的资源，没有使用autoload.php是因为后者载入以后不能起简称...
		 */
		$this->load->model('company_model','company');
		$this->load->model('object_model','object');
		$this->load->model('user_model','user');
		$this->load->model('nav_model','nav');
		
		$this->user->initialize();
		
	}
	
	function _output($output){
		
		$accepts = explode(',', $this->input->get_request_header('Accept'));
		
		if(in_array('application/json', $accepts)){
			echo json_encode($output);
		}
		else{
			echo $output;
		}
		
	}
	
}
?>