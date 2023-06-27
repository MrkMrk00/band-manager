import { createSignal } from 'solid-js';
import userCircleIcon from '../../icons/solid/circle-user.svg';
import barsIcon from '../../icons/solid/bars.svg';

const widthBreakpoint = 768;

function MobileNavbar() {
    let { display_name } = BandManager.User;
    if (display_name.includes(' ')) {
        display_name = display_name.split(' ')[0];
    }

    return (
        <nav class="flex flex-row justify-between w-full bm-navbar bm-mobile-nav">
            <button type="button" class="flex flex-row w-2/3 justify-end">
                <div class="flex flex-row justify-center w-1/2">
                    <img class="object-fill h-6" width="auto" src={barsIcon} alt="Otevřít menu" />
                </div>
            </button>
            <a href="/me" class="flex flex-row justify-end gap-2 w-1/3">
                <span>{display_name}</span>
                <img class="object-fill h-6" width="auto" src={userCircleIcon} alt={display_name} />
            </a>
        </nav>
    );
}

export default function Navbar() {
    const [isMobile, setIsMobile] = createSignal(window.innerWidth < widthBreakpoint);

    window.addEventListener('resize', () => setIsMobile(() => window.innerWidth < widthBreakpoint));

    return <>{isMobile() ? <MobileNavbar /> : <div>Nejsem mobilní</div>}</>;
}
