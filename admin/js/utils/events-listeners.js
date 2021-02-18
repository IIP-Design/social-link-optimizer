import { __ } from '@wordpress/i18n';
import A11yDialog from 'a11y-dialog';

import { addSLOMission, removeSLOMission, updateSLOPermalink } from './ajax';
import { mediaUploader, removeMedia } from './file-uploads';
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
      e.preventDefault();
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
  const confirmRemovalDialog = document.getElementById( 'gpalab-slo-removal-confirmation-dialog' );
  const dialogTitle = document.getElementById( 'gpalab-slo-dialog-title' );

  removeMissionBtns.forEach( btn => {
    btn.addEventListener( 'click', e => {
      const { id } = e.target.dataset;

      // Find the currently selected tab and it's id.
      const selected = [...tabBtns].filter( tab => tab.attributes['aria-selected'] !== undefined );
      const index = selected[0].dataset.id;

      // If deleting first tab one new first tab, otherwise open tab prior to that just deleted.
      const indexAfterRemoval = index > 0 ? index - 1 : 0;
      const msg = `Are you sure you want to delete the ${selected[0].innerText} page?`;

      dialogTitle.textContent = __( msg, 'gpalab-slo');
      confirmRemovalDialog.dataset.id = id;
      confirmRemovalDialog.dataset.idxafter = indexAfterRemoval;
    } );
  } );

  // Add event listener to the remove mission confirmation dialog button.
  const dialog = new A11yDialog( confirmRemovalDialog, '#wpwrap' );
  const confirmBtn = document.getElementById( 'remove-affirmative' );

  confirmBtn.addEventListener( 'click', () => {
    const { id, idxafter: indexAfterRemoval } = confirmRemovalDialog.dataset;

    removeSLOMission( id, indexAfterRemoval );
    dialog.hide();
  } );

  // Prevent content beneath dialog from scrolling when dialog is open.
  dialog.on( 'show', () => {
    document.documentElement.style.overflow = 'hidden';
  } );

  // Restore content scrolling when dialog is closed.
  dialog.on( 'hide', () => {
    document.documentElement.removeAttribute( 'style' );
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

  // Add event listeners to activate avatar media library uploader buttons.
  const uploadAvatar = document.querySelectorAll( '.gpalab-slo-avatar-media-manager' );

  uploadAvatar.forEach( btn => {
    btn.addEventListener( 'click', e => {
      const { id } = e.target.dataset;

      mediaUploader( e, id );
    } );
  } );

  // Add event listeners to the buttons used to remove a selected avatar image.
  const removeAvatar = document.querySelectorAll( '.gpalab-slo-avatar-remove' );

  removeAvatar.forEach( btn => {
    btn.addEventListener( 'click', e => {
      const { id } = e.target.dataset;

      removeMedia( id );
    } );
  } );
};
