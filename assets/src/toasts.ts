const TOAST_WIDTH = 300;
const TOAST_DURATION = 3000;
const UPDATE_INTERVAL = 50;

function createToast(messageText: string) {
	const toast = document.createElement('div');
	toast.style.width = `${TOAST_WIDTH}px`;
	toast.classList.add('toast');

	const toastContent = document.createElement('div');
	toastContent.classList.add('toast__content');

	const message = document.createElement('p');
	message.classList.add('toast__message');
	message.innerText = messageText;
	toastContent.insertAdjacentElement('afterbegin', message);

	const closeIcon = document.createElement('button');
	closeIcon.classList.add('toast__close');
	closeIcon.innerHTML = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"/></svg>
	`;
	toastContent.insertAdjacentElement('afterbegin', closeIcon);

	const line = document.createElement('div');
	line.classList.add('toast__line');

	toast.insertAdjacentElement('afterbegin', toastContent);
	toast.insertAdjacentElement('beforeend', line);

	const lineInterval = setInterval(() => {
		line.style.width = `${line.offsetWidth - (TOAST_WIDTH / (TOAST_DURATION / UPDATE_INTERVAL))}px`;
		}, UPDATE_INTERVAL);

	function cleanup() {
		toast.remove();
		clearInterval(lineInterval);
	}

	closeIcon.addEventListener('click', cleanup);

	const removeToastTimeout = setTimeout(cleanup, TOAST_DURATION);

	function stopRemoveToast() {
		clearTimeout(removeToastTimeout);
		clearInterval(lineInterval);
		line.remove();
	}

	toast.addEventListener('click', stopRemoveToast);
	toast.addEventListener('mouseover', stopRemoveToast);

	document.body.insertAdjacentElement('beforeend', toast);

	return toast;
}

const Toast = {
	error: (messageText: string) => {
		const toast = createToast(messageText);
		toast.classList.add('toast--error');
	},
};

interface Window { Toast: typeof Toast };

window.Toast = Toast;

