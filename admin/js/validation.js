/**
 * Add error styling to an invalid form field.
 * @param {node} element invalid form field
 */
const handleInvalidFieldStyling = element => {
  element.style.borderColor = '#dc3232';
  element.style.boxShadow = '0 0 0 1px #dc3232';
};

/**
 * Reset a form field to the default WordPress classic editor styling.
 * @param {node} element form field
 */
const handleResetFieldStyling = element => {
  element.style.borderColor = '#7e8993';
  element.style.boxShadow = '0 0 0 0 transparent';
};

/**
 * Add required to the title field label
 */
const addRequiredTitleLabel = () => {
  const titleLabel = document.getElementById( 'title-prompt-text' );

  titleLabel.textContent += ' (required)';
};

/**
 * Add required attribute to a form element.
 * @param {string} selector CSS selector
 */
const setRequiredAttribute = selector => {
  document.querySelector( selector ).setAttribute( 'required', '' );
};

/**
 * Construct a custom error message.
 * @param {string} inputName form field name
 * @param {boolean} isSelect is the field a select element
 */
const getCustomErrorMessage = inputName => {
  let message = 'Please enter a title';

  switch ( inputName ) {
    case 'gpalab_slo_mission':
      message = 'Please select a mission';
      break;
    case 'gpalab_slo_link':
      message = 'Please enter a URL.';
      break;
    default:
      break;
  }

  return message;
};

/**
 * Set a custom error message.
 * @param {node} element required form field
 * @param {string} message custom error message
 */
const handleErrorMessage = element => {
  const message = getCustomErrorMessage( element.name );

  element.setCustomValidity( message );
};

/**
 * Set custom error message.
 * @param {object} e event object
 */
const handleInvalidField = e => {
  const { target } = e;

  target.setAttribute( 'aria-invalid', 'true' );
  handleErrorMessage( target );
  handleInvalidFieldStyling( target );
};

/**
 * Validate a required form field.
 * @param {object} e event object
 */
const handleFieldValidation = e => {
  const { target } = e;

  if ( e.target.value.trim() === '' ) {
    return;
  }

  target.removeAttribute( 'aria-invalid' );
  target.setCustomValidity( '' );
  target.checkValidity();
  handleResetFieldStyling( target );
};

/**
 * Add input and invalid event listeners to post form.
 */
const initializeEventListeners = () => {
  const form = document.getElementById( 'post' );

  form.addEventListener( 'input', handleFieldValidation );
  form.addEventListener( 'invalid', handleInvalidField, true );
};

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
  addRequiredTitleLabel();
  setRequiredAttribute( '[name="post_title"]' );
  initializeEventListeners();
} );
