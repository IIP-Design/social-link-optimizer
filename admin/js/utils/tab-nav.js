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
 * @param {number} index  The index of the selected tab.
 */
export const initializeTabs = index => {
  const btns = document.querySelectorAll( '.gpalab-slo-tab-button' );
  const panels = document.querySelectorAll( '.gpalab-slo-tabpanel' );

  // Abort if no tab buttons or panels present.
  if ( !btns || !panels ) {
    return;
  }

  // Check to make sure that the provided index is within range of the tabs, if not open first tab
  const selected = index >= btns.length ? 0 : index;

  // Get all the tabs NOT selected.
  const remainingBtns = [...btns];

  remainingBtns.splice( selected, 1 );

  // Display the first tab button and panel.
  btns[selected].setAttribute( 'aria-selected', 'true' );
  panels[selected].style.display = 'flex';

  // Capture the focus on the current tab by removing the ability to tab across the remaining buttons
  remainingBtns.forEach( btn => {
    btn.setAttribute( 'tabindex', '-1' );
  } );
};

/**
 * Checks the current URL for a hash indicating which tab to open.
 *
 * @returns {number} The index of the tab to focus on.
 */
export const getTabFromLocation = () => {
  const { hash } = window.location;
  const re = /(gpalab-slo-tab-[0-9]*)/g;

  const tab = hash.match( re ) ? hash.match( re )[0] : null;

  return tab ? tab.replace( 'gpalab-slo-tab-', '' ) : 0;
};

/**
 * Adds a hash value to the URL and reloads the browser to navigate to selected tab.
 *
 * @param {number} id  The id of the tab in question.
 */
export const reloadInTab = id => {
  const { origin, pathname, search } = window.location;

  window.location.href = `${origin}${pathname}${search}#gpalab-slo-tab-${id}`;
  window.location.reload();
};
