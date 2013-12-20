<?php
class Index extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		$this->load->view('index');
	}
}
