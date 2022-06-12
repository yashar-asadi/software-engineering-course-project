<?php
/**
 * Loop item template
 */
 $link_instance = 'link-instance-' . $this->item_counter;
 $link_type = $this->__loop_item( array( 'item_link_type' ), '%s' );

 $this->add_render_attribute( $link_instance, 'class', array(
 	'novaworks-images-layout__link'
 ) );

 if ( 'lightbox' === $link_type ) {
 	$this->add_render_attribute( $link_instance, 'href', $this->__loop_item( array( 'item_image', 'url' ), '%s' ) );
 	$this->add_render_attribute( $link_instance, 'data-elementor-open-lightbox', 'yes' );
 	$this->add_render_attribute( $link_instance, 'data-elementor-lightbox-slideshow', $this->get_id()  );
 }
 else {
 	$target = $this->__loop_item( array( 'item_target' ), '%s' );
 	$target = ! empty( $target ) ? $target : '_self';

 	$this->add_render_attribute( $link_instance, 'href', $this->__loop_item( array( 'item_url' ), '%s' ) );
 	$this->add_render_attribute( $link_instance, 'target', $target );
 }
 $target = $this->__loop_item( array( 'item_link_target' ), ' target="%s"' );
$this->item_counter++;
?>
<div class="novaworks-carousel__item<?php echo $this->__loop_item( array('item_css_class'), ' %s' )?>">
	<div class="novaworks-carousel__item-inner"><?php
				echo '<a '.$this->get_render_attribute_string( $link_instance ).'>';
        echo '<div class="novaworks-carousel__image">';
				echo $this->get_loop_image_item();
        echo '</div>';
				echo '</a>';
		$title  = $this->__loop_item( array( 'item_title' ), '<h3 class="novaworks-carousel__item-title">%s</h3>' );
		$text   = $this->__loop_item( array( 'item_text' ), '<div class="novaworks-carousel__item-text">%s</div>' );
		$button =  $this->__loop_button_item( array( 'item_link', 'item_button_text' ), '<a class="elementor-button elementor-size-md novaworks-banner__button novaworks-carousel__item-button" href="%1$s"' . $target . '>%2$s</a>' );

		if ( $title || $text ) {

			echo '<div class="novaworks-carousel__content"><div class="novaworks-carousel__content-inner">';
				echo $title;
				echo $text;
				echo $button;
			echo '</div></div>';
		}
?></div>
</div>
