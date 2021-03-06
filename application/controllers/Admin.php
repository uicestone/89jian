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
		
		$orders = $this->object->getList(array('type'=>'order','with_status'=>true,'with_meta'=>true,'with_relative'=>true));

		$this->load->page_name = 'admin-order-list';
		$this->load->page_path[] = array('href'=>'/admin/order', 'text'=>'订单管理');
		
		$this->load->view('admin/order/list', compact('orders'));
		
	}
	
	function orderEdit($id = null){
		$order = $this->object->fetch($id);
		
		if(!is_null($this->input->post('deliver_card'))){
			$this->object->addStatus('卡片已发出', null, $this->input->post('card_delivery_comment'));
		}
		
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
		
		if(!is_null($this->input->post('assign')) && is_array($this->input->post('checked'))){
			foreach($this->input->post('checked') as $meal_id){
				$this->object->id = $meal_id;
				$this->object->addStatus('配货完成');
			}
			$alert[] = array('message'=>'选定项目已被标记为配货完成');
		}
		
		if(!is_null($this->input->post('deliver')) && is_array($this->input->post('checked'))){
			
			$logistic_provider = $this->input->post('logistic_provider');
			$logictic_number = $this->input->post('logistic_number');
			
			foreach($this->input->post('checked') as $meal_id){
				$this->object->id = $meal_id;
				$this->object->addStatus('已发货');
				!empty($logistic_provider[$meal_id]) && $this->object->addMeta('物流供应商', $logistic_provider[$meal_id]);
				!empty($logictic_number[$meal_id]) && $this->object->addMeta('物流单号', $logictic_number[$meal_id]);
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
		
		$this->user->id = $id;
		
		if(!is_null($this->input->post('submit'))){
			
			$data = $this->input->post();
			
			if(array_key_exists('password', $data) && $data['password'] === ''){
				unset($data['password']);
			}
			
			$this->user->update($data);
			
			$alert[] = array('type'=>'info', 'message'=>'用户信息已更新');
			
		}
		
		$user = $this->user->fetch();
		
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
		
		if(!is_null($this->input->post('submit'))){
			
			if(is_null($id)){
				$id = $this->object->add(array(
					'type'=>'card',
					'num'=>$this->input->post('num'),
					'name'=>$this->input->post('num'),
					'meta'=>array(
						'code'=>$this->input->post('code'),
						'已绑定套餐'=>'否',
						'已激活'=>'否'
					),
					'permission'=>'public'
				));
			}
			
			if($this->input->post('package')){
				
				$package = $this->object->fetch($this->input->post('package'));
				
				$this->object->id = $id;
				
				$this->object->setRelative('package', $package['id']);
				$this->object->updateMeta(array(
					'已绑定套餐'=>'是',
					'套餐'=>$package['name'] . ' (' . get_tag($package, '内容分类') . ' ' . get_tag($package, '价格档次') . ')',
					'价格档次'=>get_tag($package, '价格档次'),
					'内容分类'=>get_tag($package, '内容分类'),
					'次数'=>$this->input->post('amount')
				));
			}
			
			redirect('admin/card');
			
		}
		
		if(!is_null($id)){
			$card = $this->object->fetch($id);
		}
		
		$packages = $this->object->getList(array('type'=>'package'));
		
		$this->load->page_name = 'admin-card-detail';
		$this->load->page_path[] = array('href'=>'/admin/card', 'text'=>'卡片管理');
		$this->load->page_path[] = array('href'=>'/admin/card/'.(isset($card) ? $card['id'] : 'add'), 'text'=>(isset($card) ? $card['name'] : '添加卡片'));
		
		$this->load->view('admin/card/edit', compact('card', 'packages'));
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
		
		$this->object->id = $id;
		
		if(!is_null($this->input->post('submit'))){
			
			if(is_null($this->object->id)){
				$this->object->add(array(
					'type'=>'article',
					'num'=>urlencode($this->input->post('title')),
					'name'=>$this->input->post('title'),
					'meta'=>array('内容'=>$this->input->post('content')),
					'permission'=>'public'
				));
				
				redirect('admin/article');
			}
			else{
				$this->object->update(array(
					'name'=>$this->input->post('title'),
				));

				$this->object->updateMeta('内容', $this->input->post('content'));
			}
		}
		
		if(!is_null($this->input->post('remove'))){
			$this->object->remove();
			redirect('admin/article');
		}
		
		if(!is_null($this->object->id)){
			$article = $this->object->fetch($id);
		}
		
		$this->load->page_name = 'admin-article-detail';
		$this->load->page_path[] = array('href'=>'/admin/article', 'text'=>'文章管理');
		$this->load->page_path[] = array('href'=>'/admin/article/'.(isset($article) ? $article['id'] : 'add'), 'text'=>(isset($article) ? $article['name'] : '添加文章'));

		$this->load->view('admin/article/edit', compact('article'));
	}
	
	/**
	 * 单品管理
	 */
	function productList(){
		$products = $this->object->getList(array('type'=>'product'));
		
		$this->load->page_name = 'admin-product-list';
		$this->load->page_path[] = array('href'=>'/admin/product', 'text'=>'单品管理');
		
		$this->load->view('admin/product/list', compact('products'));
	}
	
	function productEdit($id = null){
		
		$this->object->id = $id;
		
		if(!is_null($this->input->post('submit'))){
			
			if(is_null($this->object->id)){
				$this->object->add(array(
					'type'=>'product',
					'num'=>urlencode($this->input->post('name')),
					'name'=>$this->input->post('name'),
					'meta'=>$this->input->post('meta'),
					'permission'=>'public'
				));
				
				redirect('admin/product');
			}
			else{
				
				$this->object->update(array(
					'name'=>$this->input->post('name'),
					'meta'=>$this->input->post('meta')
				));

			}
		}
		
		if(!is_null($this->input->post('remove'))){
			$this->object->remove();
			redirect('admin/product');
		}
		
		if(!is_null($this->object->id)){
			$product = $this->object->fetch($id);
		}
		
		$this->load->page_name = 'admin-product-detail';
		$this->load->page_path[] = array('href'=>'/admin/product', 'text'=>'单品管理');
		$this->load->page_path[] = array('href'=>'/admin/product/'.(isset($product) ? $product['id'] : 'add'), 'text'=>(isset($product) ? $product['name'] : '添加单品'));

		$this->load->view('admin/product/edit', compact('product'));
	}
	
	/**
	 * 套餐管理
	 */
	function packageList(){
		$packages = $this->object->getList(array('type'=>'package', 'with'=>array('tag', 'meta')));
		
		$this->load->page_name = 'admin-package-list';
		$this->load->page_path[] = array('href'=>'/admin/package', 'text'=>'套餐管理');
		
		$this->load->view('admin/package/list', compact('packages'));
	}
	
	function packageEdit($id = null){
		
		$this->object->id = $id;
		
		if(!is_null($this->input->post('submit'))){
			
			if(is_null($this->object->id)){
				$this->object->add(array(
					'type'=>'package',
					'name'=>$this->input->post('name'),
					'meta'=>$this->input->post('meta'),
					'tag'=>$this->input->post('tag'),
					'permission'=>'public'
				));
				
				redirect('admin/package');
			}
			else{
				$this->object->update(array(
					'name'=>$this->input->post('name'),
				));

				$this->object->updateMeta('内容', $this->input->post('content'));
			}
		}
		
		if(!is_null($this->input->post('remove'))){
			$this->object->remove();
			redirect('admin/package');
		}
		
		if(!is_null($this->object->id)){
			$package = $this->object->fetch($id);
		}
		
		$this->load->page_name = 'admin-package-detail';
		$this->load->page_path[] = array('href'=>'/admin/package', 'text'=>'套餐管理');
		$this->load->page_path[] = array('href'=>'/admin/package/'.(isset($package) ? $package['id'] : 'add'), 'text'=>(isset($package) ? $package['name'] : '添加套餐'));

		$this->load->view('admin/package/edit', compact('package'));
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
		
		$item = urldecode($item);
		
		if(!is_null($this->input->post('submit'))){
			$value = is_json($this->input->post('value')) ? json_decode($this->input->post('value')) : $this->input->post('value');
			$this->company->config($item, $value);
			redirect('admin/config');
		}
		
		$value = $this->company->config($item);
		
		if(!is_string($value)){
			$value = json_encode($value, JSON_UNESCAPED_UNICODE);
		}
		
		$this->load->page_name = 'admin-config-detail';
		$this->load->page_path[] = array('href'=>'/admin/config', 'text'=>'系统配置');
		$this->load->page_path[] = array('href'=>'/admin/config/' . urlencode($item), 'text'=>$item);
		
		$this->load->view('admin/config/edit', compact('value'));
	}
	
}
