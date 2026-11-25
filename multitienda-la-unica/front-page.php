<?php get_header(); ?>
<main id="contenido" class="wrap home-content" tabindex="-1">
	<section class="hero">
		<div class="hero-copy">
			<h1><?php esc_html_e( 'Todo lo que necesitas, en un mismo lugar.', 'multitienda-la-unica' ); ?></h1>
			<p><?php esc_html_e( 'Descubre nuestros productos y novedades.', 'multitienda-la-unica' ); ?></p>
			<?php if ( function_exists( 'WC' ) ) : ?>
				<a class="button-primary" href="<?php echo esc_url( la_unica_shop_url() ); ?>"><?php esc_html_e( 'Ver productos', 'multitienda-la-unica' ); ?> <span aria-hidden="true">→</span></a>
			<?php endif; ?>
		</div>
		<?php if ( is_readable( get_theme_file_path( '/assets/images/compra.webp' ) ) ) : ?>
			<img class="hero-image" src="<?php echo esc_url( get_theme_file_uri( '/assets/images/compra.webp' ) ); ?>" alt="" width="900" height="600" fetchpriority="high">
		<?php endif; ?>
	</section>
	<section class="home-section" aria-labelledby="categories-heading">
		<h2 id="categories-heading"><?php esc_html_e( 'Compra por categorías', 'multitienda-la-unica' ); ?></h2>
		<?php
		$categories = taxonomy_exists( 'product_cat' ) ? get_terms( array(
			'taxonomy' => 'product_cat',
			'parent' => 0,
			'hide_empty' => true,
			'exclude' => array( (int) get_option( 'default_product_cat' ) ),
		) ) : array();
		?>
		<?php if ( ! is_wp_error( $categories ) && $categories ) : ?>
			<ul class="category-grid">
				<?php foreach ( $categories as $category ) :
					$url = get_term_link( $category );
					if ( is_wp_error( $url ) ) {
						continue;
					}
					$image_id = (int) get_term_meta( $category->term_id, 'thumbnail_id', true );
					?>
					<li><a href="<?php echo esc_url( $url ); ?>">
						<?php if ( $image_id ) : ?>
							<?php echo wp_get_attachment_image( $image_id, 'woocommerce_thumbnail', false, array( 'alt' => '' ) ); ?>
						<?php endif; ?>
						<span><?php echo esc_html( $category->name ); ?></span><span aria-hidden="true">→</span>
					</a></li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="empty-state"><?php esc_html_e( 'Las categorías aparecerán cuando haya productos publicados en ellas.', 'multitienda-la-unica' ); ?></p>
		<?php endif; ?>
	</section>
	<?php get_template_part( 'template-parts/shop-origins' ); ?>
	<section id="ofertas" class="home-section" aria-labelledby="offers-heading">
		<h2 id="offers-heading"><?php esc_html_e( 'Ofertas destacadas', 'multitienda-la-unica' ); ?></h2>
		<?php la_unica_home_products( 'sale_products', array(), __( 'En este momento no hay ofertas activas.', 'multitienda-la-unica' ) ); ?>
	</section>
	<section class="home-section" aria-labelledby="featured-heading">
		<h2 id="featured-heading"><?php esc_html_e( 'Productos destacados', 'multitienda-la-unica' ); ?></h2>
		<?php la_unica_home_products( 'products', array( 'visibility' => 'featured' ), __( 'Todavía no hay productos destacados.', 'multitienda-la-unica' ) ); ?>
	</section>
	<section class="home-section shop-help" aria-labelledby="help-heading">
		<h2 id="help-heading"><?php esc_html_e( 'Información de compra', 'multitienda-la-unica' ); ?></h2>
		<ul>
			<li><?php esc_html_e( 'Envíos y devoluciones', 'multitienda-la-unica' ); ?></li>
			<li><?php esc_html_e( 'Métodos de pago', 'multitienda-la-unica' ); ?></li>
			<li><a href="<?php echo esc_url( la_unica_contact_url() ); ?>"><?php esc_html_e( 'Atención al cliente', 'multitienda-la-unica' ); ?></a></li>
		</ul>
	</section>
</main>
<?php get_footer(); ?>
