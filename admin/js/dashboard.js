import { ready } from './utils/document-ready';
import { setPreferredMission } from './utils/ajax';

/**
 * Identifies the mission dropdown element, and returns it's value.
 *
 * @returns {string}   The value of the selected option.
 */
const getSelectedMission = () => {
  const select = document.getElementById( 'gpalab_slo_preferred_mission_field' );

  return select.value;
};

/**
 * Send an AJAX request to update the user's mission preference when the submit button is clicked.
 */
const initializeListeners = () => {
  // Get values provided to the client by the server
  const fromPHP = window?.gpalabSloDashboard || {};

  const submitBtn = document.getElementById( 'gpalab-slo-set-mission' );

  submitBtn.addEventListener( 'click', e => {
    e.preventDefault();

    const selected = getSelectedMission();

    if ( selected !== fromPHP.currentSelection ) {
      setPreferredMission( selected );
    }
  } );
};

/**
 * Set up the page event listeners once the page is loaded.
 */
ready( () => {
  initializeListeners();
} );
