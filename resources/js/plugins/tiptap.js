import {Editor} from '@tiptap/core';
import {Image} from '@tiptap/extension-image';
import {Link} from '@tiptap/extension-link';
import {Underline} from '@tiptap/extension-underline';
import {TextAlign} from '@tiptap/extension-text-align';
import {Placeholder} from "@tiptap/extension-placeholder";
import {Video} from "./tiptap-video-extension";
import StarterKit from '@tiptap/starter-kit';

document.addEventListener('alpine:init', () => {
    Alpine.data('setupEditor', (content) => {
        let editor;
        return {
            editor: null,
            content: content,
            updatedAt: Date.now(),
            isActive(type, opts = {}) {
                return editor.isActive(type, opts);
            },
            setParagraph() {
                editor.chain().focus().setParagraph().run();
            },
            toggleBold() {
                editor.chain().toggleBold().focus().run();
            },
            toggleItalic() {
                editor.chain().focus().toggleItalic().run();
            },
            toggleStrike() {
                editor.chain().focus().toggleStrike().run();
            },
            toggleUnderline() {
                editor.commands.toggleUnderline();
            },
            toggleHeading(level) {
                editor.chain().toggleHeading({level: level}).focus().run();
            },
            toggleBulletList() {
                editor.chain().focus().toggleBulletList().run();
            },
            toggleOrderedList() {
                editor.chain().focus().toggleOrderedList().run();
            },
            setTextAlign(align) {
                editor.chain().focus().setTextAlign(align).run();
            },
            toggleLink() {
                const previousUrl = editor.getAttributes('link').href;
                const url = window.prompt('URL', previousUrl);

                if (url === null) {
                    return;
                }

                if (url === '') {
                    editor.chain().focus().extendMarkRange('link').unsetLink().run();
                    return;
                }

                editor.chain().focus().extendMarkRange('link').setLink({href: url}).run();
            },
            toggleBlockquote() {
                editor.chain().focus().toggleBlockquote().run();
            },
            setHorizontalRule() {
                editor.chain().focus().setHorizontalRule().run();
            },
            insertMedia(type, url, alt) {
                if (type.startsWith('image')) {
                    editor.chain().focus().setImage({src: url, alt: alt}).run();
                }
                if (type.startsWith('video')) {
                    editor.chain().focus().insertContent(`<video src="${url}"></video>`).run();
                }
            },
            undo() {
                editor.chain().focus().undo().run();
            },
            redo() {
                editor.chain().focus().redo().run();
            },
            clearContent() {
                editor.commands.clearContent();
            },
            insertContent(value) {
                editor.commands.insertContent(value);
            },
            focus() {
                editor.commands.focus();
            },
            init(element) {
                editor = new Editor({
                    element: element,
                    content: this.content,
                    extensions: [
                        StarterKit,
                        Underline,
                        Image,
                        Video,
                        TextAlign.configure({
                            types: ['heading', 'paragraph'],
                        }),
                        Link.configure({
                            openOnClick: false,
                        }),
                        Placeholder.configure({
                            placeholder: 'Write something...',
                        }),
                    ],
                    editorProps: {
                        attributes: {
                            class: 'focus:outline-none',
                        },
                    },
                    onUpdate: ({editor}) => {
                        this.content = editor.getHTML()
                        if (this.content === '<p></p>') this.content = null;
                    },
                    onTransaction: () => {
                        this.updatedAt = Date.now()
                    },
                    onSelectionUpdate: ({editor}) => {
                        this.updatedAt = Date.now()
                    },
                });
            },
        };
    });
});
