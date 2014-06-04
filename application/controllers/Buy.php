<?php

class Buy extends LB_Controller{
	function __construct() {
		parent::__construct();
		if(is_null($this->user->session_id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
	}
	
	/**
	 * 产品选项
	 */
	function index(){
		
		if(!is_null($this->input->post('next'))){
			// TODO 应当对次数做验证，这个表单需要验证
			$package = $this->object->fetch($this->input->post('package'));
			
			//生成订单
			$order_id = $this->object->add(array(
				'type'=>'order',
				'name'=>$package['name'] . ' (' . get_tag($package, '内容分类') . ' ' . get_tag($package, '价格档次') . ') ' .$this->input->post('次数').'周',
				'meta'=>array(
					'套餐'=>$package['name'] . ' (' . get_tag($package, '内容分类') . ' ' . get_tag($package, '价格档次') . ')',
					'内容分类'=>get_tag($package, '内容分类'),
					'价格档次'=>get_tag($package, '价格档次'),
					'次数'=>$this->input->post('次数'),
					'金额'=>$this->input->post('次数') * get_meta($package, '价格'),
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
			
			redirect('buy/logistic/' . $order_id);
		}
		
		$packages = $this->object->getList(array_merge(
			array('type'=>'package', 'with'=>array('tag', 'meta')),
			$this->input->get('package') ? array('tag'=>array('价格档次'=>$this->input->get('package'))) : array()
		));
		
		$this->load->view('buy/product_option', compact('packages'));
	}
	
	/**
	 * 物流信息
	 */
	function logistic($order_id){
		
		$this->object->id = $order_id;
		
		if(!is_null($this->input->post('next'))){
			
			try{
				$this->object->addMeta($this->input->post('meta'), null, true);
				$this->user->addMeta($this->input->post('meta'), null, true);
			}
			catch(Exception $e){
				$alert[] = array('message'=>$e->getMessage());
			}
			
			$this->object->addStatus('下单');
			
			redirect('buy/pay/'.$this->object->id);
			
		}
		
		if(!is_null($this->input->post('cancel'))){
			$this->object->addStatus('取消');
			redirect('order');
		}
		
		$current_user = $this->user->fetch($this->user->session_id);
		
		if(get_meta($current_user, '收货人') && get_meta($current_user, '联系电话') && get_meta($current_user, '收货地址') && get_meta($current_user, '邮编')){
			$this->object->updateMeta(array(
				'收货人'=>(string) get_meta($current_user, '收货人'),
				'联系电话'=>(string) get_meta($current_user, '联系电话'),
				'收货地址'=>(string) get_meta($current_user, '收货地址'),
				'邮编'=>(string) get_meta($current_user, '邮编')
			));
		}
		
		$order = $this->object->fetch($order_id);
		
		$this->load->view('buy/logistic', compact('order', 'alert'));
		
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
		
		try{
			$this->object->addMeta('alipay_sign', $alipay_request_args['sign'], true);
		}
		catch(Exception $e){}
		
		redirect($this->company->config('alipay_api').'?'.http_build_query($alipay_request_args));
		
	}
	
	
	/**
	 * 支付完成返回页面
	 */
	function paymentConfirm(){
		
//		$notify_verify = file_get_contents('https://mapi.alipay.com/gateway.do?service=notify_verify&partner='.$this->company->config('alipay_partner_id').'&notify_id='.$this->input->get('notify_id'));
//		
//		if($notify_verify !== 'true'){
//			throw new Exception('支付校验失败', 400);
//		}
//		
//		$order_id = $this->input->get('out_trade_no');
		
		$order = $this->object->fetch(16589);
		
		$this->object->addMeta('支付宝流水号', $this->input->get('trade_no'));
		
		$this->object->addStatus('支付完成');
		
		// 如果是卡，那么拿一张卡并写入订单信息
		if(get_meta($order, '是否卡片') === '是'){
			$card = $this->object->getRow(array('type'=>'card', 'meta'=>array('已绑定套餐'=>'否')));
			
			if(!$card){
				throw new Exception('获得卡片错误，请联系客服处理', 500);
			}
			
			$this->object->id = $card['id'];
			
			$this->object->authorize(array('read'=>true,'write'=>true), null, false);
			
			$this->object->updateMeta('已绑定套餐', '是');
			$this->object->addMeta(array(
				'套餐'=>get_meta($order, '套餐'),
				'价格档次'=>get_meta($order, '价格档次'),
				'内容分类'=>get_meta($order, '内容分类'),
				'次数'=>get_meta($order, '次数')
			));
			$this->object->addRelative('package', get_relative($order, 'package', 'id'));
			
			$this->object->authorize('public', null, false);
			
			// 购买的卡并不立即与用户发生关联，最终用户拿到卡，导入到自己的账号，才完成关联（直接导入“餐”，并不关联“卡”本身）
			
		}
		// 如果不是卡，那么直接将餐信息写入用户账户
		else{
			
			$this->user->getMeta();
			$bought = isset($this->user->meta['已购']) ? json_decode($this->user->meta['已购'][0], JSON_OBJECT_AS_ARRAY) : false;
			
			if(!$bought){
				$bought = array();
			}
			
			if(array_key_exists(get_meta($order, '价格档次'), $bought)){
				$bought[get_meta($order, '价格档次')] += get_meta($order, '次数');
			}
			else{
				$bought[get_meta($order, '价格档次')] = get_meta($order, '次数');
			}
			
			$this->user->updateMeta('已购', json_encode($bought));
			$this->user->updateMeta('套餐', get_meta($order, '套餐'));
			$this->user->updateMeta('下次送餐日期', get_meta($order, '首次送货日期'));
			
		}
		
		redirect('user/order');
		
	}
}

