<?php

defined( 'ABSPATH' ) || exit;

class Persian_Woocommerce_Notice {

	public function __construct() {
		add_action( 'admin_notices', [ $this, 'admin_notices' ], 10 );
		add_action( 'wp_ajax_pw_dismiss_notice', [ $this, 'dismiss_notice' ] );
		add_action( 'wp_ajax_pw_update_notice', [ $this, 'update_notice' ] );
	}

	public function admin_notices() {

		if ( ! current_user_can( 'manage_options' ) && ! current_user_can( 'manage_woocommerce' ) ) {
			return;
		}

		if ( $this->is_dismiss( 'all' ) ) {
			return;
		}

		foreach ( $this->notices() as $notice ) {

			if ( $notice['condition'] == false || $this->is_dismiss( $notice['id'] ) ) {
				continue;
			}

			$dismissible = $notice['dismiss'] ? 'is-dismissible' : '';

			$notice_id      = esc_attr( $notice['id'] );
			$notice_content = strip_tags( $notice['content'], '<p><a><input><b><img><ul><ol><li>' );

			printf( '<div class="notice pw_notice notice-success %s" id="pw_%s"><p>%s</p></div>', $dismissible, $notice_id, $notice_content );

			break;
		}

		?>
		<script type="text/javascript">
            jQuery(document).ready(function ($) {

                $(document.body).on('click', '.notice-dismiss', function () {

                    let notice = $(this).closest('.pw_notice');
                    notice = notice.attr('id');

                    if (notice !== undefined && notice.indexOf('pw_') !== -1) {

                        notice = notice.replace('pw_', '');

                        $.ajax({
                            url: "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                            type: 'post',
                            data: {
                                notice: notice,
                                action: 'pw_dismiss_notice',
                                nonce: "<?php echo wp_create_nonce( 'pw_dismiss_notice' ); ?>"
                            }
                        });
                    }

                });

                $.ajax({
                    url: "<?php echo admin_url( 'admin-ajax.php' ) ?>",
                    type: 'post',
                    data: {
                        action: 'pw_update_notice',
                        nonce: '<?php echo wp_create_nonce( 'pw_update_notice' ); ?>'
                    }
                });
            });
		</script>
		<?php
	}

