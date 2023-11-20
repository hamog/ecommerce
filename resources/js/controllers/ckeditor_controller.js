import { Controller } from '@hotwired/stimulus';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

// Connects to data-controller="ckeditor"
export default class extends Controller {
    connect() {
        ClassicEditor.create(this.element).catch((error) => {
            console.error(error);
        });
    }
}
