import {Controller} from 'stimulus';
import {Toast} from "bootstrap";

export default class FlashMessagesController extends Controller {
    connect() {
        const toastElList = [].slice.call(document.querySelectorAll('.toast'))
        toastElList.map(function (toastEl) {
            return new Toast(toastEl, {delay: 3000}).show();
        })
    }
}
