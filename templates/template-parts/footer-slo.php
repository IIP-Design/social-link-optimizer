<?php
/**
 * Footer file for GPALab SLO.
 *
 * @package GPALAB_SLO
 * @since 0.0.1
 */

 // Get the path the the plugin's assets.
$assets_dir = GPALAB_SLO_URL . 'public/assets/';
?>

    <footer id="gpalab-slo-site-footer" role="contentinfo">
      <a href="#gpalab-slo" class="back-to-top" role="navigation" aria-label="back to top">
        <?php
        $up_icon  = '<span>' . __( 'back to top', 'gpalab-slo' ) . '</span>';
        $up_icon .= '<img src=' . esc_attr( $assets_dir . 'arrow-up.svg' ) . ' alt="" height="50" width="50" class="back-to-top">';

        echo wp_kses( $up_icon, 'post' );
        ?>
      </a><!-- .back-to-top -->
    </footer>

    <?php wp_footer(); ?>

  </body>
</html>
