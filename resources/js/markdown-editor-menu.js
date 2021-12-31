import { menu } from '@milkdown/plugin-menu';
import { createCmdKey } from '@milkdown/core';
import { Redo, Undo } from '@milkdown/plugin-history';
import {
    InsertHr,
    InsertImage,
    InsertTable,
    ToggleBold,
    ToggleItalic,
    ToggleLink,
    ToggleStrikeThrough,
    TurnIntoCodeFence,
    TurnIntoHeading,
    TurnIntoTaskList,
    WrapInBlockquote,
    WrapInBulletList,
    WrapInOrderedList,
} from '@milkdown/preset-gfm';
import {
    EditorState,
    EditorView,
    MarkType,
    redo,
    setBlockType,
    undo,
    wrapIn,
} from '@milkdown/prose';

const hasMark = (state, type) => {
    const { from, $from, to, empty } = state.selection;
    if (empty) {
        return !!type.isInSet(state.storedMarks || $from.marks());
    }
    return state.doc.rangeHasMark(from, to, type);
};

export const SelectParent = createCmdKey();
export const editorMenu = menu([
    [
        {
            type: 'select',
            text: 'Heading',
            options: [
                { id: '1', text: 'Heading 1' },
                { id: '2', text: 'Heading 2' },
                { id: '3', text: 'Heading 3' },
            ],
            disabled: (view) => {
                const { state } = view;
                const setToHeading = (level) => setBlockType(state.schema.nodes.heading, { level })(state);
                return !(setToHeading(1) || setToHeading(2) || setToHeading(3));
            },
            onSelect: (id) => [TurnIntoHeading, Number(id)],
        },
    ],
    [
        {
            type: 'button',
            icon: 'undo',
            key: Undo,
            disabled: (view) => {
                return !undo(view.state);
            },
        },
        {
            type: 'button',
            icon: 'redo',
            key: Redo,
            disabled: (view) => {
                return !redo(view.state);
            },
        },
    ],
    [
        {
            type: 'button',
            icon: 'bold',
            key: ToggleBold,
            active: (view) => hasMark(view.state, view.state.schema.marks.strong),
        },
        {
            type: 'button',
            icon: 'italic',
            key: ToggleItalic,
            active: (view) => hasMark(view.state, view.state.schema.marks.em),
        },
        {
            type: 'button',
            icon: 'strikeThrough',
            key: ToggleStrikeThrough,
            active: (view) => hasMark(view.state, view.state.schema.marks.strike_through),
        },
    ],
    [
        {
            type: 'button',
            icon: 'bulletList',
            key: WrapInBulletList,
            disabled: (view) => {
                const { state } = view;
                return !wrapIn(state.schema.nodes.bullet_list)(state);
            },
        },
        {
            type: 'button',
            icon: 'orderedList',
            key: WrapInOrderedList,
            disabled: (view) => {
                const { state } = view;
                return !wrapIn(state.schema.nodes.ordered_list)(state);
            },
        },
    ],
    [
        {
            type: 'button',
            icon: 'link',
            key: ToggleLink,
            active: (view) => hasMark(view.state, view.state.schema.marks.link),
        },
        {
            type: 'button',
            icon: 'image',
            key: InsertImage,
        },
        {
            type: 'button',
            icon: 'table',
            key: InsertTable,
        },
        {
            type: 'button',
            icon: 'code',
            key: TurnIntoCodeFence,
        },
    ],
    [
        {
            type: 'button',
            icon: 'quote',
            key: WrapInBlockquote,
        },
        {
            type: 'button',
            icon: 'divider',
            key: InsertHr,
        },
        {
            type: 'button',
            icon: 'select',
            key: SelectParent,
        },
    ],
]);
