/** @jsx */

import { __ } from '@wordpress/i18n';
import { compose } from '@wordpress/compose';
import { SelectControl } from '@wordpress/components';
import { withSelect, withDispatch } from '@wordpress/data';

const MissionSelect = compose(
  withDispatch( ( dispatch, { metaKey } ) => ( {
    setMissionValue( val ) {
      dispatch( 'core/editor' ).editPost(
        { meta: { [metaKey]: val } },
      );
    },
  } ) ),
  withSelect( ( select, { label, metaKey, missions } ) => {
    const noSelection = [{ value: '', label: __( 'All Posts', 'gpalab-slo' ) }];
    const options = [...noSelection, ...missions];

    return {
      label,
      options,
      selected: select( 'core/editor' ).getEditedPostAttribute( 'meta' )[metaKey],
    };
  } ),
)( ( { label, options, selected, setMissionValue } ) => (
  <SelectControl
    label={ label }
    options={ options }
    value={ selected }
    onBlur={ e => setMissionValue( e.target.value ) }
    onChange={ setMissionValue }
  />
) );

export default MissionSelect;
