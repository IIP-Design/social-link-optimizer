import { __ } from '@wordpress/i18n';

/**
 * Create a dialog button.
 * @param {string} action Type of button action: cancel or confirm.
 */
const createActionButton = action => {
  const btn = document.createElement( 'button' );
  let idValue = 'remove-affirmative';
  let wpBtnType = 'primary';
  let btnContent = 'Yes, delete';

  if ( action === 'cancel' ) {
    idValue = 'remove-cancel';
    wpBtnType = 'secondary';
    btnContent = 'No, cancel';

    btn.setAttribute( 'data-a11y-dialog-hide', '' );
  }

  btn.setAttribute( 'type', 'button' );
  btn.setAttribute( 'id', idValue );
  btn.setAttribute( 'class', `button button-${wpBtnType}` );
  btn.textContent = __( btnContent, 'gpalab-slo' );

  return btn;
};

/**
 * Create the container for the dialog action buttons.
 */
const createActionsContainer = () => {
  const actionsContainer = document.createElement( 'div' );
  const cancelBtn = createActionButton( 'cancel' );
  const confirmBtn = createActionButton( 'confirm' );

  actionsContainer.setAttribute( 'class', 'gpalab-slo-dialog-actions' );
  actionsContainer.appendChild( cancelBtn );
  actionsContainer.appendChild( confirmBtn );

  return actionsContainer;
};

/**
 * Create the dialog heading.
 */
const createDialogTitle = () => {
  const dialogTitle = document.createElement( 'h1' );

  dialogTitle.setAttribute( 'id', 'gpalab-slo-dialog-title' );

  return dialogTitle;
};

/**
 * Create the dialog document.
 */
const createDialogDocument = () => {
  const dialogDocument = document.createElement( 'div' );
  const dialogTitle = createDialogTitle();
  const actionsContainer = createActionsContainer();

  dialogDocument.setAttribute( 'role', 'document' );
  dialogDocument.appendChild( dialogTitle );
  dialogDocument.appendChild( actionsContainer );

  return dialogDocument;
};

/**
 * Create the dialog element.
 */
const createDialog = () => {
  const dialog = document.createElement( 'div' );
  const dialogDocument = createDialogDocument();

  dialog.setAttribute( 'role', 'dialog' );
  dialog.setAttribute( 'aria-labelledby', 'gpalab-slo-dialog-title' );
  dialog.appendChild( dialogDocument );

  return dialog;
};

/**
 * Create the dialog background.
 */
const createOverlay = () => {
  const overlay = document.createElement( 'div' );

  overlay.setAttribute( 'class', 'gpalab-slo-dialog-overlay' );
  overlay.setAttribute( 'tabindex', '-1' );
  overlay.setAttribute( 'data-a11y-dialog-hide', '' );

  return overlay;
};

/**
 * Create the dialog container.
 */
const createDialogContainer = () => {
  const container = document.createElement( 'div' );
  const overlay = createOverlay();
  const dialog = createDialog();

  container.setAttribute( 'id', 'gpalab-slo-removal-confirmation-dialog' );
  container.setAttribute( 'class', 'gpalab-slo-dialog-container' );
  container.setAttribute( 'aria-hidden', 'true' );
  container.appendChild( overlay );
  container.appendChild( dialog );

  return container;
};

/**
 * Insert the dialog container as a sibling to the main content wrapper.
 */
export const insertDialogContainer = () => {
  const wpWrap = document.getElementById( 'wpwrap' );
  const dialogContainer = createDialogContainer();

  wpWrap.insertAdjacentElement( 'afterend', dialogContainer );
};
