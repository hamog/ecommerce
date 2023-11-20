import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['quantity', 'checkbox']

    state = true

    toggle(e) {
        this.state = !this.state

        if (this.state) {
            this.quantityTarget.classList.remove('d-none')
            this.checkboxTarget.classList.remove('d-none')
        } else {
            this.quantityTarget.classList.add('d-none')
            this.checkboxTarget.classList.add('d-none')
        }
    }
}
