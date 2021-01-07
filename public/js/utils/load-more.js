const REGEX = /<[lL][iI]>/g;

/**
 * Create a DocumentFragment.
 * @param {string} tagString string of html tags
 */
const createFragment = tagString => (
  document.createRange().createContextualFragment( tagString )
);

/**
 * Add a styling hook to each li tag.
 * @param {string} str string of html tags
 * @param {string} cls class value(s) to add
 */
const addStyleHooks = ( str = '', cls = 'new-item' ) => (
  str.replace( REGEX, `<li class="${cls}">` )
);

/**
 * Update the aria live region for new items added.
 * @param {number} count number of loaded items
 */
const updateLiveRegion = count => {
  const liveRegion = document.getElementById( 'gpalab-slo-live' );
  const msg = `${count} social link item${count > 1 ? 's' : ''} added.`;

  if ( liveRegion ) {
    liveRegion.textContent = msg;

    setTimeout( () => {
      liveRegion.textContent = '';
    }, 2000 );
  }
};

/**
 * Return the number of loaded items.
 * @param {string} tagString string of html tags
 */
const getCount = tagString => {
  const count = tagString.match( REGEX );

  return count?.length || 0;
};

/**
 * Send an AJAX request to load more social links.
 * @param {object} e event object
 */
const handleLoadMore = async function( e ) {
  e.preventDefault();

  const socialLinksList = document.querySelector( '.gpalab-slo-content-list' );
  // Get values provided to the client by the server
  const fromPHP = window?.gpalabSloLoadMore || {};

  const data = {
    action: 'gpalab_slo_load_more',
    mission: fromPHP.mission,
    page: fromPHP.current_page,
    query: fromPHP.social_links,
    security: fromPHP.nonce,
  };

  const options = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams( data ),
  };

  try {
    const response = await fetch( fromPHP.ajaxUrl, options );
    const result = await response.text();
    const count = getCount( result );
    const resultWithStyleHooks = addStyleHooks( result );
    const fragment = createFragment( resultWithStyleHooks );

    socialLinksList.appendChild( fragment );
    updateLiveRegion( count );
    fromPHP.current_page++;

    // Remove load more button if last page
    if ( fromPHP.current_page === +fromPHP.max_num_pages ) {
      this.parentNode.removeChild( this );
    }
  } catch ( err ) {
    console.error( err );
  }
};

/**
 * Attach a click event listener to the load more button.
 */
const loadMoreEventListener = () => {
  const loadMoreBtn = document.getElementById( 'load-more' );

  loadMoreBtn?.addEventListener( 'click', handleLoadMore );
};

export default loadMoreEventListener;
