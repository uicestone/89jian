<?php

class Buy extends LB_Controller{
	function __construct() {
		parent::__construct();
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
	}
	
	/**
	 * 自动跳转判断
	 */
	function index(){
		redirect('buy/productoption');
	}
	
	/**
	 * 产品选项
	 */
	function productOption(){
		
		if($this->input->post() !== false){
			
			$order_id = $this->object->add(array(
				'type'=>'order',
				'name'=>$this->object->fetch($this->input->post('package'))['name'].' '.$this->input->post('number').'次',
				'meta'=>array(
					array(
						'key'=>'number',
						'value'=>$this->input->post('number')
					),
					array(
						'key'=>'is_card',
						'value'=>$this->input->post('is_card')
					)
				),
				'relative'=>array(
					array(
						'relative'=>$this->input->post('package')
					)
				),
			));
			
			$this->user->config('incompleted_order', $order_id);
			
			redirect('buy/logistic');
		}
		
		$this->load->view('buy/product_option');
	}
	
	/**
	 * 物流信息
	 */
	function logistic(){
		
		if($this->input->post() !== false){
			
			if(!$this->user->config('incompleted_order')){
				throw new Exception('no incompleted order found');
			}
			
			$this->object->id = $this->user->config('incompleted_order');
			$this->object->addMetas($this->input->post('meta'));
			$this->user->addMetas($this->input->post('meta'));
			
			$this->object->addStatus(array('name'=>'下单'));
			
			redirect('user/order');
			
		}
		
		$this->load->view('buy/logistic');
		
	}
}

