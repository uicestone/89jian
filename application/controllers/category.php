<?php

class Category extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index($slug){
		$objects = $this->object->getList(array('type'=>'article','tag'=>array('category'=>$slug)));
		
		if(file_exists(APPPATH.'/views/category/'.$slug.EXT)){
			$this->load->view('category/'.$slug, compact('objects'));
		}
		else{
			$this->load->view('category', compact('objects'));
		}
		
	}
}
