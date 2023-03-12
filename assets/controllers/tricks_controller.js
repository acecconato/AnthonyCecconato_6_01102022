import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['listingHolder']

    static values = {
        page: {type: Number, default: 0},
        lastPage: Number,
        restUrl: String,
        updateRoute: String,
        deleteRoute: String,
        coverPath: String,
        isUserLoggedIn: String
    }

<<<<<<< HEAD
    async load(e) {
        const initialContent = e.currentTarget.textContent.trim();
        e.currentTarget.textContent = "Chargement en cours...";

        this.pageValue++;

=======
    async load() {
        this.pageValue++;

>>>>>>> 7b6d570 (Add listing + load more button)
        const response = await fetch(this.restUrlValue + '?page=' + this.pageValue)
        const results = await response.json();

        results.data.forEach((item) => {
            this.createItem(item)
        });

<<<<<<< HEAD
        this.listingHolderTarget.querySelector('button[data-action="tricks#load"]').textContent = initialContent;

=======
>>>>>>> 7b6d570 (Add listing + load more button)
        if (results.page >= results.pages) {
            this.listingHolderTarget.querySelector('button[data-action="tricks#load"]').remove();
        }
    }

    connect() {
        console.log((this.isUserLoggedInValue !== ''))
    }

    createItem(item) {
        const updateRoute = this.updateRouteValue.replace('js_placeholder', item.slug);
        const deleteRoute = this.deleteRouteValue.replace('js_placeholder', item.slug);

        const element = document.createElement('div');
        element.classList.add('col-12', 'col-sm-6', 'col-md-4', 'col-lg-3', 'mb-3', 'item');
        element.innerHTML = `
            <div class="card">
                <img src="${this.coverPathValue}/${item.coverWebPath}" class="card-img-top"
                     alt="Illustration de la figure « ${item.name} »">
                <div class="card-body">
                    <div class="card-title">${item.name}</div>
                    <p class="card-text">${item.description.slice(0, 30)}</p>

                    ${(this.isUserLoggedInValue !== '') ? `
                        <a href="${updateRoute}" class="btn btn-primary" title="Modifier">
                            <i class="bi bi-pencil"></i>
                        </a>
                            
                        <a href="${deleteRoute}"
                           class="btn btn-danger btn-delete"
                           title="Supprimer"
                        >
                            <i class="bi bi-trash"></i>
                        </a>
                    ` : ''}
                </div>
            </div>
        `;

        const items = this.listingHolderTarget.querySelectorAll('.item');
        const lastItem = items[items.length - 1];

        lastItem.after(element);
    }
}
