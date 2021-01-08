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

// Get the id of the selected mission for the current link.
$selected_mission = get_post_meta( get_the_ID(), 'gpalab_slo_mission', true );

// Get the remaining page data (using the $selected_mission value above).
require 'template-parts/page-settings.php';

?>

<main id="gpalab-slo-main-content" role="main">

  <?php

  if ( have_posts() ) {

    while ( have_posts() ) {
      the_post();
      ?>

    <article <?php post_class( 'stack' ); ?>>

      <header class="content-header stack">
        
        <?php

        // Render the page mission's identity avatar.
        require 'template-parts/identity-logo.php';

        // Render the preview page title.
        $page_title = isset( $selected_mission ) ? $page_settings['title'] : __( 'All Missions', 'gpalab-slo' );

        $preview_title = '<h1 class="gpalab-slo-page-title">' . $page_title . ' - Preview</h1>';

        echo wp_kses( $preview_title, 'post' );

        // Render the mission social properties.
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

            // Get the current post status.
            $post_status   = get_post_status( get_the_ID() );
            $draft_preview = false;

            // If the current post is not published or archived, render it at the top of
            // the grid/list, this allows for the previewing of draft links.
            if ( 'publish' !== $post_status && 'archived' !== $post_status ) {
              require 'template-parts/social-link-item.php';
            };

            if ( 'draft' === $post_status ) {
              $draft_preview = true;
            }

            // Return the remaining links on the preview page.
            require 'template-parts/social-link-list.php';

            ?>

          </ul>

          <?php

          // Add the load-more button when appropriate.
          require 'template-parts/load-more.php';

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
