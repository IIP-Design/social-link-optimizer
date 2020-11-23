import { getTabFromLocation, initializeTabs } from './utils/tab-nav';
import { eventListeners } from './utils/events-listeners';

/**
 * Initialized the plugin's admin JS.
 */
const init = () => {
  // Initialize tabbed-container event listeners.
  eventListeners();

  const index = getTabFromLocation();

  // Opens the first tab.
  initializeTabs( index || 0 );
};

init();
