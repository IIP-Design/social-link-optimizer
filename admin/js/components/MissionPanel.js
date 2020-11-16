/** @jsx */

import { __ } from '@wordpress/i18n';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { useSelect } from '@wordpress/data';

import MissionSelect from './MissionSelect';

const MissionPanel = () => {
  const { missions } = window.gpalabSloPlugin;
  const normalizedMissions = missions.map( mission => ( { value: mission.id, label: mission.title } ) );

  const template = useSelect( select => select( 'core/editor' ).getEditedPostAttribute( 'template' ) );

  if ( template !== 'archive-gpalab-social-link.php' ) {
    return null;
  }

  return (
    <PluginDocumentSettingPanel
      className="gpalab-slo-mission-select"
      name="gpalab-slo-mission-select"
      title={ __( 'Connect a Mission', 'gpalab-slo' ) }
    >
      <MissionSelect
        label={ __( 'Select from Available Missions:', 'gpalab-slo' ) }
        metaKey="_gpalab_slo_mission_select"
        missions={ normalizedMissions }
      />
    </PluginDocumentSettingPanel>
  );
};

export default MissionPanel;
