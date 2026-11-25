<footer class="site-footer" id="contacto">
	<div class="wrap footer-content">
		<div>
			<h2><?php esc_html_e( 'Multitienda La Única', 'multitienda-la-unica' ); ?></h2>
			<p><?php esc_html_e( 'Información del negocio y datos de contacto pendientes de confirmación.', 'multitienda-la-unica' ); ?></p>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Información y políticas', 'multitienda-la-unica' ); ?>">
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1, 'fallback_cb' => false ) ); ?>
			<?php else : ?>
				<ul>
					<li><?php esc_html_e( 'Contacto', 'multitienda-la-unica' ); ?></li>
					<li><?php esc_html_e( 'Aviso legal', 'multitienda-la-unica' ); ?></li>
					<li><?php esc_html_e( 'Política de privacidad', 'multitienda-la-unica' ); ?></li>
					<li><?php esc_html_e( 'Política de cookies', 'multitienda-la-unica' ); ?></li>
					<li><?php esc_html_e( 'Condiciones de compra', 'multitienda-la-unica' ); ?></li>
					<li><?php esc_html_e( 'Envíos y devoluciones', 'multitienda-la-unica' ); ?></li>
				</ul>
			<?php endif; ?>
		</nav>
		<p class="attribution"><a href="https://alvaro-web.pages.dev/"><?php esc_html_e( 'Diseñado y desarrollado por AV CODE STUDIO', 'multitienda-la-unica' ); ?></a></p>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
