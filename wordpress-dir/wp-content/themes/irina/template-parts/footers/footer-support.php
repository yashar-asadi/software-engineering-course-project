<?php if ( 1 == Nova_OP::getOption('site_support_list') ):?>
<!-- .support-list -->
<ul class="support-lists">
	<?php if ( ! empty( Nova_OP::getOption('site_chat_link') ) ) : ?>
	<li><a target="_blank" href="<?php echo Nova_OP::getOption('site_chat_link') ?>"><i class="inova ic-support-chat"></i></a></li>
	<?php endif;?>
	<?php if ( ! empty( Nova_OP::getOption('site_phone_link') ) ) : ?>
	<li><a target="_blank" href="<?php echo Nova_OP::getOption('site_phone_link') ?>"><i class="inova ic-support-phone"></i></a></li>
	<?php endif;?>
	<?php if ( ! empty( Nova_OP::getOption('site_email_ad') ) ) : ?>
	<li><a href="mailto:<?php echo Nova_OP::getOption('site_email_ad') ?>"><i class="inova ic-support-email"></i></a></li>
	<?php endif;?>
</ul><!-- .support-list -->
<?php endif;?>
