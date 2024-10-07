import './bootstrap';

// Added: Actual Bootstrap JavaScript dependency
import 'bootstrap';

// Added: Popper.js dependency for popover support in Bootstrap
import '@popperjs/core';

// Added: custom chart.js
// import './chart-custom';

import Alpine from 'alpinejs';
// import persist from '@alpinejs/persist';

window.Alpine = Alpine;

// Alpine.plugin(persist);

Alpine.start();