	public function notices(): array {
		global $pagenow;

		$post_type    = sanitize_text_field( $_GET['post_type'] ?? null );
		$page         = sanitize_text_field( $_GET['page'] ?? null );
		$tab          = sanitize_text_field( $_GET['tab'] ?? null );
		$has_shipping = wc_shipping_enabled();

		$notices = [
			[
				'id'        => 'tapin-orders',
				'content'   => '<b>با افزونه حمل و نقل ووکامرس فارسی یک دفتر پستی اختصاصی داشته باش و بدون مراجعه به پست همه سفارشاتتو ارسال کن.</b>
<ul>
<li>- تولید فاکتور پست همراه با بارکد پستی به صورت آنلاین</li>
<li>- جمع آوری مرسولات از محل شما توسط ماموران پست</li>
<li>- ارسال کد رهگیری پستی برای مشتریان به صورت پیامکی</li>
<li>- بروزرسانی خودکار آخرین وضعیت مرسوله در پنل ووکامرس</li>
</ul>
<a href="https://yun.ir/pwto" target="_blank">
    <input type="button" class="button button-primary" value="اطلاعات بیشتر">
</a>
<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=persian-woocommerce-shipping' ) . '" target="_blank">
    <input type="button" class="button" value="نصب افزونه پیشخوان پست">
</a>',
				'condition' => $pagenow == 'edit.php' && $post_type == 'shop_order' && $has_shipping,
				'dismiss'   => 6 * MONTH_IN_SECONDS,
			],
			[
				'id'        => 'tapin-shipping',
				'content'   => '<b>با افزونه حمل و نقل ووکامرس فارسی به رایگان هزینه پست سفارشی و پیشتاز رو بصورت دقیق و طبق آخرین تعرفه پست محاسبه کنید و سرویس پرداخت در محل رو در سراسر کشور فعال کنید.</b>
<ul>
<li>- محاسبه دقیق هزینه ارسال بر اساس وزن و شهر خریدار</li>
<li>- امکان تخفیف در هزینه ارسال بر اساس میزان خرید</li>
<li>- صدور آنلاین کد رهگیری پستی و تولید فاکتور</li>
<li>- ارسال کد رهگیری به خریدار به صورت پیامکی و در پنل کاربری</li>
</ul>
<a href="https://yun.ir/pwts" target="_blank">
    <input type="button" class="button button-primary" value="اطلاعات بیشتر">
</a>
<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=persian-woocommerce-shipping' ) . '" target="_blank">
    <input type="button" class="button" value="نصب افزونه پیشخوان پست">
</a>',
				'condition' => $page == 'wc-settings' && $tab == 'shipping' && $has_shipping,
				'dismiss'   => 6 * MONTH_IN_SECONDS,
			],
			[
				'id'        => 'tapin-tools',
				'content'   => '
				<a href="https://yun.ir/pwtt" target="_blank">
				    <img src="' . PW()->plugin_url( 'assets/images/tapin.jpg' ) . '" style="width: 100%">
                </a>',
				'condition' => $page == 'persian-wc-tools' && $has_shipping,
				'dismiss'   => 6 * MONTH_IN_SECONDS,
			],
			[
				'id'        => 'tapin-dashboard',
				'content'   => '<b>پیشخوان وردپرس خود را رایگان به شرکت ملی پست متصل کنید و یک دفتر پستی اختصاصی داشته باشید.</b>
<ul>
<li>- محاسبه دقیق هزینه های پستی در سبد خرید</li>
<li>- جمع آری سفارشات از محل شما توسط ماموران پست در سراسر کشور</li>
<li>- صدور فاکتور استاندارد پست همراه با بارکد پست</li>
<li>- ارسال کد رهگیری پست به مشتری به صورت پیامکی و پنل کاربری</li>
</ul>
<a href="https://yun.ir/pwtd" target="_blank">
    <input type="button" class="button button-primary" value="اطلاعات بیشتر">
</a>
<a href="' . admin_url( 'plugin-install.php?tab=plugin-information&plugin=persian-woocommerce-shipping' ) . '" target="_blank">
    <input type="button" class="button" value="نصب افزونه پیشخوان پست">
</a>',
				'condition' => $pagenow == 'index.php' && $has_shipping,
				'dismiss'   => 6 * MONTH_IN_SECONDS,
			],
			[
				'id'        => 'persian-date',
				'content'   => '<b>ووکامرس فارسی با طعم ووکامرس شمسی!</b>
<ul>
<li>- شمسی سازی محیط وردپرس بدون نیاز به افزونه جانبی</li>
<li>- شمسی سازی ووکامرس در محصولات، سفارشات، کوپن ها و گزارشات</li>
<li>- افزودن DatePicker شمسی در پنل ووکامرس</li>
<li>- برای فعالسازی شمسی ساز ووکامرس روی کلید زیر کلیک کنید:</li>
</ul>
<a href="' . admin_url( 'admin.php?page=persian-wc-tools' ) . '" target="_blank">
    <input type="button" class="button button-primary" value="فعالسازی شمسی ساز وردپرس و ووکامرس">
</a>',
				'condition' => PW()->get_options( 'enable_jalali_datepicker' ) !== 'yes',
				'dismiss'   => 6 * MONTH_IN_SECONDS,
			],
			[
				'id'        => 'pws',
				'content'   => sprintf( 'بنظر میرسه هنوز حمل و نقل (پست پیشتاز، سفارشی، پیک موتوری و...) فروشگاه رو پیکربندی نکردید؟ <a href="%s" target="_blank">نصب افزونه حمل و نقل فارسی ووکامرس و پیکربندی.</a>', admin_url( 'plugin-install.php?tab=plugin-information&plugin=persian-woocommerce-shipping' ) ),
				'condition' => is_plugin_inactive( 'persian-woocommerce-shipping/woocommerce-shipping.php' ) && $has_shipping,
				'dismiss'   => 6 * MONTH_IN_SECONDS,
			],
		];

		$_notices = get_option( 'pw_notices', [] );

		foreach ( $_notices['notices'] ?? [] as $_notice ) {

			$_notice['condition'] = 1;

			$rules = $_notice['rules'];

			if ( isset( $rules['pagenow'] ) && $rules['pagenow'] != $pagenow ) {
				$_notice['condition'] = 0;
			}

			if ( isset( $rules['page'] ) && $rules['page'] != $page ) {
				$_notice['condition'] = 0;
			}

			if ( isset( $rules['tab'] ) && $rules['tab'] != $tab ) {
				$_notice['condition'] = 0;
			}

			if ( isset( $rules['active'] ) && is_plugin_inactive( $rules['active'] ) ) {
				$_notice['condition'] = 0;
			}

			if ( isset( $rules['inactive'] ) && is_plugin_active( $rules['inactive'] ) ) {
				$_notice['condition'] = 0;
			}

			if ( isset( $rules['has_shipping'] ) && $rules['has_shipping'] != $has_shipping ) {
				$_notice['condition'] = 0;
			}

			unset( $_notice['rules'] );

			array_unshift( $notices, $_notice );
		}

		return $notices;
	}

