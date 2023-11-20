import { Controller } from '@hotwired/stimulus';
import { useDebounce } from 'stimulus-use';

export default class extends Controller {
    static debounces = ['filterChange', 'sortChange'];

    payload = {
        filter: {},
        sort: {},
    };

    connect() {
        useDebounce(this, { wait: 500 });
    }

    filterChange(event) {
        this.payload.filter = {
            ...this.payload.filter,
            [event.detail.filter]: event.detail.value,
        };
        console.log(event.detail.route, event.detail.filter);
        this.element.src = route(event.detail.route, this.payload);
        this.element.reload();
    }

    sortChange(event) {
        this.payload.sort = event.detail.value;

        this.element.src = route(event.detail.route, this.payload);
        this.element.reload();
    }

    clear() {
        this.payload = {
            filter: {},
            sort: {},
        };
    }
}
