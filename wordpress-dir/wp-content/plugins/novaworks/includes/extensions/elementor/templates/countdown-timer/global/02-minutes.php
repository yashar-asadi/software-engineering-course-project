<?php echo $this->blocks_separator(); ?>
<div class="novaworks-countdown-timer__item item-minutes">
	<div class="novaworks-countdown-timer__item-value" data-value="minutes"><?php echo $this->date_placeholder(); ?></div>
	<?php $this->__html( 'label_min', '<div class="novaworks-countdown-timer__item-label">%s</div>' ); ?>
</div>
