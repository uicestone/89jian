<?php $this->view('header'); ?>
<div class="article-page">
	<h1>注册</h1>
	<?php $this->view('alert'); ?>
	<form id="registerform" method="post" class="form-horizontal">
		<input name="forward"   type="hidden" value='<?=$this->input->get('forward')?>' />
		
		<div class="control-group">
			<label class="control-label" for="with_card">注册方式：</label>
			<div class="controls">
				<label class="radio">
					<input type="radio" name="with_card" value="0" />
					直接注册
				</label>
				<label class="radio">
					<input type="radio" name="with_card" value="1" />
					使用卡注册
				</label>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="email">E-mail：</label>
			<div class="controls">
				<input name="email" id="email" type="text" value="<?=set_value('email')?>" />
				<span class="label label-important"><?=form_error('email')?></span>
			</div>
		</div>		

		<div id="signup-with-card" class="conditional-fields" style="display:none">
			<div class="control-group">
				<label class="control-label" for="card_num">卡号：</label>
				<div class="controls">
					<input name="card_num" id="card_num"  type="text" value="<?=set_value('card_num')?>" />
					<span class="label label-important"><?=form_error('card_num')?></span>
				</div>
			</div>				
			<div class="control-group">
				<label class="control-label" for="card_pass">卡密码：</label>
				<div class="controls">
					<input name="card_pass" id="card_pass"  type="text" value="<?=set_value('card_pass')?>" />
					<span class="label label-important"><?=form_error('card_pass')?></span>
				</div>
			</div>
		</div>
		
		<div id="signup-without-card" class="conditional-fields" style="display:none">
			<div class="control-group">
				<label class="control-label" for="username">用户名：</label>
				<div class="controls">
					<input name="username" id="username"  type="text" value="<?=set_value('username')?>" />
					<span class="label label-important"><?=form_error('username')?></span>
				</div>
			</div>				
			<div class="control-group">
				<label class="control-label" for="password">密码：</label>
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
				<label class="checkbox" for="agree">
					<input name="agree" id="agree" type="checkbox"<?=set_checkbox('agree','on')?> />
					<span>同意"<a href="/article/user-term" target="_blank">用户协议</a>"</span>
					<span class="label label-important"><?=form_error('agree')?></span>
				</label>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<button name="signup" type="submit" class="btn btn-primary">注册</button>
				<label class="checkbox inline"><a href="/login<?php if($this->input->get()){ ?>?<?=http_build_query((array)$this->input->get())?><?php } ?>">已有账号，立即登录</a></label>
			</div>
		</div>				
	</form>
	
</div>

<script type="text/javascript">
$(function(){
	
	function checkHash(){
		$('div.conditional-fields').hide();
		
		if(window.location.hash === '#with-card'){
			$(':input[name="with_card"][value="1"]').prop('checked', true);
			$(':input[name="with_card"][value="0"]').prop('checked', false);
			$('div#signup-with-card').show();
			$('div#signup-without-card').hide();
		}
		else{
			$(':input[name="with_card"][value="1"]').prop('checked', false);
			$(':input[name="with_card"][value="0"]').prop('checked', true);
			$('div#signup-without-card').show();
			$('div#signup-with-card').hide();
		}
	}
	
	checkHash();
	
	$(':input[name="with_card"]').on('change', function(){
		if($(this).val() === '1'){
			window.location.hash = '#with-card';
			checkHash();
		}
		else{
			window.location.hash = '#without-card';
			checkHash();
		}
	});
	
});
</script>

<?php $this->view('footer'); ?>