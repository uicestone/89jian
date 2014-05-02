<?php

/**
 * 返回元数据中$key最新的一个值
 */
if(!function_exists('get_meta')){
	function get_meta(array $object, $key){
		
		if(!array_key_exists('meta', $object) || !array_key_exists($key, $object['meta'])){
			return false;
		}
		
		return array_pop($object['meta'][$key]);
	}
}

/**
 * 返回$relation关系最新的一个关联对象（信息）
 */
if(!function_exists('get_relative')){
	function get_relative(array $object, $relation, $field = 'name'){
		if(!array_key_exists('relative', $object) || !array_key_exists($relation, $object['relative'])){
			return false;
		}

		$relative = array_pop($object['relative'][$relation]);
		
		if(!$relative){
			return false;
		}
		
		if(is_null($field)){
			return $relative;
		}
		
		return $relative[$field];
	}
}

/**
 * 返回最新的一个状态，或指定状态名的最新一个时间
 * 对于两种形式表示的status，都可以解析出最新的一个状态中的某个字段（默认为状态名）
 * @property array $object
 * @property string|null 状态下的字段名，可以为name, date, comment
 */
if(!function_exists('get_status')){
	function get_status(array $object, $name = 'name'){
		if(!array_key_exists('status', $object) || !$object['status']){
			return false;
		}
		
		//数字键数组表示的status，每一个子数组是一行status数组
		if(array_is_numerical_index($object['status'])){
			$status = array_pop($object['status']);
			if(array_key_exists($name, $status)){
				return $status[$name];
			}
		}
		
		//索引键数组表示的status，是status.name和date的键值对
		$status = $object['status'];
		asort($status);
		$status_names = array_keys($status);
		return $name === 'name' ? array_pop($status_names) : array_pop($status);
		
	}
}

if(!function_exists('get_tag')){
	function get_tag($object, $taxonomy){
		if(!array_key_exists('tag', $object) || !array_key_exists($taxonomy, $object['tag'])){
			return false;
		}
		
		return implode(', ', $object['tag'][$taxonomy]);
	}
}