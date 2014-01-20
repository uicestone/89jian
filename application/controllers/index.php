<?php
class Index extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		
		$packages = $this->object->getList(array('type'=>'package', 'meta'=>array('有效'=>true), 'with_meta'=>true));
		
		$products = $this->object->getList(array('type'=>'product', 'meta'=>array('首页推荐'=>true), 'with_meta'=>true));
		
		$this->load->view('index',  compact('packages', 'products'));
	}
}
