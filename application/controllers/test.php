<?php

class Test extends LB_Controller{
	
	function __construct() {
		parent::__construct();
	}
	
	function index(){
		var_export($this->session->all_userdata());
		echo "\n";
		var_export($this->user);
	}
	
}