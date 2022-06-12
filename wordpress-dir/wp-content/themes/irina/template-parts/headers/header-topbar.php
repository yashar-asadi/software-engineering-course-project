<?php
if('on' == Nova_OP::getOption('topbar_wide')) {
	$topbar_wide = 'nova-container-fluid';
}else {
	$topbar_wide = 'nova-container';
}
 ?>
<div id="topbar" class="nova-topbar">
	<div class="<?php echo esc_attr($topbar_wide) ?> nova-topbar__inner">
		<?php nova_render_topbar(); ?>
	</div>
</div>
