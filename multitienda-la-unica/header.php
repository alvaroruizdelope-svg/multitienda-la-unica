<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#contenido"><?php esc_html_e( 'Saltar al contenido', 'multitienda-la-unica' ); ?></a>
<header class="site-header">
	<div class="topbar">
		<div class="wrap topbar-content">
			<span><?php esc_html_e( 'Tienda online', 'multitienda-la-unica' ); ?></span>
			<a href="<?php echo esc_url( la_unica_contact_url() ); ?>"><?php esc_html_e( 'Atención al cliente', 'multitienda-la-unica' ); ?></a>
		</div>
	</div>
	<div class="wrap header-content">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if ( is_readable( get_theme_file_path( '/assets/images/logo-la-unica.png' ) ) ) : ?>
				<img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/logo-la-unica.png' ) ); ?>" alt="<?php esc_attr_e( 'Multitienda La Única · Inicio', 'multitienda-la-unica' ); ?>" width="80" height="80">
			<?php else : ?>
				<span><?php esc_html_e( 'Inicio', 'multitienda-la-unica' ); ?></span>
			<?php endif; ?>
		</a>
		<?php if ( function_exists( 'WC' ) ) : ?>
			<form class="product-search" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" aria-label="<?php esc_attr_e( 'Buscar productos', 'multitienda-la-unica' ); ?>">
				<label for="product-search-input" class="screen-reader-text"><?php esc_html_e( 'Buscar productos', 'multitienda-la-unica' ); ?></label>
				<input type="search" id="product-search-input" name="s" placeholder="<?php esc_attr_e( 'Busca en el catálogo…', 'multitienda-la-unica' ); ?>" value="<?php echo esc_attr( get_search_query( false ) ); ?>" required>
				<input type="hidden" name="post_type" value="product">
				<button type="submit"><?php esc_html_e( 'Buscar', 'multitienda-la-unica' ); ?></button>
			</form>
			<div class="header-actions">
				<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Mi cuenta', 'multitienda-la-unica' ); ?></a>
				<?php la_unica_cart_link(); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="nav-bar">
		<div class="wrap">
			<button type="button" class="nav-toggle" aria-expanded="false" aria-controls="primary-navigation" hidden><?php esc_html_e( 'Menú', 'multitienda-la-unica' ); ?></button>
			<nav id="primary-navigation" aria-label="<?php esc_attr_e( 'Navegación principal', 'multitienda-la-unica' ); ?>">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'fallback_cb' => 'la_unica_primary_menu' ) ); ?>
			</nav>
		</div>
	</div>
</header>
