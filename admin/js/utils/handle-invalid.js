import { __ } from '@wordpress/i18n';

import { getFormLiveRegion, updateLiveRegion } from './validation-utils';

/**
 * Return invalid required fields.
 */
export const getInvalidFields = () => (
  document.querySelectorAll( '[aria-invalid="true"]' )
);

/**
 * Check if an input field is for a settings page title.
 * Accepts single/double digit index as part of the input name.
 *
 * @param {string} inputName Form field name
 */
const checkIfSettingsTitle = inputName => {
  const settingsTitle = /(gpalab-slo-settings\[([0-9]|[0-9][0-9])\]\[title\])/;

  return inputName.match( settingsTitle );
};

/**
 * Construct a custom error message.
 * @param {string} inputName form field name
 * @param {boolean} isSelect is the field a select element
 */
const getCustomTooltipInvalidMessage = inputName => {
  let message = __( 'Please provide a value for this field.', 'gpalab-slo' );

  switch ( inputName ) {
    case ( checkIfSettingsTitle( inputName ) || {} ).input:
      message = __( 'Please provide a mission name.', 'gpalab-slo' );
      break;
    case 'gpalab_slo_mission':
      message = __( 'Please select a mission.', 'gpalab-slo' );
      break;
    case 'gpalab_slo_link':
      message = __( 'Please enter a URL.', 'gpalab-slo' );
      break;
    case 'post_title':
      message = __( 'Please enter a title.', 'gpalab-slo' );
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

  const singular = 'Please complete the following required field';

  // Make 'field' in the message plural if multiple errors, translate resulting strings.
  const msg = errors.length > 1 ? __( `${singular}s`, 'gpalab-slo' ) : __( singular, 'gpalab-slo' );

  p.textContent = msg;

  errors.forEach( error => {
    const li = document.createElement( 'li' );
    const fields = error?.name?.split( '_' ) || [];
    const field = checkIfSettingsTitle( error.name ) ? __( 'Mission name', 'gpalab-slo' ) : fields[fields.length - 1];

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

