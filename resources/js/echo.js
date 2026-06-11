import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1'}.pusher.com`,
    wsPort: 80,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
});
