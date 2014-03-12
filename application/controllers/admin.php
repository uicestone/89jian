<?php

class Admin extends LB_Controller{
	function __construct() {
		parent::__construct();
		
		if(!$this->user->isLogged('admin')){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
		$this->load->page_name = 'admin';
		$this->load->page_path[] = array('href'=>'/admin', 'text'=>'管理中心');
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

				if(end($order['meta']['是否卡片'])){
					$this->object->add(array(
						'type'=>'card',
						'name'=>end($order['meta']['次数']).'次 '.end($order['relative']['package'])['name'].'卡',
						'relative'=>array(
							'package'=>end($order['relative']['package'])['id'],
							'user'=>$order['user'],
							'order'=>$order['id']
						),
						'meta'=>array('次数'=>end($order['meta']['次数']))
					));
				}
				else{
					for($i=0; $i<end($order['meta']['次数']); $i++){
						$this->object->add(array(
							'type'=>'meal',
							'name'=>end($order['relative']['package'])['name'],
							'relative'=>array(
								'package'=>end($order['relative']['package'])['id'],
								'user'=>$order['user'],
								'order'=>$order['id']
							),
							'meta'=>array('送货日期'=>date('Y-m-d',strtotime(end($order['meta']['首次送货日期']))+$i*7*86400))
						));
					}
				}
			}
		}

		$orders = $this->object->getList(array('type'=>'order','status'=>array('下单'),'with_status'=>true,'with_meta'=>true,'with_relative'=>true))['data'];

		$this->load->page_name = 'admin-order-list';
		$this->load->page_path[] = array('href'=>'/admin/order', 'text'=>'订单管理');
		
