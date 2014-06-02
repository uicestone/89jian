<?php $this->view('header'); ?>
<div class="container">
	<h1>订单选项</h1>
	<form method="post" class="form form-horizontal buy-form">
		<div class="steps">
			
			<li class="step">
				<div class="title">
					<label>1</label>
					消费形式
				</div>
				<div class="control-group">
					<div class="controls">
						<?=radio(array('否'=>'现货','是'=>'礼品卡'), '是否卡片', $this->input->get('是否卡片') ? '是' : '否', true)?>
					</div>
				</div>
			</li>

			<li class="step">
				<div class="title">
					<label>2</label>
					选择套餐
				</div>
				<div class="packages">
				<?php foreach($packages['data'] as $package){ ?>
					<label class="radio">
						<input type="radio" name="package" value="<?=$package['id']?>">
						<?=$package['name']?>
						<a href="<?=site_url()?>package/<?=$package['id']?>" target="_blank">
							<p class="description">¥<?=get_meta($package, '价格')?>/周 <?=get_tag($package, '内容分类')?> &raquo;</p>
						</a>
					</label>
				<?php } ?>
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
<script type="text/javascript" src="/js/buy.js"></script>
<?php $this->view('footer'); ?>
