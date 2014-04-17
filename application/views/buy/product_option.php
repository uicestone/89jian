<?php $this->view('header'); ?>
<div class="container">
	<h1>订单选项</h1>
	<form method="post" class="form form-horizontal buy-form">
		<div class="steps">
			<li class="step">
				<div class="title">
					<label>1</label>
					选择类型
				</div>
				<div class="type">
					<?=radio(array('生鲜类','干货类'), '类型', set_value('类型', '生鲜类'))?>
				</div>
			</li>

			<li class="step">
				<div class="title">
					<label>2</label>
					选择套餐
				</div>
				<div class="packages">
					<?=radio(array_column($packages, 'name', 'id'), 'package', $this->input->get('package'), true)?>
				</div>
			</li>

			<li class="step">
				<div class="title">
					<label>3</label>
					预订周数
				</div>
				<div class="control-group">
					<div class="controls">
						<div class="input-append">
							<input type="text" name="次数" class="span1" value="1" />
							<span class="add-on">周</span>
						</div>
					</div>
				</div>
			</li>

			<li class="step">
				<div class="title">
					<label>4</label>
					消费形式
				</div>
				<div class="control-group">
					<div class="controls">
						<?=radio(array('0'=>'现货','1'=>'礼品卡'), '是否卡片', $this->input->get('是否卡片'),true)?>
					</div>
				</div>
			</li>

			<li class="step">
				<div class="title">
					<label>5</label>
					首次送餐日
				</div>
				<div class="controls">
					<div class="input-append date" id="datepicker" data-date="<?=date('Y-m-d', time() + 86400 * 7)?>" data-date-format="yyyy-mm-dd">
						<input name="首次送货日期" class="span2" size="16" type="text" value="<?=date('Y-m-d', time() + 86400 * 7)?>">
						<span class="add-on"><i class="icon-calendar"></i></span>
					  </div>
				</div>
			</li>
		</div>


		<div class="control-group submit-button">
			<div class="controls">
				<button type="submit" name="next" class="btn">下一步</button>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/js/buy.js"></script>
<?php $this->view('footer'); ?>
