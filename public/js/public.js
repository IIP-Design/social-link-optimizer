import loadMoreEventListener from './utils/load-more';
import initializeObserver from './utils/back-to-top';

/**
 * Document ready
 * @param {function} callback
 */
const ready = callback => {
  if ( document.readyState !== 'loading' ) {
    return callback();
  }

  document.addEventListener( 'DOMContentLoaded', callback );
};

ready( () => {
  loadMoreEventListener();
  initializeObserver();
} );
