import {Controller} from "@hotwired/stimulus";
import slugify from 'slugify'

export default class extends Controller {
    autocomplete(e) {
        const currentValue = e.currentTarget.value;

        document.querySelectorAll('.slugInput').forEach((input) => {
            input.value = slugify(currentValue).toLowerCase();
        })
    }
}
