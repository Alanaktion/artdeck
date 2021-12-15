import { Editor, defaultValueCtx, editorViewCtx, rootCtx, serializerCtx, themeFactory } from '@milkdown/core';
import { commonmark, heading, paragraph } from '@milkdown/preset-commonmark';
import { clipboard } from '@milkdown/plugin-clipboard';
import { history } from '@milkdown/plugin-history';
import { slash } from '@milkdown/plugin-slash';
import { upload } from '@milkdown/plugin-upload';

// TODO: add theming either here or in Tailwind somehow for the UI elements
const theme = themeFactory({});

// const nodes = commonmark
//     .configure(paragraph, {
//         className: () => '',
//     })
//     .configure(heading, {
//         className: () => '',
//     });

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
        .use(slash)
        .use(upload)
        .create();

    editorElement.querySelector('.editor').classList.add(
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

    rootElement.closest('form').addEventListener('submit', event => {
        valueElement.value = getMarkdown();
    });
}

initEditor();
