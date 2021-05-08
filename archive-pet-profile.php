<?php
/**
 * The template for displaying archive pet profiles
 */

get_header();
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php
                        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                        ?>
                    </header><!-- .entry-header -->

                    <?php the_post_thumbnail(); ?>

                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer">
                    </footer><!-- .entry-footer -->
                </article><!-- #post-${ID} -->
                <?php
				// End the loop.
			endwhile;

			// If no content, include the "No posts found" template.
		else : ?>
			<section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e( 'Nothing Found', 'twentynineteen' ); ?></h1>
                </header><!-- .page-header -->

                <div class="page-content">
                    <?php
                    if ( is_search() ) :
                        ?>

                        <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hf-pet-memorial-2019' ); ?></p>
                        <?php
                        get_search_form();

                    else :
                        ?>

                        <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hf-pet-memorial-2019' ); ?></p>
                        <?php
                        get_search_form();

                    endif;
                    ?>
                </div><!-- .page-content -->
            </section><!-- .no-results -->
        <?php endif; ?>
        
		</main><!-- #main -->
	</section><!-- #primary -->
<?php
get_footer();
