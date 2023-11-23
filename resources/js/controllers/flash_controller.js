import { Controller } from '@hotwired/stimulus';
import iziToast from 'izitoast';
import 'izitoast/dist/css/iziToast.min.css';

// Connects to data-controller="flash"
export default class extends Controller {
    static values = {
        success: String,
        error: String,
    };

    connect() {
        if (this.successValue) {
            iziToast.success({
                title: 'Success',
                message: this.successValue,
                position: 'topRight',
            });
        }

        if (this.errorValue) {
            iziToast.error({
                title: 'Error',
                message: this.errorValue,
                position: 'topRight',
            });
        }
    }
}
