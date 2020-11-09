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
          // Check the current page template.
          $is_gpa_slo_archive = is_page_template( 'archive-gpalab-social-link.php' );

          if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
            the_excerpt();
          } elseif ( $is_gpa_slo_archive ) {

            // Get all mission settings.
            $slo_settings = get_option( 'gpalab-slo-settings' );

            // Get the id of the selected mission for the current page.
            $selected_mission = get_post_meta( get_the_ID(), 'gpalab-slo-mission-select', true );

            // Search for selected mission among the mission sessions and return it's data.
            $settings_key  = array_search( $selected_mission, array_column( $slo_settings, 'id' ), true );
            $page_settings = $settings_key ? $slo_settings[ $settings_key ] : array();

            // Determine the page layout (ie. grid or list).
            $layout = ( isset( $page_settings['type'] ) && '' !== $page_settings['type'] )
              ? $page_settings['type']
              : 'grid';

            // Extract the social account links from the selected mission data.
            $social_accts = array(
              'twitter'   => $page_settings ['twitter'],
              'facebook'  => $page_settings ['facebook'],
              'instagram' => $page_settings ['instagram'],
              'youtube'   => $page_settings ['youtube'],
              'linkedin'  => $page_settings ['linkedin'],
            );

            // Get the path the the plugin's assets.
            $assets_dir = GPALAB_SLO_URL . '/assets/';
            ?>

            <!-- Set up links to social media icons -->
            <aside>
              <h3 id="social-accts" class="hide-visually">
                social media accounts
              </h3>
              <ul class="social-media-accts" aria-describedby="social-accts">
              <?php
              foreach ( $social_accts as $key => $value ) {

                if ( isset( $value ) && '' !== $value ) {
                  $acct  = '<li><a href=' . esc_attr( $value ) . '>';
                  $acct .= '<img src=' . esc_attr( $assets_dir . $key . '.svg' ) . ' alt="" height="24" width="24">';
                  $acct .= '<span class="hide-visually">' . esc_html( $key ) . '</span>';
                  $acct .= '</a></li>';

                  echo wp_kses( $acct, 'post' );
                }
              }
              ?>
              </ul>
            </aside>

            <!-- Set up list/grid of social links -->
            <h2 id="instagram-posts" class="hide-visually">
              Instagram posts
            </h2>
            <ul class="gpa-social-list <?php echo esc_html( $layout ); ?>" aria-describedby="instagram-posts">
              <?php

              $args = array(
                'post_type'    => 'gpalab-social-link',
                'meta_key'     => 'gpalab-slo-mission',
                'meta_value'   => $selected_mission,
                'meta_compare' => '=',
              );

              $the_query = new WP_Query( $args );

              if ( $the_query->have_posts() ) {

                while ( $the_query->have_posts() ) {
                  $the_query->the_post();

                  // Retrieve the current link post id.
                  $current_post = get_the_ID();

                  $is_archive = get_post_meta( $current, 'gpalab-slo-archive-meta', true );

                  // skip archived items
                  if ( 'true' === $is_archive ) {
                    continue;
                  }

                  // Check if function already exists to prevent re-declaration in the loop.
                  if ( ! function_exists( 'linkify' ) ) {
                    /**
                     * Wrap some string or HTML element in a link.
                     *
                     * @param string $element   The element to be placed within a link.
                     * @param string $url       The wrapping url.
                     */
                    function linkify( $element, $url ) {
                      return '<a href="' . esc_url( $url ) . '">' . $element . '</a>';
                    }
                  }

                  // Retrieve the item title.
                  $item_title = 'list' === $layout
                    ? linkify( get_the_title( $current_post ), get_permalink() )
                    : get_the_title( $current_post );

                  // Retrieve the item photo.
                  $thumbnail = get_the_post_thumbnail(
                    $current_post,
                    'post-thumbnail',
                    array( 'class' => 'gpa-social-thumbnail' )
                  );

                  $item_photo = linkify( $thumbnail, get_permalink() );

                  // Cobble together the HTML for a link item.
                  $item  = '<li><article>';
                  $item .= '<h3 class="gpa-social-title">' . wp_kses( $item_title, 'post' ) . '</h3>';
                  $item .= 'grid' === $layout ? wp_kses( $item_photo, 'post' ) : '';
                  $item .= '</article></li>';

                  // Sanitize the HTML returned onto the page.
                  echo wp_kses( $item, 'post' );
                }
              } else {
                // Show fallback message if no links found.
                $no_links = __( 'No Social Bio Links', 'gpalab-slo' );

                echo '<p>' . esc_html( $no_links ) . '</p>';
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
