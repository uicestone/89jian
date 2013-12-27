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
	 * @param int $id
	 */
	function index(){
		$this->load->view('admin/index');
	}
	
	/**
	 * 订单管理
	 * @param int $id
	 */
	function order($id = null){
		
		if(is_null($id)){
			
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
								array('relation'=>'user','relative'=>$order['uid']),
								array('relation'=>'package','relative'=>end($order['relative']['package'])['id']),
							),
							'meta'=>array('次数'=>end($order['meta']['number']))
						));
					}
					else{
						for($i=0; $i<end($order['meta']['number']); $i++){
							$this->object->add(array(
								'type'=>'meal',
								'name'=>end($order['relative']['package'])['name'],
								'relative'=>array('package'=>end($order['relative']['package'])['id']),
								'meta'=>array('delivery'=>date('Y-m-d',strtotime(end($order['meta']['date_first_delivery']))+$i*7*86400))
							));
						}
					}
				}
			}
			
			$orders = $this->object->getList(array('type'=>'order','status'=>array('下单'),'with_status'=>true,'with_meta'=>true,'with_relative'=>true))['data'];
			
			$this->load->view('admin/order', compact('orders'));
		}
		else{
			$order = $this->object->fetch($id);
			$this->load->view('admin/order_detail', compact('order'));
		}
		
	}
	
	/**
	 * 配货管理
	 * @param int $id
	 */
	function logistic($id = null){
		$this->load->view('admin/logistic');
	}
	
	/**
	 * 食谱管理
	 * @param int $id
	 */
	function menu($id = null){
		$this->load->view('admin/menu');
	}
	
	/**
	 * 用户管理
	 * @param int $id
	 */
	function user($id = null){
		$this->load->view('admin/user');
	}
	
	/**
	 * 卡管理
	 * @param int $id
	 */
	function card($id = null){
		$this->load->view('admin/card');
	}
	
	/**
	 * 文章管理
	 * @param int $id
	 */
	function article($id = null){
		
	}
	
	function config($item = null){
		if(!$this->user->isLogged('config')){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
		if(is_null($item)){
			$this->load->page_path[]=array('text'=>lang('admin_config'),'href'=>'/admin/config');
			$this->load->view('admin/config',array('config_items'=>$this->config->witower));
		}
		else{
			if($this->input->post('submit')!==false){
				$this->config->set_user_item($item, $this->input->post('value'), 'db');
				redirect($this->uri->segment(1).'/config');
			}

			$this->load->page_path[]=array('text'=>lang('admin_config'),'href'=>'/admin/config');
			$this->load->page_path[]=array('text'=>$item,'href'=>'/admin/config/'.$item);

			$value=$this->config->user_item($item);
			$this->load->view('admin/config_edit',compact('item','value'));
		}
		
	}
	
}
