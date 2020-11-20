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

// Move between tabs.
const selectTab = id => {
  const tabs = document.querySelectorAll( '.gpalab-slo-tab-button' );

  tabs.forEach( tab => {
    if ( tab.id === `gpalab-slo-tab-${id}` ) {
      tab.focus();
      tab.setAttribute( 'aria-selected', 'true' );
      tab.removeAttribute( 'tabindex' );
    } else {
      tab.removeAttribute( 'aria-selected' );
      tab.setAttribute( 'tabindex', '-1' );
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

const switchTab = index => {
  const btns = document.querySelectorAll( '.gpalab-slo-tab-button' );

  if ( index !== null ) {
    switch ( index ) {
      case -1:
        selectTab( btns[btns.length - 1].dataset.id );
        break;
      case btns.length:
        selectTab( btns[0].dataset.id );
        break;
      default:
        selectTab( btns[index].dataset.id );
    }
  }
};

// Focus on the first tab.
const showFirstMission = () => {
  const btns = document.querySelectorAll( '.gpalab-slo-tab-button' );
  const panels = document.querySelectorAll( '.gpalab-slo-tabpanel' );

  if ( !btns || !panels ) {
    return;
  }

  const remainingBtns = [...btns];

  remainingBtns.shift();

  btns[0].setAttribute( 'aria-selected', 'true' );
  remainingBtns.forEach( btn => {
    btn.setAttribute( 'tabindex', '-1' );
  } );
  panels[0].style.display = 'flex';

  btns.forEach( ( btn, idx ) => {
    btn.addEventListener( 'keydown', e => {
      switch ( e.which ) {
        case 37:
          switchTab( idx - 1 );
          break;
        case 39:
          switchTab( idx + 1 );
          break;
        case 40:
          e.preventDefault();
          document.getElementById( `title_${idx}` ).focus();
          break;
        default:
          return null;
      }
    } );
  } );
};


const addMissionBtn = document.getElementById( 'slo-add-mission' );

addMissionBtn.addEventListener( 'click', () => {
  addSLOMission();
} );

const tabBtns = document.querySelectorAll( '.gpalab-slo-tab-button' );

tabBtns.forEach( btn => {
  btn.addEventListener( 'click', e => {
    const { id } = e.target.dataset;

    selectTab( id );
  } );
} );

const removeMissionBtns = document.querySelectorAll( '.slo-remove-mission' );

removeMissionBtns.forEach( btn => {
  btn.addEventListener( 'click', e => {
    removeSLOMission( e );
  } );
} );


window.onload = showFirstMission;
