<?if(isset($alert) && is_array($alert)){?>
<?	foreach($alert as $alert_single){?>
		<div class="alert<?if(array_key_exists('type', $alert_single)){?> alert-<?=$alert_single['type']?><?}?>">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?if(array_key_exists('title', $alert_single)){?><strong><?=$alert_single['title']?></strong><?}?>
			<?=lang($alert_single['message'])?>
		</div>
<?	}?>
<?}?>
