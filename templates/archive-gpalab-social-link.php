<?php
/**
 * Template Name: Social Link Optimizer
 * Template Post Type: page
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

 /**
  * Renders the social links page template.
  */

// Get the id of the selected mission for the current page.
$selected_mission = get_post_meta( get_the_ID(), '_gpalab_slo_mission_select', true );

// Get the remaining page data (using the $selected_mission value above).
require 'template-parts/page-settings.php';

require 'template-parts/header-slo.php';
?>

<main id="gpalab-slo-main-content" class="<?php echo ( $is_grid ) ? 'grid' : 'list'; ?>" role="main">

  <?php

  if ( have_posts() ) {

    while ( have_posts() ) {
      the_post();
      ?>

    <article <?php post_class( 'stack' ); ?> id="post-<?php the_ID(); ?>">

      <header class="content-header stack">
        
          <?php
          // Render the page mission's identity avatar.
          require 'template-parts/identity-logo.php';

          // Render the mission title.
          $page_title = isset( $page_settings['title'] ) ? $page_settings['title'] : get_the_title();

          echo '<h1 id="gpalab-slo-page-title" class="gpalab-slo-page-title">' . esc_html( $page_title ) . '</h1>';

          // Render the mission social properties.
          require 'template-parts/mission-identity.php';

          ?>

      </header>
    
      <div class="gpalab-slo-content stack">

        <?php
        // Check the current page template.
        $is_gpa_slo_archive = is_page_template( 'archive-gpalab-social-link.php' );

        if ( is_search() || ! is_singular() && 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
          the_excerpt();
        } elseif ( $is_gpa_slo_archive ) {

          require 'template-parts/social-link-layout.php';

          ?>

          <ul class="gpalab-slo-content-list list-reset <?php echo esc_html( $layout ); ?>" aria-describedby="instructions">

            <?php require 'template-parts/social-link-list.php'; ?>

          </ul>

          <p id="gpalab-slo-live" class="hide-visually" role="status" aria-live="polite"></p>

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
