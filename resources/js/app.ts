import Swup from 'swup';

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

const swup = new Swup({
    containers: ['#page_content'],
});

declare global {
    interface Window {
        BandManager: BandManagerNamespace;
        Swup: typeof swup;
    }

    const BandManager: BandManagerNamespace;
}

window.Swup = swup;
