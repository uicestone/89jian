<?php if(isset($alert) && is_array($alert)){ ?>
<?php	foreach($alert as $alert_single){ ?>
		<div class="alert<?php if(array_key_exists('type', $alert_single)){ ?> alert-<?=$alert_single['type']?><?php } ?>">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php if(array_key_exists('title', $alert_single)){ ?><strong><?=$alert_single['title']?></strong><?php } ?>
			<?=lang($alert_single['message'])?>
		</div>
<?php	} ?>
<?php } ?>
