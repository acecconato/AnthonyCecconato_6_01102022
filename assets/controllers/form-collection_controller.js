import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['collectionHolder'];

    static values = {
        imageIndex: Number,
        videoIndex: Number,
        imagePrototype: String,
        videoPrototype: String
    }

    newImage() {
        const item = document.createElement('div');
        item.classList.add('col-3', 'item', 'mb-3', 'd-flex', 'flex-column', 'justify-content-end');
        item.innerHTML += this.imagePrototypeValue.replace(/__name__/g, this.imageIndexValue);

        this.collectionHolderTarget.appendChild(item);
        this.imageIndexValue++;
    }

    newVideo(e) {
        let url = e.currentTarget.closest('.form-inline-group').querySelector('input').value

        if (!url.match(new RegExp(/^https:\/\//))) {
            return alert('Url invalide, celle-ci doit commencer par https://')
        }

        const item = document.createElement('div');
        item.classList.add('col-3', 'item', 'mb-3', 'd-flex', 'flex-column', 'justify-content-end');
        item.innerHTML += this.videoPrototypeValue.replace(/__name__/g, this.videoIndexValue);

        item.querySelector('input').value = url.trim();
        item.querySelector('iframe').src = url.replace('watch?v=', 'embed/');

        this.collectionHolderTarget.appendChild(item);
        this.videoIndexValue++;

        e.currentTarget.parentNode.remove();
    }

    toggleAddVideoPrompt() {
        const prompt = document.createElement('div');
        prompt.classList.add('form-inline-group', 'my-3', 'd-flex', 'align-items-center', 'w-50');

        const input = document.createElement('input');
        input.classList.add('form-control', 'form-control-sm', 'rounded-0');
        input.setAttribute('placeholder', 'Lien Youtube');

        const submitButton = document.createElement('button');
        submitButton.classList.add('btn', 'btn-sm', 'btn-primary', 'rounded-0');
        submitButton.type = 'button';
        submitButton.title = 'Ajouter'
        submitButton.innerHTML = '<i class="bi bi-upload"></i>';
        submitButton.addEventListener('click', this.newVideo.bind(this));

        const deleteButton = document.createElement('button');
        deleteButton.classList.add('btn', 'btn-sm', 'btn-danger', 'rounded-0');
        deleteButton.type = 'button';
        deleteButton.title = 'Annuler'
        deleteButton.innerHTML = '<i class="bi bi-x-circle"></i>';
        deleteButton.addEventListener('click', (e) => e.currentTarget.parentNode.remove());

        prompt.appendChild(input);
        prompt.appendChild(submitButton);
        prompt.appendChild(deleteButton);

        this.collectionHolderTarget.before(prompt);
    }

    removeItem(e) {
        e.currentTarget.closest('.item').remove();
    }
}
