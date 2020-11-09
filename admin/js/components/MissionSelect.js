/** @jsx */

import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useSelect } from '@wordpress/data';

const MissionSelect = () => {
  const template = useSelect( select => select('core/editor').getEditedPostAttribute('template') );

  if ( template !== 'archive-gpalab-social-link.php' ) {
    return null;
  }

  return(
    <PluginDocumentSettingPanel
      className="gpalab-slo-mission-select"
      name="gpalab-slo-mission-select"
      title="Select a Mission"
    />
  );
};

export default MissionSelect;
