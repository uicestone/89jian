<?php
/**
 * 递归去除array中的空键
 */
function array_trim($array){
	$array=(array)$array;
	foreach($array as $k => $v){
		if($v=='' || $v==array()){
			unset($array[$k]);
		}elseif(is_array($v)){
			$array[$k]=array_trim($v);
		}
	}
	return $array;
}

/**
 * 
 * @param array $arrays
 * array(
 *	'签约'=>array(
 *		array(
 *			people=>1
 *			sum=>3
 *		),
 *		array(
 *			people=>2
 *			sum=>3
 *		)
 *	)
 *	'创收'=>array(
 *		array(
 *			people=>1
 *			sum=>3
 *		)
 *	)
 * )
 * @param type $key 'sum'
 * @param type $using 'people'
 * @return array(
 *	1=>array(
 *		签约=>3
 *		创收=>3
 *	)
 * )
 */
function array_join(array $arrays,$key,$using){
	$joined=array();
	foreach($arrays as $key => $array){
		foreach($array as $row){
			
		}
	}
}

/**
 * 将数组的键作为路径，返回指定路径的子数组
 * 例如输入$array=array('a/b'=>1,'a/c'=>2,'b/a'=>3), $index='a'
 * 将返回array('b'=>1,'c'=>2);
 * @param $array
 * @param $prefix 路径
 * @param $prefix_end_with_slash 是否为prefix末尾加上'/' (default:true)
 * @param $preg 将prefix作为正则表达式匹配，由于匹配到的键名可能不唯一，因此将输出多个子数组形成的新数组
 * @return $subarray
 */
function array_prefix(array $array,$prefix,$preg=false,$prefix_end_with_slash=true){
	
	//数组中恰好存在与prefix一致的键名，则返回该键值
	if(!$preg && array_key_exists($prefix, $array)){
		return $array[$prefix];
	}
	
	if($prefix===''){
		return $array;
	}
	
	if(!$preg){
		$prefix=preg_quote($prefix,'/');
	}
	
	if($prefix_end_with_slash){
		$prefix.='\/';
	}

	$prefixed_array=array();

	foreach($array as $key => $value){
		$matches=array();
		preg_match("/^$prefix/",$key,$matches);
		if($matches){
			if($prefix_end_with_slash){
				$matches[0]=substr($matches[0],0,strlen($matches[0])-1);
			}
			$prefixed_array[$matches[0]][preg_replace("/^$prefix/", '', $key)]=$value;
		}
	}
	
	if($preg){
		return $prefixed_array;
	}else{
		return $prefixed_array?array_pop($prefixed_array):array();
	}
}

/**
 * 判断一个字符串是否为有效的json序列
 * @param type $string
 * @return type
 */
function is_json($string) {
	json_decode($string);
	return (json_last_error() === JSON_ERROR_NONE);
}

/**
 * 清除数组尾部的二级空数组
 * @param array $array
 * @return array
 */
function array_trim_rear(array $array){
	
	$return=$array;
	
	while(true){
		$tail=array_pop($array);
		if($tail===array()){
			$return=$array;
			continue;
		}else{
			break;
		}
	}

	return $return;
}

function array_remove_value(array &$array,$remove,$like=false){
	foreach($array as $key => $value){
		if(
			($like===false && $value==$remove)
			|| ($like===true && strpos($value,$remove)!==false)
			|| (is_callable($like) && $like($value,$remove))
		){
			unset($array[$key]);
		}
	}
}

function array_is_numerical_index($array){
	return array_reduce(array_keys($args), function($result, $item){
		return $result && is_integer($item);
	}, true);
}
?>
