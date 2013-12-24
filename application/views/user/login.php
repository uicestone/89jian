<?$this->view('header')?>
	<div class="title">
		<h1>登录</h1>
	</div>
	<?$this->view('alert')?>
	<div class="main">
		<div id="left" class="span5"><img src="/style/register-banner.png"></div>
		<div class="span7">
			<form id="registerform" method="post" class="form-horizontal">
				<input name="forward" type="hidden" value="<?=$this->input->get('forward')?>" />
				<div class="control-group">
					<label class="control-label" for="username">用户名/E-mail：</label>
					<div class="controls">
						<input name="username" id="username"  type="text" />
					</div>
				</div>				
				<div class="control-group">
					<label class="control-label" for="password">密码：</label>
					<div class="controls">
						<input name="password" id="password"  type="password" />
					</div>
				</div>				
				<div class="control-group">
					<div class="controls">
						<button name="login" type="submit" class="btn btn-primary">登录</button>
						<label class="checkbox inline"><a href="/signup<?if($this->input->get()){?>?<?=http_build_query((array)$this->input->get())?><?}?>">立即注册</a></label>
						<label class="checkbox inline" style="margin-left: 0;"><a href="/resetpassword">找回密码</a></label>
					</div>
				</div>				
			</form>
		</div>
	</div>
<div class="c-b"></div>
<?$this->view('footer')?>