		$this->load->view('admin/order/list', compact('orders'));
		
	}
	
	function orderEdit($id = null){
		$order = $this->object->fetch($id);
		
		$this->load->page_name = 'admin-order-detail';
		$this->load->page_path[] = array('href'=>'/admin/order', 'text'=>'订单管理');
		$this->load->page_path[] = array('href'=>'/admin/order/'.$order['id'], 'text'=>$order['name']);
		
		$this->load->view('admin/order/edit', compact('order'));
	}
	
	/**
	 * 配货管理
	 */
	function logisticList(){
		
		$alert = array();
		
		if($this->input->post('assign') !== false && is_array($this->input->post('checked'))){
			foreach($this->input->post('checked') as $meal_id){
				$this->object->id = $meal_id;
				$this->object->addStatus(array('name'=>'配货完成'));
			}
			$alert[] = array('message'=>'选定项目已被标记为配货完成');
		}
		
		if($this->input->post('deliver') !== false && is_array($this->input->post('checked'))){
			
			$logistic_provider = $this->input->post('logistic_provider');
			$logictic_number = $this->input->post('logistic_number');
			
			foreach($this->input->post('checked') as $meal_id){
				$this->object->id = $meal_id;
				$this->object->addStatus(array('name'=>'已发货'));
				!empty($logistic_provider[$meal_id]) && $this->object->addMeta(array('key'=>'物流供应商', 'value'=>$logistic_provider[$meal_id]));
				!empty($logictic_number[$meal_id]) && $this->object->addMeta(array('key'=>'物流单号', 'value'=>$logictic_number[$meal_id]));
			}
			$alert[] = array('message'=>'选定项目已被标记为已发货，物流供应商和单号信息已保存');
		}
		
		$meals = $this->object->getList(array('type'=>'meal','with_relative'=>true,'with_meta'=>true,'with_status'=>array('as_rows'=>true)));

		$this->load->page_name = 'admin-logistic-edit';
		$this->load->page_path[] = array('href'=>'/admin/logistic', 'text'=>'配货管理');
		
		$this->load->view('admin/logistic/list', compact('meals', 'alert'));
	}
	
	function logisticEdit($id = null){
		$meal = $this->object->fetch($id);
		
		$this->load->page_name = 'admin-logistic-detail';
		$this->load->page_path[] = array('href'=>'/admin/order', 'text'=>'配货管理');
		$this->load->page_path[] = array('href'=>'/admin/order/'.$meal['id'], 'text'=>$meal['name']);
		
		$this->load->view('admin/logistic/edit', compact('meal'));
	}
	
	/**
	 * 食谱管理
	 * @param int $id
	 */
	function recipeList(){
		$recipes = $this->object->getlist(array('type'=>'recipe'));
		
		$this->load->page_name = 'admin-recipe-list';
		$this->load->page_path[] = array('href'=>'/admin/recipe', 'text'=>'食谱管理');
		
		$this->load->view('admin/recipe/list', compact('recipes'));
		
	}
	
	function recipeEdit($id = null){
		
		$recipe = $this->object->fetch($id);
		
		$this->load->page_name = 'admin-recipe-detail';
		$this->load->page_path[] = array('href'=>'/admin/recipe', 'text'=>'食谱管理');
		$this->load->page_path[] = array('href'=>'/admin/recipe/'.$recipe['id'], 'text'=>$recipe['name']);
		
		$this->load->view('admin/recipe/detail', compact('recipe'));
		
	}
	
	/**
	 * 用户管理
	 * @param int $id
	 */
	function userList(){
		$users = $this->user->getList();
		
		$this->load->page_name = 'admin-user-list';
		$this->load->page_path[] = array('href'=>'/admin/user', 'text'=>'用户管理');
		$this->load->view('admin/user/list', compact('users'));
	}
	
	function userEdit($id=NULL){
		
		$alert = array();
		
		if($this->input->post('submit') !== false){
			
			$this->user->update($id, $this->input->post());
			
			$alert[] = array('type'=>'info', 'message'=>'用户信息已更新');
			
			if($this->input->post('password')){
				$this->user->updatePassword($id, $this->input->post('password'));
				$alert[] = array('message'=>'用户密码已更新');
			}
			
			if($this->input->post('group')){
				$this->user->updateGroup($id, $this->input->post('group'));
				$alert[] = array('message'=>'用户组已更新');
			}
			
		}
		
		$user = $this->user->fetch($id);
		
		$this->load->page_name = 'admin-user-detail';
		$this->load->page_path[] = array('href'=>'/admin/user', 'text'=>'用户管理');
		$this->load->page_path[] = array('href'=>'/admin/user/'.$user['id'], 'text'=>$user['name']);
		
		$this->load->view('admin/user/edit', compact('user', 'alert'));
	}
	
	/**
	 * 卡管理
	 */
	function cardList(){
		
		$cards = $this->object->getList(array('type'=>'card', 'with_relative'=>true, 'with_meta'=>true));
		$this->load->page_name = 'admin-card-list';
		$this->load->page_path[] = array('href'=>'/admin/card', 'text'=>'卡片管理');
		
		$this->load->view('admin/card/list', compact('cards'));
	}
	
	function cardEdit($id = null){
		$card = $this->object->fetch($id);
		
		$this->load->page_name = 'admin-card-detail';
		$this->load->page_path[] = array('href'=>'/admin/card', 'text'=>'卡片管理');
		$this->load->page_path[] = array('href'=>'/admin/card/'.$card['id'], 'text'=>$card['name']);
		
		$this->load->view('admin/card/edit', compact('card'));
	}
	
	/**
	 * 文章管理
	 */
	function articleList(){
		$articles = $this->object->getList(array('type'=>'article'));
		
		$this->load->page_name = 'admin-article-list';
		$this->load->page_path[] = array('href'=>'/admin/article', 'text'=>'文章管理');
		
		$this->load->view('admin/article/list', compact('articles'));
	}
	
	function articleEdit($id = null){
		$article = $this->object->fetch($id);
		
		$this->load->page_name = 'admin-article-detail';
		$this->load->page_path[] = array('href'=>'/admin/article', 'text'=>'文章管理');
		$this->load->page_path[] = array('href'=>'/admin/article/'.$article['id'], 'text'=>$article['name']);

		$this->load->view('admin/article/edit', compact('article'));
	}
	
	/**
	 * 系统配置
	 */
	function configList(){
		$items = $this->company->config();
		
		$this->load->page_name = 'admin-config-list';
		$this->load->page_path[] = array('href'=>'/admin/config', 'text'=>'系统配置');
		
		$this->load->view('admin/config/list', compact('items'));
	}
	
	function configEdit($item = null){
		$value = $this->company->config($item);
		
		$this->load->page_name = 'admin-config-detail';
		$this->load->page_path[] = array('href'=>'/admin/config', 'text'=>'系统配置');
		$this->load->page_path[] = array('href'=>'/admin/config/'.$item, 'text'=>$item);
		
		$this->load->view('admin/config/edit', compact('value'));
	}
	
}
