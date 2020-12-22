import { getFormLiveRegion, updateLiveRegion } from './validation-utils';
import { getInvalidFields, getLiveRegionInvalidMessage } from './handle-invalid';

/**
 * Validate a required form field.
 * @param {object} e event object
 */
export const handleFieldValidation = e => {
  const { target } = e;

  // Field remains invalid if empty spaces are entered.
  if ( target.value.trim() === '' ) {
    return;
  }

  // Reset styling, custom tooltip, etc.
  target.removeAttribute( 'aria-invalid' );
  target.setCustomValidity( '' );
  target.checkValidity();

  const formLiveRegion = getFormLiveRegion();

  // Reset the live region content.
  updateLiveRegion( formLiveRegion, null );

  const errors = getInvalidFields();

  // Update the live region content if there are still errors.
  if ( errors?.length ) {
    const p = getLiveRegionInvalidMessage();

    updateLiveRegion( formLiveRegion, p, 'notice notice-error gpalab-slo' );
  }
};
