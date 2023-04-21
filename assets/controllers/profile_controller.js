import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['image', 'input'];

    static values = {
        restUrl: String,
        deleteUrl: String,
        loginUrl: String,
        csrfToken: String
    };

    connect() {
        this.inputTarget.addEventListener('change', this.uploadAvatar.bind(this))
    }

    onImageClick(e) {
        e.preventDefault();
        this.inputTarget.click();
    }

    async onDeleteClick(e) {
        e.preventDefault();
        if (window.confirm("Souhaitez-vous vraiment supprimer votre compte ?")) {
            const formData = new FormData();
            formData.append('token', "ouistiti");

            await fetch(this.deleteUrlValue, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': this.csrfTokenValue}
            });

            window.location.href = this.loginUrlValue;
        }
    }

    async uploadAvatar(e) {
        const file = e.target.files[0];

        if (!file) {
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        const response = await fetch(this.restUrlValue, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': this.csrfTokenValue},
            body: formData
        })

        if (!response.ok) {
            return this.displayError((await response.json()).error)
        }

        if (document.getElementById('upload-error-alert')) {
            document.getElementById('upload-error-alert').remove();
        }

        this.imageTarget.src = URL.createObjectURL(file);
    }

    displayError(message) {
        if (!document.getElementById('upload-error-alert')) {
            const pErrorElt = document.createElement('p');
            pErrorElt.classList.add('text-danger');
            pErrorElt.id = 'upload-error-alert';
            pErrorElt.textContent = message;

            this.inputTarget.after(pErrorElt);
        } else {
            document.getElementById('upload-error-alert').textContent = message;
        }
    }
}
