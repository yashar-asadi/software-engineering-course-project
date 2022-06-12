<div id="fullscreen-menu" class="nova-fullscreen-menu">
  <button id="btn-close-modal" class="close-button close-fullscreen-menu" aria-label="Close menu" type="button" data-close="">
          <svg class="irina-close-canvas">
            <use xlink:href="#irina-close-canvas"></use>
          </svg>
  </button>
  <div class="nova-container">
    <div class="nova-fullscreen-menu__inner">
      <div class="row">
        <div class="large-8">
          <?php
          $has_menu = nova_load_menu_location('nova_menu_fullscreen');

          if( $has_menu) {
            wp_nav_menu( array(
              'theme_location' => $has_menu,
              'depth' => 3,
              'container' => false,
              'menu_class' => 'full-menu ',
            ) );
          } else {
            esc_attr_e( 'No menu assigned', 'irina' );
          }

          ?>
        </div>
        <div class="large-4">
          <div class="nova-fullscreen-menu__slidebar">
            <?php dynamic_sidebar( 'fullscreen-widget-area' ); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
