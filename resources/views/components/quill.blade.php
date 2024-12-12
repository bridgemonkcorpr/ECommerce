<div
    x-data="{ content: @entangle($attributes->wire('model')).defer }"
    x-ref="quillEditor"
    x-model="content"
    x-init="
        function setupEditor() {
            quill = new Quill($refs.quillEditor, {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['link']
                    ]
                },
                placeholder: '{{ __('Write something...') }}',
                theme: 'snow'
            });
            quill.root.innerHTML = this.content;
            quill.on('text-change', function () {
               $dispatch('input', quill.root.innerHTML);
            });
        }
    "
></div>
