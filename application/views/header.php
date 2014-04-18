<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>八九間</title>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/base.css">
	<link rel="stylesheet" href="/css/home.css">
	<link rel="stylesheet" href="/css/about.css">
	<link rel="stylesheet" href="/css/back.css">
	<link rel="stylesheet" href="/css/buy.css">
	<link rel="stylesheet" href="/css/datepicker.css">
	<?php if($this->input->cookie('fontloaded')){ ?><link rel="stylesheet" href="/css/font.css"><?php } ?>
	<script src="/js/jquery-1.9.1.js"></script>
	<script src="/js/sticky.js"></script>
</head>
<body data-spy="scroll" data-target=".navpanel" data-offset="0">
	<!-- header -->
	<div class="banner">
		<div class="container">
			<img class="logo" src="/img/logo.png" />
			<div class="account">
				<span class="welcome item">歡迎來到八九間</span>
		<?php if($this->user->isLogged()){ ?>
				<a href="/home" class="signup item">【<?=$this->user->name?>】</a>
				<?php if($this->user->isLogged('admin')){ ?>
				<a href="/admin" class="signup item">【管理】</a>
				<?php } ?>
				<a href="/logout" class="signup item">【退出】</a>
		<?php }else{ ?>
				<a href="/signup" class="signup item">【注冊】</a>
				<a href="/login" class="signup item">【登陸】</a>
		<?php } ?>
			</div>
			<?php if(in_array(uri_string(),array('','article/about-us'))){ ?>
			<div class="slogan"></div>
			<?php } ?>
		</div>
	</div>
	<div class="navigation">
		<div class="navbar container">
			<ul class="nav navbar-nav">
				<?php foreach($this->nav->get() as $nav_item){ ?>
				<li<?php if('/'.uri_string() === $nav_item['params']['href']){ ?> class="active"<?php } ?>><?=anchor($nav_item['params']['href'], $nav_item['name'], $nav_item['params'])?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
<?php if(count($this->page_path)>1){ ?>
	<div class="container">
		<ol class="breadcrumb">
			<?php  foreach($this->page_path as $level => $page){ ?>
			<li<?php if($level==count($this->page_path)-1){ ?> class="active"<?php } ?>>
				<?php if($level===0){ ?><strong><?php } ?>
				<a href="<?=$page['href']?>"><?=$page['text']?></a>
				<?php if($level===0){ ?></strong><?php } ?>
				<?php if($level<count($this->page_path)-1){ ?><span class="divider">/</span><?php } ?>
			</li>
			<?php  } ?>
		</ol>
	</div>
<?php } ?>
