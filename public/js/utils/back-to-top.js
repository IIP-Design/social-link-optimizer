/**
 * Add (remove) is-visible class if the reference element
 * is (not) intersecting the viewport.
 * @param {array} entries subject element(s)
 */
const handleBackToTopDisplay = entries => {
  const backToTop = document.querySelector( '.back-to-top' );

  if ( entries?.[0] && backToTop ) {
    const { isIntersecting } = entries[0];

    if ( isIntersecting ) {
      backToTop.classList.remove( 'is-visible' );
    } else {
      backToTop.classList.add( 'is-visible' );
    }
  }
};

/**
 * Observe the reference element for intersection changes, i.e.,
 * when it is out of the viewport (plus top rootMargin).
 */
const initializeObserver = () => {
  if ( window?.IntersectionObserver ) {
    const referenceElem = document.getElementById( 'instructions' );
    const options = {
      root: null,
      rootMargin: '100px 0px 0px 0px',
      threshold: 0,
    };

    const observer = new IntersectionObserver( handleBackToTopDisplay, options );

    observer.observe( referenceElem );
  } else {
    const backToTop = document.querySelector( '.back-to-top' );

    backToTop?.classList.add( 'is-visible' );
  }
};

export default initializeObserver;
