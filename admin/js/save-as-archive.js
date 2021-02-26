import { __ } from '@wordpress/i18n';

import { ready } from './utils/document-ready';

/**
 * Set the save post button text for social links with
 * archive status on the edit/add new social link page.
 */
const setSaveAsArchive = () => {
  const saveBtn = document.getElementById( 'save-post' );
  const status = document.getElementById( 'post_status' ).value || 'draft';

  if ( saveBtn && status === 'archived' ) {
    saveBtn.value = __( 'Save as Archived', 'gpalab-slo' );
  }
};

const appendArchivedSelectOption = () => {
  const select = document.getElementById( 'post_status' );
  const option = document.createElement( 'option' );

  option.setAttribute( 'value', 'archived' );
  option.textContent = __( 'Archived', 'gpalab-slo' );
  select.appendChild( option );
};

/**
 * Add click listeners to handle the 'OK' and 'Cancel'
 * buttons for status and timestamp changes since WordPress
 * sets the #save-post button text when either of these
 * buttons is clicked. the edit/add new social link page.
 */
const initializeEventListener = () => {
  const miscPublishActions = document.getElementById( 'misc-publishing-actions' );

  miscPublishActions.addEventListener( 'click', e => {
    e.preventDefault();
    const { innerText: btnTxt } = e.target;

    if ( btnTxt === 'OK' || btnTxt === 'Cancel' ) {
      setSaveAsArchive();
    }
  } );
};

ready( () => {
  appendArchivedSelectOption();
  initializeEventListener();
} );
