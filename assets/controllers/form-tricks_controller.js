import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['cover'];

    updateCover(e) {
        const [file] = e.currentTarget.files;

        console.log(file)
        if (!this.isImage(file.name)) {
            return window.alert("Fichier invalide, veuillez insérer une image");
        }

        this.coverTargets.forEach((target) => target.src = URL.createObjectURL(file));
    }

    isImage(value) {
        return (value.match(/\.(jpeg|jpg|png|webp)$/) != null);
    }
}
