import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['listingHolder']

    static values = {
        page: {type: Number, default: 0},
        lastPage: Number,
        restUrl: String,
        updateRoute: String,
        deleteRoute: String,
        coverPath: String
    }

    async load() {
        this.pageValue++;

        const response = await fetch(this.restUrlValue + '?page=' + this.pageValue)
        const results = await response.json();

        results.data.forEach((item) => {
            this.createItem(item)
        });

        if (results.page >= results.pages) {
            this.listingHolderTarget.querySelector('button[data-action="tricks#load"]').remove();
        }
    }

    createItem(item) {
        const updateRoute = this.updateRouteValue.replace('js_placeholder', item.slug);
        const deleteRoute = this.deleteRouteValue.replace('js_placeholder', item.slug);

        const element = document.createElement('div');
        element.classList.add('col-2', 'my-3', 'item');
        element.innerHTML = `
            <div class="card">
                <img src="${this.coverPathValue}/${item.coverWebPath}" class="card-img-top"
                     alt="Illustration de la figure « ${item.name} »">
                <div class="card-body">
                    <div class="card-title">${item.name}</div>
                    <p class="card-text">${item.description.slice(0, 30)}</p>

                    <a href="${updateRoute}" class="btn btn-primary" title="Modifier">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <a href="${deleteRoute}"
                       class="btn btn-danger btn-delete"
                       title="Supprimer"
                    >
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        `;

        const items = this.listingHolderTarget.querySelectorAll('.item');
        const lastItem = items[items.length - 1];

        lastItem.after(element);
    }
}
