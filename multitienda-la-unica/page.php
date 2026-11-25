<?php get_header(); ?>
<main id="contenido" class="wrap inner-page" tabindex="-1">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
