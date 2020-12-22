/**
 * Add required to the title field label
 */
export const addRequiredTitleLabel = () => {
  const titleLabel = document.getElementById( 'title-prompt-text' );

  titleLabel.textContent += ' (required)';
};

/**
 * Add required attribute to a form element.
 * @param {string} selector CSS selector
 */
export const setRequiredAttribute = selector => {
  document.querySelector( selector ).setAttribute( 'required', '' );
};

/**
 * Reset a form field to the default WordPress classic editor styling.
 * @param {node} element form field
 */
export const handleResetFieldStyling = element => {
  element.style.borderColor = '#7e8993';
  element.style.boxShadow = '0 0 0 0 transparent';
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
 * Return invalid required fields.
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
