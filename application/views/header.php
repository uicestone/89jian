<?php doctype(); ?>
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
    <? if($this->input->cookie('fontloaded')){ ?><link rel="stylesheet" href="/css/font.css"><? } ?>
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
		<? if($this->user->isLogged()){ ?>
                <a href="/user" class="signup item">【<?=$this->user->name?>】</a>
                <? if($this->user->isLogged('admin')){ ?>
                <a href="/admin" class="signup item">【管理】</a>
                <? } ?>
                <a href="/logout" class="signup item">【退出】</a>
		<? }else{ ?>
                <a href="/signup" class="signup item">【注冊】</a>
                <a href="/login" class="signup item">【登陸】</a>
		<? } ?>
            </div>
            <? if(in_array(uri_string(),array('','article/about-us'))){ ?>
            <div class="slogan">
                最<span class="pink">思</span>家中飯
            </div>
            <hr class="spliter">
            <div class="subslogan">
                <p>心田一畝粗茶一碗，勝過白銀三千黃金萬兩</p>
                <p>全國第一生態市麗水。八百米以上高山沃土，原生態刀耕火種，自然熟成輪耕輪種。</p>
            </div>
            <? } ?>
        </div>
    </div>
    <div class="navigation">
        <div class="navbar container">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">HOME / 首页</a></li>
                <li><a href="/article/about-us">ABOUT US / 关于我们</a></li>
                <li><a href="/category/food">INGREDIENT / 食材</a></li>
                <li><a href="/category/suite">SET MEAL / 套餐</a></li>
                <li><a href="/article/logistic">LOGISTICS / 配送</a></li>
                <li><a href="/user">MEMBER / 会员专区</a></li>
            </ul>
        </div>
    </div>
<?if(count($this->page_path)>1){?>
    <ul class="breadcrumb">
<?  foreach($this->page_path as $level => $page){?>
        <li>
            <?if($level===0){?><strong><?}?>
            <a href="<?=$page['href']?>"><?=$page['text']?></a>
            <?if($level===0){?></strong><?}?>
            <?if($level<count($this->page_path)-1){?><span class="divider">/</span><?}?>
        </li>
<?  }?>
    </ul>
<?}?>
