<?php doctype(); ?>
<html>
	<head>
		<title>八九间</title>
	</head>
	<body>
		<ul>
			<li><a href="/">首页</a></li>
			<li><a href="/article/about-us">关于我们</a></li>
			<li><a href="/category/food">食材</a></li>
			<li><a href="/category/suite">套餐</a></li>
			<li><a href="/article/logistic">配送</a></li>
			<li><a href="/user">会员专区</a></li>
		</ul>
		<?php if($this->user->isLogged()){ ?>
		<ul>
			<li><?=$this->user->name?></li>
		</ul>
		<?php } ?>