import { addSLOMission, removeSLOMission, updateSLOPermalink } from './ajax';
import { mediaUploader } from './file-uploads';
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
    addSLOMission( tabBtns.length );
  } );

  // Add event listeners to the Remove This Mission buttons.
  const removeMissionBtns = document.querySelectorAll( '.slo-remove-mission' );

  removeMissionBtns.forEach( btn => {
    btn.addEventListener( 'click', e => {
      const { id } = e.target.dataset;

      // Find the currently selected tab and it's id.
      const selected = [...tabBtns].filter( tab => tab.attributes['aria-selected'] !== undefined );
      const index = selected[0].dataset.id;

      // If deleting first tab one new first tab, otherwise ope tab prior to that just deleted.
      const indexAfterRemoval = index > 0 ? index - 1 : 0;

      removeSLOMission( id, indexAfterRemoval );
    } );
  } );

  // Add event listeners to the Update Permalink buttons.
  const updatePermalinkBtns = document.querySelectorAll( '.slo-permalink' );

  updatePermalinkBtns.forEach( ( btn, idx ) => {
    btn.addEventListener( 'click', e => {
      const { id, post } = e.target.dataset;

      const input = document.getElementById( `permalink-${id}` );

      updateSLOPermalink( post, input.value, idx );
    } );
  } );

  // Add event listeners to the activate avatar media library uploader.
  const uploadAvatar = document.querySelectorAll( '.gpalab-slo-avatar-media-manager ' );

  uploadAvatar.forEach( btn => {
    btn.addEventListener( 'click', e => {
      const { id } = e.target.dataset;

      mediaUploader( e, id );
    } );
  } );
};
