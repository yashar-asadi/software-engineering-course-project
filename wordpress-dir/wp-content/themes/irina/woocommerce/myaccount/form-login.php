<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//Show login/register in two columns
$two_col = true;

if ( isset( $is_popup ) ) {
	// Don't show 2 columns in popup
	$two_col =  false;
	$class = 'is_popup';
	// Redirect popup form to "my account" page
	$popup_redirect_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
} else {
	$class = 'no_popup';
}

// Disable register form on checkout
$show_reg_form = ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) ? true : false;

?>

<?php wc_print_notices(); ?>

<div class="container">

	<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

	<div class="nova-login-wrapper <?php echo esc_attr($class); ?>">

		<div class="nova-form-container<?php if($two_col == true) { ?> grid-x grid-padding-x<?php } ?>">

			<div id="nova-login-form" class="<?php if($two_col == true) { ?> cell large-5<?php } ?>">

				<h2 class="page-title"><?php esc_html_e( 'Login', 'irina' ); ?></h2>

				<?php if ( isset( $is_popup ) ) { ?>

					<form action="<?php echo esc_url( $popup_redirect_url ); ?>" class="woocommerce-form woocommerce-form-login login" method="post">

						<input type="hidden" name="redirect" value="<?php echo esc_url( $popup_redirect_url ); ?>" />

				<?php } else { ?>

					<form class="woocommerce-form woocommerce-form-login login" method="post">

				<?php } ?>

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" placeholder="<?php esc_html_e( 'Username or email address', 'irina' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" placeholder="<?php esc_html_e( 'Password', 'irina' ); ?>" autocomplete="current-password" />
					</p>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<p class="form-row form-group">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme inline">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'irina' ); ?></span>
						</label>
					</p>

					<p class="form-actions">
						<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
						<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'irina' ); ?>"><?php esc_html_e( 'Log in', 'irina' ); ?></button>
						<span class="woocommerce-LostPassword lost_password">
							<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'irina' ); ?></a>
						</span>
					</p>

					<?php do_action( 'woocommerce_login_actions' ); // Custom Goya ?>

					<?php if ( $show_reg_form ) : ?>
						<?php do_action( 'irina/action/toggle_registration_login', $context = 'register' ); ?>

					<?php endif; ?>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>

			</div>

			<?php if ( $show_reg_form ) : ?>

				<?php if($two_col == true) {?>
					<div class="login-divider cell large-2"><div></div></div>
				<?php } ?>

				<div id="nova-register-form" class="<?php if($two_col == true) echo 'cell large-5'; ?>">

					<h2 class="page-title"><?php esc_html_e( 'Register', 'irina' ); ?></h2>

					<?php if ( isset( $is_popup ) ) { ?>

					<form action="<?php echo esc_url( $popup_redirect_url ); ?>" class="woocommerce-form woocommerce-form-register register" method="post">

						<input type="hidden" name="redirect" class="et-login-popup-redirect-input" value="<?php echo esc_url( $popup_redirect_url ); ?>" />

					<?php } else { ?>

						<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?>>

					<?php } ?>

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" placeholder="<?php esc_html_e( 'Username', 'irina' ); ?>" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
						</p>

					<?php endif; ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" placeholder="<?php esc_html_e( 'Email address', 'irina' ); ?>" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
					</p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" placeholder="<?php esc_html_e( 'Password', 'irina' ); ?>" id="reg_password" autocomplete="new-password" />
						</p>

					<?php else : ?>

						<p><?php esc_html_e( 'A password will be sent to your email address.', 'irina' ); ?></p>

						<?php endif; ?>

						<?php do_action( 'woocommerce_register_form' ); ?>

						<p class="woocommerce-form-row form-row">
							<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
							<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'irina' ); ?>"><?php esc_html_e( 'Register', 'irina' ); ?></button>
						</p>

						<?php do_action( 'irina/action/toggle_registration_login', $context = 'login' ); ?>

						<?php do_action( 'woocommerce_register_form_end' ); ?>

					</form>

				</div>

			<?php endif; ?>

		</div>

	</div>

	<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

</div>
