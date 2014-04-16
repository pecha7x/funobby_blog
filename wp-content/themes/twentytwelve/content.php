<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
	    <?php endif; ?>
            <?php if ( is_single() ) : ?>
                <header class="entry-header single-post">
			<h1 class="entry-title single-post"><?php the_title(); ?></h1>
                        <footer class="entry-meta">
			   <?php twentytwelve_entry_meta_new(); ?>
                           <?php printf(get_the_tag_list( '#', __( ', #', 'twentytwelve' ) )); ?>
		        </footer>
		</header><!-- .entry-header -->

		<div class="entry-content single-post">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
            <?php else : ?>
		
		<header class="entry-header">
                    <?php the_post_thumbnail(); ?>
                    <h1 class="entry-title">
                        <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h1>
                    <footer class="entry-meta">
			<?php twentytwelve_entry_meta_new(); ?>
                        <?php printf(get_the_tag_list( '#', __( ', #', 'twentytwelve' ) )); ?>
		    </footer>
                    <div class="entry-content">
                        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
                        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
                    </div>
		</header>
            <?php endif; ?>
	</article><!-- #post -->
