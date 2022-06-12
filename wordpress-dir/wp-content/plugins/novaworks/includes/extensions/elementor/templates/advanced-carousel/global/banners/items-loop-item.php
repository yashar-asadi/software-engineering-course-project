<?php
/**
 * Loop item template
 */

$banner_url = $this->get_advanced_carousel_img_src();

?>
<div class="novaworks-carousel__item<?php echo $this->__loop_item( array('item_css_class'), ' %s' )?>">
    <div class="novaworks-carousel__item-inner">
        <figure class="novaworks-banner<?php if(!empty($banner_url)){ echo ' nova-lazyload-image'; } ?> novaworks-effect-<?php echo esc_attr( $this->get_settings_for_display( 'animation_effect' ) ); ?><?php if( $this->get_settings_for_display( 'custom_banner_height' ) ) { echo ' image-custom-height'; } ?>"<?php if(!empty($banner_url)){ echo ' data-background-image="'.esc_url($banner_url).'"'; } ?>><?php
            echo '<div class="novaworks-banner__overlay"></div>';
            echo $this->get_advanced_carousel_img( 'novaworks-banner__img' );
            echo '<figcaption class="novaworks-banner__content">';
            echo '<div class="novaworks-banner__content-wrap">';
            echo $this->__loop_item( array( 'item_title' ), '<h5 class="novaworks-banner__title">%s</h5>' );
            echo $this->__loop_item( array( 'item_text' ), '<div class="novaworks-banner__text">%s</div>' );
            echo $this->__loop_button_item( array( 'item_link', 'item_button_text' ), '<button type="button" class="elementor-button elementor-size-md novaworks-banner__button novaworks-carousel__item-button">%2$s</button>' );
            echo '</div>';

            $target = $this->__loop_item( array( 'item_link_target' ), ' target="%s"' );
            echo $this->__loop_item( array( 'item_link' ), '<a href="%s" class="novaworks-banner__link"' . $target . '>' );
            echo $this->__loop_item( array( 'item_link' ), '</a>' );
            echo '</figcaption>';
            ?></figure>
    </div>
</div>
