<?php
/**
 * Card item template
 */
$show_arrow = filter_var( $settings['show_card_arrows'], FILTER_VALIDATE_BOOLEAN );
$title_tag  = ! empty( $settings['item_title_size'] ) ? $settings['item_title_size'] : 'h5';
?>

<div class="novaworks-hor-timeline-item__card">
	<div class="novaworks-hor-timeline-item__card-inner">
		<?php
		$this->__render_image( $item_settings );
		echo $this->__loop_item( array( 'item_title' ) , '<' . $title_tag .' class="novaworks-hor-timeline-item__card-title">%s</' . $title_tag . '>' );
		echo $this->__loop_item( array( 'item_desc' ), '<div class="novaworks-hor-timeline-item__card-desc">%s</div>' );
		?>
	</div>
	<?php if ( $show_arrow ) { ?>
		<div class="novaworks-hor-timeline-item__card-arrow"></div>
	<?php } ?>
</div>
