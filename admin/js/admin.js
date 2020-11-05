const addSLOMissionBtn = async () => {
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
  } catch ( err ) {
    console.error( err );
  }
};

const showFirstMission = () => {
  const btn = document.getElementById( 'gpalab-slo-tab-0' );
  const panel = document.getElementById( 'gpalab-slo-settings-0' );

  btn.setAttribute( 'aria-selected', 'true' );
  panel.style.display = 'flex';
};

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

const tabBtns = document.querySelectorAll( '.gpalab-slo-tab-button' );

tabBtns.forEach( btn => {
  btn.addEventListener( 'click', e => {
    switchTab( e );
  } );
} );

const addMissionBtn = document.getElementById( 'slo-add-mission' );

addMissionBtn.addEventListener( 'click', () => {
  addSLOMissionBtn();
} );

window.onload = showFirstMission;
