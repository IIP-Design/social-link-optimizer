import { initializeTabs } from './utils/tab-nav';
import { eventListeners } from './utils/events-listeners';

const init = () => {
// Initialize tabbed-container event listeners.
  eventListeners();

  // Opens the first tab.
  initializeTabs( 0 );
};

init();
