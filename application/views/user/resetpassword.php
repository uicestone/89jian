<?php $this->view('header'); ?>
<div class="article-page">
	<h1>找回密码</h1>
	<?php $this->view('alert'); ?>
	<form id="registerform" method="post" class="form-horizontal">
		<input name="forward"   type="hidden" value='<?php //=$forward?>' />
		<div class="control-group">
			<label class="control-label" for="username">用户名：</label>
			<div class="controls">
				<input name="username" id="username"  type="text" value="<?=set_value('username')?>" />
				<span class="label label-important"><?=form_error('username')?></span>
			</div>
		</div>				
		<div class="control-group">
			<label class="control-label" for="email">E-mail：</label>
			<div class="controls">
				<input name="email" id="email" type="text" value="<?=set_value('email')?>" />
				<span class="label label-important"><?=form_error('email')?></span>
			</div>
		</div>				
		<div class="control-group">
			<label class="control-label" for="password">新密码：</label>
			<div class="controls">
				<input name="password" id="password"  type="password" />
				<span class="label label-important"><?=form_error('password')?></span>
			</div>
		</div>				
		<div class="control-group">
			<label class="control-label" for="repassword">确认密码：</label>
			<div class="controls">
				<input name="repassword" id="repassword"  type="password" />
				<span class="label label-important"><?=form_error('repassword')?></span>
			</div>
		</div>				
		<div class="control-group">
			<label class="control-label" for="repassword">验证码：</label>
			<div class="controls">
				<input name="captcha" id="captcha"  type="text" style="width: 123px;" />
				<span><?=$captcha['image']?></span>
				<span class="label label-important"><?=form_error('captcha')?></span>
			</div>
		</div>				
		<div class="control-group">
			<div class="controls">
				<button name="resetpassword" type="submit" class="btn btn-primary">验证并找回</button>
			</div>
		</div>				
	</form>
</div>	
<?php $this->view('footer'); ?>