import {Node, mergeAttributes} from '@tiptap/core'

export const Video = Node.create({
    name: 'video', // unique name for the Node
    group: 'block', // belongs to the 'block' group of extensions
    selectable: true, // so we can select the video
    draggable: true, // so we can drag the video
    atom: true, // is a single unit

    addAttributes() {
        return {
            src: {
                default: null
            },
            controls: {
                default: 'controls',
            },
        }
    },

    parseHTML() {
        return [
            {
                tag: 'video',
            },
        ]
    },

    renderHTML({HTMLAttributes}) {
        return ['video', mergeAttributes(HTMLAttributes)];
    },

    addNodeView() {
        return ({editor, node}) => {
            const div = document.createElement('div');
            div.className = 'aspect-w-16 aspect-h-9';
            const video = document.createElement('video');
            video.src = node.attrs.src;
            video.controls = node.attrs.controls;
            div.append(video);
            return {
                dom: div,
            }
        }
    },
});
