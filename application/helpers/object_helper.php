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
 * 返回最新的一个状态或其一个字段，或指定状态名的最新一个时间
 * 支持两种形式表示的status
 * @property array $object
 * @property string|null 为null时，返回最新一个状态；为name,date,comment时，返回最新一个状态的一个字段；为其他字符串时，返回该名称状态的最新一个时间
 */
if(!function_exists('get_status')){
	function get_status(array $object, $name = 'name'){
		
		if(!array_key_exists('status', $object) || !$object['status']){
			return false;
		}
		
		$status = array();
		
		foreach($object['status'] as $index => $row){
			if(is_integer($row)){
				$status[$row['date']] = $row;
			}
			else{
				foreach($row as $date){
					$status[$date] = array('name'=>$index, 'date'=>$date);
				}
			}
		}
		
		ksort($status);
		
		if(in_array($name, array('name', 'date', 'comment'))){
			end($status);
			$latest_status = current($status);;

			if(is_null($name)){
				return $latest_status;
			}
			elseif(array_key_exists($name, $latest_status)){
				return $latest_status[$name];
			}
			
			return false;
			
		}
		else{
			$status_k_v_pairs = array_column($status, 'date', 'name');
			
			if(array_key_exists($name, $status_k_v_pairs)){
				return $status_k_v_pairs[$name];
			}
			
			return false;
			
		}
		
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
