<?php

class Buy extends LB_Controller{
	function __construct() {
		parent::__construct();
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
	}
	
	/**
	 * 产品选项
	 */
	function productOption(){
		
		//如果有未填写完成的订单，跳转到物流信息
		if($this->user->config('incompleted_order')){
			redirect('buy/logistic');
		}
		
		if($this->input->post() !== false){
			
			//生成订单
			$order_id = $this->object->add(array(
				'type'=>'order',
				'name'=>$this->object->fetch($this->input->post('package'))['name'].' '.$this->input->post('次数').'次',
				'meta'=>array(
					'次数'=>$this->input->post('次数'),
					'是否卡片'=>$this->input->post('是否卡片'),
					'首次送货日期'=>$this->input->post('首次送货日期')
				),
				'relative'=>array(
					array(
						'relation'=>'package',
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
				throw new Exception('No Incompleted Order Found');
			}
			
			$this->object->id = $this->user->config('incompleted_order');
			$this->object->addMetas($this->input->post('meta'));
			$this->user->addMetas($this->input->post('meta'));
			
			$this->object->addStatus(array('name'=>'下单'));
			
			$this->user->config('incompleted_order', false);
			
			redirect('user/order');
			
		}
		
		$this->load->view('buy/logistic');
		
	}
	
	/**
	 * 支付完成返回页面
	 */
	function paymentConfirm(){
		
	}
}

