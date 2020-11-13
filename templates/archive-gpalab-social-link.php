<?php
/**
 * Template Name: Social Link Optimizer
 * Template Post Type: page
 *
 * @package GPALAB_SLO
 */

require 'template-parts/header-slo.php';
?>

<main id="gpalab-slo-main-content" role="main">

  <?php

  if ( have_posts() ) {

    while ( have_posts() ) {
      the_post();
      ?>

    <section <?php post_class( 'stack' ); ?> id="post-<?php the_ID(); ?>">

      <header class="content-header stack">
        <?php the_post_thumbnail() ?>
        <?php the_title( '<h1 class="gpalab-slo-page-title">', '</h1>' ); ?>
        <?php
          // Get all mission settings.
          $slo_settings = get_option( 'gpalab-slo-settings' );

          // Get the id of the selected mission for the current page.
          $selected_mission = get_post_meta( get_the_ID(), 'gpalab_slo_mission_select', true );

          // Search for selected mission among the mission sessions and return it's data.
          $settings_key  = array_search( $selected_mission, array_column( $slo_settings, 'id' ), true );
          $page_settings = is_numeric( $settings_key ) ? $slo_settings[ $settings_key ] : array();

          $url = $page_settings['website'];

          if ( isset( $url ) && '' !== $url ) {
            $protocols = array( 'https://', 'http://' );
            $url_host  = str_replace( $protocols, '', $url );

            $markup  = '<p class="mission-website">';
            $markup .= '<a href=' . esc_html( $url ) . '>';
            $markup .= $url_host;
            $markup .= '</a>';
            $markup .= '</p>';

            echo wp_kses( $markup, 'post' );
          }

          // Extract the social account links from the selected mission data.
          $social_accts = array(
            'twitter'   => $page_settings ['twitter'],
            'facebook'  => $page_settings ['facebook'],
            'instagram' => $page_settings ['instagram'],
            'youtube'   => $page_settings ['youtube'],
            'linkedin'  => $page_settings ['linkedin'],
            'flicker'   => $page_settings ['flicker'],
            'wechat'    => $page_settings ['wechat'],
          );

          // Get the path the the plugin's assets.
          $assets_dir = GPALAB_SLO_URL . '/assets/';
        ?>

        <!-- Set up links to social media icons -->
        <aside>
          <h3 id="social-accts" class="hide-visually">
            social media accounts
          </h3>
          <ul class="gpalab-slo-social-accts-list list-reset" aria-describedby="social-accts">
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
      </header>
    
      <div class="gpalab-slo-content stack">

        <?php
        // Check the current page template.
        $is_gpa_slo_archive = is_page_template( 'archive-gpalab-social-link.php' );

        if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
          the_excerpt();
        } elseif ( $is_gpa_slo_archive ) {

          // Determine the page layout (i.e., grid or list).
          $layout = ( isset( $page_settings['type'] ) && '' !== $page_settings['type'] )
            ? $page_settings['type']
            : 'grid';
          ?>

          <!-- Set up list/grid of social links -->
          <div id="instructions">
            <h2 id="instagram-posts" class="hide-visually">
              Instagram posts
            </h2>
            <p class="instructions <?php echo 'grid' !== $layout ? 'hide-visually' : '' ?>">
              <?php
                $item = 'grid' === $layout ? 'image' : 'item';
                echo 'Select an ' . $item . ' to see more';
              ?>
            </p>
          </div>
          <ul class="gpalab-slo-content-list list-reset <?php echo esc_html( $layout ); ?>" aria-describedby="instructions">
            <?php

            // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_key
            // phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_value
            $args = array(
              'post_type'    => 'gpalab-social-link',
              'meta_key'     => 'gpalab_slo_mission',
              'meta_value'   => $selected_mission,
              'meta_compare' => '=',
            );
            // phpcs:enable

            $the_query = new WP_Query( $args );

            if ( $the_query->have_posts() ) {

              while ( $the_query->have_posts() ) {
                $the_query->the_post();

                // Retrieve the current link post id.
                $current_post = get_the_ID();

                // Skip archived items.
                if ( 'true' === get_post_meta( $current_post, 'gpalab_slo_archive', true ) ) {
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
                  array( 'class' => 'gpalab-slo-thumbnail' )
                );

                $item_photo = linkify( $thumbnail, get_permalink() );

                $hide_visually_class = 'grid' === $layout
                  ? 'hide-visually'
                  : '';

                // Cobble together the HTML for a link item.
                $item  = '<li><article>';
                $item .= '<h3 class="title ' . $hide_visually_class . '">' . wp_kses( $item_title, 'post' ) . '</h3>';
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

      </div><!-- .gpalab-slo-content -->

      <div class="section-inner stack">
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

    </section><!-- .post -->

      <?php
    }
  }
  ?>

</main><!-- #site-content -->

<?php require 'template-parts/footer-slo.php'; ?>
