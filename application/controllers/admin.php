<?php

class Admin extends LB_Controller{
	function __construct() {
		parent::__construct();
		
		if(!$this->user->isLogged('admin')){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
	}
	
	/**
	 * 管理中心首页
	 */
	function index(){
        redirect('admin/user');
	}
	
	/**
	 * 订单管理
	 */
	function orderList(){
		
		if($this->input->post('confirm') !== false && is_array($this->input->post('checked'))){
			foreach($this->input->post('checked') as $checked){
				$this->object->id = intval($checked);
				$this->object->addStatus(array('name'=>'已确认'));

				$order = $this->object->fetch();

				if(end($order['meta']['is_card'])){
					$this->object->add(array(
						'type'=>'card',
						'name'=>end($order['meta']['number']).'次 '.end($order['relative']['package'])['name'].'卡',
						'relative'=>array(
							'package'=>end($order['relative']['package'])['id'],
							'user'=>$order['uid'],
							'order'=>$order['id']
						),
						'meta'=>array('次数'=>end($order['meta']['number']))
					));
				}
				else{
					for($i=0; $i<end($order['meta']['number']); $i++){
						$this->object->add(array(
							'type'=>'meal',
							'name'=>end($order['relative']['package'])['name'],
							'relative'=>array(
								'package'=>end($order['relative']['package'])['id'],
								'user'=>$order['uid'],
								'order'=>$order['id']
							),
							'meta'=>array('delivery'=>date('Y-m-d',strtotime(end($order['meta']['date_first_delivery']))+$i*7*86400))
						));
					}
				}
			}
		}

		$orders = $this->object->getList(array('type'=>'order','status'=>array('下单'),'with_status'=>true,'with_meta'=>true,'with_relative'=>true))['data'];

		$this->load->view('admin/order/list', compact('orders'));
		
	}
	
	function orderEdit($id = null){
		$order = $this->object->fetch($id);
		$this->load->view('admin/order/edit', compact('order'));
	}
	
	/**
	 * 配货管理
	 * @param int $id
	 */
	function logisticList(){
		$meals = $this->object->getList(array('type'=>'meal','with_relative'=>true,'with_meta'=>true,'with_status'=>true));
		$this->load->view('admin/logistic/list', compact('meals'));
	}
	
	function logisticEdit($id = null){
		$meal = $this->object->fetch($id);
		$this->load->view('admin/logistic/edit', compact('meal'));
	}
	
	/**
	 * 食谱管理
	 * @param int $id
	 */
	function menuList(){
		
	}
	
	function menuEdit($id = null){
		
	}
	
	/**
	 * 用户管理
	 * @param int $id
	 */
	function userList(){
		$users = $this->user->getList();
		$this->load->view('admin/user/list', compact('users'));
	}
	
	function userEdit($id=NULL){
		$user = $this->user->fetch($id);
		$this->load->view('admin/user/edit', compact('user'));
	}
	
	/**
	 * 卡管理
	 */
	function cardList(){
		$cards = $this->object->getList(array('type'=>'card'));
		$this->load->view('admin/card/list', compact('cards'));
	}
	
	function cardEdit($id = null){
		$card = $this->object->fetch($id);
		$this->load->view('admin/card/edit', compact('card'));
	}
	
	/**
	 * 文章管理
	 */
	function articleList(){
		$articles = $this->object->getList(array('type'=>'article'));
		$this->load->view('admin/article/list', compact('articles'));
	}
	
	function articleEdit($id = null){
		$article = $this->object->fetch($id);
		$this->load->view('admin/article/edit', compact('article'));
	}
	
	/**
	 * 系统配置
	 */
	function configList(){
		$items = $this->company->config();
		$this->load->view('admin/config/list', compact('items'));
	}
	
	function configEdit($item = null){
		$value = $this->company->config($item);
		$this->load->view('admin/config/edit', compact('value'));
	}
	
}
