<?php
$popup = Nova_OP::getOption('newsletter_popup');
$onlyhome = Nova_OP::getOption('popup_showonly_homepage');
$show_mobile = Nova_OP::getOption('popup_show_mobile');
$popup_show_again = Nova_OP::getOption('popup_show_again');
$popup_content = Nova_OP::getOption('popup_content');
?>
<?php if ( $popup ): ?>
<?php if ( is_front_page() or  $onlyhome != 1): ?>
<div class="reveal nova_nl-popup<?php if($show_mobile) { echo " disable--mobile";} ?>" id="popup_newsletter" data-reveal>
	<?php echo nova_remove_js_autop($popup_content); ?>
	<button class="close-button" data-close aria-label="Close modal" type="button">
	<svg class="irina-close-canvas">
		<use xlink:href="#irina-close-canvas"></use>
	</svg>
</button>
<?php if ($popup_show_again): ?>
<div class="popup_show_again">
	<label class="subcriper_label">
	      <input type="checkbox">
	      <?php echo Nova_OP::getOption('popup_show_again_text'); ?>
	    </label>
</div>
<?php endif;?>
</div>
<?php endif;?>
<?php endif;?>
