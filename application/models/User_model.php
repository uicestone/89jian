<?php
class User_model extends Object_model{
	
	var $session_id;
	var $name = '', $email, $password, $roles = array();
	var $groups = array();
	var $group_ids = array();//当前用户所属组的object id，包含当前用户的user id
	
	static $fields=array(
		'name'=>'',
		'email'=>null,
		'password'=>'',
		'roles'=>'',
		'last_ip'=>'',
		'last_login'=>null
	);
	
	function __construct($data = null, array $args = array()){
		parent::__construct($data, $args);
	}
	
	function initialize($id = null){
		
		$this->session_id = null;
		$this->group_ids = array();
		$this->groups = array();
		
		isset($id) && $this->session_id = intval($id);
		
		if(is_null($this->session_id) && $this->session->userdata('user_id')){
			$this->session_id = intval($this->session->userdata('user_id'));
		}
		
		if(!$this->session_id){
			return;
		}
		
		try{
			$user = $this->fetch($this->session_id, array('with'=>null), false);
		}catch(Exception $e){
			if($e->getCode() === 404){
				$this->sessionLogout();
				throw new Exception('unauthorized', 401);
			}
		}
		
		$this->name = $user['name'];
		
		$this->roles = $this->_parse_roles($user['roles']);
		
		array_push($this->group_ids, $this->session_id);
		
		$this->_get_parent_group(array($this->session_id));
		
		$groups = $this->groups;
		$this->groups = array();
		
		foreach($groups as $value){
			$this->groups[$value['id']] = $value;
		}
		
	}
	
	function _parse_roles($roles){
		
		$roles_decoded = json_decode($roles);
		
		if(is_array($roles_decoded)){
			return $roles_decoded;
		}
		elseif($roles){
			return explode(',', $roles);
		}
		else{
			return array();
		}
	}
	
	/**
	 * 
	 * @todo 应当避免掉入死循环
	 * @todo 应当在数据库建立缓存
	 */
	function _get_parent_group($children = array()){

		$parents = $this->getList(array(
			'type'=>'group',
			'has_relative_like'=>array($children)
		));
		
		$this->groups = array_merge($this->groups, $parents['data']);
		$parent_group_ids = array_map('intval', array_column($parents['data'], 'id'));
		$this->group_ids = array_merge($this->group_ids, $parent_group_ids);
		
		$this->roles = array_merge($this->roles, array_reduce(
			array_map(array($this, '_parse_roles'), array_column($parents['data'], 'roles')),
			function($result, $item){
				return array_merge($result, $item);
			}, array()
		));
			
		if($parent_group_ids){
			$this->_get_parent_group($parent_group_ids);
		}
		
	}

	function fetch($id = null, array $args = array(), $permission_check = true){
		
		if(is_null($id)){
			$id = $this->id;
		}
		
		$object = parent::fetch($id, $args, $permission_check);
		
		$user = $this->db->select('user.id, user.name, user.email, user.roles, user.last_ip, user.last_login')->from('user')->where('id', $id)->get()->row_array();
		
		if(!$user){
			throw new Exception(lang('user').' '.$id.' '.lang('not_found'), 404);
		}

		return array_merge($object, $user);
	}
	
	function getList(array $args=array()){
		
		$this->db->join('user','user.id = object.id','inner')->select('user.name, user.email, user.roles, user.last_ip, user.last_login');
		
		return parent::getList($args);
	}
	
	/**
	 * 
	 * @param array $data
	 * @param array $args
	 *	object 要添加为用户的对象ID，如果不指定，将新建一个对象
	 * @return int
	 * @todo 添加的用户是重复的，且没有指定对象时，会先成功创建对象，然后插入user表时失败，这样会在产生一个冗余对象
	 */
	function add(array $data, array $args = array()){
		
		!array_key_exists('type', $data) && $data['type'] = 'user';
		
		if(array_key_exists('object', $args)){
			$insert_id = $args['object'];
		}
		else{
			$insert_id = parent::add($data);
		}

		$data = array_merge(self::$fields, array_intersect_key($data,self::$fields));
		
		$data['id'] = $insert_id;
		$data['company'] = get_instance()->company->id;

		$this->db->insert('user',$data);
		
		return $insert_id;
	}
	
	function update(array $data){
		parent::update($data);
		return $this->db->update('user', array_intersect_key($data, self::$fields), array('id'=>$this->id));
	}
	
	function remove(){
		$this->db->delete('user', array('id'=>$this->id));
		parent::remove();
	}
	
	function verify($username, $password){
		
		$this->db
			->from('user')
			->where("(`name` = '" . $username . "' OR `email` = '" . $username . "')")
			->where('company', get_instance()->company->id)
			->where('password', $password);
		
		$user=$this->db->get()->row_array();
		
		if(!$user){
			throw new Exception('login_info_error', 403);
		}
		
		return $user;
	}
	
	/**
	 * 根据uid直接为其设置登录状态
	 */
	function sessionLogin($uid){
		$this->db->select('user.*')
			->from('user')
			->where('user.id',$uid);

		$user=$this->db->get()->row_array();
		
		if($user){
			$this->initialize($user['id']);
			$this->session->set_userdata('user_id', $user['id']);
			$this->update(array(
				'last_ip'=>$this->session->userdata('ip_address'),
				'last_login'=>date('Y-m-d H:i:s')
			));
			return true;
		}
		
		return false;
	}

	/**
	 * 登出当前用户
	 */
	function sessionLogout(){
		$this->session->sess_destroy();
		$this->initialize();
	}

	/**
	 * 判断是否以某用户组登录
	 * $check_type要检查的用户组,NULL表示只检查是否登录
	 */
	function isLogged($group=NULL){
		if(is_null($group)){
			if(empty($this->session_id)){
				return false;
			}
		}elseif(empty($this->roles) || !in_array($group,$this->roles)){
			return false;
		}

		return true;
	}
	
	/**
	 * set or get a user config value
	 * or get all config values of a user
	 * json_decode/encode automatically
	 * @param string $key
	 * @param mixed $value
	 */
	function config($key=NULL,$value=NULL){
		
		if(is_null($key)){
			
			$this->db->from('user_config')->where('user',$this->session_id);

			$config=array_column($this->db->get()->result_array(),'value','key');

			return array_map(function($value){
				
				$value = json_decode($value,true);
				
				return $value;
				
			}, $config);
			
		}
		elseif(is_null($value)){
			
			$row=$this->db->select('id,value')
				->from('user_config')
				->where('user',$this->session_id)
				->where('key',$key)
				->get()->row();

			if($row){
				$json_value=json_decode($row->value);
				
				return $json_value;
			}
			else{
				return false;
			}
		}
		else{
			
			$value=json_encode($value);
			
			return $this->db->upsert('user_config', array('user'=>$this->session_id,'key'=>$key,'value'=>$value));
		}
	}
	
	/**
	 * 根据user_config表中一项唯一的值反向获取用户ID，用于重置密码确认时识别用户
	 * 这并不是一个完美的解决方案，因此仅仅用于89jian，不能并入LubanLock
	 * @param string $item
	 * @param string $value
	 * @return int
	 */
	function retrieve_user_by_config($item, $value){
		return $this->db->select('user')
			->from('user_config')
			->where('key',$item)
			->where('value',json_encode($value))
			->get()->row()->user;
	}
	
	function remove_config($key){
		$this->db->delete('user_config',array('user'=>$this->user->id, 'key'=>$key));
	}
}
?>
