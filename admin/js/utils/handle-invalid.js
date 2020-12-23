import { getFormLiveRegion, updateLiveRegion } from './validation-utils';

/**
 * Return invalid required fields.
 */
export const getInvalidFields = () => (
  document.querySelectorAll( '[aria-invalid="true"]' )
);

/**
 * Construct a custom error message.
 * @param {string} inputName form field name
 * @param {boolean} isSelect is the field a select element
 */
const getCustomTooltipInvalidMessage = inputName => {
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
 * Construct the live region error message.
 */
export const getLiveRegionInvalidMessage = () => {
  const errors = getInvalidFields();

  if ( !errors.length ) {
    return;
  }

  const div = document.createElement( 'div' );
  const p = document.createElement( 'p' );
  const ul = document.createElement( 'ul' );
  const msg = `Please complete the following required field${errors.length > 1 ? 's' : ''}:`;

  p.textContent = msg;

  errors.forEach( error => {
    const li = document.createElement( 'li' );
    const fields = error?.name?.split( '_' ) || [];
    const field = fields[fields.length - 1];

    if ( field ) {
      li.textContent = field;
      ul.appendChild( li );
    }
  } );

  div.appendChild( p );
  div.appendChild( ul );

  return div;
};

/**
 * Set a custom error message.
 * @param {node} element required form field
 * @param {string} message custom error message
 */
export const handleInvalidFieldMessage = element => {
  const tooltipMsg = getCustomTooltipInvalidMessage( element.name );
  const p = getLiveRegionInvalidMessage();

  element.setCustomValidity( tooltipMsg );

  const formLiveRegion = getFormLiveRegion();

  // Update the live region content.
  updateLiveRegion( formLiveRegion, p, 'notice notice-error gpalab-slo' );
};

/**
 * Set custom error message.
 * @param {object} e event object
 */
export const handleInvalidField = e => {
  const { target } = e;

  // Set field as invalid
  target.setAttribute( 'aria-invalid', 'true' );
  handleInvalidFieldMessage( target );
};

