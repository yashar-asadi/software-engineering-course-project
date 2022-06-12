<?php
$currency_content = Nova_OP::getOption('currency_content');
$lang_content 		= Nova_OP::getOption('language_content');
$menu = wp_nav_menu(
array (
    'echo' => FALSE,
    'theme_location'    => 'nova_topbar_menu',
    'fallback_cb' => '__return_false'
)
);
if ($menu !== false or Nova_OP::getOption('topbar_enable_switcher') == 1): ?>
<div class="nova-topbar__left">
  <?php if ( Nova_OP::getOption('topbar_enable_switcher') == 1 ) : ?>
		<div class="nova-topbar__left--switcher">
			<?php if($currency_content):?>
				<?php echo nova_remove_js_autop($currency_content); ?>
			<?php else:?>
			<div class="dropdown currency-switcher">
				<select>
					<option value="usd">United States | EN ($)</option>
					<option value="eur">United States | EN ($)</option>
				</select>
			</div>
		<?php endif;?>
			<?php if($lang_content):?>
				<?php echo nova_remove_js_autop($lang_content); ?>
			<?php endif;?>
		</div>
  <?php endif; ?>
  <nav class="navigation-foundation">
  <?php
    $menu = wp_nav_menu(array(
        'theme_location'    => 'nova_topbar_menu',
        'container'         => false,
        'menu_class'        => 'dropdown menu',
        'items_wrap'        => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
        'link_before'       => '<span>',
                        'link_after'        => '</span>',
        'fallback_cb'     	=> 'Foundation_Dropdown_Menu_Fallback',
        'walker'            => new Foundation_Dropdown_Menu_Walker(),
      ));
  ?>
  </nav>
</div>
<?php endif; ?>
<?php if( 1 == Nova_OP::getOption('icons_on_topbar') ):?>
<div class="nova-topbar__right">
  <ul class="nova-topbar__right--action">
    <?php if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) : ?>
    <?php if ( Nova_OP::getOption('header_user_account') == 1 ) : ?>
      <li class="account-mn">
        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
          <?php echo esc_html__('Sign in / Register','irina'); ?>
        </a>
      </li>
    <?php endif; ?>
    <?php endif; ?>
    <?php if ( NOVA_WISHLIST_IS_ACTIVE ) : ?>
    <?php if ( Nova_OP::getOption('header_wishlist') == 1 ) : ?>
      <li class="wishlist-mn">
        <a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>">
          <svg class="svg-icon">
           <use xlink:href="#irina-wishlist"></use>
          </svg>
          <span><?php echo esc_html__('Wishlist','irina'); ?></span>
        </a>
      </li>
    <?php endif; ?>
    <?php endif; ?>
  </ul>
</div>
<?php endif; ?>
