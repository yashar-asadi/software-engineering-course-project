<?php
/**
 * Loop item template
 */
?>
<div class="novaworks-carousel__item<?php echo $this->__loop_item( array('item_css_class'), ' %s' )?>">
	<div class="novaworks-carousel__item-inner"><?php
		$target = $this->__loop_item( array( 'item_link_target' ), ' target="%s"' );

		echo $this->__loop_item( array( 'item_link' ), '<a href="%s" class="novaworks-carousel__item-link"' . $target . '>' );

        echo $this->__loop_item( array( 'item_icon' ), '<div class="novaworks-carousel__icon"><i class="%1$s"></i></div>' );

        echo '<div class="novaworks-carousel__content">';

        echo $this->__loop_item( array( 'item_title' ), '<h5 class="novaworks-carousel__item-title">%s</h5>' );

        echo $this->__loop_item( array( 'item_text' ), '<div class="novaworks-carousel__item-text">%s</div>' );

        echo '</div>';

		echo $this->__loop_item( array( 'item_link' ), '</a>' );
?></div>
</div>
