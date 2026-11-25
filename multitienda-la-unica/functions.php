<?php
/**
 * Configuración del tema.
 *
 * @package Multitienda_La_Unica
 */

defined( 'ABSPATH' ) || exit;

function la_unica_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'woocommerce', array( 'product_grid' => array( 'default_columns' => 4, 'default_rows' => 4 ) ) );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	register_nav_menus( array(
		'primary' => __( 'Menú principal', 'multitienda-la-unica' ),
		'footer'  => __( 'Menú de información y políticas', 'multitienda-la-unica' ),
	) );
}
add_action( 'after_setup_theme', 'la_unica_setup' );

function la_unica_assets() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'la-unica-theme', get_stylesheet_uri(), array(), $version );
	$dependencies = array( 'la-unica-theme' );
	if ( wp_style_is( 'woocommerce-general', 'enqueued' ) ) {
		$dependencies[] = 'woocommerce-general';
	}
	wp_enqueue_style( 'la-unica', get_theme_file_uri( '/assets/css/shop.css' ), $dependencies, $version );
	wp_enqueue_script( 'la-unica-menu', get_theme_file_uri( '/assets/js/menu.js' ), array(), $version, array( 'strategy' => 'defer', 'in_footer' => true ) );
	if ( function_exists( 'WC' ) ) {
		wp_enqueue_script( 'wc-cart-fragments' );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'la_unica_assets', 20 );

function la_unica_shop_url() {
	return function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
}

function la_unica_contact_url() {
	$page = get_page_by_path( 'contacto' );
	return $page && 'publish' === $page->post_status ? get_permalink( $page ) : home_url( '/#contacto' );
}

function la_unica_primary_menu() {
	$links = array(
		__( 'Inicio', 'multitienda-la-unica' )    => home_url( '/' ),
		__( 'Productos', 'multitienda-la-unica' ) => la_unica_shop_url(),
		__( 'Ofertas', 'multitienda-la-unica' )   => home_url( '/#ofertas' ),
		__( 'Contacto', 'multitienda-la-unica' )  => la_unica_contact_url(),
	);
	echo '<ul>';
	foreach ( $links as $label => $url ) {
		printf( '<li><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

function la_unica_cart_link() {
	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	?>
	<a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
		<img alt="" width="24" height="24" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/cart.svg' ) ); ?>">
		<span><?php esc_html_e( 'Carrito', 'multitienda-la-unica' ); ?></span>
		<span class="cart-count">
			<span aria-hidden="true"><?php echo esc_html( number_format_i18n( $count ) ); ?></span>
			<span class="screen-reader-text"><?php
				/* translators: %s: number of items in the cart. */
				echo esc_html( sprintf( _n( '%s artículo', '%s artículos', $count, 'multitienda-la-unica' ), number_format_i18n( $count ) ) );
			?></span>
		</span>
	</a>
	<?php
}

function la_unica_cart_fragments( $fragments ) {
	ob_start();
	la_unica_cart_link();
	$fragments['a.cart-link'] = trim( ob_get_clean() );
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'la_unica_cart_fragments' );

// Los bloques de WooCommerce actualizan su propio almacén mediante la Store API.
function la_unica_cart_block_sync() {
	if ( ! function_exists( 'WC' ) || ! ( is_cart() || is_checkout() ) ) {
		return;
	}
	wp_enqueue_script( 'wp-data' );
	wp_add_inline_script( 'wp-data', <<<'JS'
document.addEventListener('DOMContentLoaded', () => {
	let previousCount;
	const data = window.wp && window.wp.data;

	if (!data) return;

	data.subscribe(() => {
		const cart = data.select('wc/store/cart');
		const count = cart?.getCartData()?.itemsCount;

		if (!Number.isInteger(count) || !cart.hasFinishedResolution('getCartData', [])) return;
		if (previousCount === count) return;

		previousCount = count;
		jQuery(document.body).trigger('wc_fragment_refresh');
	});
});
JS
	);
}
add_action( 'wp_enqueue_scripts', 'la_unica_cart_block_sync', 30 );

function la_unica_woocommerce_wrappers() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_before_main_content', 'la_unica_shop_open', 10 );
	add_action( 'woocommerce_after_main_content', 'la_unica_shop_close', 10 );
}
add_action( 'after_setup_theme', 'la_unica_woocommerce_wrappers', 20 );

function la_unica_shop_open() {
	echo '<main id="contenido" class="wrap inner-page" tabindex="-1">';
}

function la_unica_shop_close() {
	echo '</main>';
}

function la_unica_product_availability() {
	global $product;
	if ( ! $product instanceof WC_Product ) {
		return;
	}
	if ( ! $product->is_in_stock() ) {
		$availability = __( 'Agotado', 'multitienda-la-unica' );
	} elseif ( $product->is_on_backorder() ) {
		$availability = __( 'Disponible bajo pedido', 'multitienda-la-unica' );
	} else {
		$availability = __( 'Disponible', 'multitienda-la-unica' );
	}
	printf( '<p class="product-availability">%s</p>', esc_html( $availability ) );
}
add_action( 'woocommerce_after_shop_loop_item_title', 'la_unica_product_availability', 15 );

function la_unica_home_products( $type, $attributes, $empty_message ) {
	$show_empty = static function () use ( $empty_message ) {
		echo '<p class="empty-state">' . esc_html( $empty_message ) . '</p>';
	};
	if ( ! class_exists( 'WC_Shortcode_Products' ) ) {
		$show_empty();
		return;
	}

	$empty_hook = "woocommerce_shortcode_{$type}_loop_no_results";
	add_action( $empty_hook, $show_empty );
	$products = new WC_Shortcode_Products( array_merge( array( 'limit' => 4, 'columns' => 4 ), $attributes ), $type );
	// WooCommerce genera las tarjetas y sus controles de compra.
	echo $products->get_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	remove_action( $empty_hook, $show_empty );
}
