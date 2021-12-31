<template>
    <div ref="root">
        <textarea class="hidden" data-editor-value v-model="text" :name="name"></textarea>
        <div
            class="input-text border w-full focus-within:border-primary-500 focus-within:ring focus-within:ring-primary-100 dark:focus-within:ring-primary-700"
        >
            <VueEditor :editor="editor" />
        </div>
    </div>
</template>

<script>
import { ref, toRef, onMounted } from 'vue';
import { VueEditor, useEditor } from '@milkdown/vue';
import { Editor, defaultValueCtx, editorViewCtx, rootCtx, serializerCtx, themeFactory } from '@milkdown/core';
import { commonmark } from '@milkdown/preset-commonmark';
import { clipboard } from '@milkdown/plugin-clipboard';
import { history } from '@milkdown/plugin-history';
import { upload } from '@milkdown/plugin-upload';
import { mixin, slots } from '@milkdown/theme-nord';

import { editorMenu } from '../markdown-editor-menu';

const theme = themeFactory({
    mixin,
    slots,
});

export default {
    components: {
        VueEditor,
    },
    props: {
        text: String,
        name: {
            type: String,
            default: 'text',
        },
    },
    setup(props) {
        const defaultText = toRef(props, 'text');
        const text = ref(defaultText.value);
        const name = toRef(props, 'name');
        const root = ref(null);
        let editorCtx;

        const editor = useEditor(root =>
            Editor.make()
                .config((ctx) => {
                    editorCtx = ctx;
                    ctx.set(rootCtx, root);
                    ctx.set(defaultValueCtx, text.value);
                })
                .use(theme)
                .use(commonmark.headless())
                .use(clipboard)
                .use(history)
                .use(editorMenu)
                .use(upload)
        );

        const getMarkdown = () => {
            const editorView = editorCtx.get(editorViewCtx);
            const serializer = editorCtx.get(serializerCtx);
            return serializer(editorView.state.doc);
        }

        onMounted(() => {
            // Set textarea value on form submit
            root.value.closest('form').addEventListener('submit', (e) => {
                text.value = getMarkdown();
                e.preventDefault();
            });
        });

        return { text, name, root, editor };
    },
};
</script>
