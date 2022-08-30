<template>
    <div class="editor-wrapper">
        <input type="hidden" :name="name" v-model="data">
        <div ref="root"></div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Vditor from 'vditor';
import 'vditor/dist/index.css';

const props = defineProps({
    text: String,
    name: {
        type: String,
        default: 'text',
    },
});

const root = ref(null);
const editor = ref(null);
const data = ref(props.text);

onMounted(() => {
    editor.value = new Vditor(root.value, {
        lang: 'en_US', // TODO: use current app language.
        cache: {
            // TODO: enable with work ID when editing existing works.
            enable: false,
        },
        minHeight: 360,
        toolbarConfig: {
            pin: true,
        },
        value: data.value,
        input: content => {
            data.value = content;
        },
    });
});
</script>
