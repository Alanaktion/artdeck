import { Editor, defaultValueCtx, editorViewCtx, rootCtx, serializerCtx, themeFactory } from '@milkdown/core';
import { commonmark } from '@milkdown/preset-commonmark';
import { clipboard } from '@milkdown/plugin-clipboard';
import { history } from '@milkdown/plugin-history';
import { upload } from '@milkdown/plugin-upload';
import { mixin, slots } from '@milkdown/theme-nord';

import { editorMenu } from './markdown-editor-menu';

const theme = themeFactory({
    mixin,
    slots,
});

async function initEditor() {
    const rootElement = document.querySelector('[data-markdown-editor]');
    const editorElement = rootElement.querySelector('[data-editor-render]');
    const valueElement = rootElement.querySelector('[data-editor-value]');

    const editor = await Editor.make()
        .config(ctx => {
            ctx.set(rootCtx, editorElement);
            ctx.set(defaultValueCtx, valueElement.value);
        })
        .use(theme)
        .use(commonmark.headless())
        .use(clipboard)
        .use(history)
        .use(editorMenu)
        .use(upload)
        .create();

    editorElement.querySelector('.editor').classList.add(
        'px-2',
        'py-1',
        'prose',
        'xl:prose-lg',
        'dark:prose-invert',
        'max-w-none',
        'focus:outline-none',
    );

    const getMarkdown = () =>
        editor.action(ctx => {
            const editorView = ctx.get(editorViewCtx);
            const serializer = ctx.get(serializerCtx);
            return serializer(editorView.state.doc);
        });

    rootElement.closest('form').addEventListener('submit', () => {
        valueElement.value = getMarkdown();
    });
}

initEditor();
