<?php $this->view('header'); ?>
<div class="article-page">
	<h1>登录</h1>
	<?php $this->view('alert'); ?>
	<form method="post" class="form form-horizontal">
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
				<label class="checkbox inline"><a href="/signup<?php if($this->input->get()){ ?>?<?=http_build_query((array)$this->input->get())?><?php } ?>">立即注册</a></label>
				<label class="checkbox inline"><a href="/resetpassword">找回密码</a></label>
			</div>
		</div>				
	</form>
</div>
<?php $this->view('footer'); ?>
