<?php $items_size = $this->get_settings('items_size'); ?>
<div class="elementor-novaworks-countdown-timer novaworks-elements js-novaworks-countdown-timer">
	<div class="novaworks-countdown-timer timer-<?php echo $items_size; ?>" data-due-date="<?php echo $this->due_date(); ?>">
		<?php $this->__glob_inc_if( '00-days', array( 'show_days' ) ); ?>
		<?php $this->__glob_inc_if( '01-hours', array( 'show_hours' ) ); ?>
		<?php $this->__glob_inc_if( '02-minutes', array( 'show_min' ) ); ?>
		<?php $this->__glob_inc_if( '03-seconds', array( 'show_sec' ) ); ?>
	</div>
</div>
