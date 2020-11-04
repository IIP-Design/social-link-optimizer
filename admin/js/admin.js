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

const addMissionBtn = document.getElementById( 'slo-add-mission' );

addMissionBtn.addEventListener( 'click', () => {
  addSLOMissionBtn();
} );