	public function dismiss_notice() {

		check_ajax_referer( 'pw_dismiss_notice', 'nonce' );

		$this->set_dismiss( $_POST['notice'] );

		die();
	}

	public function update_notice() {

		$update = get_transient( 'pw_update_notices' );

		if ( $update ) {
			return;
		}

		set_transient( 'pw_update_notices', 1, DAY_IN_SECONDS / 4 );

		check_ajax_referer( 'pw_update_notice', 'nonce' );

		$notices = wp_remote_get( 'https://woonotice.ir/pw.json', [ 'timeout' => 5, ] );
		$sign    = wp_remote_get( 'https://woohash.ir/pw.hash', [ 'timeout' => 5, ] );

		if ( is_wp_error( $notices ) || is_wp_error( $sign ) ) {
			die();
		}

		if ( ! is_array( $notices ) || ! is_array( $sign ) ) {
			die();
		}

		$notices = trim( $notices['body'] );
		$sign    = trim( $sign['body'] );

		if ( sha1( $notices ) !== $sign ) {
			die();
		}

		$notices = json_decode( $notices, JSON_OBJECT_AS_ARRAY );

		if ( empty( $notices ) || ! is_array( $notices ) ) {
			die();
		}

		foreach ( $notices['notices'] as &$_notice ) {

			$doc     = new DOMDocument();
			$content = strip_tags( $_notice['content'], '<p><a><b><img><ul><ol><li>' );
			$content = str_replace( [ 'javascript', 'java', 'script' ], '', $content );
			$doc->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ) );

			foreach ( $doc->getElementsByTagName( '*' ) as $element ) {

				$href  = null;
				$src   = null;
				$style = $element->getAttribute( 'style' );

				if ( $element->nodeName == 'a' ) {
					$href = $element->getAttribute( 'href' );
				}

				if ( $element->nodeName == 'img' ) {
					$src = $element->getAttribute( 'src' );
				}

				foreach ( $element->attributes as $attribute ) {
					$element->removeAttribute( $attribute->name );
				}

				if ( $href && filter_var( $href, FILTER_VALIDATE_URL ) ) {
					$element->setAttribute( 'href', $href );
					$element->setAttribute( 'target', '_blank' );
				}

				if ( $src && filter_var( $src, FILTER_VALIDATE_URL ) && strpos( $src, 'https://woonotice.ir' ) === 0 ) {
					$element->setAttribute( 'src', $src );
				}

				if ( $style ) {
					$element->setAttribute( 'style', $style );
				}
			}

			$_notice['content'] = $doc->saveHTML();
		}

		update_option( 'pw_notices', $notices );

		die();
	}

	public function set_dismiss( $notice_id ) {

		$notices = wp_list_pluck( $this->notices(), 'dismiss', 'id' );

		if ( isset( $notices[ $notice_id ] ) && $notices[ $notice_id ] ) {
			set_transient( 'pw_notice_' . $notice_id, 'DISMISS', intval( $notices[ $notice_id ] ) );
			set_transient( 'pw_notice_all', 'DISMISS', HOUR_IN_SECONDS );
		}
	}

	public function is_dismiss( $notice_id ): bool {
		return get_transient( 'pw_notice_' . $notice_id ) !== false;
	}

}

new Persian_Woocommerce_Notice();