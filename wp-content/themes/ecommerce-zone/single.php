<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Ecommerce Zone
 */

get_header(); ?>
    <div id="primary" class="content-area col-md-12 <?php echo is_active_sidebar('sidebar-1') ? "col-lg-9" : "col-lg-12"; ?>">
        <main id="main" class="site-main module-border-wrap mb-4">
            <?php while (have_posts()) : the_post();
                get_template_part('template-parts/content', 'single'); ?>

                <?php if (!is_singular('attachment')):
                    the_post_navigation();
                    endif;
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif; ?>
                <?php endwhile; // End of the loop.
            ?>
        </main>
    </div>
<?php
get_sidebar();
get_footer();