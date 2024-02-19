import { createEffect, createSignal, onCleanup, onMount } from 'solid-js';
import { customElement } from './utils';
import clsx from 'clsx';

const TOAST_WIDTH = 300;
const TOAST_DURATION = 5000;
const UPDATE_INTERVAL = 50;
const EVENT_DISPLAY_TOAST = 'bm:new-toast';

type Toast = {
    type: 'error';
    message: string;
};

customElement('bm-toaster', { event: EVENT_DISPLAY_TOAST }, function (props, { element }) {
    const [messages, setMessages] = createSignal<Toast[]>([]);
    const [lineWidths, setLineWidths] = createSignal<Record<string, number>>({});
    let interval: number;

    function handleAddMessage(ev: CustomEvent<Toast>) {
        setMessages(prev => [...prev, ev.detail]);
        setLineWidths(prev => ({ ...prev, [ev.detail.message]: TOAST_WIDTH }));
    }

    function removeToast(message: string, toast?: HTMLElement) {
        if (toast) {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.remove();
            }, 300);
            return;
        }

        setMessages(prev => prev.filter(m => m.message !== message));
        setLineWidths(prev => {
            const copy = { ...prev };
            delete copy[message];
            return copy;
        });
    }

    createEffect(() => {
        messages();
        interval = setInterval(() => {
            for (const message in lineWidths()) {
                const newWidth = Math.max(
                    lineWidths()[message] - TOAST_WIDTH / (TOAST_DURATION / UPDATE_INTERVAL),
                    0,
                );

                if (newWidth === 0) {
                    setMessages(prev => prev.filter(m => m.message !== message));
                    setLineWidths(prev => {
                        const copy = { ...prev };
                        delete copy[message];
                        return copy;
                    });

                    return;
                }

                setLineWidths(prev => ({ ...prev, [message]: newWidth }));
            }
        }, UPDATE_INTERVAL);

        onCleanup(() => {
            clearInterval(interval);
        });
    });

    onMount(() => {
        element.addEventListener(props.event, handleAddMessage);
    });

    onCleanup(() => {
        element.removeEventListener(props.event, handleAddMessage);
    });

    return (
        <>
            {messages().map(({ message, type }) => (
                <div
                    style={{ width: '300px', left: 'calc(50% - 150px)' }}
                    class={clsx(
                        'absolute bottom-2 overflow-x-hidden break-words rounded-2xl border shadow',
                        type === 'error' && 'border-red-500 bg-red-100 text-red-500',
                    )}
                    onMouseOver={() => {
                        clearInterval(interval);
                        setLineWidths(prev => ({ ...prev, [message]: TOAST_WIDTH }));
                    }}
                >
                    <div class="flex flex-row items-center">
                        <button
                            class="block h-full w-full max-w-[64px] fill-red-500 p-4"
                            type="button"
                            onClick={() => removeToast(message)}
                        >
                            {/* Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.*/}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM175 175c-9.4 9.4-9.4 24.6 0 33.9l47 47-47 47c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l47-47 47 47c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-47-47 47-47c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-47 47-47-47c-9.4-9.4-24.6-9.4-33.9 0z"></path>
                            </svg>
                        </button>
                        <p>{message}</p>
                    </div>
                    <div
                        class="h-[4px] bg-red-500 transition-all"
                        style={{ width: `${lineWidths()[message] ?? 300}px` }}
                    ></div>
                </div>
            ))}
        </>
    );
});

const Toast = {
    error: (messageText: string) => {
        const event = new CustomEvent<Toast>(EVENT_DISPLAY_TOAST, {
            detail: {
                type: 'error',
                message: messageText,
            },
        });

        const toaster = document.querySelector('bm-toaster');
        if (!toaster) {
            throw new Error('Toaster not mounted.');
        }

        toaster.dispatchEvent(event);
    },
};

declare global {
    interface Window {
        Toast: typeof Toast;
    }
}

window.Toast = Toast;
