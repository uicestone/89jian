<?php

class Product extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$products = $this->object->getList(array('type'=>'product','with_meta'=>true));
		$this->load->view('product', compact('products'));
	}
	
	function view($slug){
		
		$article = $this->object->getRow(array('type'=>'product','or'=>array('num'=>urlencode($slug),'id'=>$slug),'with_meta'=>true));
		
		$this->load->view('article', compact('article'));
		
	}
}
