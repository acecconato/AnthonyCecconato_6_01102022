import {Controller} from "stimulus";

export default class extends Controller {
    static targets = ["collectionContainer"]

    static values = {
        index: Number,
        prototype: String,
    }

    connect() {
        document
            .querySelectorAll('ul.videos li')
            .forEach((video) => {
                addTagFormDeleteLink(video)
            })
    }

    addCollectionElement(event) {
        const item = document.createElement('li');
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        this.collectionContainerTarget.appendChild(item);
        this.indexValue++;
    }
}

const addTagFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('button')
    removeFormButton.classList.add('btn', 'btn-danger', 'rounded-0')
    removeFormButton.setAttribute('title', 'Supprimer l\'élément')
    removeFormButton.innerHTML = '<i class="bi bi-trash"></i>'

    item.append(removeFormButton);

    removeFormButton.addEventListener('click', (e) => {
        e.preventDefault();
        item.remove();
    });
}
