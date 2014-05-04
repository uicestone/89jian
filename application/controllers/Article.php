<?php

class Article extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function view($slug){
		
		$article = $this->object->getRow(array('type'=>'article','or'=>array('num'=>urlencode($slug),'id'=>$slug),'with_meta'=>true));
		
		if(file_exists(APPPATH.'/views/article/'.$slug.'.php')){
			$this->load->view('article/'.$slug, compact('article'));
		}
		else{
			$this->load->view('article', compact('article'));
		}
		
	}
}
