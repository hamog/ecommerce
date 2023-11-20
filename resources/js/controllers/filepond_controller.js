import { Controller } from '@hotwired/stimulus';
import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginImageValidateSize from 'filepond-plugin-image-validate-size';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageExifOrientation,
    FilePondPluginImageValidateSize,
    FilePondPluginFileValidateType
);

// Connects to data-controller="filepond"
export default class extends Controller {
    static targets = ['input', 'template', 'upload'];

    static values = {
        process: String,
        restore: String,
        revert: String,
        current: Array,
    };

    connect() {
        const pond = FilePond.create(this.inputTarget, {
            name: 'image',
            credits: false,
            acceptedFileTypes: ['image/png', 'image/jpeg'],
        });

        let token = document.head.querySelector('meta[name="csrf-token"]');
        let submitter = document.querySelector(
            'input[type="submit"][form="storeProduct"]'
        );

        pond.setOptions({
            allowMultiple: true,
            files: this.currentValue.map((image) => ({
                source: typeof image === 'string' ? image : image.file_url,

                options: {
                    type: typeof image === 'string' ? 'limbo' : 'local',
                },
            })),

            server: {
                process: {
                    url: this.processValue,
                    headers: {
                        'X-CSRF-Token': token.content,
                    },
                },
            },
        });

        pond.on('processfile', (error, event) => {
            const template = this.templateTarget.innerHTML
                .replace('NAME', 'images[]')
                .replace('VALUE', event.serverId);

            this.element.insertAdjacentHTML('beforeend', template);
            submitter.removeAttribute('disabled');
        });



    }
}
