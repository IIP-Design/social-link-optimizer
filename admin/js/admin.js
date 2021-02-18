import { getTabFromLocation, initializeTabs } from './utils/tab-nav';
import { eventListeners } from './utils/events-listeners';
import { insertDialogContainer } from './utils/remove-mission-dialog';

/**
 * Initialized the plugin's admin JS.
 */
const init = () => {
  // inserts the remove mission confirmation dialog.
  insertDialogContainer();

  // Initialize tabbed-container event listeners.
  eventListeners();

  const index = getTabFromLocation();

  // Opens the first tab.
  initializeTabs( index || 0 );
};

init();
