<?php if ( NOVA_WOOCOMMERCE_IS_ACTIVE && Nova_OP::getOption('header_user_account') == 1 ) : ?>
  <?php if ( is_user_logged_in() ){ ?>
    <div class="handheld_component">
      <a class="component-target" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
        <svg class="irina-user-bar">
         <use xlink:href="#irina-user-bar"></use>
        </svg>
    </a>
    </div>
  <?php }else { ?>
  <div class="handheld_component">
    <a class="component-target"<?php if ( Nova_OP::getOption('header_user_action') == 'account-page' ) : ?> href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"<?php endif; ?><?php if ( Nova_OP::getOption('header_user_action') == 'modal' ) : ?> data-toggle="AcccountCanvas"<?php endif; ?>>
      <svg class="irina-user-bar">
       <use xlink:href="#irina-user-bar"></use>
      </svg>
  </a>
  </div>
<?php } ?>
<?php endif; ?>
