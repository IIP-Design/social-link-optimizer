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
      ?>
    
      <div class="post-inner">
    
        <div class="entry-content gpa-social-link-optimizer">
    
          <?php
          $is_gpaslo_page_template = is_page_template( 'template-social-link-optimizer.php' );

          if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
            the_excerpt();
          } elseif ( $is_gpaslo_page_template ) {
            $all_settings = get_option( 'gpalab_slo_settings_option_name' );
            $display_as   = $all_settings['display_gpalab_slo_as_a_0'];
            $layout       = ( isset( $display_as ) && '' !== $display_as )
              ? $display_as
              : 'grid';

            $social_accts = array(
              'twitter'   => $all_settings['twitter_feed_3'],
              'facebook'  => $all_settings['facebook_page_1'],
              'instagram' => $all_settings['instagram_feed_5'],
              'youtube'   => $all_settings['youtube_channel_4'],
              'linkedin'  => $all_settings['linkedin_profile_2'],
            );

            $assets_dir = plugins_url( 'social-link-optimizer' ) . '/assets/';
            ?>

            <aside>
              <h3 id="social-accts" class="hide-visually">
                social media accounts
              </h3>
              <ul class="social-media-accts" aria-describedby="social-accts">
              <?php
              foreach ( $social_accts as $key => $value ) {
                if ( isset( $value ) && '' !== $value ) {
                  echo '<li>';
                  echo '<a href="' . $value . '">';
                  echo '<img src="' . $assets_dir . $key . '.svg" alt="" height="24" width="24">';
                  echo '<span class="hide-visually">' . $key . '</span>';
                  echo '</a>';
                  echo '</li>';
                }
              }
              ?>
              </ul>
            </aside>

            <h2 id="instagram-posts" class="hide-visually">
              Instagram posts
            </h2>
            <ul class="gpa-social-list <?php echo $layout; ?>" aria-describedby="instagram-posts">
              <?php

              $args      = array( 'post_type' => 'social_link' );
              $the_query = new WP_Query( $args );

              if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                  $the_query->the_post();
                  $anchor_tag_open  = '<a href="' . esc_url( get_permalink() ) . '">';
                  $anchor_tag_close = '</a>';

                  echo '<li>';
                  echo '<article>';
                  echo '<h3 class="gpa-social-title">';
                  echo $layout == 'list' ? $anchor_tag_open : null;
                  the_title();
                  echo $layout == 'list' ? $anchor_tag_close : null;
                  echo '</h3>';
                  echo $layout == 'grid' ? $anchor_tag_open : null;
                  $layout == 'grid' ? the_post_thumbnail( 'post-thumbnail', array( 'class' => 'gpa-social-thumbnail' ) ) : null;
                  echo $layout == 'grid' ? $anchor_tag_close : null;
                  echo '</article>';
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
        ?>
    
      </div><!-- .section-inner -->
    
      </article><!-- .post -->

      <?php
    }
  }
  ?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' ); ?>

<?php get_footer(); ?>
