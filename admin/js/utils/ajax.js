import { reloadInTab } from './tab-nav';

/**
 * Send an Ajax request to add a new mission to the plugin settings.
 *
 * @param {string} length  Length of the old array which is equal to the index of the new item.
 */
export const addSLOMission = async length => {
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

    reloadInTab( length );
  } catch ( err ) {
    console.error( err );
  }
};

/**
 * Remove a mission from the settings page.
 *
 * @param {string} id     The id of the mission to delete.
 * @param {number} index  The index of the tab that should show after reload.
 */
export const removeSLOMission = async ( id, index ) => {
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

    reloadInTab( index );
  } catch ( err ) {
    console.error( err );
  }
};

/**
 * Update the post_name (i.e. permalink) of a given WordPress post.
 *
 * @param {string} postId     The id of a WordPress SLO page.
 * @param {string} permalink  The new permalink value to be saved.
 * @param {string} index      The index of the current tab.
 */
export const updateSLOPermalink = async ( postId, permalink, index ) => {
  // Get values provided to the client by the server
  const fromPHP = window?.gpalabSloAdmin || {};

  const formData = new FormData();

  formData.append( 'action', 'gpalab_update_slo_permalink' );
  formData.append( 'security', fromPHP.sloNonce );
  formData.append( 'permalink', permalink );
  formData.append( 'post_id', postId );

  try {
    const response = await fetch( fromPHP.ajaxUrl, {
      method: 'POST',
      body: formData,
    } );

    const result = await response.json();

    console.log( result );
    reloadInTab( index );
  } catch ( err ) {
    console.error( err );
  }
};
