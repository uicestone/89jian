<?php

class Type extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index($slug){
		$objects = $this->object->getList(array('type'=>$slug));
		
		if(file_exists(APPPATH.'/views/type/'.$slug.'.php')){
			$this->load->view('type/'.$slug, compact('objects'));
		}
		else{
			$this->load->view('type', compact('objects'));
		}
		
	}
}
