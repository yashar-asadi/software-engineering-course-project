<?php
/**
 * Loop item template
 */
$banner_url = $this->__get_banner_image_src();

?>
<figure class="novaworks-banner nova-lazyload-image novaworks-effect-<?php $this->__html( 'effect', '%s' ); ?>" data-background-image="<?php echo esc_url($banner_url); ?>"><?php
    $target = $this->__get_html( 'link_target', ' target="%s"' );

    echo '<div class="novaworks-banner__overlay"></div>';
    echo $this->__get_banner_image();
    echo '<figcaption class="novaworks-banner__content">';
    echo '<div class="novaworks-banner__content-wrap">';
    $title_tag = $this->__get_html( 'title_tag', '%s' );

    $this->__html( 'title', '<' . $title_tag  . ' class="novaworks-banner__title">%s</' . $title_tag  . '>' );
    $this->__html( 'text', '<div class="novaworks-banner__text">%s</div>' );
    $this->__html( 'btn_text', '<button type="button" class="elementor-button elementor-size-md novaworks-banner__button novaworks-carousel__item-button">%s</button>' );

    echo '</div>';
    $this->__html( 'link', '<a href="%s" class="novaworks-banner__link"' . $target . '>' );
    $this->__html( 'link', '</a>' );
    echo '</figcaption>';
?></figure>
