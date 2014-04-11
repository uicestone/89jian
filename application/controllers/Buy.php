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
			
			$package = $this->object->fetch($this->input->post('package'));
			
			//生成订单
			$order_id = $this->object->add(array(
				'type'=>'order',
				'name'=>$package['name'].' '.$this->input->post('次数').'次',
				'meta'=>array(
					'次数'=>$this->input->post('次数'),
					'金额'=>$this->input->post('次数') * end($package['meta']['价格']),
					'是否卡片'=>$this->input->post('是否卡片'),
					'首次送货日期'=>$this->input->post('首次送货日期'),
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
		
		$packages = $this->object->getList(array('type'=>'package'))['data'];
		
		$this->load->view('buy/product_option', compact('packages'));
	}
	
	/**
	 * 物流信息
	 */
	function logistic(){
		
		if($this->input->post() !== false){
			
			if(!$this->user->config('incompleted_order')){
				throw new Exception('No Incompleted Order Found', '500');
			}
			
			$this->object->id = $this->user->config('incompleted_order');
			$this->object->addMetas($this->input->post('meta'));
			$this->user->addMetas($this->input->post('meta'));
			
			$this->object->addStatus(array('name'=>'下单'));
			
			redirect('buy/pay/'.$this->object->id);
			
		}
		
		$this->load->view('buy/logistic');
		
	}
	
	function pay($order_id){
		
		$order = $this->object->fetch($order_id);
		
		$alipay_request_args = array(
			'service'=>'create_direct_pay_by_user',
			'partner'=>$this->company->config('alipay_partner_id'),
			'_input_charset'=>'utf-8',
			'return_url'=>base_url().'buy/paymentconfirm',
			'seller_email'=>'bin_lin@89jian.com',
			'out_trade_no'=>$order['id'],
			'subject'=>$order['name'],
			'payment_type'=>1,
			'total_fee'=>end($order['meta']['金额'])
		);
	  
		ksort($alipay_request_args);
		
		$alipay_request_args_temp = array();
		
		foreach($alipay_request_args as $key => $value){
			$alipay_request_args_temp[] = $key.'='.$value;
		}
		
		$sign_text = implode('&', $alipay_request_args_temp);
		
		$alipay_request_args['sign'] = md5($sign_text.$this->company->config('alipay_key'));
		
		$alipay_request_args['sign_type'] = 'MD5';
		
		$this->object->addMeta(array('key'=>'alipay_sign','value'=>$alipay_request_args['sign']));
		
		redirect('?'.http_build_query($alipay_request_args), 'php', $this->company->config('alipay_api'));
		
	}
	
	
	/**
	 * 支付完成返回页面
	 */
	function paymentConfirm(){
		
		$notify_verify = file_get_contents('https://mapi.alipay.com/gateway.do?service=notify_verify&partner='.$this->company->config('alipay_partner_id').'&notify_id='.$this->input->get('notify_id'));
		
		if($notify_verify !== 'true'){
			throw new Exception('支付校验失败', 400);
		}
		
		$order_id = $this->input->get('out_trade_no');
		
		$order = $this->object->fetch($order_id);
		
		$this->object->addMeta(array('key'=>'支付宝流水号', 'value'=>$this->input->get('trade_no')));
		
		$this->object->addStatus(array('name'=>'支付完成'));
		
		$this->user->config('incompleted_order', false);
		
		redirect('user/order');
		
	}
}

