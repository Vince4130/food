import './bootstrap';

// Added: Actual Bootstrap JavaScript dependency
import 'bootstrap';

// Added: Popper.js dependency for popover support in Bootstrap
import '@popperjs/core';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
