<?php
/**
 * Plantilla para mostrar el contenido de una página.
 */
 
// Cabecera
get_header();

if(have_posts()){
	the_post(); ?>
	<article>
		<?php
		if(has_post_thumbnail()){
			the_post_thumbnail('thumbnail');
		}
		the_title('<h1>','</h1>');
		the_content();
		?>
	</article>
<?php
}

// Footer
get_footer();
