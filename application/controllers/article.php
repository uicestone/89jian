<?php

class Article extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	function index($slug){
		$this->load->view('article');
	}
}