import './custom-elements';
import Swup from 'swup';
import customElement from './custom-elements';
import Navbar from './components/Navbar';

interface IUser {
    id: number;
    display_name: string;
    email: string | null;
    fb_id: string | null;
    created_at: string;
    updated_at: string;
}

type BandManagerNamespace = {
    User: IUser;
};

declare global {
    interface Window {
        BandManager: BandManagerNamespace;
    }

    const BandManager: BandManagerNamespace;
}

new Swup({
    containers: ['#page_content'],
});

customElement('bm-navigation', Navbar);
