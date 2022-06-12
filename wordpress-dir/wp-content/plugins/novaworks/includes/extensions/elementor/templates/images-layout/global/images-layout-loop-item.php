<?php
/**
 * Images list item template
 */
$settings = $this->get_settings_for_display();
$col_class = $this->__loop_item( array( 'item_css_class' ), '%s' );

if ( 'grid' == $settings['layout_type'] || 'masonry' == $settings['layout_type'] ) {
	$col_class .= ' grid-item';
}

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

$this->item_counter++;

?>
<div class="novaworks-images-layout__item <?php echo $col_class ?>">
	<div class="novaworks-images-layout__inner">
		<a <?php echo $this->get_render_attribute_string( $link_instance ); ?>>
			<div class="novaworks-images-layout__image"><?php
                echo $this->get_loop_image_item();
				?>
			</div>
			<div class="novaworks-images-layout__content"><?php
                echo $this->__loop_item( array( 'item_icon' ), '<div class="novaworks-images-layout__icon"><div class="novaworks-images-layout-icon-inner"><i class="%s"></i></div></div>' );
                $title_tag = $this->__get_html( 'title_html_tag', '%s' );

                echo $this->__loop_item( array( 'item_title' ), '<' . $title_tag . ' class="novaworks-images-layout__title">%s</' . $title_tag . '>' );
                echo $this->__loop_item( array( 'item_desc' ), '<div class="novaworks-images-layout__desc">%s</div>' );
            ?></div>
		</a>
	</div>
</div>
