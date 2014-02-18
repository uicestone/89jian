<?php
/**
 * @param string $uri
 * @param string $method php|js
 * @param string $base_url
 */
function redirect($uri='',$method='php',$base_url=NULL){
	$CI=&get_instance();
	is_null($base_url) && $base_url=$CI->config->item('base_url');

	if($method=='php'){
		header("location:{$base_url}".$uri);
	}
	elseif($method=='js'){
		echo "<script>location.href='$base_url.$uri</script>";
	}
	exit;
}

/**
 * 输出1K的空格来强制浏览器输出
 * 使用后在下文执行任何输出，再紧跟flush();即可即时看到
 */
function forceExport(){
	ob_end_clean();   //清空并关闭输出缓冲区
	echo str_repeat(' ',1024);
}
?>