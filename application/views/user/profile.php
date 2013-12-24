<?php $this->view('header'); ?>
	<div class="span9">
		<form method="post" class="form-horizontal">
			<div class="tab-content">
				<?php $this->view('alert'); ?>
				<div id="address" class="main tab-pane">
					<div class="control-group">
						<label class="control-label">* 收货人姓名：</label><input type="text" name="meta[收货人姓名]" value="<?=set_value('meta[收货人姓名]',$meta['收货人姓名'])?>">
					</div>	
					<div class="control-group">
						<label class="control-label">* 证件类型：</label>
						<select name="meta[证件类型]">
							<?=options(array('身份证','军官证','港澳台胞证','护照'), set_value('meta[证件类型]',$meta['证件类型']),'证件类型')?>
						</select>
						
					</div>	
					<div class="control-group">
						<label class="control-label">* 证件号码：</label><input type="text" name="meta[证件号码]" value="<?=set_value('meta[证件号码]',$meta['证件号码'])?>">
					</div>	
					<div class="control-group">
						<label class="control-label">* 银行账号：</label><input type="text" name="meta[银行账号]" value="<?=set_value('meta[银行账号]',$meta['银行账号'])?>">
					</div>	
					<div class="control-group">
						<label class="control-label">* 所在地：</label>
						<select name="meta[邮寄省市]">
							<?=options(array('上海'), set_value('meta[邮寄省市]',$meta['邮寄省市']), '省市')?>
						</select>
						<select name="meta[邮寄地区]">
							<?=options(array('徐汇','浦东','黄浦','静安','普陀','闸北','杨浦','虹口','宝山','嘉定','青浦','闵行','松江','奉贤'), set_value('meta[邮寄地区]',$meta['邮寄地区']),'地区')?>
						</select>
					</div>	
					<div class="control-group">
						<label class="control-label">* 详细地址：</label><input type="text" name="meta[详细地址]" value="<?=set_value('meta[详细地址]',$meta['详细地址'])?>">
					</div>	
					<div class="control-group">
						<label class="control-label">* 邮政编码：</label><input type="text" name="meta[邮政编码]" value="<?=set_value('meta[邮政编码]',$meta['邮政编码'])?>">
					</div>	
					<div class="control-group">
						<label class="control-label">* 联系电话：</label><input type="text" name="meta[联系电话]" value="<?=set_value('meta[联系电话]',$meta['联系电话'])?>">
					</div>	
					<div class="control-group">
						<label class="control-label">* 送货时间：</label>
						<select name="meta[送货时间]">
							<?=options(array('工作日','双休日','不限'), set_value('meta[送货时间]',$meta['送货时间']),'送货时间')?>
						</select>
					</div>	
				</div>
				<div id="password" class="main tab-pane">
					<div class="warning">
						<p>重要提示：每天互联网都会有大量用户的帐号存在</p>
					</div>
					<div class="control-group">
						<label class="control-label">当前密码：</label>
						<input type="password" name="password" autocomplete="off">
						<label class="label label-important"><?=form_error('password')?></label>
					</div>	
					<div class="control-group">
						<label class="control-label">新密码：</label>
						<input type="password" name="password_new">
						<label class="label label-important"><?=form_error('password_new')?></label>
					</div>	
					<div class="control-group">
						<!--<label class="control-label">安全强度：</label><span><img src="style/ps-grade.png"> 弱</span><span><img src="style/ps-grade-2.png"> 中</span><span><img src="style/ps-grade-3.png"> 强</span>-->
						<label class="control-label">确认密码：</label>
						<input type="password" name="password_new_confirm">
						<label class="label label-important"><?=form_error('password_new_confirm')?></label>
					</div>	
				</div>
				<div class="form-actions">
					<div class="control">
						<button type="submit" name="submit" class="btn btn-primary">保存</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div id="right" class="span3 sidebar">
		<div class="box">
			<ul class="nav nav-stacked nav-pills">
				<li><b>帐号</b></li>
				<li><a href="#address" data-toggle="pill">收货地址</a></li>
				<hr>
				<li><b>帐号安全</b></li>
				<li><a href="#password" data-toggle="pill">修改密码</a></li>
			</ul>
		</div>
	</div>
<script type="text/javascript">
$(function(){
	
	$(':input').on('change',function(){
		$(this).attr('changed','changed');
	});
	
	$('.btn-group>:button').on('click',function(){
		$(this).siblings(':button').removeAttr('changed');
		$(this).attr('changed','changed');
		$(this).parent().find(':radio[name="'+$(this).attr('name')+'"][value="'+$(this).text()+'"]').prop('checked',true).trigger('change');
	});
	
	$('form').on('submit',function(){
		$(this).find(':input:not([changed]):not([name="submit"])').prop('disabled',true);
	});
	
	//http://stackoverflow.com/questions/7862233/twitter-bootstrap-tabs-go-to-specific-tab-on-page-reload
	if (window.location.hash) {
		$('.nav-pills a[href='+window.location.hash+']').tab('show') ;
	} 

	// Change hash for page-reload
	$('.nav-pills a').on('shown', function (e) {
		window.location.hash = e.target.hash;
	});
	
});
</script>
<?php $this->view('footer'); ?>