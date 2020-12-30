/**
 * @deprecated
 */
import { registerPlugin } from '@wordpress/plugins';

import MissionPanel from './components/MissionPanel';

registerPlugin( 'gpalab-slo-mission-select', {
  icon: null,
  render: MissionPanel,
} );
