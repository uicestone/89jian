<?php

class Article extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index($slug){
		
		$article = $this->object->getRow(array('type'=>'article','num'=>'slug'));
		
		if(file_exists(APPPATH.'/views/article/'.$slug.EXT)){
			$this->load->view('article/'.$slug, compact('article'));
		}
		else{
			$this->load->view('article', compact('article'));
		}
		
	}
}
