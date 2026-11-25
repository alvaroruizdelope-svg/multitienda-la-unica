<?php get_header(); ?>
<main id="contenido" class="wrap inner-page" tabindex="-1">
	<?php if ( is_search() ) : ?>
		<h1><?php
			/* translators: %s: search term. */
			echo esc_html( sprintf( __( 'Resultados para «%s»', 'multitienda-la-unica' ), get_search_query( false ) ) );
		?></h1>
	<?php elseif ( is_archive() ) : ?>
		<?php the_archive_title( '<h1>', '</h1>' ); ?>
		<?php the_archive_description(); ?>
	<?php elseif ( is_home() ) : ?>
		<h1><?php esc_html_e( 'Entradas', 'multitienda-la-unica' ); ?></h1>
	<?php elseif ( is_404() ) : ?>
		<h1><?php esc_html_e( 'Página no encontrada', 'multitienda-la-unica' ); ?></h1>
	<?php endif; ?>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<?php if ( is_singular() ) : ?>
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
					<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
				<?php else : ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php the_excerpt(); ?>
				<?php endif; ?>
			</article>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
		<p class="empty-state"><?php esc_html_e( 'No se ha encontrado contenido.', 'multitienda-la-unica' ); ?></p>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
