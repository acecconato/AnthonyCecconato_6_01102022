import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['listingHolder', 'template']

    static values = {
        page: {type: Number, default: 0},
        restUrl: String
    }

    async load(page) {
        const response = await fetch(this.restUrlValue + '?page=' + this.pageValue)
        const datas = await response.json();

        console.log(datas)
    }
}
