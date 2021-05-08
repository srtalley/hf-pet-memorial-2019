<?php
/**
 * The template for displaying all single pet portfolios
 */

get_header();
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :

                the_post();

                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    </header>

                    <div class="entry-content">
                        <?php
                        the_post_thumbnail();

                        the_content();
                        ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer">
                    </footer><!-- .entry-footer -->
                </article><!-- #post-${ID} -->

            <?php endwhile; // End of the loop. ?>
		</main><!-- #main -->
	</section><!-- #primary -->
<?php
get_footer();
