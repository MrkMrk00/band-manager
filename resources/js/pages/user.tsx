import '../../css/pages/user.css';
import customElement from '../custom-elements';

customElement('bm-user-form', function () {
    const { display_name, fb_id } = BandManager.User;

    function handleFormSubmit(e: SubmitEvent) {
        e.preventDefault();
        const fd = new FormData(e.target as HTMLFormElement);
        debugger;

        console.log(fd);
    }

    return (
        <>
            <form class="flex flex-col gap-2" onsubmit={handleFormSubmit}>
                <div class="bm-form-row">
                    <label for="display-name-input">Přezdívka</label>
                    <input name="display_name" id="display-name-input" value={display_name} />
                </div>

                <div class="bm-form-row">
                    <button class="btn bg-green-400" type="submit">
                        Uložit
                    </button>
                </div>
            </form>
        </>
    );
});
