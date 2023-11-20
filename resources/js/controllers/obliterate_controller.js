import { Controller } from '@hotwired/stimulus';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.css';

// Connects to data-controller="obliterate"
export default class extends Controller {
    static targets = ['form'];

    static values = {
        url: String,
        trash: Boolean,
    };

    handle() {
        Swal.fire({
            title: 'Are you sure?',
            text:
                this.trashValue === true
                    ? 'This item will be sent to your trash. It will be permanently deleted after 30 days'
                    : "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd3333',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete!',
        }).then((result) => {
            if (result.isConfirmed) {
                this.formTarget.requestSubmit();
            }
        });
    }
}
