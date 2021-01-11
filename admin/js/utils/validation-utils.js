/**
 * Add required to the title field label
 */
export const addRequiredTitleLabel = () => {
  const titleLabel = document.getElementById( 'title-prompt-text' );

  if ( titleLabel ) {
    titleLabel.textContent += ' (required)';
  }
};

/**
 * Add required attribute to a form element.
 * @param {string} selector CSS selector
 */
export const setRequiredAttribute = selector => {
  const el = document.querySelector( selector );

  if ( el ) {
    el.setAttribute( 'required', '' );
  }
};

/**
 * Insert a live region for validation errors
 */
export const insertFormLiveRegion = () => {
  const form = document.getElementById( 'post' );
  const formLiveRegion = document.createElement( 'div' );

  formLiveRegion.setAttribute( 'id', 'gpalab-slo-validation' );
  formLiveRegion.setAttribute( 'role', 'status' );
  formLiveRegion.setAttribute( 'aria-live', 'polite' );
  form.insertAdjacentElement( 'beforebegin', formLiveRegion );
};

/**
 * Return the live region element.
 */
export const getFormLiveRegion = () => (
  document.getElementById( 'gpalab-slo-validation' )
);

/**
 * Update the live region content.
 * @param {node} element the live region node
 * @param {node} childNode the node to append to the live region
 */
export const updateLiveRegion = ( element, childNode, classValues = '' ) => {
  element.innerHTML = '';
  element.classList = classValues;

  if ( childNode && classValues ) {
    element.appendChild( childNode );
  }
};

/**
 * Debounce function.
 * @param {function} fn the function to debounce
 */
export const debounce = ( fn, delay ) => {
  let timeout;

  return function( ...args ) {
    const fnCall = () => fn.apply( this, args );

    clearTimeout( timeout );
    timeout = setTimeout( fnCall, delay );
  };
};
