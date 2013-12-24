<?php

class User extends LB_Controller{
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * 用户中心首页
	 */
	function index(){
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
		$this->load->view('user/index');
		
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
		
		if($this->input->post('signup')!==false){
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

				if($this->form_validation->run()!==false){
					$user_id=$this->user->add(array(
						'name'=>$this->input->post('username'),
						'password'=>$this->input->post('password'),
						'email'=>$this->input->post('email')
					));

					$this->user->sessionLogin($user_id);

					redirect(urldecode($this->input->post('forward')));
				}
			}catch(Exception $e){
				show_error($e->getMessage());
			}
		}
		
		$this->load->page_name='signup';
		
		$this->load->view('user/signup',compact('captcha'));
	}
	
	function _agree($value){
		if(is_null($value)){
			$this->form_validation->set_message('_agree', '请同意“用户协议”');
			return false;
		}
		return true;
	}
		
	/**
	 * 登陆页面
	 */
	function login(){
		
		if($this->user->isLogged()){
			redirect();
		}
		
		$alert=array();
		
		if($this->input->post('login')!==false){
			$user=$this->user->verify($this->input->post('username'), $this->input->post('password'));
			if($user){
				$this->user->sessionLogin($user['id']);
				redirect(urldecode($this->input->post('forward')));
			}else{
				$alert[]=array('title'=>'错误：','message'=>'用户名或密码错误');
			}
		}
		
		$this->load->page_name='register';
		
		$this->load->view('user/login',compact('alert'));
	}
	
	function logout(){
		$this->user->sessionLogout();
		redirect('');
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
		
		if($this->input->post('resetpassword')!==false){
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
	 * 用户资料编辑页面
	 */
	function profile(){
		
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
		if($this->input->post('submit')!==false){
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules(array());
			
			try{
				
				if($this->input->post('password_new')!==false){
					
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
		
		$profiles=$this->user->getProfiles();
		
			$this->load->page_path[]=array('text'=>lang('profile'),'href'=>'/profile');
		
		$this->load->view('user/profile', compact('user','profiles','alert'));
	}
	
	/**
	 * 我的仓库
	 */
	function repository(){
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
		$this->load->view('user/repository');
		
	}
	
	/**
	 * 我的订单
	 */
	function order(){
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
		$this->load->view('user/order');
		
	}
	
	/**
	 * 卡片管理
	 */
	function card(){
		if(is_null($this->user->id)){
			redirect('login?'.http_build_query(array('forward'=>substr($this->input->server('REQUEST_URI'),1))));
		}
		
		$this->load->view('user/card');
		
	}
	
}
