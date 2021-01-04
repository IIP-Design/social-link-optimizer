import { ready } from './utils/document-ready';
import {
  addRequiredTitleLabel,
  debounce,
  insertFormLiveRegion,
  setRequiredAttribute,
} from './utils/validation-utils';
import { handleFieldValidation } from './utils/handle-valid';
import { handleInvalidField } from './utils/handle-invalid';

/**
 * Add input and invalid event listeners to social link form.
 */
const initializeEventListeners = () => {
  const form = document.getElementById( 'post' );
  const debounceFieldValidation = debounce( handleFieldValidation, 500 );

  form.addEventListener( 'input', debounceFieldValidation );
  form.addEventListener( 'invalid', handleInvalidField, true );
};

ready( () => {
  insertFormLiveRegion();
  addRequiredTitleLabel();
  setRequiredAttribute( '[name="post_title"]' );
  initializeEventListeners();
} );
