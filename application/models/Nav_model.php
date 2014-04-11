<?php
class Nav_model extends CI_Model{
	
	static $fields;
	
	function __construct() {
		parent::__construct();
		
		self::$fields=array(
			'user' => $this->user->id,
			'name' => '',
			'params' => '',
			'parent' => NULL,
			'order' => 0
		);
		
	}
	
	
	function add(array $data){
		
		if(array_key_exists('param', $data)){
			$data['param'] = json_encode($data['param']);
		}
		
		$this->db->upsert('nav',
			array_merge(
				self::$fields,
				array_intersect_key($data, self::$fields)
			)
		);
		
		return $this->db->insert_id();
	}
	
	function update(array $data, $id){
	
		if(array_key_exists('params', $data)){
			$data['params'] = json_encode($data['params']);
		}
		
		return $this->db->update('nav', array_intersect_key($data, self::$fields), array('id'=>$id));
	}
	
	function get(){

		$nav_items = $this->db->from('nav')->get()->result_array();

		foreach($nav_items as &$nav_item){

			$nav_item['params'] = json_decode($nav_item['params'], JSON_OBJECT_AS_ARRAY);

			if(array_key_exists('href', $nav_item['params'])){
				$nav_item['href'] = $nav_item['params']['href'];
			}

		}
		
		return $nav_items;

	}
}
