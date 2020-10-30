<?php
/**
 * Template Name: Social Link Optimizer
 * Template Post Type: page
 *
 * @package GPALAB_SLO
 */

get_header();
?>

<main id="site-content" role="main">

  <?php

  if ( have_posts() ) {

    while ( have_posts() ) {
      the_post();
      ?>

      <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

      <?php

      get_template_part( 'template-parts/entry-header' );

      if ( ! is_search() ) {
        get_template_part( 'template-parts/featured-image' );
      }

      ?>
    
      <div class="post-inner">
    
        <div class="entry-content gpa-social-link-optimizer">
    
					<?php
					$is_gpaslo_page_template = is_page_template( '/templates/template-social-link-optimizer.php' );

          if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
            the_excerpt();
          } elseif ( $is_gpaslo_page_template ) {
						$all_settings = get_option( 'gpalab_slo_settings_option_name' );;
						$display_as = $all_settings['display_gpalab_slo_as_a_0'];
						$layout = ( isset( $display_as ) && $display_as !== '' )
							? $display_as
							: 'grid';
						?>

            <ul class="gpa-social-list <?php echo $layout; ?>">
              <?php

              $args      = array( 'post_type' => 'social_link' );
              $the_query = new WP_Query( $args );

              if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                  $the_query->the_post();
                  echo '<li>';
                  echo '<h2 class="gpa-social-title">';
                  echo '<a href="' . esc_url( get_permalink() ) . '">';
                  the_title();
                  echo '</a>';
                  echo '</h2>';
                  echo '<div class="gpa-social-thumbnail">';
                  the_post_thumbnail();
                  echo '</div>';
                  echo '</li>';
                }
              } else {
                echo '<p>No Social Bio Links</p>';
              }

              wp_reset_postdata();

              ?>
            </ul>
            <?php
          } else {
            the_content( __( 'Continue reading', 'gpalab-slo' ) );
          }
          ?>
    
        </div><!-- .entry-content -->
    
      </div><!-- .post-inner -->
    
      <div class="section-inner">
        <?php
        wp_link_pages(
          array(
            'before'      => '<nav class="post-nav-links bg-light-background" aria-label="' . esc_attr__( 'Page', 'gpalab-slo' ) . '"><span class="label">' . __( 'Pages:', 'gpalab-slo' ) . '</span>',
            'after'       => '</nav>',
            'link_before' => '<span class="page-number">',
            'link_after'  => '</span>',
          )
        );

        edit_post_link();

        // Single bottom post meta.
        twentytwenty_the_post_meta( get_the_ID(), 'single-bottom' );

        if ( post_type_supports( get_post_type( get_the_ID() ), 'author' ) && is_single() ) {

          get_template_part( 'template-parts/entry-author-bio' );

        }
        ?>
    
      </div><!-- .section-inner -->
    
      <?php

      if ( is_single() ) {
        get_template_part( 'template-parts/navigation' );
      }

      /**
       *  Output comments wrapper if it's a post, or if comments are open,
       * or if there's a comment number – and check for password.
       * */
      if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
        ?>

        <div class="comments-wrapper section-inner">
          <?php comments_template(); ?>
        </div><!-- .comments-wrapper -->

        <?php
      }
      ?>
    
      </article><!-- .post -->

      <?php
    }
  }
  ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
