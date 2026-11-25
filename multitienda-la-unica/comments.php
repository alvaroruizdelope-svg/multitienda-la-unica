<?php
if ( post_password_required() ) {
	return;
}
?>
<section class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h2><?php esc_html_e( 'Comentarios', 'multitienda-la-unica' ); ?></h2>
		<ol><?php wp_list_comments(); ?></ol>
		<?php the_comments_pagination(); ?>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>
