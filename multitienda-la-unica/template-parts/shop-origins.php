<?php
/**
 * Navegación por la clasificación comercial de WooCommerce.
 *
 * @package Multitienda_La_Unica
 */

defined( 'ABSPATH' ) || exit;

$taxonomy = get_taxonomy( 'pa_origen' );
if ( ! $taxonomy ) {
	return;
}

$origins = array(
	'espana'   => __( 'Productos españoles', 'multitienda-la-unica' ),
	'colombia' => __( 'Productos colombianos', 'multitienda-la-unica' ),
);
$links = array();

foreach ( $origins as $slug => $label ) {
	$term = get_term_by( 'slug', $slug, $taxonomy->name );
	if ( ! $term ) {
		continue;
	}

	$url = $taxonomy->public
		? get_term_link( $term )
		: add_query_arg( 'filter_origen', $term->slug, la_unica_shop_url() );

	if ( ! is_wp_error( $url ) ) {
		$links[ $slug ] = array( 'label' => $label, 'url' => $url );
	}
}

if ( ! $links ) {
	return;
}
?>
<section class="home-section" aria-labelledby="origins-heading">
	<h2 id="origins-heading"><?php esc_html_e( 'Compra por origen', 'multitienda-la-unica' ); ?></h2>
	<p class="origin-description"><?php esc_html_e( 'Explora el catálogo por origen comercial.', 'multitienda-la-unica' ); ?></p>
	<ul class="origin-grid">
		<?php foreach ( $links as $slug => $link ) : ?>
			<li>
				<a class="origin-card origin-card--<?php echo esc_attr( $slug ); ?>" href="<?php echo esc_url( $link['url'] ); ?>">
					<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/flag-' . $slug . '.svg' ) ); ?>" width="42" height="28" alt="">
					<span><?php echo esc_html( $link['label'] ); ?></span>
					<span class="origin-arrow" aria-hidden="true">→</span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</section>
