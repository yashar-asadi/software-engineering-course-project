<?php
/**
 * Images list item template
 */
$settings   = $this->get_settings_for_display();

$read_more_label  = $this->get_settings_for_display('read_more_label');
$custom_excerpt_length  = $this->get_settings_for_display('custom_excerpt_length');
if(empty($read_more_label)){
    $read_more_label = __('Read More', 'novaworks-elements');
}

$preset         = $settings['preset'];
$layout_type    = $settings['layout_type'];

if( $layout_type == 'list' ) {
    $preset = $settings['preset_list'];
}

$item_instance = 'item-instance-' . $this->item_counter;

$this->add_render_attribute( $item_instance, 'class', get_post_class( array(
    'loop__item',
    'grid-item',
    'novaworks-portfolio__item',
    'visible-status'
), get_the_ID() ) );

if ( 'masonry' == $layout_type ) {
    $item_sizes = $this->get_masonry_item_sizes($this->__processed_index);
    $this->add_render_attribute( $item_instance, 'data-width', $item_sizes['item_width'] );
    $this->add_render_attribute( $item_instance, 'data-height', $item_sizes['item_height'] );
}

$term_obj = get_the_terms(get_the_ID(), 'la_portfolio_category');
$slug_list = array('all');
$cat_list = array();
if(!is_wp_error($term_obj) && !empty($term_obj)){
    foreach ($term_obj as $term){
        $slug_list[] = $term->slug;
    }
    $cat_list = wp_list_pluck($term_obj, 'name');
}

$link_instance = 'link-instance-' . $this->item_counter;

$link_css_class = array('novaworks-images-layout__link');

$this->add_render_attribute( $link_instance, 'class', $link_css_class);

$item_image_url = get_the_post_thumbnail_url(get_the_ID(), $settings['image_size']);

$item_button_url = get_the_permalink();

$this->add_render_attribute( $link_instance, 'href', $item_button_url );

?>
<article <?php echo $this->get_render_attribute_string( $item_instance ); ?>>
    <div class="novaworks-portfolio__inner">
        <div class="novaworks-portfolio__image_wrap">
            <a <?php echo $this->get_render_attribute_string( $link_instance ); ?>>
                <figure class="figure__object_fit novaworks-portfolio__image">
                    <?php the_post_thumbnail($settings['image_size'], array('class' => 'novaworks-portfolio__image-instance'));?>
                </figure>
            </a><?php if( !($layout_type != 'list' && $preset == 'type-5') ):?>
            <div class="novaworks-portfolio__icons">
                <a data-rel="lightcase:myCollection:slideshow" href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" class="nova-popup novaworks-portfolio__icon_gallery"><i class="novaworksicon-eye"></i></a>
                <a href="<?php echo esc_url($item_button_url); ?>" class="novaworks-portfolio__icon_link"><i class="novaworksicon-web-link"></i></a>
            </div><?php endif; ?>
        </div>
        <div class="novaworks-portfolio__content">
            <div class="novaworks-portfolio__content-inner"><?php
                if($layout_type != 'list' && $preset == 'type-5'){
                    ?>
                    <div class="novaworks-portfolio__icons">
                        <a data-rel="lightcase:myCollection:slideshow" href="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" class="nova-popup novaworks-portfolio__icon_gallery"><i class="novaworksicon-eye"></i></a>
                        <a href="<?php echo esc_url($item_button_url); ?>" class="novaworks-portfolio__icon_link"><i class="novaworksicon-web-link"></i></a>
                    </div>
                    <?php
                }
                ?>
                <div class="novaworks-portfolio__content-inner2"><?php
                    $title_tag = $this->__get_html( 'title_html_tag', '%s' );
                    echo sprintf(
                        '<%1$s class="novaworks-portfolio__title"><a href="%2$s">%3$s</a></%1$s>',
                        esc_attr($title_tag),
                        esc_url($item_button_url),
                        esc_html(get_the_title())
                    );
                    if( $this->get_settings_for_display('show_category') && !empty($cat_list)){
                        echo sprintf('<p class="novaworks-portfolio__category">%s</p>', join(', ', $cat_list));
                    }

                    if( $this->get_settings_for_display('show_excerpt') && !empty($custom_excerpt_length)){
                        echo sprintf(
                            '<p class="novaworks-portfolio__desc">%1$s</p>',
                            nova_excerpt(intval( $custom_excerpt_length ))
                        );
                    }
                    if( $this->get_settings_for_display('show_readmore_btn') ) {

                        $btn_attr = 'class="novaworks-portfolio__button button"';

                        if($preset == 'list-type-2' || $preset == 'type-6' || $preset == 'type-7'){
                            $read_more_label = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><g stroke-linecap="square" stroke-width="2" stroke="currentColor" fill="none" stroke-miterlimit="10"><path stroke-linecap="butt" d="M14 32h36"/><circle cx="32" cy="32" r="30"/><path d="M36 18l14 14-14 14"/></g></svg>';
                            $btn_attr = 'class="novaworks-portfolio__button button js-el" data-la_component="SVGAnimation" data-hover="yes"';
                        }

                        echo sprintf(
                            '<a %1$s href="%2$s"><span class="novaworks-portfolio__button-text">%3$s</span></a>',
                            $btn_attr,
                            $item_button_url,
                            $read_more_label
                        );
                    }
                    if( $this->get_settings_for_display('show_divider') ){
                        echo '<div class="novaworks-portfolio__divider"><span></span></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</article>
