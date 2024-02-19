import 'vite/modulepreload-polyfill'
import 'htmx.org';
import './styles.css';
import './toasts';

document.body.addEventListener('htmx:afterRequest', function (ev_) {
	const ev = ev_ as CustomEvent<{ failed: boolean; successful: boolean; xhr: XMLHttpRequest }>;

	if (ev.detail.failed) {
		window.Toast.error(`Chyba ${ev.detail.xhr.status}: ${ev.detail.xhr.statusText}`);
	}
});

