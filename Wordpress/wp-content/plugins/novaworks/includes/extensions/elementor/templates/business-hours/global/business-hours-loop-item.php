<?php
/**
 * Business Hours item template
 */
?>
<div class="nova-business-hours__item">
	<span class="nova-business-day"><?php echo $this->__loop_item( array( 'item_date' ) ); ?></span>
	<span class="nova-business-time"><?php echo $this->__loop_item( array( 'item_hours' ) ); ?></span>
</div>
