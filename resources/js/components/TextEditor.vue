<template>
    <div class="editorjs-wrapper">
        <input type="hidden" :name="name" v-model="data">
        <div ref="root"></div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import SimpleImage from '@editorjs/simple-image';
import List from '@editorjs/list';
import Table from '@editorjs/table';
import Underline from '@editorjs/underline';

const props = defineProps({
    text: String,
    name: {
        type: String,
        default: 'text',
    },
});

const root = ref(null);
const editor = ref(null);
const dirty = ref(false);
const data = ref(props.text);

const save = (submit = false) => {
    editor.value.save().then((outputData) => {
        dirty.value = false;
        data.value = JSON.stringify(outputData);
        if (submit) {
            root.value.closest('form').submit();
        }
    }).catch((error) => {
        console.error('Saving failed: ', error);
    });
}
const debouncedSave = _.debounce(() => save(false), 250);

onMounted(() => {
    editor.value = new EditorJS({
        holder: root.value,
        data: data.value,
        placeholder: 'Write something fun!',
        tools: {
            header: Header,
            image: SimpleImage,
            list: List,
            table: Table,
            underline: Underline,
        },
        onChange: () => {
            dirty.value = true;
            debouncedSave();
        }
    });

    // Set value on form submit
    root.value.closest('form').addEventListener('submit', (e) => {
        if (dirty.value) {
            save(true);
            e.preventDefault();
        }
    });
});
</script>
