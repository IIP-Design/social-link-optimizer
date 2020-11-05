/**
 * Send an Ajax request to add a new mission to the plugin settings.
 */
const addSLOMission = async () => {
  // Get values provided to the client by the server
  const fromPHP = window?.gpalabSloAdmin || {};

  const formData = new FormData();

  formData.append( 'action', 'gpalab_add_slo_mission' );
  formData.append( 'security', fromPHP.sloNonce );

  try {
    const response = await fetch( fromPHP.ajaxUrl, {
      method: 'POST',
      body: formData,
    } );

    const result = await response.json();

    console.log( result );
    window.location.reload();
  } catch ( err ) {
    console.error( err );
  }
};

/**
 * Remove a mission from the settings page.
 *
 * @param {Event} e  A JavaScript event object.
 */
const removeSLOMission = async e => {
  const { id } = e.target.dataset;

  // Get values provided to the client by the server
  const fromPHP = window?.gpalabSloAdmin || {};

  const formData = new FormData();

  formData.append( 'action', 'gpalab_remove_slo_mission' );
  formData.append( 'security', fromPHP.sloNonce );
  formData.append( 'mission_id', id );

  try {
    const response = await fetch( fromPHP.ajaxUrl, {
      method: 'POST',
      body: formData,
    } );

    const result = await response.json();

    console.log( result );
    window.location.reload();
  } catch ( err ) {
    console.error( err );
  }
};

// Focus on the first tab.
const showFirstMission = () => {
  const btns = document.querySelectorAll( '.gpalab-slo-tab-button' );
  const panels = document.querySelectorAll( '.gpalab-slo-tabpanel' );

  if ( !btns || !panels ) {
    return;
  }

  btns[0].setAttribute( 'aria-selected', 'true' );
  panels[0].style.display = 'flex';
};

// Move between tabs.
const switchTab = e => {
  const { id } = e.target.dataset;

  const tabs = document.querySelectorAll( '.gpalab-slo-tab-button' );

  tabs.forEach( tab => {
    if ( tab.id === `gpalab-slo-tab-${id}` ) {
      tab.setAttribute( 'aria-selected', 'true' );
    } else {
      tab.removeAttribute( 'aria-selected' );
    }
  } );

  const panels = document.querySelectorAll( '.gpalab-slo-tabpanel' );

  panels.forEach( panel => {
    if ( panel.id === `gpalab-slo-settings-${id}` ) {
      panel.style.display = 'flex';
    } else {
      panel.style.display = 'none';
    }
  } );
};

const addMissionBtn = document.getElementById( 'slo-add-mission' );

addMissionBtn.addEventListener( 'click', () => {
  addSLOMission();
} );

const tabBtns = document.querySelectorAll( '.gpalab-slo-tab-button' );

tabBtns.forEach( btn => {
  btn.addEventListener( 'click', e => {
    switchTab( e );
  } );
} );

const removeMissionBtns = document.querySelectorAll( '.slo-remove-mission' );

removeMissionBtns.forEach( btn => {
  btn.addEventListener( 'click', e => {
    removeSLOMission( e );
  } );
} );

window.onload = showFirstMission;
