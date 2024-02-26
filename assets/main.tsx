import 'vite/modulepreload-polyfill';
import 'htmx.org';
import './styles.css';
import { customElement } from './utils';
import { Toaster, toast } from 'solid-toast';

declare global {
    interface Window {
        Toast: typeof toast;
    }
}

customElement('bm-toaster', {}, () => <Toaster position="top-center" />);

window.Toast = toast;

document.body.addEventListener('htmx:afterRequest', function (ev_) {
    const ev = ev_ as CustomEvent<{ failed: boolean; successful: boolean; xhr: XMLHttpRequest }>;

    if (ev.detail.failed) {
        window.Toast.error(`Chyba ${ev.detail.xhr.status}: ${ev.detail.xhr.statusText}`);
    }
});
