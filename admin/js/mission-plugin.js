import { registerPlugin } from '@wordpress/plugins';

import MissionSelect from './components/MissionSelect';

registerPlugin( 'gpalab-slo-mission-select', {
  icon: null,
  render: MissionSelect,
} );
