/**
 * Check if the document is ready and then run a function.
 *
 * @param {function} callback The function to be run when the DOM is loaded.
 */
export const ready = callback => {
  if ( document.readyState !== 'loading' ) {
    return callback();
  }

  document.addEventListener( 'DOMContentLoaded', callback );
};
