/**
 * Update the tabbed container display when a new tab is selected.
 *
 * @param {string} id  The id value of the selected tab.
 */
export const selectTab = id => {
  const tabs = document.querySelectorAll( '.gpalab-slo-tab-button' );

  // Update the display of the tab buttons.
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

  // Hide all but the selected tab panel.
  panels.forEach( panel => {
    if ( panel.id === `gpalab-slo-settings-${id}` ) {
      panel.style.display = 'flex';
    } else {
      panel.style.display = 'none';
    }
  } );
};

/**
 * Navigate between tabs by index (used in keyboard nav).
 *
 * @param {int} index Index of the tab which should be showing.
 */
export const switchTab = index => {
  const btns = document.querySelectorAll( '.gpalab-slo-tab-button' );

  if ( index !== null ) {
    switch ( index ) {
      // If on first tab wrap around to the last tab.
      case -1:
        selectTab( btns[btns.length - 1].dataset.id );
        break;
      // If on the last tab wrap around to the first tab.
      case btns.length:
        selectTab( btns[0].dataset.id );
        break;
      default:
        selectTab( btns[index].dataset.id );
    }
  }
};

/**
 * Open on the initial tab.
 *
 * @param {int} index  The index of the selected tab.
 */
export const initializeTabs = index => {
  const btns = document.querySelectorAll( '.gpalab-slo-tab-button' );
  const panels = document.querySelectorAll( '.gpalab-slo-tabpanel' );

  if ( !btns || !panels ) {
    return;
  }

  const remainingBtns = [...btns];

  remainingBtns.splice( index, 1 );

  // Display the first tab button and panel.
  btns[index].setAttribute( 'aria-selected', 'true' );
  panels[index].style.display = 'flex';

  // Capture the focus on the current tab by removing the ability to tab across buttons
  remainingBtns.forEach( btn => {
    btn.setAttribute( 'tabindex', '-1' );
  } );
};
