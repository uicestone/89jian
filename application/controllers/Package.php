<?php

class Package extends LB_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->load->view('package/price-list');
	}
	
	function type($price){
		$packages = $this->object->getList(array('type'=>'package', '价格档次'=>$price, 'with'=>array('tag', 'meta')));
		$this->load->view('package/type-list', compact('packages'));
	}
	
}
