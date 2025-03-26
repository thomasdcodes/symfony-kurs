import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    async askForDeletion(event) {
        if (confirm('Soll dieser Veranstaltungsort wirklich gelöscht werden?')) {
            await fetch(event.params.deleteUrl);
        }
    }
}
