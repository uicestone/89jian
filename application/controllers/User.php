<?php
class User extends LB_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->page_name = 'user';
		$this->load->page_path[] = array('href'=>'/user', 'text'=>'用户中心');
	}
	
	function index($id = NULL){
		
		switch ($this->input->method) {
			case 'GET':
				if(is_null($id)){
					$this->getList();
				}
				else{
					$this->fetch($id);
				}
				break;
			
			case 'POST':
				$this->add();
				break;
			
			case 'PUT':
				$this->update($id);
				break;
			
			case 'DELETE':
				$this->remove($id);
				break;
		}
	}
	
	function fetch($id){
		
		$args=$this->input->get();
		
		$user = $this->user->fetch($id, $args);
		
		$this->output->set_output($user);
	}
	
	function getList(){
		
		$args=$this->input->get();
		
		$result = $this->user->getList($args);

		$this->output->set_output($result['data']);
		$this->output->set_status_header(200, 'OK, '.$result['info']['total'].' Users in Total');
	}
	
	function add(){
		$user_id = $this->user->add($this->input->data(), $this->input->get());
		$this->fetch($user_id);
	}
	
	function update($id){
		$this->user->id = $id;
		$this->user->update($this->input->data());
		$this->fetch($id);
	}
	
	function remove($id){
		$this->user->id = $id;
		$this->user->remove();
	}
	
	function logout(){
		$this->user->sessionLogout();
		redirect('');
	}

	/**
	 * 登陆页面
	 */
	function login(){

		if($this->user->isLogged()){
			redirect();
		}

		$alert=array();

		try{	
			if(!is_null($this->input->post('login'))){
				
				$user=$this->user->verify($this->input->post('username'), $this->input->post('password'));

				$this->user->sessionLogin($user['id']);

				if(!$this->input->post('forward') && $this->user->isLogged('admin')){
					redirect('admin');
				}

				redirect(urldecode($this->input->post('forward')));

			}
		}catch(Exception $e){
			$alert[]=array('message'=>$e->getMessage());
		}

		$this->load->page_name='register';

		$this->load->view('user/login',compact('alert'));
	}

	/**
	 * 注册页面
	 */
	function signup(){

		$this->load->library('form_validation');
		$this->load->helper('captcha');

		$captcha=create_captcha(array(
			'word'=>random_string('alnum',4),
			'img_path' => './uploads/captcha/',
			'img_url' => '/uploads/captcha/',
			'img_width' => 80
		));

		$data = array(
			'captcha_time' => $captcha['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $captcha['word']
		);

		$this->db->insert('captcha', $data);

		$this->form_validation->set_rules(array(
			array('field'=>'email','label'=>'E-mail','rules'=>'required|valid_email|is_unique[user.email]'),
			array('field'=>'username','label'=>'用户名','rules'=>'required|is_unique[user.name]'),
			array('field'=>'password','label'=>'密码','rules'=>'required'),
			array('field'=>'repassword','label'=>'重复密码','rules'=>'required|matches[password]'),
		))
			->set_message('matches','两次%s输入不一致')
			->set_message('test','同意用户协议')
			->set_rules('agree','同意用户协议','callback__agree');

		if(!is_null($this->input->post('signup'))){
			try{
				// 首先删除旧的验证码
				$this->db->where('captcha_time < ', time()-7200)->delete('captcha');

				// 然后再看是否有验证码存在:
				if ($this->db->where(array('word'=>$this->input->post('captcha'), 'ip_address'=>$this->input->ip_address()))->count_all_results('captcha') === 0){
					$this->form_validation->_field_data['captcha']['error']='验证码错误';
					throw new Exception;
				}

				if($this->form_validation->run()!==false){
					if(is_null($this->user->id)){
						$this->user->id = 1;//因为每个对象必须有user字段，新注册用户的user字段为root
					}

					$user_id=$this->user->add(array(
						'name'=>$this->input->post('username'),
						'password'=>$this->input->post('password'),
						'email'=>$this->input->post('email')
					));

					$this->user->sessionLogin($user_id);

					redirect(urldecode($this->input->post('forward')));
				}

			}catch(Exception $e){

			}
		}

		$this->load->page_name='signup';

		$this->load->view('user/signup',compact('captcha'));
	}

	/**
	 * 用户资料编辑页面
	 */
	function profile(){

		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}

		if(!is_null($this->input->post('submit'))){

			$this->load->library('form_validation');
			$this->form_validation->set_rules(array());

			try{

				if($this->input->post('password_new')){

					$this->form_validation->set_rules(array(
						array('field'=>'password','label'=>'密码','rules'=>'required'),
						array('field'=>'password_new','label'=>'新密码','rules'=>'required'),
						array('field'=>'password_new_confirm','label'=>'重复密码','rules'=>'required|matches[password_new]')
					))
						->set_message('matches','两次%s输入不一致');

					if(!$this->user->verify($this->user->name, $this->input->post('password'))){
						$this->form_validation->_field_data['password']['error']='原密码错误';
						throw new Exception();
					}

					if(!$this->form_validation->run()){
						throw new Exception();
					}

					$this->user->update(array('password'=>$this->input->post('password_new')),$this->user->id);
					$alert[]=array('title'=>'提示','message'=>'密码已修改','type'=>'info');

				}

				is_array($this->input->post('user')) && $this->user->update($this->input->post('user'));

				is_array($this->input->post('profiles')) && $this->user->updateProfiles($this->input->post('profiles'));

				$this->load->library('upload',array(
					'upload_path'=>'./uploads/',
					'allowed_types'=>'jpg',
					'overwrite'=>true
				));

				if(isset($_FILES['avatar']) && !$_FILES['avatar']['error']){
					if(!$this->upload->do_upload('avatar')){
						throw new Exception($this->upload->display_errors());
					}

					$upload_data=$this->upload->data();

					$this->load->library('image_lib');

					$this->image_lib->initialize(array(
						'source_image'=>$upload_data['full_path'],
						'maintain_ratio'=>true,
						'width'=>200,
						'height'=>200,
						'new_image'=>'./uploads/avatar/'.$this->user->id.'_200.jpg'
					));

					$this->image_lib->resize();

					$this->image_lib->clear();

					$this->image_lib->initialize(array(
						'source_image'=>$upload_data['full_path'],
						'maintain_ratio'=>true,
						'width'=>100,
						'height'=>100,
						'new_image'=>'./uploads/avatar/'.$this->user->id.'_100.jpg'
					));

					$this->image_lib->resize();

					$this->image_lib->clear();

					$this->image_lib->initialize(array(
						'source_image'=>$upload_data['full_path'],
						'maintain_ratio'=>true,
						'width'=>30,
						'height'=>30,
						'new_image'=>'./uploads/avatar/'.$this->user->id.'_30.jpg'
					));

					$this->image_lib->resize();

					$this->image_lib->clear();

					rename($upload_data['full_path'],'./uploads/avatar/'.$this->user->id.'.jpg');
				}

			}catch(Exception $e){
				$e->getMessage() && $alert[]=array('message'=>$e->getMessage());
			}
		}

		$user=$this->user->fetch();

		$this->load->page_path[]=array('text'=>'个人资料','href'=>'/profile');

		$this->load->view('user/profile', compact('user','alert'));
	}

	function config($item = null){
		
		switch($this->input->method){
			case 'GET':
				break;
			
			case 'POST':
				$data = $this->input->data();
				
				if(is_array($data)){
					foreach($data as $key => $value){
						$this->user->config($key, $value);
					}
				}
				else{
					$this->user->config($item, $data);
				}
				
				break;
		}
		
		$this->output->set_output(is_null($item) ? $this->user->config($item) : array($item=>$this->user->config($item)));
		
	}
	
	/**
	 * 用户中心首页
	 */
	function home(){
        redirect('meal');
	}

	function _agree($value){
		if(is_null($value)){
			$this->form_validation->set_message('_agree', '请同意“用户协议”');
			return false;
		}
		return true;
	}

	function resetPassword(){

		$this->load->library('form_validation');
		$this->load->helper('captcha');

		$captcha=create_captcha(array(
			'word'=>random_string('alnum',4),
			'img_path' => './uploads/captcha/',
			'img_url' => '/uploads/captcha/',
			'img_width' => 80
		));

		$data = array(
			'captcha_time' => $captcha['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $captcha['word']
		);

		$this->db->insert('captcha', $data);

		$this->form_validation->set_rules(array(
			array('field'=>'password','label'=>'新密码','rules'=>'required'),
			array('field'=>'repassword','label'=>'重复密码','rules'=>'required|matches[password]'),
		))
			->set_message('matches','两次%s输入不一致');

		if(!is_null($this->input->post('resetpassword'))){
			try{
				// 首先删除旧的验证码
				$expiration = time()-7200; // 2小时限制
				$this->db->where('captcha_time < ',$expiration)->delete('captcha');

				// 然后再看是否有验证码存在:
				$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
				$binds = array($this->input->post('captcha'), $this->input->ip_address(), $expiration);
				$query = $this->db->query($sql, $binds);
				$row = $query->row();
				if ($row->count == 0)
				{
					$this->form_validation->_field_data['captcha']['error']='验证码错误';
					throw new Exception;
				}

				$user = $this->user->getList(array('name'=>$this->input->post('username'),'email'=>$this->input->post('email')));

				if(empty($user)){
					$this->form_validation->_field_data['email']['error']='邮箱和用户名不匹配';
					throw new Exception;
				}

				if($this->form_validation->run()!==false){

					$token = random_string('alnum', 32);

					$this->user->id=$user[0]['id'];
					$this->user->set_config('password_reset/to', $this->input->post('password'));
					$this->user->set_config('password_reset/token', $token);
					$this->user->id=NULL;

					//$this->user->updatePassword($user[0]['id'], $this->input->post('password'));

					$this->load->library('email');

					$this->email->initialize(array(
						'protocol'=>'smtp',
						'smtp_host'=>$this->config->user_item('email/smtp/server'),
						'smtp_user'=>$this->config->user_item('email/smtp/username'),
						'smtp_pass'=>$this->config->user_item('email/smtp/password'),
						'mailtype'=>'html',
						'crlf'=>"\r\n",
						'newline'=>"\r\n"
					));

					$this->email->from($this->config->user_item('email/smtp/username'), '智塔帮助');
					$this->email->to($this->input->post('email')); 

					$this->email->subject('您申请重置您在智塔(Witower.com)的账户密码');
					$this->email->message('点击此链接以确认设置新密码<a href="'.base_url().'user/resetpasswordconfirm/'.$token.'" target="_blank">'.base_url().'user/resetpasswordconfirm/'.$token.'</a>'); 

					$this->email->send();

					$alert[]=array('type'=>'success','message'=>'成功发送重置确认邮件，前往邮箱点击链接即可重置密码');

				}
			}catch(Exception $e){
				$alert[]=array('type'=>'error','message'=>$e->getMessage());
			}

		}

		$this->load->page_name='register';

		$this->load->view('user/resetpassword', compact('captcha','alert'));
	}

	function resetPasswordConfirm($token){
		$uid = $this->user->retrieve_user_by_config('password_reset/token', $token);

		if($uid){
			$this->user->init($uid);
			$this->user->updatePassword($uid, $this->user->config('password_reset/to'));
			$this->user->remove_config_item('password_reset/to');
			$this->user->remove_config_item('password_reset/token');

			redirect('login');
		}
	}

	/**
	 * 我的仓库
	 */
	function meal(){
		
		$alert = array();
		
		$meals = $this->object->getList(array('type'=>'meal','with_relative'=>true,'with_meta'=>true,'with_status'=>true,'has_relative_like'=>array('user'=>$this->user->session_id)));

		$this->load->page_name = 'user-logistic-edit';
		$this->load->page_path[] = array('href'=>'/user/logistic', 'text'=>'我的仓库');
		
		$this->load->view('user/meal/list', compact('meals', 'alert'));
	}
	
	/**
	 * 我的订单
	 */
	function order($id = null){
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}

		$this->load->page_path[]=array('text'=>'我的订单','href'=>'/order');

		if(is_null($id)){

			$orders = $this->object->getList(array('type'=>'order','user'=>$this->user->id,'status'=>array('下单'),'with_status'=>true,'with_meta'=>true,'with_relative'=>true));

			$this->load->view('user/order/list', compact('orders'));
		}
		else{
			$order = $this->object->fetch($id);
			$this->load->view('user/order/edit', compact('order'));
		}

	}

	/**
	 * 卡片管理
	 */
	function card(){
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}

		$this->load->page_path[]=array('text'=>'卡片管理','href'=>'/card');

		$this->load->view('user/card/list');

	}}
?>
