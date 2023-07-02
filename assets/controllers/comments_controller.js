import {Controller} from "@hotwired/stimulus";
import * as lodash from 'lodash';
import * as moment from 'moment';

moment.locale('fr');

export default class extends Controller {
    static targets = ['template', 'listing', 'spinner', 'loadMore'];

    static values = {
        url: String
    }

    async connect() {
        this.template = lodash.template(this.templateTarget.innerHTML);
        this.page = 0;
        await this.renderComments();
        this.toggleSpinner(false);
    }

    async renderComments(page = 0) {
        this.toggleSpinner(true);
        const comments = await this.getComments(page);

        if (comments.total_items <= 0) {
            this.listingTarget.innerHTML = `
                <p class="col-10 mx-auto alert alert-info">Il n y a pas encore de commentaires... Soyez le premier !</p>
            `;
        }

        comments.data.forEach((comment, i) => {
            comment.createdAt = moment(comment.createdAt).startOf('minutes').fromNow();
            comment.avatar = (comment.user.avatar) ? '/uploads/avatar/' + comment.user.avatar : 'https://via.placeholder.com/150';

            const newItem = document.createElement('div');
            newItem.classList.add(`comment-${i}`);
            newItem.innerHTML = this.template(comment);

            this.listingTarget.append(newItem);
            this.indexValue++;
        });

        this.toggleSpinner(false);

        if (comments.page + 1 >= comments.pages) {
            return this.loadMoreTarget.remove();
        }

        this.loadMoreTarget.classList.remove('d-none');
    }

    renderError(message) {
        this.listingTarget.innerHTML = `<p class="col-10 mx-auto alert alert-danger">${message}</p>`
    }

    async getComments(page = 0) {
        const response = await fetch(this.urlValue + '?page=' + page);

        if (!response.ok) {
            return this.renderError('Impossible de charger les commentaires');
        }

        return await response.json();
    }

    async loadMore() {
        await this.renderComments(++this.page);
    }

    toggleSpinner(status = true) {
        if (status) {
            return this.spinnerTarget.classList.remove('d-none');
        }

        return this.spinnerTarget.classList.add('d-none');
    }
}
