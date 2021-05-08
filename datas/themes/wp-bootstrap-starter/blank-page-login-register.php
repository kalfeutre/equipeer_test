<?php
/**
 * Template Name: Blank with Login and register forms
 */

get_header();
?>
    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            <div class="container">
                
                <div class="form-signin">
                    
                    <a href="<?php echo get_site_url(); ?>">
                        <img class="mt-4 mb-4 img-fluid mx-auto d-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-equipeer-sport-300.png" alt="<?php echo get_bloginfo('name'); ?> <?php echo get_bloginfo('description'); ?>" width="300" height="64">
                    </a>
                    
                    <?php
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content', 'notitle' );
                    endwhile; // End of the loop.
                    ?>
                    
                </div> <!-- ./form-signin -->
                    
            </div> <!-- ./container -->
        
        </main> <!-- #main -->
    
    </section> <!-- #primary -->

<?php
get_footer();