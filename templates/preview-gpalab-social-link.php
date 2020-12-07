<?php
/**
 * Template Name: Social Link Preview
 * Template Post Type: gpalab-social-link
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

 /**
  * Simulates the social links page template in order to
  * preview how a social link would look once published.
  */

// If the user is not hitting a preview URL, redirect them to the homepage.
// phpcs:disable WordPress.Security.NonceVerification.Recommended
if ( ! isset( $_GET['preview'] ) || 'true' !== sanitize_text_field( wp_unslash( $_GET['preview'] ) ) ) {
  wp_safe_redirect( home_url() );
  exit;
}
// phpcs:enable

require 'template-parts/header-slo.php';

?>

<main id="gpalab-slo-main-content" role="main">

  <?php

  if ( have_posts() ) {

    while ( have_posts() ) {
      the_post();
      ?>

    <article <?php post_class( 'stack' ); ?> id="post-<?php the_ID(); ?>">

      <header class="content-header stack">
        
        <?php

        // Get all mission settings.
        $slo_settings = get_option( 'gpalab-slo-settings' );

        // Get the id of the selected mission for the current link.
        $selected_mission = get_post_meta( get_the_ID(), 'gpalab_slo_mission', true );

        // Search for selected mission among the mission sessions and return it's data.
        $settings_key  = array_search( $selected_mission, array_column( $slo_settings, 'id' ), true );
        $page_settings = is_numeric( $settings_key ) ? $slo_settings[ $settings_key ] : array();

        $page_title = $selected_mission ? $page_settings['title'] : __( 'All Missions', 'gpalab-slo' );

        $preview_title = '<h1 class="gpalab-slo-page-title">' . $page_title . ' - Preview</h1>';

        echo wp_kses( $preview_title, 'post' );

        require 'template-parts/mission-identity.php';

        ?>

      </header>
    
      <div class="gpalab-slo-content stack">

        <?php
        // Check the current page template.
        $is_slo_preview = is_singular( 'gpalab-social-link' );

        if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
          the_excerpt();
        } elseif ( $is_slo_preview ) {

          require 'template-parts/social-link-layout.php';

          ?>

          <ul class="gpalab-slo-content-list list-reset <?php echo esc_html( $layout ); ?>" aria-describedby="instructions">

            <?php

            // If the current post is not published, render it at the top of
            // the grid/list, this allows for the previewing of draft links.
            if ( 'publish' !== get_post_status( get_the_ID() ) ) {
              // Retrieve the current link post id.
              $current_post = get_the_ID();

              // Ignore if the link is set to be archived.
              if ( 'true' !== get_post_meta( $current_post, 'gpalab_slo_archive', true ) ) {
                require 'template-parts/social-link-item.php';
              }
            };

            // Return the remaining links on the preview page.
            require 'template-parts/social-link-list.php';

            ?>

          </ul>

          <?php
        } else {
          the_content( __( 'Continue reading', 'gpalab-slo' ) );
        }
        ?>

      </div><!-- .gpalab-slo-content -->

      <?php require 'template-parts/inner-section.php'; ?>

    </article><!-- .post -->

      <?php
    }
  }
  ?>

</main><!-- #gpalab-slo-main-content -->

<?php require 'template-parts/footer-slo.php'; ?>
