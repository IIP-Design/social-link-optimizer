<?php
/**
 * Footer file for GPALab SLO.
 *
 * @package GPALAB_SLO
 */

?>

    <footer id="gpalab-slo-site-footer" role="contentinfo">
      <a href="#gpalab-slo-site-header" class="back-to-top" >
        <?php
        /* translators: %s: HTML character for up arrow. */
        printf( esc_html__( 'Back to top %s', 'gpalab-slo' ), '<span class="arrow" aria-hidden="true">&uarr;</span>' );
        ?>
      </a><!-- .back-to-top -->
    </footer>

    <?php wp_footer(); ?>

  </body>
</html>
