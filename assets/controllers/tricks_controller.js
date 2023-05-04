import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['listingHolder']

    static values = {
        page: {type: Number, default: 0},
        lastPage: Number,
        restUrl: String,
        showRoute: String,
        updateRoute: String,
        deleteRoute: String,
        coverPath: String,
        isUserLoggedIn: String
    }

    async load(e) {
        const initialContent = e.currentTarget.textContent.trim();
        e.currentTarget.textContent = "Chargement en cours...";

        this.pageValue++;

        const response = await fetch(this.restUrlValue + '?page=' + this.pageValue)
        const results = await response.json();

        results.data.forEach((item) => {
            this.createItem(item)
        });

        this.listingHolderTarget.querySelector('button[data-action="tricks#load"]').textContent = initialContent;

        if (results.page >= results.pages) {
            this.listingHolderTarget.querySelector('button[data-action="tricks#load"]').remove();
        }
    }

    createItem(item) {
        const showRoute = this.showRouteValue.replace('js_placeholder', item.slug);
        const updateRoute = this.updateRouteValue.replace('js_placeholder', item.slug);
        const deleteRoute = this.deleteRouteValue.replace('js_placeholder', item.slug);

        const element = document.createElement('div');
        element.classList.add('col-12', 'col-sm-6', 'col-md-4', 'col-lg-3', 'mb-3', 'item');
        element.innerHTML = `
            <div class="card">
                <a href="${showRoute}" class="text-reset text-decoration-none">
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
                </a>
            </div>
        `;

        const items = this.listingHolderTarget.querySelectorAll('.item');
        const lastItem = items[items.length - 1];

        lastItem.after(element);
    }
}
