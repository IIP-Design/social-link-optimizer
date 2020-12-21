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
const getCustomTooltipErrorMessage = inputName => {
  let message = 'Please enter a title.';

  switch ( inputName ) {
    case 'gpalab_slo_mission':
      message = 'Please select a mission.';
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
 * Return invalid required fields.
 */
const getInvalidFields = () => (
  document.querySelectorAll( '[aria-invalid="true"]' )
);

/**
 * Return invalid required fields.
 */
const getFormLiveRegion = () => (
  document.getElementById( 'gpalab-slo-validation' )
);

/**
 * Update the live region content.
 * @param {node} element the live region node
 * @param {node} childNode the node to append to the live region
 */
const updateLiveRegion = ( element, childNode, classValues = '' ) => {
  element.innerHTML = '';
  element.classList = classValues;

  if ( childNode && classValues ) {
    element.appendChild( childNode );
  }
};

/**
 * Construct the live region error message.
 */
const getLiveRegionErrorMessage = () => {
  const errors = getInvalidFields();

  if ( !errors.length ) {
    return;
  }

  const p = document.createElement( 'p' );
  const ul = document.createElement( 'ul' );
  const msg = `Please complete the following required field${errors.length > 1 ? 's' : ''}:`;

  p.textContent = msg;
  ul.style.listStyle = 'disc';
  ul.style.paddingLeft = '1rem';

  errors.forEach( error => {
    const li = document.createElement( 'li' );
    const fields = error?.name?.split( '_' ) || [];
    const field = fields[fields.length - 1];

    if ( field ) {
      li.textContent = field;
      ul.appendChild( li );
    }
  } );

  p.appendChild( ul );

  return p;
};

/**
 * Set a custom error message.
 * @param {node} element required form field
 * @param {string} message custom error message
 */
const handleFieldErrorMessage = element => {
  const tooltipMsg = getCustomTooltipErrorMessage( element.name );
  const p = getLiveRegionErrorMessage();

  element.setCustomValidity( tooltipMsg );

  const formLiveRegion = getFormLiveRegion();

  // Update the live region content.
  updateLiveRegion( formLiveRegion, p, 'notice notice-error gpalab-slo' );
};

/**
 * Set custom error message.
 * @param {object} e event object
 */
const handleInvalidField = e => {
  const { target } = e;

  // Set field as invalid
  target.setAttribute( 'aria-invalid', 'true' );
  handleFieldErrorMessage( target );
  handleInvalidFieldStyling( target );
};

/**
 * Validate a required form field.
 * @param {object} e event object
 */
const handleFieldValidation = e => {
  const { target } = e;

  // Field remains invalid if empty spaces are entered.
  if ( target.value.trim() === '' ) {
    return;
  }

  // Reset styling, custom tooltip, etc.
  target.removeAttribute( 'aria-invalid' );
  target.setCustomValidity( '' );
  target.checkValidity();
  handleResetFieldStyling( target );

  const formLiveRegion = getFormLiveRegion();

  // Reset the live region content.
  updateLiveRegion( formLiveRegion, null );

  const errors = getInvalidFields();

  // Update the live region content if there are still errors.
  if ( errors?.length ) {
    const p = getLiveRegionErrorMessage();

    updateLiveRegion( formLiveRegion, p, 'notice notice-error gpalab-slo' );
  }
};

/**
 * Insert a live region for validation errors
 */
const insertFormLiveRegion = () => {
  const form = document.getElementById( 'post' );
  const formLiveRegion = document.createElement( 'div' );

  formLiveRegion.setAttribute( 'id', 'gpalab-slo-validation' );
  formLiveRegion.setAttribute( 'role', 'status' );
  formLiveRegion.setAttribute( 'aria-live', 'polite' );
  form.insertAdjacentElement( 'beforebegin', formLiveRegion );
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
  insertFormLiveRegion();
  addRequiredTitleLabel();
  setRequiredAttribute( '[name="post_title"]' );
  initializeEventListeners();
} );
