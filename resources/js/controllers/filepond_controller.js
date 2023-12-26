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

            revert: (uniqueFileId, load, error) => {
                axios
                    .delete(`${this.revertValue}?media=${uniqueFileId}`)
                    .then((response) => {
                        this.uploadTargets.forEach((el) => {
                            if (el.value == uniqueFileId) {
                                el.remove();
                            }
                        });

                        load();
                    })
                    .catch((err) => {
                        error({
                            type: 'error',
                            body: err.message,
                            code: err.response?.status,
                        });
                    });
            },

            restore: (
                uniqueFileId,
                load,
                error,
                progress,
                abort,
                headers
            ) => {
                axios
                    .get(`${this.restoreValue}?path=${uniqueFileId}`, {
                        onDownloadProgress: (event) => {
                            progress(true, event.loaded, event.total);
                        },
                        responseType: "blob",
                    })
                    .then((response) => {
                        headers(response.request.getAllResponseHeaders());

                        load(response.data);
                    })
                    .catch((err) => error(err.message));

                // Should expose an abort method so the request can be cancelled
                return {
                    abort: () => {
                        // User tapped abort, cancel our ongoing actions here

                        // Let FilePond know the request has been cancelled
                        abort();
                    },
                };
            },

            remove: (source, load, error) => {
                axios
                    .delete(`${this.revertValue}?media=${source}`)
                    .then((response) => {
                        load();
                    })
                    .catch((err) => {
                        error({
                            type: 'error',
                            body: err.message,
                            code: err.response?.status,
                        });
                    });
            },

            load: (source, load, error, progress, abort, headers) => {
                axios
                    .get(source, {
                        onDownloadProgress: (event) => {
                            progress(true, event.loaded, event.total);
                        },
                        responseType: 'blob',
                    })
                    .then((response) => {
                        headers(response.request.getAllResponseHeaders());

                        load(response.data);
                    })
                    .catch((err) => {
                        if (err.response) {
                            return error({
                                type: 'error',
                                body: err.response.statusText,
                                code: err.response.status,
                            });
                        }

                        return error({
                            type: 'error',
                            body: err.message,
                            code: 400,
                        });
                    });

                return {
                    abort: () => {
                        // User tapped cancel, abort our ongoing actions here

                        // Let FilePond know the request has been cancelled
                        abort();
                    },
                };
            },


        });


        pond.on('processfilestart', () => {
            submitter.setAttribute('disabled', true);
        });

        pond.on('addfilestart', () => {
            submitter.setAttribute('disabled', true);
        });

        pond.on('addfile', () => {
            submitter.removeAttribute('disabled');
        });

        pond.on('processfilerevert', () => {
            submitter.removeAttribute('disabled');
        });

        pond.on('processfileabort', () => {
            submitter.removeAttribute('disabled');
        });

    }
}
