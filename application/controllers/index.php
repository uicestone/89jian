<?php
class Index extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		
		$packages = $this->object->getList(array('type'=>'package', 'meta'=>array('active'=>true), 'with_meta'=>true));
		
		$products = $this->object->getList(array('type'=>'product', 'meta'=>array('show_in_home'=>true), 'with_meta'=>true));
		
		$this->load->view('index',  compact('packages', 'products'));
	}
}
