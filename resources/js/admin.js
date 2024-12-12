import './plugins/apexcharts';
import './plugins/flatpickr';
import './plugins/quill';
import './plugins/tippy';
import './plugins/tiptap';

import.meta.glob([
    '../img/**',
    '../svg/**',
]);

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import focus from '@alpinejs/focus';
import mask from '@alpinejs/mask';
import persist from '@alpinejs/persist';
import Clipboard from '@ryangjchandler/alpine-clipboard';

window.Alpine = Alpine;
Alpine.plugin(intersect);
Alpine.plugin(focus);
Alpine.plugin(mask);
Alpine.plugin(persist);
Alpine.plugin(Clipboard);
Alpine.start();
