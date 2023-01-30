import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['collectionHolder'];

    static values = {
        index: Number,
        prototype: String
    }

    newItem() {
        console.log('hit');
        const item = document.createElement('div');
        item.classList.add('col-4', 'item');
        item.innerHTML += this.prototypeValue.replace(/__name__/g, this.indexValue);

        this.collectionHolderTarget.appendChild(item);
        this.indexValue++;
    }

    removeItem(e) {
       e.currentTarget.closest('.item').remove();
       this.indexValue--;
    }
}
