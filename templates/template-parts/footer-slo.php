<?php
/**
 * Footer file for GPALab SLO.
 *
 * @package GPALAB_SLO
 */

 // Get the path the the plugin's assets.
$assets_dir = GPALAB_SLO_URL . 'public/assets/';
?>

    <footer id="gpalab-slo-site-footer" role="contentinfo">
      <a href="#gpalab-slo-site-header" class="back-to-top">
        <?php
        $up_icon  = '<img src=' . esc_attr( $assets_dir . 'arrow-up.svg' ) . ' alt="" height="50" width="50" class="back-to-top">';
        $up_icon .= '<span class="hide-visually">' . __( 'back to top', 'gpalab-slo' ) . '</span>';

        echo wp_kses( $up_icon, 'post' );
        ?>
      </a><!-- .back-to-top -->
    </footer>

    <?php wp_footer(); ?>

  </body>
</html>
