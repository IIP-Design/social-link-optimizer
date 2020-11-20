/**
 * Send an Ajax request to add a new mission to the plugin settings.
 */
export const addSLOMission = async () => {
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
export const removeSLOMission = async e => {
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
