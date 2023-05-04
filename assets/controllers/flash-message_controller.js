import {Controller} from "@hotwired/stimulus";
import Swal from "sweetalert2";

export default class extends Controller {
    fireAlert({params: {type, message}}) {
        Swal.fire({
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: true,
            timer: 8000
        })
    }
}
