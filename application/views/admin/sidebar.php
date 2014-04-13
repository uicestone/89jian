	<div class="sidebar">
		<div class="top"></div>
		<div class="block">
			<ul>
				<li><a href="/admin/user" class="<?php if(strpos(uri_string(), 'admin/user') === 0){ ?> active<?php } ?>">用户</a></li>
				<li><a href="/admin/card" class="<?php if(strpos(uri_string(), 'admin/card') === 0){ ?> active<?php } ?>">卡片</a></li>
				<li><a href="/admin/order" class="<?php if(strpos(uri_string(), 'admin/order') === 0){ ?> active<?php } ?>">订单</a></li>
				<li><a href="/admin/logistic" class="<?php if(strpos(uri_string(), 'admin/logistic') === 0){ ?> active<?php } ?>">配货</a></li>
				<li><a href="/admin/recipe" class="<?php if(strpos(uri_string(), 'admin/recipe') === 0){ ?> active<?php } ?>">食谱</a></li>
				<li><a href="/admin/article" class="<?php if(strpos(uri_string(), 'admin/article') === 0){ ?> active<?php } ?>">文章</a></li>
				<li><a href="/admin/config" class="<?php if(strpos(uri_string(), 'admin/config') === 0){ ?> active<?php } ?>">配置</a></li>
			</ul>
		</div>
		<div class="bottom"></div>
	</div>
