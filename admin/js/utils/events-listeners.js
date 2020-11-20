import { addSLOMission, removeSLOMission } from './ajax';
import { selectTab, switchTab } from './tab-nav';

/**
 * Adds event listeners required to run the settings page tabbed container.
 */
export const eventListeners = () => {
  // Add event listeners to tab navigation buttons.
  const tabBtns = document.querySelectorAll( '.gpalab-slo-tab-button' );

  // Handle clicking on tab.
  tabBtns.forEach( btn => {
    btn.addEventListener( 'click', e => {
      const { id } = e.target.dataset;

      selectTab( id );
    } );
  } );

  // Handle keyboard navigation.
  tabBtns.forEach( ( btn, idx ) => {
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

  // Add event listener to the Add Mission button.
  const addMissionBtn = document.getElementById( 'slo-add-mission' );

  addMissionBtn.addEventListener( 'click', () => {
    addSLOMission();
  } );

  // Add event listeners to the Remove This Mission buttons.
  const removeMissionBtns = document.querySelectorAll( '.slo-remove-mission' );

  removeMissionBtns.forEach( btn => {
    btn.addEventListener( 'click', e => {
      removeSLOMission( e );
    } );
  } );
};
